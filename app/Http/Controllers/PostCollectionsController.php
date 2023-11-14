<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCollectionRequest;
use App\Models\PostCollection;

class PostCollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $status)
    {
        return view('post_collections.index', [
            'post_collections' => $this
                ->current_user()
                ->post_collections()
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
        return view('post_collections.create');
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

        redirect()
            ->route('post_collections.edit', ['post_collection' => $post_collection])
            ->with('success', 'PostCollection created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function show(PostCollection $postCollection)
    {
        return view('post_collections.show', [
            'post_collection' => $postCollection,
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
        return view('post_collections.edit', [
            'post_collection' => $postCollection,
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
        $postCollection->update($request->validated());

        redirect()
            ->route('post_collections.edit', ['post_collection' => $postCollection])
            ->with('success', 'PostCollection updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCollection $postCollection)
    {
        if ($postCollection->delete()) {
            return redirect()
                ->route('post_collections.index', ['status' => 'draft'])
                ->with('success', 'PostCollection archived successfully!');
        } else {
            return back()
                ->with('error', 'PostCollection could not be archived.');
        }
    }
}
