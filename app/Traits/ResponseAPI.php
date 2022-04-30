<?php
namespace App\Traits;

trait ResponseAPI {
    /**
     * Core of response
     *
     * @param string $message
     * @param string $data
     * @param integer $statusCode
     * @param boolean $isSuccess
     */
    public function coreResponse($message, $data = null, $statusCode, $isSuccess = true)
    {
        // check the params
        if (!$message) {
            return response()->json([
                'message' => 'Message is required'
            ], 500);
        }

        // send the response
        if( $isSuccess ) {
            return response()->json([
                'message' => $message,
                'status' => true,
                'statusCode' => $statusCode,
                'result' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'status' => false,
                'statusCode' => $statusCode,
                'result' => $data
            ], $statusCode);
        }
    }

    /**
     * Send any success response
     *
     * @param string $message
     * @param array|object $data
     * @param integer $statusCode
     */
    public function success($message, $data, $statusCode = 200)
    {
        return $this->coreResponse($message, $data, $statusCode, true);
    }

    /**
     * Send any error response
     *
     * @param string $message
     * @param integer $statusCode
     */
    public function error($message, $data = null, $statusCode = 500) {
        return $this->coreResponse($message, $data, $statusCode, false);
    }
}
