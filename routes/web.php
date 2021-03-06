<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->group(['prefix' => '/worker'], function () use ($router) {
        $router->get('/', function() {
            return redirect('api/v1/worker/all');
        });

        $router->get('/all', 'WorkerController@getAll');
        $router->get('/one/id/{id}', 'WorkerController@getOne');
        $router->get('/one/id/{id}/schedules', 'WorkerController@withSchedules');
        $router->get('/one/id/{id}/shifts', 'WorkerController@withShifts');
    });

    $router->group(['prefix' => '/schedule'], function () use ($router) {
        $router->get('/', function() {
            return redirect('api/v1/schedule/all');
        });

        $router->get('/all', 'ScheduleController@getAll');
        $router->get('/one/id/{id}', 'ScheduleController@getOne');
        $router->post('/create', 'ScheduleController@create');
        $router->post('/create-many', 'ScheduleController@createMany');
        $router->delete('delete/{id}', 'ScheduleController@delete');
    });

    $router->group(['prefix' => '/shifts'], function () use ($router) {
        $router->get('/', function(Request $request) {
            return redirect("api/v1/shifts/all?date=$request->date");
        });

        $router->get('/all', 'ShiftController@getAll');
        $router->get('/filter', 'ShiftController@filter');
    });
});
