<?php

use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShiftUnitTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * Test fetch all shifts
     */
    public function test_unit_fetch_all_shifts()
    {
        self::seedDatabase();
        $res = \App\Services\ShiftService::all();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $res);
        $responseBody = collect($res);
        $this->assertArrayHasKey("type", $responseBody[0]);
        $this->assertEquals("00:00", $responseBody[0]["starts_at"]);
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
