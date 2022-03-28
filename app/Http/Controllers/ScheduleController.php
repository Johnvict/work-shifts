<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;

class ScheduleController extends Controller
{

    /** @var \App\Services\ScheduleService $scheduleService */
    public $scheduleService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Fetches all Workers
     *
     * @return \App\Helpers\ApiResponse
     */
    public function getAll()
    {
        return self::successful($this->scheduleService::all());
    }


    /**
     * Fetches a single worker with necessary details
     *
     * @return \App\Helpers\ApiResponse
     */
    public function getOne($id)
    {
        $schedule = $this->scheduleService::one($id);
        return $schedule ? self::successful($schedule) : self::failed("Sorry, no schedule found with this id", 404);
    }

}