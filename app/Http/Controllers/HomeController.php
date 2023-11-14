<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;

class HomeController extends Controller
{
    public function index()
    {
        // Get the top ten most viewed posts
        $most_viewed_posts = Post::orderBy('views', 'desc')->take(10)->get();
        // Get the top ten most viewed post_collections
        $most_viewed_post_collections = PostCollection::orderBy('views', 'desc')->take(10)->get();
        return view('home', [
            'most_viewed_posts' => $most_viewed_posts,
            'most_viewed_post_collections' => $most_viewed_post_collections,
        ]);
    }
}
