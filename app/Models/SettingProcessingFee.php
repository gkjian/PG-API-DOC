<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class SettingProcessingFee extends Model
{
    use SoftDeletes, Auditable, HasFactory;
    //暂时没用
    public $table = 'setting_processing_fee';

    
    const STATUS_SELECT = [
        '0' => 'Enabled',
        '1' => 'Disabled',
    ];

    const TYPE = [
        '0' => 'Deposit',
        '1' => 'Payout',
        '2' => 'Settlment',
        '3' => 'Top Up',
    ];

    const FEE_TYPE = [
        '0' => 'Fix',
        '1' => 'Rate',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'gate_id',
        'fee_type',
        'type',
        'value',
        'range_min',
        'range_max',
        'status',
    ];

    public function gate()
    {

        return $this->belongsTo(Product::class, 'gate_id');
    }
}
