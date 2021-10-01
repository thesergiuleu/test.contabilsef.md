<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\GeneralsController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostImportController;
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
//Auth::routes();

Route::group(['prefix' => 'auth'], function () {
   Route::post('login', [\App\Http\Controllers\Auth\LoginController::class,'login']);
});

Route::get('users', [PostImportController::class, 'users']);
Route::get('categories', [PostImportController::class, 'categories']);
Route::get('pages', [PostImportController::class, 'pages']);
Route::get('subscription-services', [PostImportController::class, 'subscriptionServices']);
Route::get('subscriptions', [PostImportController::class, 'subscriptions']);
Route::get('posts', [PostImportController::class, 'posts']);
Route::get('glossary', [PostImportController::class, 'glossary']);
Route::get('forms', [PostImportController::class, 'forms']);

Route::prefix('pages')->group(function () {
    Route::get('{page}', [PageController::class, 'getPage']);
});

Route::get('posts/{slug}', [PostsController::class, 'show']);





