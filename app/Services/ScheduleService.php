<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\Carbon;
use App\Models\Worker;
use Exception;

class ScheduleService
{
    /**
     * Fetches all schedules from the DB
     *
     * @return App\Model\Schedule
     */
    public static function all()
    {
        return Schedule::with('shift')->paginate(10);
    }

    /**
     * Fetches one schedule from the DB with all related data
     *
     * @return App\Model\Schedule
     */
    public static function one($id)
    {
        return Schedule::whereId($id)->with(['shift', 'worker'])->first();
    }

    /**
     * Creates a schedule for a user
     * @param mixed $data - Request fields: worker_id, shift_id, date
     * @return \App\Models\Schedule
     */
    public function create($data) {
        $this->checkExistence($data);
        $schedule = Schedule::create($data);
        $schedule->shift;
        $schedule->worker;
        return $schedule;
    }

    public function checkExistence($data) {
        $worker = Worker::whereId($data["worker_id"])->first();
        $shiftExist = $worker->schedules()->where('date', $data["date"])->first();

        if ($shiftExist) {
            throw new Exception("This worker already has a work schedule for " . $data['date']);
        }

    }
}
