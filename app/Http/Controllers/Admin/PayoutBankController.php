<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPayoutBankRequest;
use App\Http\Requests\StorePayoutBankRequest;
use App\Http\Requests\UpdatePayoutBankRequest;
use App\Models\Payout;
use App\Models\PayoutBank;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PayoutBankController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('payout_bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PayoutBank::with(['payout'])->select(sprintf('%s.*', (new PayoutBank)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'payout_bank_show';
                // $editGate      = 'payout_bank_edit';
                // $deleteGate    = 'payout_bank_delete';
                $crudRoutePart = 'payout-banks';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    // 'editGate',
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
            $table->editColumn('bank_currency', function ($row) {
                return $row->bank_currency ? $row->bank_currency : "";
            });
            $table->addColumn('payout_transaction', function ($row) {
                return $row->payout ? $row->payout->document_no : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'payout']);

            return $table->make(true);
        }

        return view('admin.payoutBanks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('payout_bank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = Payout::all()->pluck('document_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.payoutBanks.create', compact('payouts'));
    }

    public function store(StorePayoutBankRequest $request)
    {
        $payoutBank = PayoutBank::create($request->all());

        return redirect()->route('admin.payout-banks.index');
    }

    public function edit(PayoutBank $payoutBank)
    {
        abort_if(Gate::denies('payout_bank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = Payout::all()->pluck('document_no', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payoutBank->load('payout');

        return view('admin.payoutBanks.edit', compact('payouts', 'payoutBank'));
    }

    public function update(UpdatePayoutBankRequest $request, PayoutBank $payoutBank)
    {
        $payoutBank->update($request->all());

        return redirect()->route('admin.payout-banks.index');
    }

    public function show(PayoutBank $payoutBank)
    {
        abort_if(Gate::denies('payout_bank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutBank->load('payout');

        return view('admin.payoutBanks.show', compact('payoutBank'));
    }

    public function destroy(PayoutBank $payoutBank)
    {
        abort_if(Gate::denies('payout_bank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutBank->delete();

        return back();
    }

    public function massDestroy(MassDestroyPayoutBankRequest $request)
    {
        PayoutBank::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
