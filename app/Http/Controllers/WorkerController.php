<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Services\WorkerService;

class WorkerController extends Controller
{

    /** @var \App\Services\WorkerService $workerService */
    public $workerService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WorkerService $workerService)
    {
        $this->workerService = $workerService;
    }

    /**
     * Fetches all Workers
     *
     * @return \App\Helpers\ApiResponse
     */
    public function getAll()
    {
        $workers = $this->workerService::all();
        return $workers ? self::successful($workers) : self::failed("Sorry, no workers found in our records", 404);
    }


    /**
     * Fetches a single worker with necessary details
     *
     * @return \App\Helpers\ApiResponse
     */
    public function getOne($id)
    {
        $worker = $this->workerService::one($id);
        return $worker ? self::successful($worker) : self::failed("Sorry, no worker found with this id", 404);
    }


    /**
     * Fetches a single worker with Schedules nested with shifts
     *
     * @return \App\Helpers\ApiResponse
     */
    public function withSchedules($id)
    {
        $worker = $this->workerService::oneWithSchedules($id);
        return $worker ? self::successful($worker) : self::failed("Sorry, no worker found with this id", 404);
    }


    /**
     * Fetches a single worker with Shifts nested with Schedules
     *
     * @return \App\Helpers\ApiResponse
     */
    public function withShifts($id)
    {
        $worker = $this->workerService::one($id);
        return $worker ? self::successful($worker) : self::failed("Sorry, no worker found with this id", 404);
    }
}
