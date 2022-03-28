<?php

namespace App\Services;

use App\Models\Schedule;

class ScheduleService
{
    /**
     * Fetches all schedules from the DB
     *
     * @return App\Model\Worker
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

}
