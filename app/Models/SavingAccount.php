<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;

class SavingAccount extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'saving_accounts';

    const STATUS_SELECT = [
        '0' => 'Enabled',
        '1' => 'Disabled',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bank_id',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'currency_id',
        'daily_limit',
        'transaction_limit',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',

        'daily_amount',
        'total_credit',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function check_daily_limit(Collection $topUp_arr, Collection $payout_arr, Collection $settlement_arr)
    {  //收集payout , settlement , top up 的 进行中/成功付款 balance
        $total_amount = 0;
        $count = 0;

        $saving_account_id = $this->id;

        foreach ($payout_arr as $payout) {
            if ($payout['saving_account_id'] == $saving_account_id) {
                $total_amount += $payout->amount;
                $count++;
            }
        }

        foreach ($topUp_arr as $topUp) {
            if ($topUp['saving_account_id'] == $saving_account_id) {
                $total_amount += $topUp->amount;
                $count++;
            }
        }

        foreach ($settlement_arr as $settlement) {
            if ($settlement['saving_account_id'] == $saving_account_id) {
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
