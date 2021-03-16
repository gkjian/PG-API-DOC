<?php

namespace App\Http\Requests;

use App\Models\ApiKey;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateApiKeyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('api_key_edit');
    }

    public function rules()
    {
        return [
            'api_key' => [
                'string',
                'nullable',
            ],
        ];
    }
}
