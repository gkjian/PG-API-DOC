<?php

namespace App\Http\Requests;

use App\PG_Response\API_RES;
use App\Encryption\Paydecrypt;
use App\Exceptions\NewValidationException;
use Exception;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class NewFormRequest extends FormRequest implements ValidatesWhenResolved
{
    /**
     * 重写框架的 FormRequest 类的 failedValidation 方法
     * @param Validator $validator
     * @throws SfoException
     */
    protected function failedValidation(Validator $validator)
    {

        throw (new NewValidationException($validator))
            ->errorBag($this->errorBag);
    }
}
