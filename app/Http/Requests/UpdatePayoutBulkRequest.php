<?php

namespace App\Http\Requests;

use App\Models\PayoutBulk;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePayoutBulkRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('payout_bulk_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
