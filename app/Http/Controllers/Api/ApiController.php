<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function apiResponse($resultType, $data, $message = null, $code = 200)
    {
        $response = [];
        $response['success'] = $resultType == ResoultType::Success ? true : false;

        $response['data'] = $data;
        $response['message'] = $message;

        return response()->json($response, $code);
    }
}

class ResoultType
{
    const Success = 1;
    const Information = 2;
    const Warning = 3;
    const Error = 4;

}
