<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class Product extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'products';

    const STATUS_SELECT = [
        '0' => 'Enabled',
        '1' => 'Disabled',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const FEE_CALCULATION_TYPE = [
        0 => "Subtraction",
        1 => "Addition"
    ];

    protected $fillable = [
        'gate_id',
        'merchant_id',
        'name',
        'secret_key',
        'product_key',
        'status',
        'description',
        'currency_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'callback_url',
        'redirect_url',
        'daily_limit',
        'daily_amount',
        'processing_fee',
        'processing_fee_calc_type'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
    // public function processing_fee()
    // {
    //     return $this->hasMany(SettingProcessingFee::class, 'id', 'gate_id');
    // }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * @$amount 
     * @param $type top up , payout ,settlement , deposit
     * @return array 
     * - //fee_calc_type: 0= 减法 1=加法  //剩减法
     * - amount:传进来的价钱 
     * - //merchant_fix: 当时merchant 要抽的 fee (fix) 
     * - //merchant_rate: 当时merchant 要抽的 fee (rate) 
     * - //merchant_amount_fix: 当时merchant 要抽的 fee 的结果  
     * - //merchant_amount_rate: 当时merchant 要抽的 fee (rate) 的结果 
     * - //merchant_fee: 总共需要扣多少 merchant 
     * - //amount_after_merchant_charge: merchant charge 过的 
     * - pg_fix: 当时 pg 要抽的 fee (fix)
     * - pg_rate: 当时 pg 要抽的 fee (rate)
     * - pg_amount_fix: 当时 pg 要抽的 fee (fix) 的结果 
     * - pg_amount_rate: 当时 pg 要抽的 fee (rate) 的结果 
     * - pg_fee: 总共需要扣多少 pg
     * - //merchant_final_fee: 扣除pg fee 之后的 merchant fee 
     * - user_final_amount: 最后需要返回给user看的钱
     * - merchant_final_amount: merchant 钱包需要扣/加的钱
     */
    public function processing_fee_testing($amount, $type)
    {
        //测试用 暂时弃用

        $res_data = [];

        $merchant_fix = 0;
        $merchant_rate = 0;
        $merchant_amount_fix = 0;
        $merchant_amount_rate = 0;
        $merchant_fee = 0;
        $amount_after_merchant_charge = 0;

        $pg_rate = 0;
        $pg_fix = 0;
        $pg_fee = 0;
        $pg_amount_rate = 0;
        $pg_amount_fix = 0;


        $user_final_amount = 0;
        $merchant_final_amount = 0;

        $gate_processing_fee = json_decode($this->processing_fee);

        // $fee_calc_type = $this->processing_fee_calc_type; // 算法 0 = 减法  1 = 加法
        $fee_calc_type = 0;

        $type = "payout";

        $res_data['type'] = $type;
        $res_data['amount'] = $amount;

        //拿出rate 和 fix
        switch (strtoupper($type)) {
            case "TOP_UP":

                //流程是 merchant charge user, pg charge merchant
                $pg_rate = $gate_processing_fee->top_up[0]->rate; //2%
                $pg_fix = $gate_processing_fee->top_up[0]->fix;  //3

                $merchant_rate = $gate_processing_fee->top_up_merchant[0]->rate; //3%
                $merchant_fix = $gate_processing_fee->top_up_merchant[0]->fix; // 4

                $merchant_amount_rate = ($amount / 100) * $merchant_rate; //2
                $merchant_amount_fix = $merchant_fix; //2

                $merchant_fee = bcadd($merchant_amount_rate, $merchant_amount_fix, 2);

                if ($fee_calc_type == 1) {
                    //走加法
                    //用户需要bank in 给pg 的钱的变多
                    $user_final_amount = $amount + $merchant_fee; // merchant 将 processing fee 转嫁 给 user
                } else {
                    $user_final_amount = $amount;
                }

                // $amount_after_merchant_charge = $amount ;

                $pg_amount_rate = ($amount / 100) * $pg_rate; //2
                $pg_amount_fix = $pg_fix; //2

                $pg_fee = bcadd($pg_amount_rate, $pg_amount_fix, 2);

                $merchant_final_fee = bcsub($merchant_fee, $pg_fee, 2);

                $merchant_final_amount = bcadd($amount, $merchant_final_fee, 2);

                break;
            case "PAYOUT":

                //流程是pg 先charge merchant, merchant charge user
                $pg_rate = $gate_processing_fee->payout[0]->rate;
                $pg_fix = $gate_processing_fee->payout[0]->fix;

                $merchant_rate = $gate_processing_fee->payout_merchant[0]->rate; //3%
                $merchant_fix = $gate_processing_fee->payout_merchant[0]->fix; // 4

                $merchant_amount_rate = ($amount / 100) * $merchant_rate; //2
                $merchant_amount_fix = $merchant_fix; //2

                $merchant_fee = bcadd($merchant_amount_rate, $merchant_amount_fix, 2);

                // $amount_after_merchant_charge = $amount - $merchant_fee;
                if ($fee_calc_type == 0) {
                    //走减法
                    $user_final_amount = $amount - $merchant_fee;
                } else if ($fee_calc_type == 1) {
                    //走加法
                    $user_final_amount = $amount; // merchant 将 fee 转嫁
                }

                $pg_amount_rate = ($amount / 100) * $pg_rate; //2
                $pg_amount_fix = $pg_fix; //2

                $pg_fee = bcadd($pg_amount_rate, $pg_amount_fix, 2);

                $merchant_final_fee = bcsub($merchant_fee, $pg_fee, 2);

                $merchant_final_amount = - ($amount + $pg_fee - $merchant_fee);

                break;
            case "SETTLEMENT":
                $pg_rate = $gate_processing_fee->settlement[0]->rate;
                $pg_fix = $gate_processing_fee->settlement[0]->fix;

                $pg_amount_rate = ($amount / 100) * $pg_rate; //2
                $pg_amount_fix = $pg_fix; //2

                $merchant_rate = $gate_processing_fee->settlement_merchant[0]->rate; //3%
                $merchant_fix = $gate_processing_fee->settlement_merchant[0]->fix; // 4

                $merchant_amount_rate = ($amount / 100) * $merchant_rate; //2
                $merchant_amount_fix = $merchant_fix; //2

                // $amount_after_merchant_charge = $amount - $merchant_fee;
                if ($fee_calc_type == 0) {
                    //走减法
                    $user_final_amount = $amount - $merchant_fee;
                } else if ($fee_calc_type == 1) {
                    //走加法
                    $user_final_amount = $amount; // merchant 将 fee 转嫁
                }

                $pg_amount_rate = ($amount / 100) * $pg_rate; //2
                $pg_amount_fix = $pg_fix; //2

                $pg_fee = bcadd($pg_amount_rate, $pg_amount_fix, 2);

                $merchant_final_fee = bcsub($merchant_fee, $pg_fee, 2);

                $merchant_final_amount = - ($amount + $pg_fee - $merchant_fee);

                break;
            case "DEPOSIT":
                $pg_rate = $gate_processing_fee->deposit[0]->rate;
                $pg_fix = $gate_processing_fee->deposit[0]->fix;

                $pg_amount_rate = ($amount / 100) * $pg_rate; //2
                $pg_amount_fix = $pg_fix; //2

                $merchant_rate = $gate_processing_fee->deposit_merchant[0]->rate; //3%
                $merchant_fix = $gate_processing_fee->deposit_merchant[0]->fix; // 4

                $merchant_amount_rate = ($amount / 100) * $merchant_rate; //2
                $merchant_amount_fix = $merchant_fix; //2

                break;
        }

        return [
            // 'fee_calc_type' => $fee_calc_type,
            'type' => $type,
            'amount' => $amount,
            // 'merchant_fix' => $merchant_fix,
            // 'merchant_rate' => $merchant_rate,
            // 'merchant_amount_fix' => $merchant_amount_fix,
            // 'merchant_amount_rate' => $merchant_amount_rate,
            // 'merchant_fee' => $merchant_fee,
            // 'amount_after_merchant_charge' => $amount_after_merchant_charge,
            'pg_fix' => $pg_fix,
            'pg_rate' => $pg_rate,
            'pg_amount_fix' => $pg_amount_fix,
            'pg_amount_rate' => $pg_amount_rate,
            'pg_fee' => $pg_fee,
            // 'merchant_final_fee' => $merchant_final_fee,
            'user_final_amount' => $user_final_amount,
            'merchant_final_amount' => $merchant_final_amount,
        ];
    }

    public function check_daily_limit(Collection $topUp_arr, Collection $payout_arr, Collection $settlement_arr)
    {

        //收集payout , settlement , top up 的
        $total_amount = 0;
        $count = 0;

        foreach ($payout_arr as $payout) {
            $total_amount += $payout->amount;
        }

        foreach ($topUp_arr as $topUp) {
            $total_amount += $topUp->amount;
        }


        foreach ($settlement_arr as $settlement) {
            $total_amount += $settlement->amount;
        }


        $count = $payout_arr->count() + $topUp_arr->count() + $settlement_arr->count();

        return [
            'daily_cur_limit_amount' => $total_amount,
            'daily_cur_limit' => $count,
            // 'list' => $list,
            // 'daily_cur_reply_amount' => 
        ];
    }
    /**
     * @param $secret_key  merchant 传过来的 secret_key
     * @param $product_key merchant 传过来的 product_key
     */
    public function verify_key(String $secret_key, String $product_key)
    {

        $gate_secret_key = strval($this->secret_key);
        $gate_product_key = strval($this->product_key);

        if (strcmp($gate_secret_key, $secret_key) != 0) {
            //strcmp 0 == equal
            return false;
        }

        if (strcmp($gate_product_key, $product_key) != 0) {
            //strcmp 0 == equal

            return false;
        }

        return true;
    }

    /**
     * @$amount 
     * @param $type top up , payout ,settlement , deposit
     */
    public function processing_fee($amount, $type)
    {

        $gate_processing_fee = json_decode($this->processing_fee);

        $rate = 0;
        $fix = 0;

        switch (strtoupper($type)) {
            case "TOP_UP":
                $rate = $gate_processing_fee->top_up[0]->rate;
                $fix = $gate_processing_fee->top_up[0]->fix;
                break;
            case "PAYOUT":
                $rate =  $gate_processing_fee->payout[0]->rate;
                $fix = $gate_processing_fee->payout[0]->fix;
                break;
            case "SETTLEMENT":
                $rate =  $gate_processing_fee->settlement[0]->rate;
                $fix = $gate_processing_fee->settlement[0]->fix;
                break;
            case "DEPOSIT":
                $rate = $gate_processing_fee->deposit[0]->rate;
                $fix = $gate_processing_fee->deposit[0]->fix;
                break;
        }

        $total_rate = ($amount / 100) * $rate;
        $total_fix = $fix;

        $total_fee = bcadd($total_rate, $total_fix, 2);

        return [
            'type' => $type,
            'config_rate' => $rate,
            'config_fix' => $fix,
            'rate' => $total_rate,
            'fix' => $total_fix,
            'fee' => $total_fee,
        ];
    }
}
