<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\PostCollection;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class CommentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $commentable_slug)
    {
        $comments = Comment::whereMorphHas(
            [Post::class, PostCollection::class],
            function (Builder $query) use ($commentable_slug) {
                $query->where('slug', $commentable_slug);
            }
        )->get();

        return view('comments.index', [
            'comments' => $comments,
            'commentable' => $comments->first()->commentable,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $commentable_slug)
    {
        $commentable = Comment::whereMorphHas([Post::class, PostCollection::class], function (Builder $query) use ($commentable_slug) {
            $query->where('slug', $commentable_slug);
        })->first()->commentable;

        return view('comments.create', [
            'commentable' => $commentable,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $commentable_slug
     * @param  \App\Http\Requests\CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(string $commentable_slug, CommentRequest $request)
    {
        Comment::create($request->validated() + [
            'commentable_id' => Comment::whereMorphHas([Post::class, PostCollection::class], function (Builder $query) use ($commentable_slug) {
                $query->where('slug', $commentable_slug);
            })->first()->commentable->id,
            'commentable_type' => get_class(Comment::whereMorphHas([Post::class, PostCollection::class], function (Builder $query) use ($commentable_slug) {
                $query->where('slug', $commentable_slug);
            })->first()->commentable),
            'user_id' => auth()->user()->id,
        ]);

        return redirect()
            ->route('comments.index', ['commentable_slug' => $commentable_slug])
            ->with('success', 'Comment created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $commentable_slug
     * @param  \App\Http\Requests\CommentRequest $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(string $commentable_slug, CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return redirect()
            ->route('comments.index', ['commentable_slug' => $commentable_slug])
            ->with('success', 'Comment updated successfully!');
    }
}
