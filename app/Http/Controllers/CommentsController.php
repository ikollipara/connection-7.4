<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\PostCollection;
use App\Models\Post;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use InvalidArgumentException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class CommentsController extends Controller
{

    /**
     * Resolve the item by slug.
     * @param string $slug The slug of the item.
     * @return Post|PostCollection The item.
     * @throws InvalidArgumentException 
     */
    private function resolve_item_by_slug(string $slug)
    {
        return (Post::query()->where('slug', $slug)->first() ?? PostCollection::query()->where('slug', $slug)->first());
    }

    /**
     * Resolve the redirect.
     * @param Post|PostCollection $item The item.
     * @return RedirectResponse The redirect formmated with the item.
     * @throws BindingResolutionException 
     * @throws RouteNotFoundException 
     */
    private function resolve_redirect($item)
    {
        if (get_class($item) == Post::class) {
            return redirect()
                ->route('posts.comments.index', ['post' => $item]);
        } else {
            return redirect()
                ->route('collections.comments.index', ['post_collection' => $item]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($commentable_slug)
    {
        $item = $this->resolve_item_by_slug($commentable_slug);
        return Inertia::render('Comments/Index', [
            'comments' => $item->comments,
            'commentable' => $item,
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
        $item = $this->resolve_item_by_slug($commentable_slug);
        $item->comments()->create(
            array_merge(
                $request->validated(),
                ['user_id' => $this->current_user()->id]
            )
        );
        return $this->resolve_redirect($item)
            ->with('success', 'Comment created successfully!');
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
        $item = $this->resolve_item_by_slug($commentable_slug);
        $this->authorize('update', $comment);
        $comment->update($request->validated());

        return $this->resolve_redirect($item)
            ->with('success', 'Comment updated successfully!');
    }
}
