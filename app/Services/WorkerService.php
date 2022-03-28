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
        return Worker::whereId($id)->first();
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
