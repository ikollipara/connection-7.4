<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCollectionRequest;
use App\Models\PostCollection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostCollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query("status") ?? "draft";
        return view("collections.index", [
            "collections" => $this->current_user()
                ->postCollections()
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
        return view("collections.create");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function show(PostCollection $postCollection)
    {
        $this->authorize("view", $postCollection);
        return view("collections.show", [
            "collection" => $postCollection,
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
        $this->authorize("update", $postCollection);
        return view("collections.edit", [
            "collection" => $postCollection,
        ]);
    }
}
