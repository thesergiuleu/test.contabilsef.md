<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Package;
use App\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(): JsonResponse
    {
        return responseSuccess(SubscriptionService::all());
    }

    public function getCheckoutInfo(SubscriptionService $service, Package $package): JsonResponse
    {
        return responseSuccess([
            'service' => $service,
            'package' => $package
        ]);
    }
}
