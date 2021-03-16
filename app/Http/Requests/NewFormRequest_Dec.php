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

class NewFormRequest_Dec extends FormRequest implements ValidatesWhenResolved
{
    //解析带有加密的form data
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

    protected function getValidatorInstance()
    {
       
        //解密数据
        $encryted_data = $this->all(); // 全部资料

        if(empty($encryted_data['secret_key'])) {

            throw new HttpResponseException(response()->json(API_RES::res_format(10005, API_RES::api_ret_msg('api.error')), 401));
        }

        if(empty($encryted_data['product_key'])) {

            throw new HttpResponseException(response()->json(API_RES::res_format(10006, API_RES::api_ret_msg('api.error')), 401));
        }
        
        $secret_key = $encryted_data['secret_key'];
        $product_key =  $encryted_data['product_key'];

        if(!isset($encryted_data['form_data'])){
            
            throw new HttpResponseException(response()->json(API_RES::res_format(10007, API_RES::api_ret_msg('api.error')), 401));
        }
 
        //解压数据
        $decryted = Paydecrypt::paydecrypt2($encryted_data['form_data'] , $secret_key , $product_key);

        $decode_data = json_decode($decryted);

        if(empty($decode_data)){

            throw new HttpResponseException(response()->json(API_RES::res_format(10008, API_RES::api_ret_msg('api.error')), 200));
        }

        $data = [];

        foreach($decode_data as $index => $row){

            $data[$index] = $row;
        }

        // dd($data);

        $this->merge($data);

        return parent::getValidatorInstance($data);
    }
}
