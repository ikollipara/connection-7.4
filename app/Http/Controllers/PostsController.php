<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User */
        $user = $this->current_user();

        /** @var string */
        $status = $request->query("status", "draft");

        return view("posts.index", [
            "posts" => $user
                ->posts()
                ->status($status)
                ->get(),
            "status" => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view("posts.create");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        $this->authorize("view", $post);
        /** @var \App\Models\User */
        $user = $this->current_user();
        if ($post->isViewedBy($user)) {
            $post->view($user);
        }

        if (!array_key_exists("languages", $post->metadata)) {
            $post->metadata = array_merge($post->metadata, ["languages" => []]);
        }

        return view("posts.show", ["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        $this->authorize("update", $post);
        return view("posts.edit", ["post" => $post]);
    }
}
