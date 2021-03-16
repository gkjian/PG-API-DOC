<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTopUpRequest;
use App\Http\Requests\StoreTopUpRequest;
use App\Http\Requests\UpdateTopUpRequest;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\TopUp;
use App\Models\Currency;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Balance;
use App\Models\GateSavingAccount;
use Exception;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TopUpController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('deposit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $user = Auth::user();

            if (Auth::guard('merchant')->check()) {
                $query = TopUp::with(['merchant', 'gate', 'gate.currency', 'saving_account'])->select(sprintf('%s.*', (new TopUp)->table))->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id);
            } else {
                $query = TopUp::with(['merchant', 'gate', 'gate.currency', 'saving_account'])->select(sprintf('%s.*', (new TopUp)->table));
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                // $viewGate      = 'deposit_show';
                // $editGate      = 'deposit_edit';
                // $deleteGate    = 'deposit_delete';
                $crudRoutePart = 'top-ups';
                $approveGate   = 'deposit_edit';

                // $gateSavingAccount = GateSavingAccount::with(['gate', 'saving_account'])->where('gate_id', $row->gate_id)->first();
                $status = TopUp::STATUS_SELECT[$row->status];
                // switch ($status) {
                //     case 'Initial':
                //         $status = sprintf('<span class="badge badge-secondary">%s</span>', $status);
                //         break;
                //     case 'Failed':
                //         $status = sprintf('<span class="badge badge-danger">%s</span>', $status);
                //         break;
                //     case 'Rejected':
                //         $status = sprintf('<span class="badge badge-danger">%s</span>', $status);
                //         break;
                //     case 'Not Verify':
                //         $status = sprintf('<span class="badge badge-danger">%s</span>', $status);
                //         break;
                //     case 'KIV':
                //         $status = sprintf('<span class="badge badge-success">%s</span>', $status);
                //         break;
                //     case 'Pending':
                //         $status = sprintf('<span class="badge badge-warning">%s</span>', $status);
                //         break;
                //     case 'Verified':
                //         $status = sprintf('<span class="badge badge-warning">%s</span>', $status);
                //         break;
                //     case 'Approved':
                //         $status = sprintf('<span class="badge badge-primary">%s</span>', $status);
                //         break;
                //     case 'Reconfirmed':
                //         $status = sprintf('<span class="badge badge-info">%s</span>', $status);
                //         break;
                //     default:
                //         $status =  sprintf('<span class="badge badge-danger">%s</span>', $status);
                //         break;
                // }

                $img = ($row->payment_slip) ? $row->payment_slip->getUrl() : '';
                $row->status_name =  TopUp::STATUS_SELECT[$row->status];
                $row->status_verify_name =  TopUp::STATUS_VERIFY_SELECT[$row->status_verify];

                return view('partials.datatablesActions', compact(
                    // 'viewGate',
                    // 'editGate',
                    // 'deleteGate',
                    'crudRoutePart',
                    'row',
                    'approveGate',
                    // 'gateSavingAccount',
                    // 'status',
                    'img'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? $row->merchant->name : '';
            });

            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? number_format($row->amount, 2) : "";
            });
            $table->addColumn('c', function ($row) { // currency
                return $row->gate->currency->short_code . ' ';
            });
            $table->editColumn('processing_fee', function ($row) {
                return $row->processing_fee ? number_format($row->processing_fee, 2) : "";
            });
            $table->addColumn('processing', function ($row) {
                return sprintf(" <br> ") . "( " . number_format($row->processing_rate, 2) . "% + " . number_format($row->processing_fix, 2) . " )";
            });
            $table->editColumn('transaction', function ($row) {
                return $row->document_no ? $row->document_no : "";
            });
            $table->editColumn('client_transaction', function ($row) {
                return $row->client_transaction ? $row->client_transaction : "";
            });
            $table->editColumn('status_name', function ($row) {
                return TopUp::STATUS_SELECT[$row->status];
            });
            $table->editColumn('status_verify_name', function ($row) {
                return TopUp::STATUS_VERIFY_SELECT[$row->status_verify];
            });
            // $table->editColumn('status', function ($row) {
            //     // if ($row->status != null) {
            //     $status = TopUp::STATUS_SELECT[$row->status];
            //     switch ($status) {
            //         case 'Initial':
            //             return sprintf('<span class="badge badge-secondary">%s</span>', $status);
            //             break;
            //         case 'Failed':
            //             return sprintf('<span class="badge badge-danger">%s</span>', $status);
            //             break;
            //         case 'Rejected':
            //             return sprintf('<span class="badge badge-danger">%s</span>', $status);
            //             break;
            //         case 'Not Verify':
            //             return sprintf('<span class="badge badge-danger">%s</span>', $status);
            //             break;
            //         case 'KIV':
            //             return sprintf('<span class="badge badge-success">%s</span>', $status);
            //             break;
            //         case 'Pending':
            //             return sprintf('<span class="badge badge-warning">%s</span>', $status);
            //             break;
            //         case 'Verified':
            //             return sprintf('<span class="badge badge-warning">%s</span>', $status);
            //             break;
            //         case 'Approved':
            //             return sprintf('<span class="badge badge-primary">%s</span>', $status);
            //             break;
            //         case 'Reconfirmed':
            //             return sprintf('<span class="badge badge-info">%s</span>', $status);
            //             break;
            //         default:
            //             return sprintf('<span class="badge badge-secondary">%s</span>', $status);
            //             break;
            //     }
            //     // }else{
            //     //     return '';
            //     // }
            // });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->editColumn('payment_slip', function ($row) {
                return $row->payment_slip != '' ? '<a href="' . $row->payment_slip->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('freeze', function ($row) {
                return $row->freeze ? $row->freeze : "";
            });
            $table->editColumn('signature', function ($row) {
                return $row->signature ? $row->signature : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'gate', 'payment_slip', 'status', 'processing']);

            return $table->make(true);
        }

        $currency_arr = Currency::get();

        return view('admin.topUps.index', compact('currency_arr'));
    }

    public function create()
    {
        abort_if(Gate::denies('deposit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchants = Merchant::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $no = TopUp::whereRaw('DATE(created_at) = CURDATE()')->count('created_at') + 1;
        $no = substr_replace('000', $no, 3 - strlen($no));
        $document_no = 't' . now()->format('ymdHis') . $no;

        return view('admin.topUps.create', compact('merchants', 'gates', 'document_no'));
    }

    public function store(StoreTopUpRequest $request)
    {
        $topUp = TopUp::create($request->all());

        if ($request->input('payment_slip', false)) {
            $topUp->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $topUp->id]);
        }

        return redirect()->route('admin.top-ups.index');
    }

    public function edit(TopUp $topUp)
    {
        abort_if(Gate::denies('deposit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchants = Merchant::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $topUp->load('merchant', 'gate');

        return view('admin.topUps.edit', compact('merchants', 'gates', 'topUp'));
    }

    public function update(UpdateTopUpRequest $request, TopUp $topUp)
    {
        $topUp->update($request->all());

        if ($request->input('payment_slip', false)) {
            if (!$topUp->payment_slip || $request->input('payment_slip') !== $topUp->payment_slip->file_name) {
                if ($topUp->payment_slip) {
                    $topUp->payment_slip->delete();
                }

                $topUp->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
            }
        } elseif ($topUp->payment_slip) {
            $topUp->payment_slip->delete();
        }

        return redirect()->route('admin.top-ups.index');
    }

    public function show(TopUp $topUp)
    {
        abort_if(Gate::denies('deposit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topUp->load('merchant', 'gate');

        return view('admin.topUps.show', compact('topUp'));
    }

    public function destroy(TopUp $topUp)
    {
        abort_if(Gate::denies('deposit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topUp->delete();

        return back();
    }

    public function massDestroy(MassDestroyTopUpRequest $request)
    {
        TopUp::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('deposit_create') && Gate::denies('deposit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new TopUp();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function topUp_approve(Request $request)
    { // 拒绝或者接受
        if (empty($request->id) || $request->id == null) {
            return $this->res_format(-1, $this->api_ret_msg('api.failed'));
        }

        $topUp_model = TopUp::find($request->id);

        if ($topUp_model->status == 2 || $topUp_model->status == 7) {
            //已经做过rejected / approve
            return $this->res_format(-1, $this->api_ret_msg('admin.top_up_approval.illegal_action'));
        }
        if ($topUp_model->status == 9) {
            //已经过期
            return $this->res_format(-1, $this->api_ret_msg('admin.top_up_approval.expire_action'));
        }

        if ($request->status != null) {

            if ($request->status == 7) {
                //点击approve
                if ($topUp_model->status_verify != 1 || $topUp_model->status != 5) {
                    //不是verify 的都false
                    return $this->res_format(-1, $this->api_ret_msg('admin.top_up_approval.illegal_action'));
                }
            } else if ($request->status == 2) {
                //reject
                if ($topUp_model->status_verify == 1) {
                    //是verify 的都false
                    return $this->res_format(-1, $this->api_ret_msg('admin.top_up_approval.illegal_action'));
                }
            }

            $topUp_model->status = $request->status;
        }

        if ($request->status_verify != null) {

            $topUp_model->status_verify = $request->status_verify;
        }

        if (!$request->amount_adjustment) {
            $topUp_model->amount_adjustment = 0;
        } else {
            $topUp_model->amount_adjustment = $request->amount_adjustment;
        }

        $user = Auth::user();

        $topUp_model->approve_by = $user->name;
        $topUp_model->admin_remark = $request->admin_remark;
        $topUp_model->admin_approval_time = now();
        $topUp_model->statement_date = now()->format('Y-m-d');

        DB::beginTransaction();

        try {

            if ($request->status == '7') {
                // 成功交易存进 balance
                $insert_data = [
                    'merchant_id'       => $topUp_model->merchant_id,
                    'debit'             => $topUp_model->amount,
                    'credit'            => 0,
                    'type'              => 0,
                    'remark'            => '',
                    'status'            => 0,
                    'settlement_status' => 0,
                    'ref_id'            => $topUp_model->id,
                    'processing_fee'    => $topUp_model->processing_fee,
                    'processing_fix'    => $topUp_model->processing_fix,
                    'processing_rate'    => $topUp_model->processing_rate,
                    'gate_id'           => $topUp_model->gate_id,
                    'document_no'       => $topUp_model->document_no,
                    'saving_account_id' => $topUp_model->saving_account_id
                ];

                $update = $topUp_model->save();
                if (!$update) {
                    return $this->res_format(-1, $this->api_ret_msg('t update failed'));
                }
                $update = Balance::create($insert_data);
                if (!$update) {
                    return $this->res_format(-1, $this->api_ret_msg('b update failed'));
                }
                $update = Product::where('id', $topUp_model->gate_id)->increment('freeze_credit', $topUp_model->amount - $topUp_model->processing_fee);
                if (!$update) {
                    return $this->res_format(-1, $this->api_ret_msg('m update failed'));
                }
            } else {
                $update = $topUp_model->save();
            }

            if ($topUp_model->status == 7 || $topUp_model->status == 2) {
                // 拿出callback_url
                if (!empty($topUp_model->callback_url) || ($topUp_model->callback_url != null)) {
                    $callback_url = $topUp_model->callback_url;
                } else {
                    $callback_url = $topUp_model->gate->callback_url;
                }

                if (!empty($topUp_model->redirect_url) || ($topUp_model->redirect_url != null)) {
                    $redirect_url = $topUp_model->redirect_url;
                } else {
                    $redirect_url = $topUp_model->gate->redirect_url;
                }

                $insert_data_callback = [
                    'amount' => $topUp_model->amount,
                    'status' => 0,
                    'document_no' => $topUp_model->document_no,
                    'merchant_id' => $topUp_model->merchant_id,
                    'client_transaction' => $topUp_model->client_transaction,
                    'return_status' => $topUp_model->status,
                    'throttle' => 0,
                    'gate_id' => $topUp_model->gate_id,
                    'callback_url' => $callback_url,
                    'redirect_url' => $redirect_url,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                DB::table('callback_topups')->insert($insert_data_callback);
            }

            DB::commit();

            return $this->res_format(0, $this->api_ret_msg('api.success'));
        } catch (Exception $e) {

            Log::alert("[" . $request->path() . "]" . $e);

            DB::rollback();

            return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
        }
    }

    public function deposit_daily_adjustment(Request $request)
    {
        abort_if(Gate::denies('deposit_daily_adjustment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $user = Auth::user();

            if (Auth::guard('merchant')->check()) {
                $query = TopUp::with(['merchant', 'gate', 'gate.currency', 'saving_account'])->select(sprintf('%s.*', (new TopUp)->table))->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id)->where('approve_by', '<>', '')->where('amount_adjustment', '<>', 0);
            } else {
                $query = TopUp::with(['merchant', 'gate', 'gate.currency', 'saving_account'])->select(sprintf('%s.*', (new TopUp)->table))->where('approve_by', '<>', '')->where('amount_adjustment', '<>', 0);
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? $row->merchant->name : '';
            });

            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });
            $table->addColumn('c', function ($row) { // currency
                return $row->gate->currency->short_code . ' ';
            });
            $table->editColumn('processing_fee', function ($row) {
                return $row->processing_fee ? number_format($row->processing_fee, 2) : "";
            });
            $table->addColumn('processing', function ($row) {
                return sprintf(" <br> ") . "( " . number_format($row->processing_rate, 2) . "% + " . number_format($row->processing_fix, 2) . " )";
            });
            $table->editColumn('transaction', function ($row) {
                return $row->document_no ? $row->document_no : "";
            });
            $table->editColumn('client_transaction', function ($row) {
                return $row->client_transaction ? $row->client_transaction : "";
            });
            $table->editColumn('status_name', function ($row) {
                return TopUp::STATUS_SELECT[$row->status];
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->editColumn('payment_slip', function ($row) {
                return $row->payment_slip != '' ? '<a href="' . $row->payment_slip->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('freeze', function ($row) {
                return $row->freeze ? $row->freeze : "";
            });
            $table->editColumn('signature', function ($row) {
                return $row->signature ? $row->signature : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'gate', 'payment_slip', 'status', 'processing']);

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

        return view('admin.reporting.deposit_daily_adjustment', compact('currency_arr', 'merchant_arr', 'project_arr'));
    }
}
