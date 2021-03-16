<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDepositRequest;
use App\Http\Requests\StoreDepositRequest;
use App\Http\Requests\UpdateDepositRequest;
use App\Models\Deposit;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\GateSavingAccount;
use App\Models\Admin;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\SavingAccount;
use App\Models\Balance;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('top_up_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            if (Auth::guard('admin')->check()) {
                $query = Deposit::with(['merchant', 'gate'])->select(sprintf('%s.*', (new Deposit)->table));
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('merchant')->check()) {
                $user = Auth::user();
                $query = Deposit::with(['merchant', 'gate'])->select(sprintf('%s.*', (new Deposit)->table))->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id);
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {

                $viewGate      = 'top_up_show';
                // $editGate      = 'top_up_edit';
                // $deleteGate    = 'top_up_delete';
                $crudRoutePart = 'deposits';
                $approveGate   = 'top_up_edit';
                $img = ($row->payment_slip) ? $row->payment_slip->getUrl() : '';

                $status = Deposit::STATUS_SELECT[$row->status];
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
                        $status = sprintf('<span class="badge badge-warning" style="color:white">%s</span>', $status);
                        break;
                }

                $depositAction = null;

                if (Auth::guard('admin')->check()) {
                    if ($status != 'Completed' || $status != 'Rejected') {
                        $depositAction = 'depositAction';
                    }
                }

                $img = ($row->payment_slip) ? $row->payment_slip->getUrl() : '';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    // 'editGate',
                    // 'deleteGate',
                    'crudRoutePart',
                    'depositAction',
                    'row',
                    'status',
                    'img'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->addColumn('document_no', function ($row) {
                return $row->document_no ? $row->document_no : "";
            });

            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? $row->merchant->name : '';
            });

            $table->addColumn('project_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? number_format($row->amount, 2) : "";
            });
            $table->editColumn('processing_fee', function ($row) {
                return $row->processing_fee ? number_format($row->processing_fee, 2) . sprintf(" <br> ") . "( " . number_format($row->processing_rate, 2) . "% +" . number_format($row->processing_fix, 2) . " )" : "";
            });
            $table->editColumn('bank_name', function ($row) {
                return $row->bank_name ? $row->bank_name : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('status_name', function ($row) {
                return Deposit::STATUS_SELECT[$row->status];
             });
            $table->editColumn('status', function ($row) {
                return isset($row->status) ? $row->status : "";
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'status', 'processing_fee']);

            return $table->make(true);
        }

        return view('admin.deposits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('top_up_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);
            $merchant_id = null;

            $gates = Product::all();
        } else if (Auth::guard('partner')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);
            $merchant_id = null;

            $gates = Product::all();
        } else {
            $merchants = null;

            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;

            if ($user->parent_id) {
                $gates = Product::all()->where('merchant_id', $user->parent_id);
            } else {
                $gates = Product::all()->where('merchant_id', $user->id);
            }

        }

        $no = Deposit::whereRaw('DATE(created_at) = CURDATE()')->count('created_at') + 1;
        $no = substr_replace('000', $no, 3 - strlen($no));
        $document_no = 'd' . now()->format('ymdHis') . $no;

        return view('admin.deposits.create', compact('merchants', 'merchant_id', 'document_no', 'gates'));
    }

    public function store(StoreDepositRequest $request)
    {
        if (Auth::guard('admin')->check()) {
            $request['processed_by'] = Auth::id();
        }

        $gate = Product::find($request->input('gate_id'));
        $saving_account = GateSavingAccount::find($request->input('gate_id'));

        $request['ip_address'] = $request->ip();
        $request['status'] = '0';
        $request['currency_id'] = $gate['currency_id'];
        $processing = $gate->processing_fee($request->amount, "DEPOSIT");
        $request['processing_fee'] = $processing['fee'];
        $request['processing_rate'] = $processing['config_rate'];
        $request['processing_fix'] = $processing['config_fix'];
        $request['saving_account_id'] = $saving_account['saving_account_id'];

        $deposit = Deposit::create($request->all());

        if ($request->input('payment_slip', false)) {
            $deposit->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $deposit->id]);
        }

        return redirect()->route('admin.deposits.index');
    }

    public function edit(Deposit $deposit)
    {
        abort_if(Gate::denies('top_up_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        };

        $currencies = Currency::all()->pluck('short_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deposit->load('merchant', 'currency');

        return view('admin.deposits.edit', compact('merchants', 'currencies', 'deposit'));
    }

    public function update(UpdateDepositRequest $request, Deposit $deposit)
    {
        $deposit->update($request->all());

        if ($request->input('payment_slip', false)) {
            if (!$deposit->payment_slip || $request->input('payment_slip') !== $deposit->payment_slip->file_name) {
                if ($deposit->payment_slip) {
                    $deposit->payment_slip->delete();
                }

                $deposit->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
            }
        } elseif ($deposit->payment_slip) {
            $deposit->payment_slip->delete();
        }

        return redirect()->route('admin.deposits.index');
    }

    public function show(Deposit $deposit)
    {
        abort_if(Gate::denies('top_up_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deposit->load('merchant', 'currency', 'processed_by', 'saving_account', 'gate');
        // dd($deposit);

        return view('admin.deposits.show', compact('deposit'));
    }

    public function destroy(Deposit $deposit)
    {
        abort_if(Gate::denies('top_up_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deposit->delete();

        return back();
    }

    public function massDestroy(MassDestroyDepositRequest $request)
    {
        Deposit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function deposit_approve(Request $request){ // 拒绝或者接受
        if(empty($request->id) || $request->id == null){
            return $this->res_format(-1, $this->api_ret_msg('api.failed'));
        }

        $deposit_model = Deposit::find($request->id);
        $deposit_model->status = $request->status;
        $deposit_model->processed_at = now();
        $deposit_model->processed_by = Auth::id();

        if($request->status == '1'){
            // 成功交易存进 balances
            $insert_data = [
                'merchant_id'       => $deposit_model->merchant_id,
                'debit'             => $deposit_model->amount,
                'credit'            => 0,
                'type'              => 1,
                'remark'            => '',
                'status'            => 0,
                'settlement_status' => 0,
                'ref_id'            => $deposit_model->id,
                'gate_id'           => $deposit_model->gate_id,
                'document_no'       => $deposit_model->document_no,
                'processing_fee'    => $deposit_model->processing_fee,
                'processing_fix'    => $deposit_model->processing_fix,
                'processing_rate'   => $deposit_model->processing_rate,
                'saving_account_id' => $deposit_model->saving_account_id
            ];

            DB::beginTransaction();
            try {
                $update = $deposit_model->save();
                if(!$update){
                    return $this->res_format(-1, $this->api_ret_msg('d update failed'));
                }
                $update = Balance::create($insert_data);
                if(!$update){
                    return $this->res_format(-1, $this->api_ret_msg('b update failed'));
                }
                $update = Product::where('id', $deposit_model->gate_id)->increment('current_credit', $deposit_model->amount - $deposit_model->processing_fee);
                if(!$update){
                    return $this->res_format(-1, $this->api_ret_msg('m update failed'));
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
            }
        }else{
            $update = $deposit_model->save();
            if(!$update){
                return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
            }
        }

        return $this->res_format(0, $this->api_ret_msg('api.success'));
    }
}
