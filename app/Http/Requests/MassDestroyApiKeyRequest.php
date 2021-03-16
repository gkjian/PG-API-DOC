<?php

namespace App\Http\Requests;

use App\Models\ApiKey;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyApiKeyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('api_key_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:api_keys,id',
        ];
    }
}
