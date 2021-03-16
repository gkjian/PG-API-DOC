<?php

namespace App\Http\Requests;

use App\Models\SavingAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSavingAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('saving_account_create');
    }

    public function rules()
    {
        return [
            'bank_id'   => [
                'unique:saving_accounts',
                'required',
            ],
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
                'required',
            ],
            'transaction_limit'   => [
                'numeric',
                'required',
            ],
            
        ];
    }
}
