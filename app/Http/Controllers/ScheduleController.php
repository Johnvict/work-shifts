<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Exception;
use Illuminate\Http\Request;

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
     * @param Integer $id Schedule Id
     * @return \App\Helpers\ApiResponse
     */
    public function getOne($id)
    {
        $schedule = $this->scheduleService::one($id);
        return $schedule ? self::successful($schedule) : self::failed("Sorry, no schedule found with this id", 404);
    }

    public function create(Request $request) {
        $hasError = self::validateRequest($request, self::$createScheduleRule);
        if ($hasError) return self::failed($hasError);

        try {
            $data = $this->scheduleService->create($request->only(['worker_id', 'shift_id', 'date']));
            return self::successful($data);
        } catch (Exception $error) {
            return  self::failed($error->getMessage());
        }
    }

    public function createMany(Request $request) {
        $hasError = self::validateRequest($request, self::$createManyScheduleRule);
        if ($hasError) return self::failed($hasError);

        try {
            $data = $this->scheduleService->createMany($request->data);
            return self::successful($data);
        } catch (Exception $error) {
            return  self::failed($error->getMessage());
        }
    }
}
