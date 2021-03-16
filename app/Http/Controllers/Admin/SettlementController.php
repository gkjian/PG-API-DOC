<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySettlementRequest;
use App\Http\Requests\StoreSettlementRequest;
use App\Http\Requests\UpdateSettlementRequest;
use App\Models\Merchant;
use App\Models\Settlement;
use App\Models\SettlementBank;
use App\Models\Currency;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

use App\Models\Balance;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SettlementController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('settlement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if ($request->ajax()) {

            if (Auth::guard('merchant')->check()) {
                $query = Settlement::with(['merchant', 'bank', 'gate','currency'])->select(sprintf('%s.*', (new Settlement)->table))->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id);
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('admin')->check()) {
                $query = Settlement::with(['merchant', 'bank', 'gate','currency'])->select(sprintf('%s.*', (new Settlement)->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'settlement_show';
                // $editGate      = 'settlement_edit';
                // $deleteGate    = 'settlement_delete';
                $crudRoutePart = 'settlements';

                $status = Settlement::STATUS_SELECT[$row->status];
                switch ($status) {
                    case 'Rejected':
                        $status = sprintf('<span class="badge badge-danger">%s</span>', $status);
                        break;
                    case 'Failed':
                        $status = sprintf('<span class="badge badge-danger">%s</span>', $status);
                        break;
                    case 'Completed':
                        $status = sprintf('<span class="badge badge-success">%s</span>', $status);
                        break;
                    case 'Pending':
                        $status = sprintf('<span class="badge badge-warning">%s</span>', $status);
                        break;
                }
                $settlementAction = null;

                if (Auth::guard('admin')->check()) {
                    if ($status != 'Completed' || $status != 'Rejected') {
                        $settlementAction = 'settlement_edit';
                    }
                }

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    // 'editGate',
                    // 'deleteGate',
                    'crudRoutePart',
                    'row',
                    'settlementAction',
                    'status',
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? $row->merchant->name : '';
            });

            $table->editColumn('bank_name', function ($row) {
                return $row->bank_name ? $row->bank_name : "";
            });
            $table->editColumn('bank_account_name', function ($row) {
                return $row->bank_account_name ? $row->bank_account_name : "";
            });
            $table->editColumn('bank_account_number', function ($row) {
                return $row->bank_account_number ? $row->bank_account_number : "";
            });
            $table->editColumn('status', function ($row) {
                return isset($row->status) ? $row->status : "";
            });
            $table->editColumn('status_name', function ($row) {
               return Settlement::STATUS_SELECT[$row->status];
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->editColumn('transaction', function ($row) {
                return $row->document_no ? $row->document_no : "";
            });
            $table->addColumn('bank_bank_name', function ($row) {
                return $row->bank ? $row->bank->bank_name : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });
            $table->addColumn('c', function ($row) { // currency short code
                return $row->currency->short_code ? $row->currency->short_code : '';
            });
            $table->addColumn('c-name', function ($row) { // currency name
                return $row->currency->name ? $row->currency->name : '';
            });
            $table->editColumn('processing_fee', function ($row) {
                return $row->processing_fee ? number_format($row->processing_fee, 2) : "";
            });
            $table->addColumn('processing', function ($row) {
                return sprintf(" <br> ") . "( " . number_format($row->processing_rate, 2) . "% +" . number_format($row->processing_fix, 2) . " )";
            });

            $table->editColumn('payment_slip', function ($row) {
                return $row->payment_slip ? '<a href="' . $row->payment_slip->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'bank', 'payment_slip', 'status', 'processing']);

            return $table->make(true);
        }

        if (Auth::guard('merchant')->check()) {
            $merchant_arr = Merchant::select('id', 'name')->where('id', $user->parent_id ? $user->parent_id : $user->id)->get();
            $project_arr  = Product::select('id', 'name')->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id)->get();
        } else if (Auth::guard('partner')->check()) {
        } else if (Auth::guard('admin')->check()) {
            $merchant_arr = Merchant::select('id', 'name')->get();
            $project_arr  = Product::select('id', 'name')->get();
        }

        $currency_arr = Currency::get();

        return view('admin.settlements.index' , compact('currency_arr', 'merchant_arr', 'project_arr'));
    }

    public function create()
    {
        abort_if(Gate::denies('settlement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        $gates = null;
        $merchant_id = null;
        $merchants = null;

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);

            $banks = SettlementBank::all();
        } else if (Auth::guard('partner')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);

            $banks = SettlementBank::all();
        } else if (Auth::guard('merchant')->check()) {
            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;

            $banks = SettlementBank::all()->where('merchant_id', $merchant_id);
            $gates = Product::with(['currency'])->where('merchant_id', $merchant_id)->get();
        }

        $no = Settlement::whereRaw('DATE(created_at) = CURDATE()')->count('created_at') + 1;
        $no = substr_replace('000', $no, 3 - strlen($no));
        $document_no = 's' . now()->format('ymdHis') . $no;

        return view('admin.settlements.create', compact('merchants', 'merchant_id', 'gates', 'banks', 'document_no'));
    }

    public function store(StoreSettlementRequest $request)
    {
        $request['status'] = '0';
        $product = Product::find($request->gate_id);
        $request['currency_id'] = $product->currency_id;
        $processing = $product->processing_fee($request->amount, "SETTLEMENT");
        $request['processing_fee'] = $processing['fee'];
        $request['processing_rate'] = $processing['config_rate'];
        $request['processing_fix'] = $processing['config_fix'];

        $amount = $request->amount;

        DB::beginTransaction();
        try {

            $insert_settlement = Settlement::create($request->all());
            if (!$insert_settlement) {
                return $this->res_format(-1, $this->api_ret_msg('insert_settlement failed'));
            }

            $decrement_current_credit = Product::where('id', $request->gate_id)->decrement('current_credit', $amount + $request->processing_fee);
            if (!$decrement_current_credit) {
                return $this->res_format(-1, $this->api_ret_msg('decrement_current_credit failed'));
            }

            $increment_settlement_freeze_credit = Product::where('id', $request->gate_id)->increment('settlement_freeze_credit', $amount + $request->processing_fee);
            if (!$increment_settlement_freeze_credit) {
                return $this->res_format(-1, $this->api_ret_msg('increment_settlement_freeze_credit failed'));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $insert_settlement->id]);
        }

        return redirect()->route('admin.settlements.index');
    }

    public function edit(Settlement $settlement)
    {
        abort_if(Gate::denies('settlement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::where('parent_id', null)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else if (Auth::guard('partner')->check()) {
            $merchants = Merchant::where([
                'parent_id' => null,
                'partner_id' => $user->id
            ])->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else if (Auth::guard('merchant')->check()) {
            $merchants = Merchant::where([
                'parent_id' => null,
                'partner_id' => $user->partner_id
            ])->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $banks = SettlementBank::all()->pluck('bank_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $settlement->load('merchant', 'bank');

        return view('admin.settlements.edit', compact('merchants', 'banks', 'settlement'));
    }

    public function update(UpdateSettlementRequest $request, Settlement $settlement)
    {
        $settlement->update($request->all());

        if ($request->input('payment_slip', false)) {
            if (!$settlement->payment_slip || $request->input('payment_slip') !== $settlement->payment_slip->file_name) {
                if ($settlement->payment_slip) {
                    $settlement->payment_slip->delete();
                }

                $settlement->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
            }
        } elseif ($settlement->payment_slip) {
            $settlement->payment_slip->delete();
        }

        return redirect()->route('admin.settlements.index');
    }

    public function show(Settlement $settlement)
    {
        abort_if(Gate::denies('settlement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settlement->load('merchant', 'bank');

        return view('admin.settlements.show', compact('settlement'));
    }

    public function destroy(Settlement $settlement)
    {
        abort_if(Gate::denies('settlement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settlement->delete();

        return back();
    }

    public function massDestroy(MassDestroySettlementRequest $request)
    {
        Settlement::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('settlement_create') && Gate::denies('settlement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Settlement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function settlement_approve(Request $request)
    { // 拒绝或者接受
        if (empty($request->id) || $request->id == null) {
            return $this->res_format(-1, $this->api_ret_msg('api.failed'));
        }

        $settlement_model = Settlement::find($request->id);
        $settlement_model->status         = $request->status;
        $settlement_model->remark         = $request->remark;
        $settlement_model->statement_date = now()->format('Y-m-d');

        if ($request->status == 1) {
            if (!$request->saving_account_id) {
                return $this->res_format(-1, $this->api_ret_msg('api.saving_account_id_required'));
            }

            // approve 必须有 receipt
            if (!$request->hasFile('payment_slip')) {
                return $this->res_format(-1, $this->api_ret_msg('api.image_required'));
            }

            $project = Product::select('settlement_freeze_credit')->where('id', $settlement_model->gate_id)->first();

            if ($project->settlement_freeze_credit < $settlement_model->amount) {
                return $this->res_format(-2, $this->api_ret_msg('api.noEnoughMoney') . $project->settlement_freeze_credit);
            }

            $settlement_model->saving_account_id = $request->saving_account_id;
            $settlement_model->submit_amount     = $request->submit_amount;
            $settlement_model->amount_left       = $request->amount_left;

            // 成功交易存进 balance
            $insert_data = [
                'merchant_id'       => $settlement_model->merchant_id,
                'debit'             => 0,
                'credit'            => $settlement_model->amount,
                'type'              => 3,
                'remark'            => '',
                'status'            => 0,
                'settlement_status' => 0,
                'ref_id'            => $settlement_model->id,
                'gate_id'           => $settlement_model->gate_id,
                'document_no'       => $settlement_model->document_no,
                'saving_account_id' => $request->saving_account_id,
                'processing_fee'    => $settlement_model->processing_fee,
                'processing_fix'    => $settlement_model->processing_fix,
                'processing_rate'   => $settlement_model->processing_rate,
            ];

            DB::beginTransaction();
            try {
                if (!$settlement_model->payment_slip || $request->file('payment_slip') !== $settlement_model->payment_slip->file_name) {
                    if ($settlement_model->payment_slip) {
                        $settlement_model->payment_slip->delete();
                    }
                }
                $settlement_model->addMedia($request->file('payment_slip'))->toMediaCollection('payment_slip');
                $update_s = $settlement_model->save();
                if (!$update_s) {
                    return $this->res_format(-1, $this->api_ret_msg('s update failed'));
                }
                $insert_b = Balance::create($insert_data);
                if (!$insert_b) {
                    return $this->res_format(-1, $this->api_ret_msg('b insert failed'));
                }
                $update_m = Product::where('id', $settlement_model->gate_id)->decrement('settlement_freeze_credit', $settlement_model->amount + $settlement_model->processing_fee);
                if (!$update_m) {
                    return $this->res_format(-1, $this->api_ret_msg('m update failed'));
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
            }
        } else if ($request->status == 2 || $request->status == 3) {

            $project = Product::select('settlement_freeze_credit')->where('id', $settlement_model->gate_id)->first();

            if ($project->settlement_freeze_credit < $settlement_model->amount) {
                $update_s = $settlement_model->save();
                if (!$update_s) {
                    return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
                }
            } else {
                DB::beginTransaction();
                try {

                    $update_s = $settlement_model->save();
                    if (!$update_s) {
                        return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
                    }

                    $update_m = Product::where('id', $settlement_model->gate_id)->decrement('settlement_freeze_credit', $settlement_model->amount + $settlement_model->processing_fee);
                    if (!$update_m) {
                        return $this->res_format(-1, $this->api_ret_msg('m update failed'));
                    }

                    $increment_current_credit = Product::where('id', $settlement_model->gate_id)->increment('current_credit', $settlement_model->amount + $settlement_model->processing_fee);
                    if (!$increment_current_credit) {
                        return $this->res_format(-1, $this->api_ret_msg('increment_current_credit failed'));
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
                }
            }
        } else {
            $update_s = $settlement_model->save();
            if (!$update_s) {
                return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
            }
        }

        return $this->res_format(0, $this->api_ret_msg('api.success'));
    }
}
