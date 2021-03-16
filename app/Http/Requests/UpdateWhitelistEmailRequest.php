<?php

namespace App\Http\Requests;

use App\Models\WhitelistEmail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWhitelistEmailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whitelist_email_edit');
    }

    public function rules()
    {
        return [];
    }
}
