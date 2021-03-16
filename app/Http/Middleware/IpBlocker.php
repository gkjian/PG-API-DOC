<?php

namespace App\Http\Middleware;

use App\Models\WhitelistIpAddress;
use App\PG_Response\API_RES;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class IpBlocker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $type ip 过滤类型 whitelist , blacklist
     * @return mixed
     */
    public function handle(Request $request, Closure $next, String $type)
    {

        // $environment = App::environment('local');

        // if (!$environment) {
        if (strtoupper($type)  == 'WHITELIST') {
            //检查白名单
            $ip = $request->ip();

            $whitelist = WhitelistIpAddress::where('ip_address', $ip)->where('status', 0)->first();

            if (empty($whitelist)) {
                Log::info("[" . $request->path() . "]" . ' ip [' . $ip . "] 未在white list 中");

                return response(API_RES::res_format(9000, API_RES::api_ret_msg('api.error')), 503);
            }
        } else if (strtoupper($type) == 'BLACKLIST') {
        }
        // }


        return $next($request);
    }
}
