<?php

namespace App\Http\Requests;

use App\Models\Balance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBalanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('balance_edit');
    }

    public function rules()
    {
        return [
            'debit'        => [
                'string',
                'nullable',
            ],
            'credit'       => [
                'string',
                'nullable',
            ],
            'document_no' => [
                'string',
                'nullable',
            ],
            'remark'       => [
                'string',
                'nullable',
            ],
        ];
    }
}
