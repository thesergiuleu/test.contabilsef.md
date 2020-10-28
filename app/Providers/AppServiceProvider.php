<?php

namespace App\Providers;

use App\Actions\AproveAComment;
use App\Actions\SendSubscriptionInvoice;
use App\Services\PostsService;
use App\Services\PostsServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
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
        Voyager::addAction(SendSubscriptionInvoice::class);
        Voyager::addAction(AproveAComment::class);
    }
}
