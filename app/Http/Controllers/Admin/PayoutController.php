<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\Admin_Approval_Payout_Request;
use App\Http\Requests\MassDestroyPayoutRequest;
use App\Http\Requests\StorePayoutBulkRequest;
use App\Http\Requests\StorePayoutRequest;
use App\Http\Requests\UpdatePayoutRequest;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Payout;
use App\Models\PayoutBulk;
use App\Models\Product;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayoutController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('payout_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $user = Auth::user();
            if (Auth::guard('merchant')->check()) {
                $query = $query = Payout::with(['merchant', 'bulk', 'gate', 'gate.currency', 'saving_account'])->select(sprintf('%s.*', (new Payout)->table))->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id);
            } else {
                $query = $query = Payout::with(['merchant', 'bulk', 'gate', 'gate.currency', 'saving_account'])->select(sprintf('%s.*', (new Payout)->table));
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');


        

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'payout_show';
                // $editGate      = 'payout_edit';
                // $deleteGate    = 'payout_delete';
                $crudRoutePart = 'payouts';
                $row->status_name =  Payout::STATUS_SELECT[$row->status];

                $manage_toUp_request = null;

                $status = Payout::STATUS_SELECT[$row->status];

                if (Auth::guard('admin')->check()) {
                    $manage_toUp_request = 'payout_edit';
                }

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    // 'editGate',
                    // 'deleteGate',
                    'crudRoutePart',
                    'row',
                    'status',
                    'manage_toUp_request'
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
            $table->editColumn('status_name', function ($row) {
                return ($row->status != null) ? Payout::STATUS_SELECT[$row->status] : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });
            $table->addColumn('currency', function ($row) {
                return $row->gate->currency->short_code . ' ';
            });
            $table->editColumn('processing_fee', function ($row) {
                return $row->processing_fee ? number_format($row->processing_fee, 2) : "";
            });
            $table->addColumn('processing', function ($row) {
                return sprintf(" <br> ") . "( " . number_format($row->processing_rate, 2) . "% +" . number_format($row->processing_fix, 2) . " )";
            });

            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->addColumn('bulk_name', function ($row) {
                return $row->bulk ? $row->bulk->name : '';
            });

            $table->editColumn('transaction', function ($row) {
                return $row->document_no ? $row->document_no : "";
            });
            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->editColumn('payment_slip', function ($row) {
                return $row->payment_slip ? '<a href="' . $row->payment_slip->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'bulk', 'gate', 'payment_slip', 'processing']);

            return $table->make(true);
        }

        $merchant_arr = Merchant::select('id', 'name')->get();
        $transaction_arr = Payout::select('id', 'document_no')->get();
        $project_arr = Product::select('id', 'name')->get();
        $bankHolder_arr = Payout::select('id', 'bank_account_name')->get();
        $bankAcc_arr = Payout::select('id', 'bank_account_number')->get();
        $bankName_arr = Payout::select('id', 'bank_name')->get();
        $currency_arr = Currency::get();

        return view('admin.payouts.index', compact('currency_arr','merchant_arr','transaction_arr','project_arr',
        'bankHolder_arr','bankAcc_arr','bankName_arr'));
    }

    public function create()
    {
        abort_if(Gate::denies('payout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);
            $merchant_id = null;
        } else if (Auth::guard('partner')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);
            $merchant_id = null;
        } else if (Auth::guard('merchant')->check()) {
            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;
            $merchants = Merchant::all()->where('id', $merchant_id);
        }

        return view('admin.payouts.create', compact('merchants', 'merchant_id'));
    }

    public function store(StorePayoutRequest $request)
    {

        $insert_data = $request->validated();

        $insert_data['gate_id'] = $request->validated()['project_id'];

        $insert_data['status'] = 0;

        $insert_data['document_no'] = Payout::generate_document_no();


        $project = Product::find($insert_data['gate_id'])->first();

        $p_fee = $project->processing_fee($insert_data['amount'], "PAYOUT");

        $insert_data['currency_id'] = $project->currency_id;

        $insert_data['processing_fee'] = $p_fee['fee'];
        $insert_data['processing_rate'] = $p_fee['config_rate'];
        $insert_data['processing_fix'] = $p_fee['config_fix'];

        Payout::create($insert_data);

        return redirect()->route('admin.payouts.index');
    }

    public function edit(Payout $payout)
    {
        abort_if(Gate::denies('payout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchants = Merchant::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bulks = PayoutBulk::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payout->load('merchant', 'bulk', 'gate');

        return view('admin.payouts.edit', compact('merchants', 'bulks', 'gates', 'payout'));
    }

    public function update(UpdatePayoutRequest $request, Payout $payout)
    {

        $payout->update($request->all());

        if ($request->input('payment_slip', false)) {
            if (!$payout->payment_slip || $request->input('payment_slip') !== $payout->payment_slip->file_name) {
                if ($payout->payment_slip) {
                    $payout->payment_slip->delete();
                }

                $payout->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
            }
        } elseif ($payout->payment_slip) {
            $payout->payment_slip->delete();
        }

        return redirect()->route('admin.payouts.index');
    }

    public function show(Payout $payout)
    {
        abort_if(Gate::denies('payout_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payout->load('merchant', 'bulk', 'gate', 'gate.currency');

        return view('admin.payouts.show', compact('payout'));
    }

    public function destroy(Payout $payout)
    {
        abort_if(Gate::denies('payout_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payout->delete();

        return back();
    }

    public function massDestroy(MassDestroyPayoutRequest $request)
    {
        Payout::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('payout_create') && Gate::denies('payout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Payout();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function payout_approve(Admin_Approval_Payout_Request $request)
    {
        //拒绝或者接受
        if (empty(request('id')) || request('id') == null) {
            return $this->res_format(-1, $this->api_ret_msg('api.failed'));
        }

        $payout_model = Payout::find(request('id'));

        $project = Product::where('id', $payout_model->gate_id)->first();

        DB::beginTransaction();

        try {

            if (request('status') == 1) {
                //approve 必须有receipt
                if (!$request->saving_account_id) {
                    return $this->res_format(-1, $this->api_ret_msg('api.saving_account_id_required'));
                }

                if (empty($project)) {
                    return $this->res_format(-1, $this->api_ret_msg('api.empty'));
                }

                if ($project->current_credit < $payout_model->amount) {
                    return $this->res_format(-2, $this->api_ret_msg('api.noEnoughMoney') . $project->current_credit);
                }

                if (!$request->hasFile('payment_slip')) {
                    return $this->res_format(-1, $this->api_ret_msg('api.image_required'));
                }

                $payout_model->addMedia($request->file('payment_slip'))->toMediaCollection('payout');

                $payout_model->update([
                    'saving_account_id' => $request->saving_account_id,
                    'statement_date'    => now()->format('Y-m-d')
                ]);

                // 成功交易存进balance
                $insert_data = [
                    'debit' => 0,
                    'credit' => $payout_model->amount,
                    'type' => 2,
                    'status' => 0,
                    'document_no' => $payout_model->document_no,
                    'remark' => '',
                    'settlement_status' => 0,
                    'merchant_id' => $payout_model->merchant_id,
                    'gate_id' => $payout_model->gate_id,
                    'saving_account_id' => $payout_model->saving_account_id,
                    'ref_id' => $payout_model->id,
                    'processing_fee'    => $payout_model->processing_fee,
                    'processing_fix'    => $payout_model->processing_fix,
                    'processing_rate'    => $payout_model->processing_rate,
                ];

                $final_amount = bcadd($payout_model->amount, $payout_model->processing_fee, 2);

                Product::where(['id' => $payout_model->gate_id])->decrement('current_credit', ($final_amount));

                Balance::create($insert_data);
            }
            $request['statement_date'] = now()->format('Y-m-d');
            $payout_model->update($request->only(['status', 'admin_remark', 'statement_date']));

            if ($payout_model->status == 1 || $payout_model->status == 3) {

                // 拿出callback_url
                if (!empty($payout_model->callback_url) || ($payout_model->callback_url != null)) {
                    $callback_url = $payout_model->callback_url;
                } else {
                    $callback_url = $payout_model->gate->callback_url;
                }

                if (!empty($payout_model->redirect_url) || ($payout_model->redirect_url != null)) {
                    $redirect_url = $payout_model->redirect_url;
                } else {
                    $redirect_url = $payout_model->gate->redirect_url;
                }

                $insert_data_callback = [
                    'amount' => $payout_model->amount,
                    'status' => 0,
                    'document_no' => $payout_model->document_no,
                    'merchant_id' => $payout_model->merchant_id,
                    'client_transaction' => $payout_model->document_no,
                    'return_status' => $request['status'],
                    'throttle' => 0,
                    'gate_id' => $payout_model->gate_id,
                    'callback_url' => $callback_url,
                    'redirect_url' => $redirect_url,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                DB::table('callback_payouts')->insert($insert_data_callback);
            }

            DB::commit();

            return $this->res_format(0, $this->api_ret_msg('api.success'));
        } catch (Exception $e) {

            Log::alert("[" . $request->path() . "]" . $e);
            DB::rollBack();

            return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
        }
    }

    public function create_bulk()
    {
        abort_if(Gate::denies('payout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Auth::guard('merchant')->check()) {
            if ($user->parent_id) {
                $gate_arr = Product::where('merchant_id', $user->parent_id)->get()->pluck('name', 'gate_id');
            } else {
                $gate_arr = Product::where('merchant_id', $user->id)->get()->pluck('name', 'gate_id');
            }
        } else if (Auth::guard('partner')->check()) {
        } else if (Auth::guard('admin')->check()) {
            $gate_arr = Product::get()->pluck('name', 'gate_id')->prepend(trans('global.pleaseSelect'), '');
        }

        return view('admin.payouts.create_bulk', compact('gate_arr'));
    }

    public function store_bulk(StorePayoutBulkRequest $request)
    {

        // dd($request->all());

        // abort_if(Gate::denies('payout_store'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = $request['payouts'];

        if (count($payouts) <= 0) {
            return $this->res_format(0, $this->api_ret_msg('api.error'));
        }

        $user = Auth::user();

        DB::beginTransaction();

        try {

            $insert_data = [
                'name' => $request['bulk_name'],
            ];

            try {
                $res_payout_bulk = PayoutBulk::create($insert_data);
            } catch (Exception $e) {

                return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
            }

            foreach ($payouts as $index => $p) {
                // dd($p);

                if ($p['gate'] == null) {
                    continue;
                }

                $insert_data = [
                    'bank_account_name' => $p['fullname'],
                    'bank_account_number' => $p['account_no'],
                    'client_transaction' => $p['client_transaction'],
                    'bank_branch' => $p['branch'],
                    'bank_name' => $p['bank_code'],
                    'bank_city' => $p['city'],
                    'bank_state' => $p['state'],
                    'amount' => $p['amount'],
                    'remark' => $p['remark'],
                    'status' => 0,
                ];

                $project = Product::where('gate_id', $p['gate'])->first();

                $insert_data['gate_id'] = $project->id;

                $insert_data['bulk_id'] = $res_payout_bulk['id'];

                $insert_data['document_no'] = Payout::generate_document_no();

                $insert_data['merchant_id'] = $project->merchant_id;

                $insert_data['currency_id'] = $project->currency_id;

                $p_fee = $project->processing_fee($insert_data['amount'], "PAYOUT");

                $insert_data['processing_fee'] = $p_fee['fee'];
                $insert_data['processing_rate'] = $p_fee['config_rate'];
                $insert_data['processing_fix'] = $p_fee['config_fix'];

                Payout::create($insert_data);
            }

            DB::commit();

            return $this->res_format(0, $this->api_ret_msg('api.success'));
        } catch (\Exception $e) {
            DB::rollback();

            // dd($e);
            return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
        }
    }
}
