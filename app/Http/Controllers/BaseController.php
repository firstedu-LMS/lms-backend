<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{

    protected function success($data, $message, $code = 200)
    {
        return $this->ApiResponse(
            $data,
            [],
            $message,
            $code,
            config('http_status_code.true')
        );
    }

    protected function error($err,  $message = null,  $code)
    {
        return $this->ApiResponse(
            [],
            $err,
            $message,
            $code,
            config('http_status_code.false')
        );
    }

    public function  ApiResponse($data, $err, $message, $code, $conditon)
    {
        return response()->json([
            'conditon' => $conditon,
            'message' => $message,
            'errors' => $err,
            'data' => $data
        ], $code);
    }
}