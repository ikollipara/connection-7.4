<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        // Get the top ten most viewed posts
        $most_viewed_posts = Post::query()
            ->where("published", true)
            ->orderBy("views", "desc")
            ->take(10)
            ->with("user")
            ->get();
        // Get the top ten most viewed post_collections
        $most_viewed_post_collections = PostCollection::query()
            ->where("published", true)
            ->orderBy("views", "desc")
            ->take(10)
            ->with("user")
            ->get();

        return view("users.home", [
            "most_viewed_posts" => $most_viewed_posts,
            "most_viewed_post_collections" => $most_viewed_post_collections,
        ]);
    }
}
