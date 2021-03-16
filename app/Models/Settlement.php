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

class Settlement extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'settlements';

    protected $appends = [
        'payment_slip',
    ];

    protected $dates = [
        'statement_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Completed',
        '2' => 'Failed',
        '3' => 'Rejected',
    ];

    protected $fillable = [
        'merchant_id',
        'amount',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'status',
        'remark',
        'document_no',
        'bank_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'bank_branch',
        'currency_id',
        'crypto_currency',
        'crypto_wallet_address',
        'saving_account_id',
        'submit_amount',
        'amount_left',
        'gate_id',
        'processing_fee',
        'processing_rate',
        'processing_fix',
        'statement_date',
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

    public function bank()
    {
        return $this->belongsTo(SettlementBank::class, 'bank_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
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
        return $this->getMedia('payment_slip')->last();
    }

    public static function in_progress_transaction($gate_id)
    {
        //使用着的自己 pending/ success
        return  Settlement::where('gate_id', $gate_id)->whereIn('status', [0, 1])->whereDate('created_at', Date('Y-m-d'))->get();
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
