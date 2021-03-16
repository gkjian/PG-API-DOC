<?php

namespace App\Http\Requests;

use App\Models\Merchant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMerchantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('merchant_edit');
    }

    public function rules()
    {
        return [
            'name'    => [
                'string',
                'required',
            ],
            'email'   => [
                'required',
                'unique:merchants,email,' . request()->route('merchant')->id,
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
            'freeze_credit'  => [
                'numeric',
            ],
        ];
    }
}
