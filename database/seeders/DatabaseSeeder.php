<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() != 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->call(WorkerSeeder::class);
        $this->call(ShiftSeeder::class);

        if (App::environment() != 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
