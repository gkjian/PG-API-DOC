<?php

namespace App\Http\Requests;

use App\Models\Settlement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSettlementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('settlement_create');
    }

    public function rules()
    {
        return [
            'amount'              => [
                'numeric',
                'required',
            ],
            'bank_id'              => [
                'required',
            ],
            'bank_name'           => [
                'string',
                'nullable',
            ],
            'bank_account_name'   => [
                'string',
                'nullable',
            ],
            'bank_account_number' => [
                'string',
                'nullable',
            ],
            'remark'              => [
                'string',
                'nullable',
            ],
            'document_no'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
