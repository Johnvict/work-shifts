<?php

use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ScheduleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test to create schedule
     */
    public function test_create_schedule()
    {
        self::seedDatabase();
        $data = [
            "worker_id" => 1,
            "shift_id"  => 1,
            "date"      => date('Y-m-d'),
        ];

        $res = $this->post('api/v1/schedule/create', $data);
        $res->seeStatusCode(200);

        $responseBody = json_decode($res->response->getContent());

        $this->assertEquals(strtolower($responseBody->message), 'successful');
        $this->assertEquals($responseBody->code, '00');

        $res->seeJsonStructure([
            'code',
            'message',
            'data'
        ]);
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
