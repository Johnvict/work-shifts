<?php

namespace App\Http\Controllers;

use App\Services\ShiftService;
use Illuminate\Http\Request;

class ShiftController extends Controller
{

    /** @var \App\Services\ShiftService $shiftService */
    public $shiftService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    /**
     * Fetches all Shifts for a specified date or for [today]
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\ApiResponse
     */
    public function getAll(Request $request)
    {
        $hasError = self::validateRequest($request, self::$dateRule);
        if ($hasError) return self::failed($hasError);
        return self::successful($this->shiftService::all($request->date));
    }

    /**
     * Filter Shifts for a range of date or shift type
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\ApiResponse
     */
    public function filter(Request $request)
    {
        $hasError = self::validateRequest($request, self::$filterRule);
        if ($hasError) return self::failed($hasError);
        return self::successful($this->shiftService::filter($request->type, $request->from, $request->to));
    }
}
