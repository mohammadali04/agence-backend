<?php
namespace Modules\Shared\Http\Controllers\Api;
use App\Http\Controllers\Controller;

class BaseResponderController extends Controller
{
    public function sendResponse($result,$message, $statusCode = 200){
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message
        ];
        return response()->json($response, $statusCode);
    }
    public function sendError($error, $errorMessages = [], $statusCode = null){
        $response = [
            'success' => false,
            'message' => $error,
            'errors' => $errorMessages
        ];
        return response()->json($response, $statusCode);
    }

}
