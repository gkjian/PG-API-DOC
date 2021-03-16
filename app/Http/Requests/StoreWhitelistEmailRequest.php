<?php

namespace App\Http\Requests;

use App\Models\WhitelistEmail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWhitelistEmailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whitelist_email_create');
    }

    public function rules()
    {
        return [];
    }
}
