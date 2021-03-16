<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class WhitelistIpAddress extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'whitelist_ip_addresses';

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
        'gate_id',
        'ip_address',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function gate()
    {
        return $this->belongsTo(Product::class, 'gate_id');
    }
}
