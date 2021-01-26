<?php

namespace App\Http\Controllers;

use App\Category;
use App\Option;
use App\Post;
use App\SubscriptionService;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionServiceController extends Controller
{
    public function show(SubscriptionService $subscriptionService)
    {
        $viewData['service'] = $subscriptionService;
        $viewData['packages'] = $subscriptionService->packages->load('options');

        $options = Option::query()->get();

        $viewData['options'] = $options;
        $viewData['posts'] = Post::query()->whereHas('subscriptionServices', function (Builder $builder) use ($subscriptionService) {
            $builder->where('subscription_service_id', $subscriptionService->id);
        })->limit(7)->get();

        return view('services.show', $viewData);
    }
}
