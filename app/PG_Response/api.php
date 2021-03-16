<?php

namespace App\PG_Response;

use Illuminate\Support\Facades\Lang;

// <!-- 前台返回api 格式 -->

class API_RES
{
    /**
     * @param int $status 状态码 0=成功 其他就随便
     * @param string $msg 信息
     * @param mixed $data 需要传输的资料
     * @return array
     */
    public static function res_format($status, string $msg, $data = [])
    {

        return  array(
            'status' => $status,
            'ret_msg' => $msg,
            'data' => $data,
        );
    }
    /**
     * @param string $label
     * @param mixed $data 需要传输的资料
     * @return string
     */
    public static function api_ret_msg($label, $replace_data = [])
    {

        $locale = 'en'; // 之后看可以接受来自user session 的 语言跟换

        return (Lang::get($label, $replace_data, $locale));
    }
}
