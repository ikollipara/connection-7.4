<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionController;
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

Route::view('/', 'index')->name('index');
Route::view('/about', 'about')->name('about');

Route::resource('/registration', RegistrationController::class);
Route::resource('/login', SessionController::class)->only(['create', 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('/upload', UploadController::class)->only(['destroy', 'store']);
    Route::resource('/users', UsersController::class);
    Route::resource('/posts', PostsController::class);
    Route::resource('/collections', PostCollectionsController::class);
    Route::resource('/posts/{post:slug}/comments', CommentsController::class);
    Route::resource('/collections/{post_collection:slug}/comments', CommentsController::class);
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');
});
