<?php

namespace App\Http\Requests;

use App\Models\Payout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePayoutRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('payout_create');
    }

    public function rules()
    {
        return [
            'amount'              => [
                'numeric',
            ],
            'merchant_id'              => [
                'required',
            ],
            'project_id'              => [
                'required',
            ],
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
            'client_transaction' => [
                'string',
                'required',
            ],
            'remark'              => [
                'string',
                'nullable',
            ],
            'bank_branch'              => [
                'string',
                'nullable',
            ],
            'bank_city'              => [
                'string',
                'nullable',
            ],
            'bank_state'              => [
                'string',
                'nullable',
            ],
        ];
    }
}
