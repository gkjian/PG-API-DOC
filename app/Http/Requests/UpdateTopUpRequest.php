<?php

namespace App\Http\Requests;

use App\Models\TopUp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTopUpRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('deposit_edit');
    }

    public function rules()
    {
        return [
            'amount'             => [
                'numeric',
            ],
            'processing_fee'     => [
                'numeric',
            ],
            'document_no'        => [
                'string',
                'nullable',
            ],
            'client_transaction' => [
                'string',
                'nullable',
            ],
            'remark'             => [
                'string',
                'nullable',
            ],
            'freeze'             => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'signature'          => [
                'string',
                'nullable',
            ],
        ];
    }
}
