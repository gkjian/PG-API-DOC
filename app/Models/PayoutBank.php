<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class PayoutBank extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'payout_banks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'bank_currency',
        'payout_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'bank_code',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function payout()
    {
        return $this->belongsTo(Payout::class, 'payout_id');
    }
}
