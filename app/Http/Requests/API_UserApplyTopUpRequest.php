<?php

namespace App\Http\Requests;

use App\Models\TopUp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class API_UserApplyTopUpRequest extends NewFormRequest
{
    public function authorize()
    {
        // return Gate::allows('deposit_create');
        return true;
    }

    public function rules()
    {
        return [
            'amount'    => [
                'numeric',
                'required',
                'min:0'
            ],
            'gate_id'   => [
                'required',
                'numeric'
            ],
            'client_transaction'   => [
                'required',
            ],
            'callback_url'   => [
                'string',
                'nullable'
            ],
            'redirect_url'   => [
                'string',
                'nullable'
            ],
            'product_key'   => [
                'string',
                'required'
            ],
            'secret_key'   => [
                'string',
                'required'
            ],
            // 'client_ip'   => [
            //     'string',
            //     'required'
            // ],
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'amount.required' => 'amount must be a required.',
    //     ];
    // }
}
