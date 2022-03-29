<?php

namespace App\Services;

use App\Models\Shift;
use Carbon\Carbon;

class ShiftService
{

    /**
     * Fetch all shifts with their associated schedules and workers
     *
     * @param date|null $date filter schedules attached to shift to a specific date or [today]
     */
    public static function all($date = null)
    {
        $query = Shift::query();

        $query->when($date, function ($query) use ($date) {
            $query->with(['schedules' => function ($query) use ($date) {
                $query->whereDate('date', $date);

            }]);
        });

        $query->when(!$date, function ($query) use ($date) {
            $query->with(['schedules' => function ($query) use ($date) {
                $query->whereDate('date', Carbon::now());
            }]);
        })->get();

        return $query->get();
    }

    /**
     * Fetch specified shift with their associated schedules and workers filtered by a range of start to end date
     *
     * @param string $type Type of shift
     *  - morning
     *  - day
     *  - evening
     * @param date $from filter schedules attached to shift from the specified date
     * @param date $to filter schedules attached to shift to the specified date
     */
    public static function filter($type, $from, $to)
    {
        $query = Shift::query();

        $query->where('type', $type);
        $query->with(['schedules' => function ($query) use ($from, $to) {
            $query
            ->where('date', '>=', $from)
            ->where('date', '<=', $to);
        }]);
        return $query->first();
    }


}
