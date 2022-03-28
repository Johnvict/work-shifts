<?php

namespace App\Http\Controllers;

use App\Models\Worker;

class WorkerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @return \App\Helpers\ApiResponse::
     */
    public function all() {
        return self::successful(Worker::all());
    }
}
