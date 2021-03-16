<?php

namespace App\Http\Requests;

use App\Models\WhitelistEmail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWhitelistEmailRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('whitelist_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:whitelist_emails,id',
        ];
    }
}
