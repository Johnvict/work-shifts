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

    /**
     * Creates a new schedule associated to a worker and a shift for a specified date
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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


    /**
     * Creates a list of new schedule, EACH associated to a worker and a shift for a specified date
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMany(Request $request) {
        $hasError = self::validateRequest($request, self::$createManyScheduleRule);
        if ($hasError) return self::failed($hasError);

        try {
            $data = $this->scheduleService::createMany($request->data);
            return self::successful($data);
        } catch (Exception $error) {
            return  self::failed($error->getMessage());
        }
    }

    /**
     * Deletes a shift
     *
     * @param Integer $id
     */
    public function delete($id) {
        $data = $this->scheduleService->delete($id);
        if (isset($data["schedule"])) return self::successful($data["schedule"]);
        return self::failed($data["message"], 404);
    }
}
