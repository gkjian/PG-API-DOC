<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;

class GateSavingAccount extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'gate_saving_accounts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'gate_id',
        'daily_limit',
        'saving_account_id',
        'created_at',
        'updated_at',
        'deleted_at',

        'daily_amount',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function gate()
    {
        return $this->belongsTo(Product::class, 'gate_id');
    }

    public function saving_account()
    {
        return $this->belongsTo(SavingAccount::class, 'saving_account_id');
    }

    public function check_daily_limit(Collection $topUp_arr, Collection $payout_arr, Collection $settlement_arr)
    {

        //收集payout , settlement , top up 的 进行中/成功付款 balance
        $total_amount = 0;
        $count = 0;

        $saving_account_id = $this->saving_account_id;
        $gate_id = $this->gate_id;

        foreach ($payout_arr as $payout) {
            if ($payout['saving_account_id'] == $saving_account_id && $payout['gate_id'] == $gate_id) {
                $total_amount += $payout->amount;
                $count++;
            }
        }

        foreach ($topUp_arr as $topUp) {
            if ($topUp['saving_account_id'] == $saving_account_id && $topUp['gate_id'] == $gate_id) {
                $total_amount += $topUp->amount;
                $count++;
            }
        }

        foreach ($settlement_arr as $settlement) {
            if ($settlement['saving_account_id'] == $saving_account_id && $settlement['gate_id'] == $gate_id) {
                $total_amount += $settlement->amount;
                $count++;
            }
        }

        return [
            'daily_cur_limit_amount' => $total_amount,
            'daily_cur_limit' => $count,
            // 'list' => $list,
            // 'daily_cur_reply_amount' => 
        ];
    }
}
