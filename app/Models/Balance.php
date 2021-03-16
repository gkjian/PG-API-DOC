<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Support\Facades\Schema;

class Balance extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'balances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const SETTLEMENT_STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Completed',
    ];

    const STATUS_SELECT = [
        '0' => 'Completed',
        '1' => 'Canceled',
        '2' => 'Canceled and Refund',
    ];

    const TYPE_SELECT = [
        '0' => 'Deposit',
        '1' => 'Top Up',
        '2' => 'Payout',
        '3' => 'Settlement',
        '4' => 'Merchant Processing Fee',
        '5' => 'Partner Processing Fee',
    ];

    protected $fillable = [
        'merchant_id',
        'debit',
        'credit',
        'type',
        'status',
        'document_no',
        'remark',
        'settlement_status',
        'gate_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'ref_id',
        'saving_account_id',
        'settlement_bank_id',
        'processing_fee',
        'processing_rate',
        'processing_fix',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function gate()
    {
        return $this->belongsTo(Product::class, 'gate_id');
    }

    public function saving_account()
    {
        return $this->belongsTo(SavingAccount::class, 'saving_account_id');
    }

    public function settlement_bank()
    {

        $default = [];

        $all_field = Schema::getColumnListing((new SettlementBank)->getTable());

        foreach($all_field as $field){
            $default[$field] = "";
        }

        return $this->belongsTo(SettlementBank::class, 'settlement_bank_id')->withDefault($default);
    }
}
