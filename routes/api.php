<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\GeneralsController;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\SeminarsController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostImportController;
use Illuminate\Support\Facades\Auth;
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
    Auth::routes();
    Route::get('user', [UsersController::class, 'getUser'])->middleware('auth:sanctum');
});

Route::prefix('users')->group(function () {
    Route::put('update', [UsersController::class, 'update'])->middleware('auth:sanctum');
});

Route::prefix('pages')->group(function () {
    Route::get('{page}', [PageController::class, 'getPage']);
    Route::post('contact/contact-us', [ContactsController::class, 'contactUs']);
});

Route::get('posts/{slug}', [PostsController::class, 'show']);
Route::get('categories/{slug}', [CategoriesController::class, 'show']);

Route::group(['prefix' => 'comments'], function () {
    Route::get('{post}', [CommentsController::class, 'getPostComments']);
    Route::post('{post}', [CommentsController::class, 'addComment']);
});

Route::group(['prefix' => 'services'], function () {
    Route::get('', [ServicesController::class, 'index']);
    Route::post('check-email', [ServicesController::class, 'checkEmail']);
    Route::get('checkout/{service}/{package}', [ServicesController::class, 'getCheckoutInfo']);
    Route::post('checkout/{service}/{package}', [PaymentsController::class, 'postCheckout']);
});

Route::post('seminare/{post}', [SeminarsController::class, 'register']);
Route::get('footer-menu', [GeneralsController::class, 'footerMenu']);

#FOR IMPORT
Route::get('users', [PostImportController::class, 'users']);
Route::get('categories', [PostImportController::class, 'categories']);
Route::get('pages', [PostImportController::class, 'pages']);
Route::get('subscription-services', [PostImportController::class, 'subscriptionServices']);
Route::get('subscriptions', [PostImportController::class, 'subscriptions']);
Route::get('posts', [PostImportController::class, 'posts']);
Route::get('glossary', [PostImportController::class, 'glossary']);
Route::get('forms', [PostImportController::class, 'forms']);
