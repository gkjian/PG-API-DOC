<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class Deposit extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'deposits';

    protected $appends = [
        'payment_slip',
    ];

    protected $dates = [
        'processed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Completed',
        '2' => 'Failed',
        '3' => 'Rejected',
        '4' => 'Cancelled',
    ];

    protected $fillable = [
        'merchant_id',
        'amount',
        'processing_fee',
        'processing_rate',
        'currency_id',
        'description',
        'status',
        'remark',
        'ip_address',
        'processed_at',
        'processed_by',
        'created_at',
        'updated_at',
        'deleted_at',

        'document_no',
        'client_transaction_id',
        'gate_id',
        'saving_account_id',
        'processing_fix'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function processed_by()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }

    public function gate()
    {
        return $this->belongsTo(Product::class, 'gate_id');
    }

    public function saving_account()
    {
        return $this->belongsTo(SavingAccount::class, 'saving_account_id');
    }

    public function getProcessedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setProcessedAtAttribute($value)
    {
        $this->attributes['processed_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getPaymentSlipAttribute()
    {
        return $this->getMedia('payment_slip')->last();
    }
}
