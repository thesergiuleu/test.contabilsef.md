<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeneralsController extends Controller
{
    public function menu(): JsonResponse
    {
        return $this->responseOk(menu('site', '_json')->values());
    }
}
