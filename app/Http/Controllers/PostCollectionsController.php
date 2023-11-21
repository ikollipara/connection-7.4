<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCollectionRequest;
use App\Models\PostCollection;
use Inertia\Inertia;

class PostCollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $status = 'draft')
    {
        return Inertia::render('PostCollections/Index', [
            'collections' => $this
                ->current_user()
                ->postCollections()
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
        return Inertia::render('PostCollections/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostCollectionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCollectionRequest $request)
    {
        $post_collection = PostCollection::create($request->validated());
        return redirect()
            ->route('collections.edit', ['post_collection' => $post_collection])
            ->with('success', 'Collection created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function show(PostCollection $postCollection)
    {
        $this->authorize('view', $postCollection);
        return Inertia::render('PostCollections/Show', [
            'collection' => $postCollection,
            'likes' => $postCollection->likes(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(PostCollection $postCollection)
    {
        $this->authorize('update', $postCollection);
        return Inertia('PostCollections/Edit', [
            'collection' => $postCollection,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostCollectionRequest $request
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function update(PostCollectionRequest $request, PostCollection $postCollection)
    {
        $this->authorize('update', $postCollection);
        $postCollection->update($request->validated());

        return redirect()
            ->route('collections.edit', ['post_collection' => $postCollection])
            ->with('success', 'Collection updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCollection $postCollection)
    {
        $this->authorize('delete', $postCollection);
        if ($postCollection->delete()) {
            return redirect()
                ->route('collections.index', ['status' => 'draft'])
                ->with('success', 'Collection archived successfully!');
        } else {
            return back()
                ->with('error', 'Collection could not be archived.');
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(PostCollection $postCollection)
    {
        $this->authorize('restore', $postCollection);
        if ($postCollection->restore()) {
            return redirect()
                ->route('collections.index')
                ->with('success', 'Collection restored successfully!');
        } else {
            return back()
                ->with('error', 'Collection could not be restored.');
        }
    }
}
