<?php

namespace App\Http\Controllers;

use App\Events\PostViewed;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query("status") ?? "draft";
        return view("posts.index", [
            "posts" => $this->current_user()
                ->posts()
                ->status($status)
                ->get(),
            "status" => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("posts.create");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize("view", $post);
        if ($post->isViewedBy($this->current_user())) {
            return view("posts.show", ["post" => $post]);
        } else {
            $post->view($this->current_user());
            return view("posts.show", ["post" => $post]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize("update", $post);
        return view("posts.edit", ["post" => $post]);
    }
}
