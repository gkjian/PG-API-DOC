<?php

namespace App\Models;

use App\Traits\Auditable;
use Bugsnag\DateTime\Date;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;
use Illuminate\Support\Facades\Schema;

class Payout extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'payouts';

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
        '3' => 'Reject',
    ];

    protected $fillable = [
        'merchant_id',
        'amount',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'status',
        'remark',
        'bulk_id',
        'document_no',
        'gate_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'callback_url',
        'saving_account_id',
        'bank_code',
        'admin_remark',
        'processing_fee',
        'processing_rate',
        'processing_fix',
        'currency_id',
        'bank_branch',
        'bank_city',
        'bank_state',
        'agent_name',
        'swift_code',
        'account_number',
        'iban_europe',
        'client_transaction',
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('payout')
            ->acceptsMimeTypes(['image/jpeg', 'application/pdf', 'image/png']);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function bulk()
    {
        return $this->belongsTo(PayoutBulk::class, 'bulk_id');
    }

    public function gate()
    {
        return $this->belongsTo(Product::class, 'gate_id');
    }

    public function saving_account()
    {

        $default = [];

        $all_field = Schema::getColumnListing((new SavingAccount)->getTable());

        foreach($all_field as $field){
            $default[$field] = "";
        }

        return $this->belongsTo(SavingAccount::class, 'saving_account_id')->withDefault($default);
    }

    public function getPaymentSlipAttribute()
    {
        return $this->getMedia('payout')->last();
    }
    public static function in_progress_transaction($gate_id)
    {
        return  Payout::select('amount', 'status', 'saving_account_id')->where('gate_id', $gate_id)->whereIn('status', [1, 0])->whereDate('created_at', Date('Y-m-d'))->get();
    }

    public static function generate_document_no()
    {

        $no = Payout::whereRaw('DATE(created_at) = CURDATE()')->count('created_at') + 1;
        $no = substr_replace('000', $no, 3 - strlen($no));

        return  $document_no = 'p' . now()->format('ymdHis') . $no;
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
