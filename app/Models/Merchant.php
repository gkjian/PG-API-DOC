<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Traits\HasRoles;

class Merchant extends Authenticatable
{
    use HasFactory, HasRoles;

    public $table = 'merchants';

    const STATUS_SELECT = [
        '0' => 'Active',
        '1' => 'Inactive',
    ];

    protected $guarded = [];
}