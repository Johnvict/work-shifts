<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\Carbon;
use App\Models\Worker;
use Exception;
use Illuminate\Support\Facades\DB;

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
     * Creates a schedule for a worker
     *
     * @param mixed $data Request fields: worker_id, shift_id, date
     * @return \App\Models\Schedule
     */
    public function create($data)
    {
        $this->checkExistence($data);
        $schedule = Schedule::create($data);
        $schedule->shift;
        $schedule->worker;
        return $schedule;
    }

    /**
     * Creates a list of schedules for several workers
     *
     * @param mixed $data Request fields: worker_id, shift_id, date
     * @return \App\Models\Schedule
     */
    public function createMany($data)
    {

        $dataToStore = $this->filerOutExistedData($data);

        Schedule::insert($dataToStore);
        return  array_values($dataToStore);
    }

    /**
     * Checks if there is an existing work schedule for this worker on same date specified
     *
     * @param mixed $data Request data, including worker_id and date
     */
    public function checkExistence($data)
    {
        $worker = Worker::whereId($data["worker_id"])->first();
        $scheduleExists = $worker->schedules()->where('date', $data["date"])->first();

        if ($scheduleExists) {
            throw new Exception("This worker already has a work schedule for " . $data['date']);
        }
    }

    /**
     * Filter out any of these schedules of which a corresponding schedule is already created
     * for any of its associated worker on same specified date
     *
     * @param mixed $data Request data, including worker_id and date
     */
    public function filerOutExistedData($data)
    {
        $worker_ids = [];
        $dates = [];
        $dataToStore = [];
        $timeNow = Carbon::now();   // To avoid creating (almost) same thing multiple times

        foreach (collect($data) as $val) {
            array_push($worker_ids, $val["worker_id"]);
            array_push($dates, $val["date"]);
            array_push($dataToStore, [
                "worker_id"     => $val["worker_id"],
                "shift_id"      => $val["shift_id"],
                "date"          => $val["date"],
                "created_at"    => $timeNow,
                "updated_at"    => $timeNow
            ]);
        }
        $fetched = DB::table('schedules')
            ->whereIn('worker_id', $worker_ids)
            ->whereIn('date', $dates)
            ->select(['worker_id', 'date'])
            ->get()
            ->toArray();

        return array_filter($dataToStore, function ($data) use ($fetched, $dataToStore) {
            foreach ($fetched as $val) {
                if ($val->worker_id == $data["worker_id"] && $val->date == $data["date"]) {
                    return false;
                }
            }
            return true;
        });
    }
}
