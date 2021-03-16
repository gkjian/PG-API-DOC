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
use Spatie\MediaLibrary\MediaCollections\File;

class TopUp extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'top_ups';

    protected $appends = [
        'payment_slip',
    ];

    const STATUS_SELECT = [
        '0' => 'Initial',
        '1' => 'Failed',
        '2' => 'Rejected',
        // '3' => 'Not Verify',
        // '4' => 'KIV',
        '5' => 'Pending',
        // '6' => 'Verified',
        '7' => 'Approved',
        // '8' => 'Reconfirmed',
        '9' => 'Expired'
    ];

    const STATUS_VERIFY_SELECT = [
        '0' => "Unverified",
        '1' => "Verified",
        '2' => 'KIV',
        '3' => 'Reconfirmed',
    ];

    protected $dates = [
        'statement_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'merchant_id',
        'gate_id',
        'amount',
        'processing_fee',
        'document_no',
        'client_transaction',
        'status',
        'remark',
        'freeze',
        'signature',
        'created_at',
        'updated_at',
        'deleted_at',
        'callback_url',
        'redirect_url',
        'ip_user',
        'user_update_time',
        'admin_approval_time',
        'expire_time',
        'processing_rate',
        'processing_fix',
        'admin_remark',
        'currency_id',
        'saving_account_id',
        'user_name',
        'statement_date',
        'amount_adjustment',
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('topUp')
            ->useDisk('s3')
            ->acceptsMimeTypes(['image/jpeg', 'application/pdf', 'image/png']);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function gate()
    {
        return $this->belongsTo(Product::class, 'gate_id');
    }

    public function saving_account()
    {
        return $this->belongsTo(SavingAccount::class, 'saving_account_id');
    }

    public function getPaymentSlipAttribute()
    {
        return $this->getMedia('topUp')->last();
    }

    public static function in_progress_transaction($gate_id)
    {
        return $topUp_arr = TopUp::where('gate_id', $gate_id)->whereIn('status', [0, 5, 6, 7, 8])->whereDate('created_at', Date('Y-m-d'))->get();
    }

    public function getStatementDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStatementDateAttribute($value)
    {
        $this->attributes['statement_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
