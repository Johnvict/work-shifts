<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Helpers\ApiResponse;
use App\Helpers\RequestValidator;

class Controller extends BaseController
{
    /** Uses a centralized response */
    use ApiResponse;
    use RequestValidator;
    //
}
