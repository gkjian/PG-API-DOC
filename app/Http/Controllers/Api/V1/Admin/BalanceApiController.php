<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBalanceRequest;
use App\Http\Requests\UpdateBalanceRequest;
use App\Http\Resources\Admin\BalanceResource;
use App\Models\Balance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Product;
use App\Models\SavingAccount;
use Illuminate\Support\Facades\DB;

class BalanceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BalanceResource(Balance::with(['merchant', 'gate'])->get());
    }

    public function store(StoreBalanceRequest $request)
    {
        $balance = Balance::create($request->all());

        return (new BalanceResource($balance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Balance $balance)
    {
        abort_if(Gate::denies('balance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BalanceResource($balance->load(['merchant', 'gate']));
    }

    public function update(UpdateBalanceRequest $request, Balance $balance)
    {
        $balance->update($request->all());

        return (new BalanceResource($balance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Balance $balance)
    {
        abort_if(Gate::denies('balance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $balance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function balance_settle(){
        DB::beginTransaction();
        try {
            $res = [];

            // SUM debit and credit groupBy saving_account_id
            $saving_account_ids = Balance::select(DB::raw('SUM(debit) as total_debit, SUM(credit) as total_credit'), 'saving_account_id')
                                        ->where('settlement_status', 0)
                                        ->groupBy('saving_account_id')
                                        ->get();

            // update SavingAccounts' total_credit
            foreach ($saving_account_ids as $sa_id) {
                $total = $sa_id->total_debit - $sa_id->total_credit;
                $saving_account = SavingAccount::find($sa_id->saving_account_id);
                $saving_account->total_credit = $saving_account->total_credit + $total;
                $saving_account->save();

                // save for return
                $res['Saving Account'][] = $saving_account;
            }

            // get Products where freeze_credit != 0
            $products = Product::where('freeze_credit', '<>', 0)->get();

            // update Products' current_credit
            foreach ($products as $product) {
                $product->current_credit = $product->current_credit + $product->freeze_credit;
                $product->freeze_credit = 0;
                $product->save();

                // save for return
                $res['Merchant'][] = $product;
            }

            $res['balance'] = Balance::where('settlement_status', 0)->update(['settlement_status' => '1']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->res_format(-1, $this->api_ret_msg('api.update_failed'));
        }

        return new BalanceResource($res);
    }
}
