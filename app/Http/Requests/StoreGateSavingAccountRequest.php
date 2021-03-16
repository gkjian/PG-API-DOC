<?php

namespace App\Http\Requests;

use App\Models\GateSavingAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGateSavingAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_saving_account_create');
    }

    public function rules()
    {
        return [
            'gate_id'           => [
                'required',
            ],
            'saving_account_id'   => [
                'required',
            ],
            'daily_limit'         => [
                'numeric',
                'required',
            ],
        ];
    }
}
