<?php

namespace App\Http\Requests;

use App\Models\WhitelistIpAddress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWhitelistIpAddressRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whitelist_ip_address_create');
    }

    public function rules()
    {
        return [
            'ip_address' => [
                'string',
                'required',
            ],
        ];
    }
}
