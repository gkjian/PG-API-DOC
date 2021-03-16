<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Admin_Approval_Payout_Request extends NewFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status'   => [
                'numeric',
                'required',
            ],
        ];
    }
}
