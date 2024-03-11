<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostCollectionsController;
use App\Http\Livewire\Password\ForgotPassword;
use App\Http\Livewire\Password\ResetPassword;
use App\Http\Livewire\User\Login;
use App\Http\Livewire\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\User;
use App\Http\Livewire\Post;
use App\Http\Livewire\Collection;
use App\Http\Livewire\Home;
use App\Http\Livewire\Search;

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

Route::get("/sign-up", User\Create::class)->name("registration.create");
Route::get("/login", Login::class)->name("login.create");

Route::get("/email/verify/{id}/{hash}", function (
    EmailVerificationRequest $request
) {
    $request->fulfill();
    Log::info("Email verified for user {$request->user()->id}.");
    return redirect()->route("home");
})
    ->middleware(["auth"])
    ->name("verification.verify");

Route::get("/email/verify", VerifyEmail::class)
    ->middleware("auth")
    ->name("verification.notice");

Route::get("/forgot-password", ForgotPassword::class)
    ->middleware("guest")
    ->name("password.request");

Route::get("/reset-password/{token}", ResetPassword::class)
    ->middleware("guest")
    ->name("password.reset");

Route::middleware("auth")->group(function () {
    Route::get("/home", Home::class)->name("home");
    Route::view("/faq", "faq")
        ->name("faq")
        ->middleware("verified");
    Route::get("/search", Search::class)
        ->name("search")
        ->middleware("verified");
    Route::get("/users/{user}/edit", User\Settings::class)
        ->name("users.edit")
        ->middleware("verified");
    Route::get("/users/{user}", User\Show::class)
        ->name("users.show")
        ->middleware("verified");
    Route::get("/users/{user}/posts", User\Posts::class)
        ->name("users.posts.index")
        ->middleware("verified");
    Route::get("/users/{user}/collections", User\Collections::class)
        ->name("users.collections.index")
        ->middleware("verified");
    Route::get("/users/{user}/followers", User\Followers::class)
        ->name("users.followers.index")
        ->middleware("verified");
    Route::get("/users/{user}/followings", User\Followings::class)
        ->name("users.followings.index")
        ->middleware("verified");

    // File Upload
    Route::post("/upload", [FileUploadController::class, "store"])
        ->name("upload.store")
        ->middleware("verified");
    Route::delete("/upload", [FileUploadController::class, "destroy"])
        ->name("upload.destroy")
        ->middleware("verified");

    // Post Routes
    Route::get("/posts", Post\Index::class)
        ->name("posts.index")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/create", Post\Editor::class)
        ->name("posts.create")
        ->middleware("verified");
    Route::get("/posts/{post}", [PostsController::class, "show"])
        ->name("posts.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{uuid}/edit", Post\Editor::class)
        ->name("posts.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{post}/comments", Post\Comments::class)
        ->name("posts.comments.index")
        ->withTrashed()
        ->middleware("verified");

    // Post Collection Routes
    Route::get("/collections/create", Collection\Editor::class)
        ->name("collections.create")
        ->middleware("verified");
    Route::get("/collections/{post_collection}", [
        PostCollectionsController::class,
        "show",
    ])
        ->name("collections.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections/{uuid}/edit", Collection\Editor::class)
        ->name("collections.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections", Collection\Index::class)
        ->name("collections.index")
        ->withTrashed()
        ->middleware("verified");
    Route::get(
        "/collections/{post_collection}/comments",
        Collection\Comments::class,
    )
        ->name("collections.comments.index")
        ->withTrashed()
        ->middleware("verified");
});
