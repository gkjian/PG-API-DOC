<?php

namespace App\Http\Requests;

use App\Models\Merchant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMerchantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('merchant_create');
    }

    public function rules()
    {
        return [
            'name'     => [
                'string',
                'required',
            ],
            'email'    => [
                'required',
                'unique:merchants',
            ],
            'password' => [
                'required',
            ],
            'roles.*'  => [
                'string',
            ],
            'roles'    => [
                'required',
                'array',
            ],
            'person_incharge_name'     => [
                'required',
            ],
            'contact'     => [
                'required',
            ],
            'status'     => [
                'required',
            ],
        ];
    }
}
