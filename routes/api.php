<?php

use App\Http\Controllers\PostImportController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('posts', [PostImportController::class, 'posts']);

Route::get('categories', [PostImportController::class, 'categories']);

Route::get('users', [PostImportController::class, 'users']);

Route::get('subscription-services', [PostImportController::class, 'subscriptionServices']);

Route::get('subscriptions', [PostImportController::class, 'subscriptions']);

Route::get('pages', [PostImportController::class, 'pages']);

