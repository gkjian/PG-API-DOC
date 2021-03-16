<?php

namespace App\Http\Requests;

use App\Models\SettlementBank;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSettlementBankRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('settlement_bank_create');
    }

    public function rules()
    {
        return [
            'bank_name'           => [
                'string',
                'required',
            ],
            'bank_account_name'   => [
                'string',
                'required',
            ],
            'bank_account_number' => [
                'string',
                'required',
            ],
            'status' => [
                'required',
            ]
        ];
    }
}
