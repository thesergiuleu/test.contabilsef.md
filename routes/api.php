<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\GeneralsController;
use App\Http\Controllers\Api\PostsController;
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

Route::group(['prefix' => 'v1.0'], function () {

    Route::get('menu', [GeneralsController::class, 'menu']);

    Route::prefix('posts')->group(function () {
        Route::get('', [PostsController::class, 'index']);
        Route::get('{slug}', [PostsController::class, 'show']);
        Route::get('category/{slug}', [PostsController::class, 'getPostsByCategorySlug']);
    });
    Route::prefix('categories')->group(function () {
        Route::get('', [CategoriesController::class, 'index']);
        Route::get('children/{slug}', [CategoriesController::class, 'getCategoryChildren']);
        Route::get('{slug}', [CategoriesController::class, 'show']);
    });
});
Route::get('users', [PostImportController::class, 'users']);
Route::get('categories', [PostImportController::class, 'categories']);
Route::get('pages', [PostImportController::class, 'pages']);
Route::get('subscription-services', [PostImportController::class, 'subscriptionServices']);
Route::get('subscriptions', [PostImportController::class, 'subscriptions']);
Route::get('posts', [PostImportController::class, 'posts']);
Route::get('glossary', [PostImportController::class, 'glossary']);
Route::get('forms', [PostImportController::class, 'forms']);






