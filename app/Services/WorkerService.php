<?php

namespace App\Services;

use App\Models\Worker;

class WorkerService
{
    /**
     * Fetches one worker from the DB
     *
     * @return App\Model\Worker
     */
    public static function one($id)
    {
        return Worker::whereId($id)->with('shifts')->first();
    }

    /**
     * Fetches one worker from the DB
     *
     * @return App\Model\Worker
     */
    public static function oneWithSchedules($id)
    {
        return Worker::whereId($id)->with('schedules')->first();
    }

    /**
     * Fetches all workers from the DB
     *
     * @return App\Model\Worker
     */
    public static function all()
    {
        return Worker::all();
    }
}
