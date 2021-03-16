<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySettlementBankRequest;
use App\Http\Requests\StoreSettlementBankRequest;
use App\Http\Requests\UpdateSettlementBankRequest;
use App\Models\Merchant;
use App\Models\SettlementBank;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

class SettlementBankController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('settlement_bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            $user = Auth::user();

            if (Auth::guard('admin')->check()) {
                $query = SettlementBank::with(['merchant'])->select(sprintf('%s.*', (new SettlementBank)->table));
            } else if (Auth::guard('partner')->check()) {
                $query = SettlementBank::with(['merchant'])->select(sprintf('%s.*', (new SettlementBank)->table));
            } else if (Auth::guard('merchant')->check()) {
                if ($user->parent_id) {
                    $query = SettlementBank::with(['merchant'])->select(sprintf('%s.*', (new SettlementBank)->table))->where('merchant_id', $user->parent_id);
                } else {
                    $query = SettlementBank::with(['merchant'])->select(sprintf('%s.*', (new SettlementBank)->table))->where('merchant_id', $user->id);
                }
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'settlement_bank_show';
                $editGate      = 'settlement_bank_edit';
                // $deleteGate    = 'settlement_bank_delete';
                $crudRoutePart = 'settlement-banks';

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
                return SettlementBank::STATUS_SELECT[$row->status] ? SettlementBank::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant']);

            return $table->make(true);
        }

        return view('admin.settlementBanks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('settlement_bank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::where('parent_id', null)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            $merchant_id = null;

        } else {
            $merchants = null;

            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;
        }

        return view('admin.settlementBanks.create', compact('merchants', 'merchant_id'));
    }

    public function store(StoreSettlementBankRequest $request)
    {
        $settlementBank = SettlementBank::create($request->all());

        return redirect()->route('admin.settlement-banks.index');
    }

    public function edit(SettlementBank $settlementBank)
    {
        abort_if(Gate::denies('settlement_bank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        $merchant_id = 0;

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::where('parent_id', null)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            $merchant_id = null;
        } else {
            $merchants = null;

            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;
        }

        $settlementBank->load('merchant');

        return view('admin.settlementBanks.edit', compact('merchants', 'settlementBank', 'merchant_id'));
    }

    public function update(UpdateSettlementBankRequest $request, SettlementBank $settlementBank)
    {
        $settlementBank->update($request->all());

        return redirect()->route('admin.settlement-banks.index');
    }

    public function show(SettlementBank $settlementBank)
    {
        abort_if(Gate::denies('settlement_bank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settlementBank->load('merchant');

        return view('admin.settlementBanks.show', compact('settlementBank'));
    }

    public function destroy(SettlementBank $settlementBank)
    {
        abort_if(Gate::denies('settlement_bank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settlementBank->delete();

        return back();
    }

    public function massDestroy(MassDestroySettlementBankRequest $request)
    {
        SettlementBank::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
