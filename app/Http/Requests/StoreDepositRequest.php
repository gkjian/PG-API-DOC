<?php

namespace App\Http\Requests;

use App\Models\Deposit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDepositRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('top_up_create');
    }

    public function rules()
    {
        return [
            'document_no'    => [
                'required',
            ],
            'merchant_id'   =>  [
                'required',
            ],
            'amount'        =>  [
                'numeric',
                'required',
            ],
            'gate_id'       =>  [
                'required',
            ],
            'payment_slip'  => [
                'required',
            ]
        ];
    }
}
