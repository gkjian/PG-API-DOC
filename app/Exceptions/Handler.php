<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NewValidationException) {
            //自定义exception 返回方法
            //这里可以返回first，也可以返回all(),根据自己需要返回
            return response()->json(['status'=>$e->status,'ret_msg'=>$e->getMessage(),'errors'=>$e->validator->errors()]);
        }

        if ($e instanceof ThrottleRequestsException) {
            //自定义exception 返回方法
            //这里可以返回first，也可以返回all(),根据自己需要返回
            // return $e;
            return response()->json(['status'=> 5001 ,'ret_msg'=>$e->getMessage(),'errors'=>[]]);
        }

        // if($e instanceof QueryException ){
        //     return response()->json($e);
        // }
        return parent::render($request, $e);
    }
}
