<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class API_UserUpdateTopUpRequest extends NewFormRequest_Dec
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
            'payment_slip' => [
                'required'
            ]
        ];
    }
}
