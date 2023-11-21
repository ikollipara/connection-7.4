<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PharIo\Manifest\Author;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = 'draft')
    {

        return Inertia::render('Posts/Index', [
            'posts' => $this
                ->current_user()
                ->posts()
                ->status($status)
                ->get(),
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $post = Post::create($request->validated());

        return redirect()
            ->route('posts.edit', ['post' => $post], 303)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return Inertia::render('Posts/Show', ['post' => $post->with('user'), 'likes' => $post->likes()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return Inertia::render('Posts/Edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->validated());
        return redirect()
            ->route('posts.edit', ['post' => $post], 303)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        if ($post->delete()) {
            return redirect()->route('posts.index', [], 303)->with('success', 'Post archived successfully!');
        }

        return back()->with('error', 'Post could not be archived.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Post $post)
    {
        $this->authorize('restore', $post);
        if ($post->restore()) {
            return redirect()->route('posts.index')->with('success', 'Post restored successfully!');
        }

        return back()->with('error', 'Post could not be restored.');
    }
}
