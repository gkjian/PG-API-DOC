<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdminRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_create');
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
                'unique:admins',
            ],
            'password' => [
                'required',
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'required',
                'array',
            ],
        ];
    }
}
