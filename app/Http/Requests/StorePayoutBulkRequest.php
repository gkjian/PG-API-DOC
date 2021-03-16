<?php

namespace App\Http\Requests;

use App\Models\PayoutBulk;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePayoutBulkRequest extends NewFormRequest
{
    public function authorize()
    {
        return Gate::allows('payout_create');
    }

    public function rules()
    {
        return [
            'bulk_name' => [
                'string',
                'required',
            ],
            'payouts' => [
                'array',
                'required',
            ],
            'payouts.*.client_transaction' => [
                'required',
                'distinct', // members of the array must be unique
                'unique:payouts',
            ],
            'payouts.*.gate' => [
                'required',
            ],
            'payouts.*.fullname' => [
                'required',
            ],
            'payouts.*.account_no' => [
                'required',
            ],
            'payouts.*.bank_code' => [
                'required',
            ],
            'payouts.*.branch' => [
                'nullable',
            ],
            'payouts.*.city' => [
                'nullable',
            ],
            'payouts.*.state' => [
                'nullable',
            ],
            'payouts.*.amount' => [
                'required',
                'numeric'
            ],
            'payouts.*.remark' => [
                'nullable',
            ],

        ];
    }
}
