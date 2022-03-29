<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait RequestValidator
{

    public static $createScheduleRule = [
        'worker_id'     =>  'required|numeric|exists:workers,id',
        'shift_id'      =>  'required|numeric|exists:shifts,id',
        'date'          =>  'required|date|after_or_equal:today',
    ];

    public static $dateRule = [
        'date'          =>  'date_format:Y-m-d',
    ];

    public static $filterRule = [
        'type'          =>  'required|in:morning,day,evening',
        'from'          =>  'required|date_format:Y-m-d',
        'to'          =>  'required|date_format:Y-m-d',
    ];

    public static $createManyScheduleRule = [
        'data'                 => 'array',
        'data.*.worker_id'     => 'required|numeric|exists:workers,id',
        'data.*.shift_id'      => 'required|numeric|exists:shifts,id',
        'data.*.date'          => 'required|date|after_or_equal:today',
    ];


    /**
     * Ensures a better object whose keys are the parameter keys as expected and values are the error message
     *
     * @param Mixed $errorArray Complex array got from Laravel Validator method
     * @return Mixed|null An object is returned if there is an unexpected request body or null if no error
     */
    private static function formatError($errorArray)
    {
        $newErrorFormat = collect($errorArray)->map(function ($error) {
            return $error[0];
        });
        return $newErrorFormat;
    }

    /**
     * Validate parameters on incoming requests
     *
     * @param Illuminate\Http\Request $requestData The request body as sent from client
     * @param Array $validationRule Validation rule for each request param
     * @return Mixed|null An object is returned if there is an unexpected request body or null if no error
     */
    public static function validateRequest(Request $requestData, array $validationRule)
    {
        $validation = Validator::make($requestData->all(), $validationRule);

        // ? Did we get some errors? Okay, restructure the error @here
        if ($validation->fails()) return static::formatError($validation->errors());
        return false;
    }
}
