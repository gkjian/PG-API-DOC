<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class ApiKey extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'api_keys';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'api_key',
        'gate_id',
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
    
    public function scopeGenerateApiKey($query, $length, $gate_id)
    {

        do {
            $key = $this->generate($length);
            $check = ApiKey::where('api_key', $key)->count();
        } while ($check >= 1);

        ApiKey::create(['api_key' => $key, 'gate_id' => $gate_id]);

        return $key;
    }

    function generate($length)
    {

        $pool = array_merge(range(2, 9), range('a', 'h'), range('j', 'k'), range('m', 'n'), range('p', 'z'));

        $key = "";

        for ($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }

        return $key;
    }
}
