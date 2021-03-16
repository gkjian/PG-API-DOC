<?php

namespace App\Http\Requests;

use App\Models\PayoutBank;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePayoutBankRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('payout_bank_create');
    }

    public function rules()
    {
        return [
            'bank_name'           => [
                'string',
                'nullable',
            ],
            'bank_account_name'   => [
                'string',
                'nullable',
            ],
            'bank_account_number' => [
                'nullable',
                'string',
            ],
            'bank_currency'       => [
                'string',
                'nullable',
            ],
        ];
    }
}
