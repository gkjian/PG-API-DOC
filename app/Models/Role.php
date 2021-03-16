<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasRoles;

use \DateTimeInterface;

class Role extends SpatieRole
{
    public $table = 'roles';

    public function created_by()
    {
        return $this->belongsTo(Admin::class, 'created_by_id');
    }

    public function modified_by()
    {
        return $this->belongsTo(Admin::class, 'modified_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
