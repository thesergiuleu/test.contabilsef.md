<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Http\Resources\SubscriptionResource;
use App\Package;
use App\SubscriptionService;
use App\User;
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
            'package' => new PackageResource($package)
        ]);
    }

    public function checkEmail(): JsonResponse
    {
        $email = request()->input('email');
        $user = User::whereEmail($email)->first();
        return responseSuccess($user ? "existing_user" : "new_user");
    }

    public function getSubscription(SubscriptionService $service)
    {
        /** @var User $user */
        $user = getAuthUser();

        return responseSuccess($user->activeSubscription($service->id) ? new SubscriptionResource($user->activeSubscription($service->id)) : $user->activeSubscription($service->id));
    }
}
