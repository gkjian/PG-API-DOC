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

class Partner extends Authenticatable
{
    use HasFactory, HasRoles;

    public $table = 'partners';

    const STATUS_SELECT = [
        '0' => 'Active',
        '1' => 'Inactive',
    ];

    protected $guarded = [];
}