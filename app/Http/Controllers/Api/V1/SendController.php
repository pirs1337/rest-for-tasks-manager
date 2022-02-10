<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendController extends Controller
{
    public function sendSuccess($data, $status = 200){
        $response = [
            'status' => true
        ];

        foreach ($data as $key => $element) {
            $response[$key] = $element;
        }

        return response()->json($response, $status);
    }

    public function sendError($data, $status = 422){
        $response = [
            'error' => [
                'status' => false
            ]
            
        ];

        foreach ($data as $key => $element) {
            $response['error'][$key] = $element;
        }

        return response()->json($response, $status);
    }

    public function sendAccessDenied(){
        $response = [
            'error' => [
                'status' => false,
                'msg' => 'Access denied'
            ]
        ];
        return response()->json($response, 403);
    }
}
