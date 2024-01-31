<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostCollectionCommentsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionController;
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

Route::view("/", "home")->name("index");
Route::view("/about", "about")->name("about");

Route::resource("/registration", RegistrationController::class);
Route::resource("/login", SessionController::class)->only(["create", "store"]);

Route::get("/email/verify", [EmailController::class, "verify"])
    ->middleware("auth")
    ->name("verification.notice");
Route::get("/email/verify/{id}/{hash}", [
    EmailController::class,
    "validateHash",
])
    ->middleware(["auth", "signed"])
    ->name("verification.verify");
Route::post("/email/verification-notification", [
    EmailController::class,
    "resend",
])
    ->middleware(["auth", "throttle:6,1"])
    ->name("verification.send");

Route::get("/forgot-password", [PasswordResetController::class, "index"])
    ->middleware("guest")
    ->name("password.request");

Route::post("/forgot-password", [PasswordResetController::class, "create"])
    ->middleware("guest")
    ->name("password.email");

Route::get("/reset-password/{token}", [PasswordResetController::class, "show"])
    ->middleware("guest")
    ->name("password.reset");

Route::post("/reset-password", [PasswordResetController::class, "update"])
    ->middleware("guest")
    ->name("password.update");

Route::middleware("auth")->group(function () {
    Route::get("/home", [HomeController::class, "index"])->name("home");
    Route::view("/faq", "faq")
        ->name("faq")
        ->middleware("verified");
    Route::view("/search", "search")
        ->name("search")
        ->middleware("verified");
    Route::resource("/users", UsersController::class);

    // File Upload
    Route::post("/upload", [FileUploadController::class, "store"])
        ->name("upload.store")
        ->middleware("verified");
    Route::delete("/upload", [FileUploadController::class, "destroy"])
        ->name("upload.destroy")
        ->middleware("verified");

    // Post Routes
    Route::get("/posts", [PostsController::class, "index"])
        ->name("posts.index")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/create", [PostsController::class, "create"])
        ->name("posts.create")
        ->middleware("verified");
    Route::get("/posts/{post}", [PostsController::class, "show"])
        ->name("posts.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{post}/edit", [PostsController::class, "edit"])
        ->name("posts.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{post}/comments", [
        PostCommentsController::class,
        "index",
    ])
        ->name("posts.comments.index")
        ->withTrashed()
        ->middleware("verified");

    // Post Collection Routes
    Route::get("/collections/create", [
        PostCollectionsController::class,
        "create",
    ])
        ->name("collections.create")
        ->middleware("verified");
    Route::get("/collections/{post_collection}", [
        PostCollectionsController::class,
        "show",
    ])
        ->name("collections.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections/{post_collection}/edit", [
        PostCollectionsController::class,
        "edit",
    ])
        ->name("collections.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections", [PostCollectionsController::class, "index"])
        ->name("collections.index")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections/{post_collection}/comments", [
        PostCollectionCommentsController::class,
        "index",
    ])
        ->name("collections.comments.index")
        ->withTrashed()
        ->middleware("verified");

    Route::delete("/logout", [SessionController::class, "destroy"])->name(
        "logout",
    );
});
