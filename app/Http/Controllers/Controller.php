<?php

namespace App\Http\Controllers;

use App\PG_Response\API_RES;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Lang;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @param int $status 状态码 0=成功 其他就随便
     * @param string $msg 信息
     * @param mixed $data 需要传输的资料
     * @return array
     */
    public function res_format($status, string $msg, $data = [])
    {

        return API_RES::res_format($status, $msg, $data);
    }
    /**
     * @param string $label
     * @param mixed $data 需要传输的资料
     * @return string
     */
    public function api_ret_msg($label, $replace_data = [])
    {

        return API_RES::api_ret_msg($label, $replace_data);
    }
}
