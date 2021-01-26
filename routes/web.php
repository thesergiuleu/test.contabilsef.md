<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GlosaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\SubscriptionServiceController;
use App\Http\Controllers\UsersController;
use App\Page;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('magic/{type?}', function ($type = 'dataType') {
    if ($type == 'dataRow') {
        print_r(json_encode(\TCG\Voyager\Models\DataRow::all()));
    } elseif ($type == 'dataType') {
        print_r(json_encode(\TCG\Voyager\Models\DataType::all()));
    } elseif ($type == 'menuItem') {
        print_r(json_encode(\TCG\Voyager\Models\MenuItem::query()->where('menu_id', 1)->get()));
    } elseif ($type == 'menu') {
        print_r(json_encode(\TCG\Voyager\Models\Menu::all()));
    } elseif ($type == 'options') {
        print_r(json_encode(\App\Option::all()));
    } elseif ($type == 'packages') {
        print_r(json_encode(\App\Package::all()));

    }
});
Auth::routes();
Route::get('confirm/{hash}', [UsersController::class, 'confirm'])->name('confirm');
Route::get('service/{subscriptionService}', [SubscriptionServiceController::class, 'show'])->name('service-landing');
Route::post('checkout', [PaymentsController::class, 'postCheckout'])->name('checkout.store');
Route::get('check-email', [PaymentsController::class, 'checkEmail'])->name('check-email');
Route::get('checkout/{service}/{package}', [PaymentsController::class, 'getCheckoutPage'])->name('checkout');
/* ******************************************** ADMIN *************************************************************** */

Route::group(['prefix' => 'admin'], function () {
    Route::get('login-as/{user}', [UsersController::class, 'loginAs'])->name('log-in-as');
    Route::prefix('instruire')->name('voyager.instruire.')->group(function () {
        Route::resource('','Admin\InstruireController');
    });
    Voyager::routes();

});

/* ********************************************* SITE *************************************************************** */

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('', [SubscriptionsController::class, 'view'])->name('profile');
    Route::post('subscribe', [SubscriptionsController::class, 'store'])->name('subscribe.store');
    Route::get('send/{subscription}', [SubscriptionsController::class, 'send'])->name('subscribe.send');

    Route::prefix('users')->name('user.')->group(function () {
        Route::get('delete', [UsersController::class, 'destroy'])->name('delete');
        Route::post('update', [UsersController::class, 'update'])->name('update');
    });

    Route::get('comments/change-status/{comment}', function (\App\Comment $comment) {
        $comment->is_approved = !$comment->is_approved;
        $comment->save();
        return redirect()->back();
    })->name('comment.change_status');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('dictionar-contabil', [GlosaryController::class, 'index'])->name('glossary.index');

Route::get('contacte', 'ContactsController@getPage')->name('contact');

Route::get(Page::SUBSCRIBE, 'PageController@getSubscribePage')->name('subscribe');
Route::get('page/{slug}', 'PageController@view')->name('page.view');

Route::post('contact', 'ContactsController@store')->name('contact-post');

Route::prefix('offers')->group(function () {
    Route::get('', [OfferController::class, 'index'])->name('offer.index');
    Route::get('create', [OfferController::class, 'create'])->name('offer.create');
    Route::post('', [OfferController::class, 'store'])->name('offer.store');
    Route::get('{offer}', [OfferController::class, 'view'])->name('offer.view');
});

Route::post('newsletter', 'NewslettersController@submit')->name('newsletter');
Route::post('comments/{post}', 'CommentsController@store')->name('comments.store');
Route::post('instruire/register/{post}', 'InstruireController@register')->name('instruire.register');
Route::post('pool/{pool}', 'PoolsController@vote')->name('pool.vote');
Route::get('posts/{categorySlug}/{slug}', [PostController::class, 'view'])->name('post.view');
Route::get('{slug}', [CategoryController::class, 'view'])->name('category.view');






