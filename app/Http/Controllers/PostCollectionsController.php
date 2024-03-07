<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCollectionRequest;
use App\Models\PostCollection;
use Illuminate\Http\Request;

class PostCollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = $request->query("status", "draft");

        /** @var \App\Models\User */
        $user = $this->current_user();

        return view("collections.index", [
            "collections" => $user
                ->postCollections()
                /** @phpstan-ignore-next-line */
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
        return view("collections.create");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\View\View
     */
    public function show(PostCollection $postCollection)
    {
        $this->authorize("view", $postCollection);

        /** @var \App\Models\User */
        $user = $this->current_user();

        if (!$postCollection->isViewedBy($user)) {
            $postCollection->view($user);
        }

        if (!array_key_exists("languages", $postCollection->metadata)) {
            $postCollection->metadata = array_merge($postCollection->metadata, [
                "languages" => [],
            ]);
        }

        return view("collections.show", [
            "collection" => $postCollection,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\View\View
     */
    public function edit(PostCollection $postCollection)
    {
        $this->authorize("update", $postCollection);
        return view("collections.edit", [
            "collection" => $postCollection,
        ]);
    }
}
