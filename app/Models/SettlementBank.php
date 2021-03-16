<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class SettlementBank extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'settlement_banks';

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
        'merchant_id',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'bank_code',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
}
