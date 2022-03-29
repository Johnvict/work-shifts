<?php

use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ScheduleUnitTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test to create morning schedule
     */
    public function test_unit_create_schedule()
    {
        self::seedDatabase();
        $data = [
            "worker_id" => 2,
            "shift_id"  => 1,
            "date"      => date('Y-m-d'),
        ];

        $res = App\Services\ScheduleService::create($data);
        $this->assertInstanceOf(\App\Models\Schedule::class, $res);
        $responseBody = json_decode($res);

        $this->assertEquals($responseBody->date, $data["date"]);
        $this->assertEquals($responseBody->shift->type, "morning");
    }

    /**
     * Test to create several schedules
     */
    public function test_unit_create_many_schedules()
    {
        self::seedDatabase();
        $data = [
            [
                "worker_id" => 1,
                "shift_id"  => 1,
                "date"      => date('Y-m-d')
            ],
            [
                "worker_id" => 2,
                "shift_id"  => 1,
                "date"      => date('Y-m-d')
            ],
            [
                "worker_id" => 3,
                "shift_id"  => 1,
                "date"      => date('Y-m-d')
            ]
        ];

        $res = App\Services\ScheduleService::createMany($data);
        $this->assertIsArray($res);
        $this->assertEquals($res[0]["date"], $data[0]["date"]);
        $this->assertEquals($res[1]["shift_id"], $data[1]["shift_id"]);
    }

    /**
     * Test to create several schedules see if no duplicate is inserted into DB
     */
    public function test_unit_create_many_schedules_filters_duplicate_entry()
    {
        self::seedDatabase();
        $shouldPreExist = [
            "worker_id" => 2,
            "shift_id"  => 2,
            "date"      => date('Y-m-d'),
        ];

        App\Services\ScheduleService::create($shouldPreExist);

        $data = [
            [
                "worker_id" => 1,
                "shift_id"  => 1,
                "date"      => date('Y-m-d')
            ],
            [
                "worker_id" => 2,
                "shift_id"  => 1,
                "date"      => date('Y-m-d')
            ],
            [
                "worker_id" => 3,
                "shift_id"  => 1,
                "date"      => date('Y-m-d')
            ],

            // This should not be returned, making the length of returned values less than one
            [
                "worker_id" => 2,
                "shift_id"  => 2,
                "date"      => date('Y-m-d')
            ]
        ];

        $res = App\Services\ScheduleService::createMany($data);
        $this->assertIsArray($res);
        $this->assertLessThan(count($data), count(collect($res)));
    }

    /**
     * Test fetch all schedules returned as a paginated response
     */
    public function test_unit_fetch_all_schedules()
    {
        $res = App\Services\ScheduleService::all();
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $res);
    }

    /**
     * Test for fetch a single schedule returns the correct data
     */
    public function test_unit_fetch_one_schedule()
    {
        self::seedDatabase();
        $data = [
            "worker_id" => 2,
            "shift_id"  => 2,
            "date"      => date('Y-m-d'),
        ];

        App\Services\ScheduleService::create($data);

        $res = App\Services\ScheduleService::one(1);
        $responseBody = json_decode($res);
        $this->assertInstanceOf(\App\Models\Schedule::class, $res);
        $this->assertEquals($responseBody->date, $data["date"]);
        $this->assertEquals($responseBody->shift->type, "day");
    }

    /**
     * Test for delete, ensuring that the expected data is deleted
     */
    public function test_unit_delete_one_schedule()
    {
        self::seedDatabase();
        $data = [
            "worker_id" => 2,
            "shift_id"  => 2,
            "date"      => date('Y-m-d'),
        ];

        App\Services\ScheduleService::create($data);

        $res = App\Services\ScheduleService::delete(1);
        $responseBody = json_decode($res["schedule"]);

        $this->assertInstanceOf(\App\Models\Schedule::class, $res["schedule"]);
        $this->assertEquals($responseBody->date, $data["date"]);
        $this->assertEquals($responseBody->shift->type, "day");
    }

    /**
     * Run seeder in our test environment
     *
     * @return void
     */
    public static function seedDatabase()
    {
        Artisan::call('db:seed');
    }
}
