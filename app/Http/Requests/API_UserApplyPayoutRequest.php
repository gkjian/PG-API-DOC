<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class API_UserApplyPayoutRequest extends NewFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_name'            => [
                'string',
                'required',
            ],
            'bank_account_name'    => [
                'string',
                'required',
            ],
            'bank_account_number'  => [
                'string',
                'numeric'
            ],
            'amount'  => [
                'required',
                'numeric',
                'min:0'
            ],
            'gate_id'  => [
                'required',
                'numeric'
            ],
            'bank_code'  => [
                'nullable',
            ],
            'product_key'   => [
                'string',
                'required'
            ],
            'secret_key'   => [
                'string',
                'required'
            ],
            'remark' => [
                'nullable',
            ]
        ];
    }
}
