<?php

use App\Models\GateSavingAccount;
use App\Models\Payout;
use App\Models\Product;
use App\Models\SavingAccount;
use App\Models\Settlement;
use App\Models\TopUp;
use App\PG_Response\API_RES;
use Illuminate\Support\Facades\Log;

function test_global_func()
{
    return "测试全局";
}

function find_bank_res_format($status,  $reason = [], $bank = [])
{

    return [
        'status' => $status,
        'bank' => $bank,
        'reason' => $reason
    ];
}

function find_bank($gate_id, $amount)
{
    $bank = [];

    $reason = [];

    $Product_db = Product::find($gate_id);

    $payout_disable_limit = Payout::in_progress_transaction($gate_id); // payout list

    $toUp_disable_limit = TopUp::in_progress_transaction($gate_id); // top up list

    $settlement_disable_limit = Settlement::in_progress_transaction($gate_id); // top up list

    $gate_limit = $Product_db->check_daily_limit($toUp_disable_limit, $payout_disable_limit, $settlement_disable_limit);

    $total_disable_amount = $gate_limit['daily_cur_limit_amount'];
    $total_disable = $gate_limit['daily_cur_limit'];

    //检查gate 是否还有足够的次数/金额
    if (($amount > bcsub($Product_db->daily_amount, $total_disable_amount) && $Product_db->daily_amount != null)) {

        //错过当前gate 限制金额
        $reason[] = "Gate ID :" . $Product_db->gate_id . ", Gate Name : " . $Product_db->name . ' (Amount is limit)';

        return find_bank_res_format(false, $reason);
    }

    if ((bcsub($Product_db->daily_limit, $total_disable) <= 0) && $Product_db->daily_limit !=  null) {

        //错过当前gate 限制次数
        $reason[] = "Gate ID :" . $Product_db->gate_id . ", Gate Name : " . $Product_db->name . ' (Frequency is limit)';

        return find_bank_res_format(false, $reason);
    }

    //拿出所有gate 的 gate saving account
    $gate_saving_account_arr = GateSavingAccount::where('gate_id', $gate_id)->get();

    if (($gate_saving_account_arr->count()) > 0) {

        foreach ($gate_saving_account_arr as $i => $gate_saving_account) {

            //检查gate 的 daily limit 是否足够
            $gate_saving_limit = $gate_saving_account->check_daily_limit($toUp_disable_limit, $payout_disable_limit, $settlement_disable_limit);

            $total_disable_amount = $gate_saving_limit['daily_cur_limit_amount'];
            $total_disable = $gate_saving_limit['daily_cur_limit'];

            //检查gate 是否还有足够的次数/金额
            if ($amount > bcsub($gate_saving_account->daily_amount, $total_disable_amount) && $gate_saving_account->daily_amount = null) {

                $reason[] = "Gate Saving ID :" . $gate_saving_account->id . ' (Amount is limit)';
                continue;
            }

            if ((bcsub($gate_saving_account->daily_limit, $total_disable) <= 0) && $gate_saving_account->daily_limit != null) {
                $reason[] = "Gate Saving ID :" . $gate_saving_account->id . ' (Frequency is limit)';
                continue;
            }

            try {
                $tmp_saving_account = $gate_saving_account->saving_account;
            } catch (Exception $e) {
                $reason[] = "Gate Saving ID :" . $gate_saving_account->id . ' is using invalid saving account';
                continue;
            }

            $saving_acc_limit = $tmp_saving_account->check_daily_limit($toUp_disable_limit, $payout_disable_limit, $settlement_disable_limit);

            $total_disable_amount = $saving_acc_limit['daily_cur_limit_amount'];
            $total_disable = $saving_acc_limit['daily_cur_limit'];
            //检查saving account 是否还有足够的次数/金额
            if (($amount > $tmp_saving_account->transaction_limit) && $tmp_saving_account->transaction_limit != null) {
                $reason[] = "Saving Account ID :" . $tmp_saving_account->bank_id . ' (Amount is reach transaction limit)';
                continue;
            }

            if (($amount > bcsub($gate_saving_account->daily_amount, $total_disable_amount)) && $gate_saving_account->daily_amount != null) {
                $reason[] = "Saving Account ID :" . $tmp_saving_account->bank_id . ' (daily limit (amount) is reach daily limit)';
                continue;
            }

            if ((bcsub($gate_saving_account->daily_limit, $total_disable) <= 0) && $gate_saving_account->daily_limit != null) {
                $reason[] = "Saving Account ID :" . $tmp_saving_account->bank_id . ' (daily limit (frequency) is reach daily limit)';
                continue;
            }

            $bank = $tmp_saving_account;

            break;
        }
    } else {

        $reason[] = "Gate ID :" . $Product_db->gate_id . ", Gate Name : " . $Product_db->name . ' (no saving account)';

        return find_bank_res_format(false, $reason);
    }

    if (empty($bank)) {
        $reason[] = "Gate ID :" . $Product_db->gate_id . ", Gate Name : " . $Product_db->name . ' (Cannot find a valid bank)';
        return find_bank_res_format(false, $reason);
    }

    return find_bank_res_format(true, $reason, $bank);

}
