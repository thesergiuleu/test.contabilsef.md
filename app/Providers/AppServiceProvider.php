<?php

namespace App\Providers;

use App\Services\PostsService;
use App\Services\PostsServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostsServiceInterface::class, PostsService::class);
        Carbon::setLocale('ro');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend(
            'recaptcha',
            'App\\Validators\\ReCaptcha@validate'
        );
        Voyager::addAction(\App\Actions\SendSubscriptionInvoice::class);
    }
}
