<?php

namespace App\Http\Requests;

use App\Models\Deposit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDepositRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('top_up_edit');
    }

    public function rules()
    {
        return [
            'amount'         => [
                'numeric',
            ],
            'processing_fee' => [
                'numeric',
            ],
            'description'    => [
                'string',
                'nullable',
            ],
            'remark'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
