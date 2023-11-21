<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostCollectionsController;
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

Route::get('/', [StaticPagesController::class, 'index'])->name('index');
Route::get('/about', [StaticPagesController::class, 'about'])->name('about');

Route::resource('/registration', RegistrationController::class);
Route::resource('/login', SessionController::class)->only(['create', 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/upload', [FileUploadController::class, 'store'])->name('upload.store');
    Route::delete('/upload', [FileUploadController::class, 'destroy'])->name('upload.destroy');
    Route::resource('/users', UsersController::class);
    Route::patch('/posts/{post}/status', [PostsController::class, 'restore'])->name('posts.restore')->withTrashed();
    Route::resource('/posts', PostsController::class);
    Route::get('/posts/{status?}', [PostsController::class, 'index'])->name('posts.index')->withTrashed();
    Route::patch('/collections/{post_collection}/status', [PostCollectionsController::class, 'restore'])->name('collections.restore')->withTrashed();
    Route::resource('collections', PostCollectionsController::class)->parameters([
        'collections' => 'post_collection'
    ]);
    Route::get('/collections/{status?}', [PostCollectionsController::class, 'index'])->name('collections.index')->withTrashed();
    Route::resource('posts.comments', CommentsController::class)->scoped([
        'post' => 'slug'
    ]);
    Route::resource('collections.comments', CommentsController::class)->parameters([
        'collections' => 'post_collection'
    ])->scoped([
        'post_collection' => 'slug'
    ]);
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');
});
