<?php

namespace App\Helpers;

trait ApiResponse
{

    /**
     * Returns a successful HTTP response as json
     * @param mixed $data - Optional Response Data
     * @param $status_code - Optional Http Status Code
     * @return Illuminate\Http\Response
     */
    public static function successful($data = null, $status_code = 200)
    {
        return response()->json([
            "code"      => "00",
            "message"   => "successful",
            "data"      => $data
        ], $status_code);
    }

    /**
     * Returns a failed HTTP response as json
     * @param mixed $data - Optional Response Data
     * @param $status_code - Optional Http Status Code
     * @return Illuminate\Http\Response
     */
    public static function failed($message = "failed", $status_code = 400)
    {
        return response()->json([
            "code"      => "01",
            "message"   => $message
        ], $status_code);
    }
}
