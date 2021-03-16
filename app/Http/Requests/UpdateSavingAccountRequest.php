<?php

namespace App\Http\Requests;

use App\Models\SavingAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSavingAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('saving_account_edit');
    }

    public function rules()
    {
        return [
            'bank_name'           => [
                'string',
                'required',
            ],
            'bank_account_name'   => [
                'string',
                'required',
            ],
            'bank_account_number' => [
                'string',
                'required',
            ],
            'daily_limit'         => [
                'numeric',
            ],
            'transaction_limit'   => [
                'numeric',
            ],
        ];
    }
}
