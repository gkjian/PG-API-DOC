<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
// use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Permission extends SpatiePermission
{
    public $table = 'permissions';
    // protected $fillable = [
    //     'type',
    //     'created_by',
    //     'modified_by',
    // ];

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
