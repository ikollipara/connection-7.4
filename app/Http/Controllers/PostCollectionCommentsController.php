<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\PostCollection;
use Illuminate\Http\Request;

class PostCollectionCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\View\View
     */
    public function index(PostCollection $postCollection)
    {
        return view("collections.comments.index", [
            "collection" => $postCollection,
        ]);
    }
}
