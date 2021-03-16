<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySavingAccountRequest;
use App\Http\Requests\StoreSavingAccountRequest;
use App\Http\Requests\UpdateSavingAccountRequest;
use App\Models\Currency;
use App\Models\GateSavingAccount;
use App\Models\Payout;
use App\Models\Product;
use App\Models\SavingAccount;
use App\Models\Settlement;
use App\Models\TopUp;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SavingAccountController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('saving_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SavingAccount::with(['currency'])->select(sprintf('%s.*', (new SavingAccount)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'saving_account_show';
                $editGate      = 'saving_account_edit';
                // $deleteGate    = 'saving_account_delete';
                $crudRoutePart = 'saving-accounts';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    // 'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
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

            $table->addColumn('currency_name', function ($row) {
                return $row->currency ? $row->currency->name . '(' . $row->currency->short_code . ')' : '';
            });

            $table->editColumn('daily_limit', function ($row) {
                return $row->daily_limit ? number_format($row->daily_limit, 2) : "";
            });
            $table->editColumn('transaction_limit', function ($row) {
                return $row->transaction_limit ? number_format($row->transaction_limit, 2) : "";
            });
            $table->editColumn('status', function ($row) {
                return ($row->status != null) ? SavingAccount::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'currency']);

            return $table->make(true);
        }

        return view('admin.savingAccounts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('saving_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $currencies = Currency::all();

        return view('admin.savingAccounts.create', compact('currencies'));
    }

    public function store(StoreSavingAccountRequest $request)
    {
        $savingAccount = SavingAccount::create($request->all());

        return redirect()->route('admin.saving-accounts.index');
    }

    public function edit(SavingAccount $savingAccount)
    {
        abort_if(Gate::denies('saving_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $currencies = Currency::all();

        $savingAccount->load('currency');

        return view('admin.savingAccounts.edit', compact('currencies', 'savingAccount'));
    }

    public function update(UpdateSavingAccountRequest $request, SavingAccount $savingAccount)
    {
        $savingAccount->update($request->all());

        return redirect()->route('admin.saving-accounts.index');
    }

    public function show(SavingAccount $savingAccount)
    {
        abort_if(Gate::denies('saving_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $savingAccount->load('currency');

        return view('admin.savingAccounts.show', compact('savingAccount'));
    }

    public function destroy(SavingAccount $savingAccount)
    {
        abort_if(Gate::denies('saving_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $savingAccount->delete();

        return back();
    }

    public function massDestroy(MassDestroySavingAccountRequest $request)
    {
        SavingAccount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function check_bank_balance(Request $request)
    {
        //接口
        $res_data = [];

        $bank_id = $request->has('bank_id') ? $request->query('bank_id') : null;

        if ($bank_id == null) {
            return [];
        }

        $gate_id = $request->has('gate_id') ? $request->query('gate_id') : null;

        if ($bank_id == null) {
            return [];
        }

        $project = Product::find($gate_id);

        if (empty($project)) {

            return [];
        }

        $in_processing_payout = Payout::in_progress_transaction($gate_id);

        $in_processing_top_up = TopUp::in_progress_transaction($gate_id);

        $in_processing_settlement = Settlement::in_progress_transaction($gate_id);

        $res_data['project'] = $project;

        $project_limit = $project->check_daily_limit($in_processing_top_up, $in_processing_payout, $in_processing_settlement);

        $res_data['gate_balance'] = $project['daily_amount'] != null ? $project['daily_amount'] - $project_limit['daily_cur_limit_amount'] : "infinity";
        $res_data['gate_balance_limit'] =  $project['daily_limit'] != null ? $project['daily_limit'] - $project_limit['daily_cur_limit'] : "infinity";

        //算 gate saving 
        $gate_saving_acc = GateSavingAccount::where('gate_id', $gate_id)->where('saving_account_id', $bank_id)->first();

        $res_data['gate_saving_acc'] = $project;

        $gate_saving_limit = $gate_saving_acc->check_daily_limit($in_processing_top_up, $in_processing_payout, $in_processing_settlement);

        $res_data['gate_saving_balance'] = $gate_saving_acc['daily_amount'] != null ? $gate_saving_acc['daily_amount'] - $gate_saving_limit['daily_cur_limit_amount'] : "infinity";
        $res_data['gate_saving_balance_limit'] =  $gate_saving_acc['daily_limit'] != null ? $gate_saving_acc['daily_limit'] - $gate_saving_limit['daily_cur_limit'] : "infinity";

        //算银行的
        $saving_acc = SavingAccount::find($bank_id);

        $res_data['saving_acc'] = $saving_acc;

        $saving_limit = $saving_acc->check_daily_limit($in_processing_top_up, $in_processing_payout, $in_processing_settlement);

        $res_data['saving_acc_balance'] = $saving_acc['daily_amount'] != null ? $saving_acc['daily_amount'] - $saving_limit['daily_cur_limit_amount'] : "infinity";
        $res_data['saving_acc_balance_limit'] =  $saving_acc['daily_limit'] != null ? $saving_acc['daily_limit'] - $saving_limit['daily_cur_limit'] : "infinity";

        return $res_data;
    }

    public function get_bank_data(Request $request) {
        $id = $request->has('id') ? $request->query('id') : null;

        if ($id == null) {
            return [];
        }
        
        return SavingAccount::where('id', $id)->first();
    }

}
