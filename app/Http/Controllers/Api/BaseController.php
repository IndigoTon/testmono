<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @param $result
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     * Send Method
     */
    public function sendResponse($result, $message)
    {

        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * @param $error
     * @param $errorMessages
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     * Return Error Response;
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
