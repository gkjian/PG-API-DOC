<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyGateSavingAccountRequest;
use App\Http\Requests\StoreGateSavingAccountRequest;
use App\Http\Requests\UpdateGateSavingAccountRequest;
use App\Models\GateSavingAccount;
use App\Models\Product;
use App\Models\SavingAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

class GateSavingAccountController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('project_saving_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            if (Auth::guard('merchant')->check()) {
                $query = GateSavingAccount::whereHas('gate', function ($query) {
                    $user = Auth::user();
                    return $query->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id);
                })->with(['saving_account'])->select(sprintf('%s.*', (new GateSavingAccount)->table));
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('admin')->check()) {
                $query = GateSavingAccount::with(['gate', 'saving_account'])->select(sprintf('%s.*', (new GateSavingAccount)->table));
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'project_saving_account_show';
                $editGate      = 'project_saving_account_edit';
                // $deleteGate    = 'project_saving_account_delete';
                $crudRoutePart = 'gate-saving-accounts';

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
            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->addColumn('daily_limit', function ($row) {
                return $row->daily_limit ? number_format($row->daily_limit, 2) : '';
            });

            $table->addColumn('saving_account_bank_name', function ($row) {
                return $row->saving_account ? $row->saving_account->bank_name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'gate', 'saving_account']);

            return $table->make(true);
        }

        return view('admin.gateSavingAccounts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('project_saving_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        if (Auth::guard('merchant')->check()) {
            $gates = Product::where('merchant_id', $user->parent_id ? $user->parent_id : $user->id)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else if (Auth::guard('partner')->check()) {
        } else if (Auth::guard('admin')->check()) {
            $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }
        $saving_accounts = SavingAccount::all()->pluck('bank_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.gateSavingAccounts.create', compact('gates', 'saving_accounts'));
    }

    public function store(StoreGateSavingAccountRequest $request)
    {
        $gateSavingAccount = GateSavingAccount::create($request->all());

        return redirect()->route('admin.gate-saving-accounts.index');
    }

    public function edit(GateSavingAccount $gateSavingAccount)
    {
        abort_if(Gate::denies('project_saving_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        if (Auth::guard('merchant')->check()) {
            $gates = Product::where('merchant_id', $user->parent_id ? $user->parent_id : $user->id)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else if (Auth::guard('partner')->check()) {
        } else if (Auth::guard('admin')->check()) {
            $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $saving_accounts = SavingAccount::all()->pluck('bank_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gateSavingAccount->load('gate', 'saving_account');

        return view('admin.gateSavingAccounts.edit', compact('gates', 'saving_accounts', 'gateSavingAccount'));
    }

    public function update(UpdateGateSavingAccountRequest $request, GateSavingAccount $gateSavingAccount)
    {
        $gateSavingAccount->update($request->all());

        return redirect()->route('admin.gate-saving-accounts.index');
    }

    public function show(GateSavingAccount $gateSavingAccount)
    {
        abort_if(Gate::denies('project_saving_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateSavingAccount->load('gate', 'saving_account');

        return view('admin.gateSavingAccounts.show', compact('gateSavingAccount'));
    }

    public function destroy(GateSavingAccount $gateSavingAccount)
    {
        abort_if(Gate::denies('project_saving_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateSavingAccount->delete();

        return back();
    }

    public function massDestroy(MassDestroyGateSavingAccountRequest $request)
    {
        GateSavingAccount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function get_bank_list(Request $request)
    {

        $gate_id = $request->has('gate_id') ? $request->query('gate_id') : null;

        if ($gate_id == null) {
            return [];
        }
        
        return GateSavingAccount::with(['saving_account'])->where('gate_id', $gate_id)->get();
    }
}
