<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */
    public function index(Post $post)
    {
        return view("posts.comments.index", [
            "post" => $post,
        ]);
    }
}
