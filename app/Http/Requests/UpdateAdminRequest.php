<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_edit');
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
                'unique:admins,email,' . request()->route('admin')->id,
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
        ];
    }
}
