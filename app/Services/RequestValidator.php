<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

trait RequestValidator
{
    public static $errorArray, $queryArray = [];
	/**
	 * ? These static values are validation rules for all POST requests into our microservice
	 * ? They are used statically from various providers needing them
	 */


	public static $createScheduleRule = [
		'worker_id'     =>  'required|numeric|exists:workers,id',
		'shift_id'      =>  'required|numeric|exists:shifts,id',
		'date'          =>  'required|date|after_or_equal:today',
	];


	/**
	 * ? To ensure a better object whose keys are the parameter keys as expected and values are the error message
	 * @param Mixed $errorArray - Complex array got from Laravel Validator method
	 * @return Mixed or null - An object is returned if there is an unexpected request body or null if no error
	 */
	public static function formatError($errorArray)
	{
		RequestValidator::$errorArray = collect($errorArray);
		$newErrorFormat = RequestValidator::$errorArray->map(function ($error) {
			return $error[0];
		});
		return $newErrorFormat;
	}

	/**
	 * ? To validate parameters on incoming requests
	 * ? These validation customizes the validation error
	 * @param Request $requestData - The request body as sent from the client
	 * @return Mixed or null - An object is returned if there is an unexpected request body or null if no error
	 */
	public static function validateRequest(Request $requestData, array $validationRule)
	{
		$validation = Validator::make($requestData->all(), $validationRule);

		// ? Did we get some errors? Okay, restructure the error @here
		if ($validation->fails()) return RequestValidator::formatError($validation->errors());
		return false;
	}
}