<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get the top ten most viewed posts
        $most_viewed_posts = Post::query()
            ->where("published", true)
            ->orderBy("views", "desc")
            ->take(10)
            ->get();
        $most_viewed_posts->map(fn($post) => $post->load("user"));
        // Get the top ten most viewed post_collections
        $most_viewed_post_collections = PostCollection::query()
            ->where("published", true)
            ->orderBy("views", "desc")
            ->take(10)
            ->get();
        $most_viewed_post_collections->map(
            fn($collection) => $collection->load("user"),
        );
        return view("users.home", [
            "most_viewed_posts" => $most_viewed_posts,
            "most_viewed_post_collections" => $most_viewed_post_collections,
        ]);
    }

    public function search(Request $request)
    {
        return view("search");
    }
}
