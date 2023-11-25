<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCollectionCommentsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostCollectionsController;
use App\Http\Controllers\PostCommentsController;
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

Route::get("/", [StaticPagesController::class, "index"])->name("index");
Route::get("/about", [StaticPagesController::class, "about"])->name("about");

Route::resource("/registration", RegistrationController::class);
Route::resource("/login", SessionController::class)->only(["create", "store"]);

Route::middleware("auth")->group(function () {
    Route::get("/home", [HomeController::class, "index"])->name("home");
    Route::get("/search", [HomeController::class, "search"])->name("search");
    Route::resource("/users", UsersController::class);

    // File Upload
    Route::post("/upload", [FileUploadController::class, "store"])->name(
        "upload.store",
    );
    Route::delete("/upload", [FileUploadController::class, "destroy"])->name(
        "upload.destroy",
    );

    // Post Routes
    Route::get("/posts", [PostsController::class, "index"])
        ->name("posts.index")
        ->withTrashed();
    Route::resource("/posts", PostsController::class)->only([
        "create",
        "show",
        "edit",
    ]);
    Route::get("/posts/{post}/comments", [
        PostCommentsController::class,
        "index",
    ])->name("posts.comments.index");

    // Post Collection Routes
    Route::resource("collections", PostCollectionsController::class)
        ->parameters(["collections" => "post_collection"])
        ->only(["create", "show", "edit"]);
    Route::get("/collections", [PostCollectionsController::class, "index"])
        ->name("collections.index")
        ->withTrashed();
    Route::get("/collections/{post_collection}/comments", [
        PostCollectionCommentsController::class,
        "index",
    ])->name("collections.comments.index");

    Route::delete("/logout", [SessionController::class, "destroy"])->name(
        "logout",
    );
});
