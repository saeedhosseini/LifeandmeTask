<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('successResponse')) {
    function successResponse($data, $message = 'progress successfully done', $cookie = null): JsonResponse
    {
        $res = response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message
        ]);
        if ($cookie != null) {
            $res->cookie($cookie);
        }
        return $res;
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message = 'Call Support', $exception = null, string $type = null, string $errorMessage = '', $status = 200, $cookie = null): JsonResponse
    {
        $result = [
            'status' => false,
            'message' => $message,
        ];

        //if in debug show error completely
        if (config('app.debug')){
            if ($type != null)
                $result['error'] = [
                    'type' => $type,
                    'error' => $errorMessage
                ];
            else if ($exception != null)
                $result['error'] = [
                    'type' => get_class($exception),
                    'error' => $exception instanceof Exception ? $exception->getMessage() : "",
                ];
        }

        $res = response()->json($result, $status);
        if ($cookie != null) {
            $res->cookie($cookie);
        }
        return $res;
    }
}

