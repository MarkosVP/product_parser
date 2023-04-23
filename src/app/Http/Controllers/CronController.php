<?php

namespace App\Http\Controllers;

use App\Utils\RequestUtils;

class CronController extends Controller
{
    public function execute()
    {
        return RequestUtils::retornaSucesso('OK');
    }
}
