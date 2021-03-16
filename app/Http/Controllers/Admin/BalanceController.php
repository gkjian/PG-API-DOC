<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBalanceRequest;
use App\Http\Requests\StoreBalanceRequest;
use App\Http\Requests\UpdateBalanceRequest;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use App\Models\SavingAccount;
use App\Models\SettlementBank;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {

        abort_if(Gate::denies('balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            if (Auth::guard('merchant')->check()) {
                $query = Balance::whereHas('merchant', function ($query) {
                    $user = Auth::user();
                    return $query->where('id', $user->parent_id ? $user->parent_id : $user->id);
                })->with(['saving_account', 'gate', 'gate.currency' , 'settlement_bank'])->select(sprintf('%s.*', (new Balance)->table));
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('admin')->check()) {
                $query = Balance::with(['merchant', 'saving_account', 'gate', 'gate.currency' , 'settlement_bank'])->select(sprintf('%s.*', (new Balance)->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'balance_show';
                // $editGate      = 'balance_edit';
                // $deleteGate    = 'balance_delete';
                $crudRoutePart = 'balances';

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
            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? sprintf('<a href=' . route('admin.merchants.show', $row->merchant->id) . '>%s</a>', $row->merchant->name) : '';
            });

            $table->editColumn('debit', function ($row) {
                return $row->debit ? number_format($row->debit, 2) : "";
            });
            $table->editColumn('credit', function ($row) {
                return $row->credit ? number_format($row->credit, 2) : "";
            });
            $table->editColumn('type', function ($row) {
                return Balance::TYPE_SELECT[$row->type] ? Balance::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('status_name', function ($row) {
                return Balance::STATUS_SELECT[$row->status] ? Balance::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('transaction', function ($row) {
                return $row->document_no ? $row->document_no : "";
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->editColumn('settlement_status_name', function ($row) {
                return Balance::SETTLEMENT_STATUS_SELECT[$row->settlement_status] ? Balance::SETTLEMENT_STATUS_SELECT[$row->settlement_status] : '';
            });
            $table->editColumn('processing_fee', function ($row) {
                return $row->processing_fee ? number_format($row->processing_fee, 2) . sprintf(" <br> ") ."( ". number_format($row->processing_rate, 2) . "% + " . number_format($row->processing_fix, 2) . " )" : "";
            });
            $table->editColumn('currency', function ($row) {
                return $row->gate->currency->name ? $row->gate->currency->name : "";
            });
            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'gate', 'merchant_name', 'processing_fee']);

            return $table->make(true);
        }

        return view('admin.balances.index');
    }

    public function create()
    {
        abort_if(Gate::denies('balance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchants = Merchant::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $saving_accounts = SavingAccount::all()->pluck('bank_id', 'id')->prepend(trans('global.pleaseSelect'), '');

        $settlement_banks = SettlementBank::all()->pluck('bank_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.balances.create', compact('merchants', 'gates', 'saving_accounts', 'settlement_banks'));
    }

    public function store(StoreBalanceRequest $request)
    {
        $balance = Balance::create($request->all());

        return redirect()->route('admin.balances.index');
    }

    public function edit(Balance $balance)
    {
        abort_if(Gate::denies('balance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchants = Merchant::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $saving_accounts = SavingAccount::all()->pluck('bank_id', 'id')->prepend(trans('global.pleaseSelect'), '');

        $settlement_banks = SettlementBank::all()->pluck('bank_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $balance->load('merchant', 'gate', 'saving_account', 'settlement_bank');

        return view('admin.balances.edit', compact('merchants', 'gates', 'balance', 'saving_accounts', 'settlement_banks'));
    }

    public function update(UpdateBalanceRequest $request, Balance $balance)
    {
        $balance->update($request->all());

        return redirect()->route('admin.balances.index');
    }

    public function show(Balance $balance)
    {
        abort_if(Gate::denies('balance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->load('merchant', 'gate');
        $ref = '';

        switch ($balance->type) {
            case '0':
                $ref = '<a href="' . env('APP_URL', 'http://localhost') . '/top-ups/' . $balance->ref_id . '" target="_blank">' . $balance->ref_id . '</a>';
                break;
            case '1':
                $ref = '<a href="' . env('APP_URL', 'http://localhost') . '/deposits/' . $balance->ref_id . '" target="_blank">' . $balance->ref_id . '</a>';
                break;
            case '2':
                $ref = '<a href="' . env('APP_URL', 'http://localhost') . '/payouts/' . $balance->ref_id . '" target="_blank">' . $balance->ref_id . '</a>';
                break;
            case '3':
                $ref = '<a href="' . env('APP_URL', 'http://localhost') . '/settlements/' . $balance->ref_id . '" target="_blank">' . $balance->ref_id . '</a>';
                break;
        }

        return view('admin.balances.show', compact('balance', 'ref'));
    }

    public function destroy(Balance $balance)
    {
        abort_if(Gate::denies('balance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->delete();

        return back();
    }

    public function massDestroy(MassDestroyBalanceRequest $request)
    {
        Balance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function balance_settle()
    {
        Artisan::call('balance_settlement:daily');

        return redirect()->route('admin.balances.index');
    }

    public function daily_statement(Request $request)
    {
        // abort_if(Gate::denies('daily_statement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            if (Auth::guard('merchant')->check()) {
                $query = Balance::whereHas('merchant', function ($query) {
                    $user = Auth::user();
                    return $query->where('id', $user->parent_id ? $user->parent_id : $user->id);
                })->with(['saving_account', 'gate', 'gate.currency' , 'settlement_bank'])->select(sprintf('%s.*', (new Balance)->table));
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('admin')->check()) {
                // $query = Balance::with(['merchant', 'saving_account', 'gate', 'gate.currency' , 'settlement_bank'])->select(sprintf('%s.*', (new Balance)->table));
                $query = Balance::with(['merchant', 'gate', 'gate.currency'])
                            ->select('merchant_id', 'gate_id', 'type', 'processing_rate',
                                DB::raw('
                                    DATE(created_at) AS date,
                                    SUM(debit) AS total_debit,
                                    SUM(credit) AS total_credit,
                                    SUM(processing_fee) AS total_fee,
                                    SUM(processing_fix) AS total_fix
                                ')
                            )->where('settlement_status', 0)
                        ->groupBy('date', 'merchant_id', 'gate_id', 'type', 'processing_rate');
            }

            $gates = Product::select('id', 'current_credit')->whereIn('id', Balance::select('gate_id')->groupBy('gate_id')->get())->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            // $table->addColumn('actions', '&nbsp;');

            // $table->editColumn('actions', function ($row) {
            //     $viewGate      = 'balance_show';
            //     $editGate      = 'balance_edit';
            //     $deleteGate    = 'balance_delete';
            //     $crudRoutePart = 'balances';

            //     return view('partials.datatablesActions', compact(
            //         'viewGate',
            //         'editGate',
            //         'deleteGate',
            //         'crudRoutePart',
            //         'row'
            //     ));
            // });

            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? sprintf('<a href=' . route('admin.merchants.show', $row->merchant->id) . '>%s</a>', $row->merchant->name) : '';
            });
            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? sprintf('<a href=' . route('admin.products.show', $row->gate->id) . '>%s</a>', $row->gate->name) : '';
            });
            $table->editColumn('type', function ($row) {
                return Balance::TYPE_SELECT[$row->type] ? Balance::TYPE_SELECT[$row->type] : '';
            });
            $table->addColumn('amount', function ($row) {
                if ($row->total_debit != 0) {
                    return number_format($row->total_debit, 2);
                } else {
                    return number_format(-$row->total_credit, 2);
                }
            });
            $table->editColumn('total_fee', function ($row) {
                return $row->total_fee ? number_format(-$row->total_fee, 2) : "";
            });
            $table->addColumn('processing', function ($row) {
                return sprintf("<br><b class='text-danger'>(%s%% + %s)</b>", number_format($row->processing_rate), number_format($row->total_fix, 2));
            });
            $table->addColumn('total_amount', function ($row) {
                if ($row->total_debit != 0) {
                    return number_format($row->total_debit - $row->total_fee, 2);
                } else {
                    return number_format(-$row->total_credit - $row->total_fee, 2);
                }
            });
            $table->addColumn('balance_after', function ($row) use ($gates) {
                foreach ($gates as $gate) {
                    if ($gate->id == $row->gate_id) {
                        $gate->current_credit = $gate->current_credit + $row->total_debit - $row->total_credit - $row->total_fee;
                        return number_format($gate->current_credit, 2);
                    }
                }
            });
            $table->addColumn('currency', function ($row) {
                return $row->gate->currency->short_code ? $row->gate->currency->short_code : "";
            });

            // $table->editColumn('id', function ($row) {
            //     return $row->id ? $row->id : "";
            // });
            // $table->editColumn('debit', function ($row) {
            //     return $row->debit ? number_format($row->debit, 2) : "";
            // });
            // $table->editColumn('credit', function ($row) {
            //     return $row->credit ? number_format($row->credit, 2) : "";
            // });
            // $table->editColumn('status_name', function ($row) {
            //     return Balance::STATUS_SELECT[$row->status] ? Balance::STATUS_SELECT[$row->status] : '';
            // });
            // $table->editColumn('transaction', function ($row) {
            //     return $row->document_no ? $row->document_no : "";
            // });
            // $table->editColumn('remark', function ($row) {
            //     return $row->remark ? $row->remark : "";
            // });
            // $table->editColumn('settlement_status_name', function ($row) {
            //     return Balance::SETTLEMENT_STATUS_SELECT[$row->settlement_status] ? Balance::SETTLEMENT_STATUS_SELECT[$row->settlement_status] : '';
            // });

            $table->rawColumns([/*'actions', 'merchant', */'placeholder', 'merchant_name', 'gate_name', 'processing']);

            return $table->make(true);
        }

        $currency_arr = Currency::all()->pluck('short_code', 'id');
        return view('admin.reporting.daily_statement', compact('currency_arr'));
    }
}
