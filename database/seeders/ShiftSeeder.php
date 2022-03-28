<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = [
            [
                "type"      => "morning",
                "starts_at" => "00:00",
                "closes_at" => "08:00",
            ],
            [
                "type"      => "day",
                "starts_at" => "08:00",
                "closes_at" => "16:00",
            ],
            [
                "type"      => "evening",
                "starts_at" => "16:00",
                "closes_at" => "00:00",
            ],
        ];

        Shift::truncate();
        Shift::insert($shifts);
    }
}
