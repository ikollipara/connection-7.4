<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function index()
    {
        return view('home', ['title' => 'conneCTION']);
    }

    public function about()
    {
        return view('about', ['title' => 'About conneCTION']);
    }
}
