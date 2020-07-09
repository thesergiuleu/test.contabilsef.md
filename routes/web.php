<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/pages', [PageController::class, 'index'])->name('page.index');
Route::get('/pages/{id}', [PageController::class, 'view'])->name('page.view');

Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/posts/{id}', [PostController::class, 'view'])->name('post.view');

Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/categories/{id}', [CategoryController::class, 'view'])->name('category.view');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
