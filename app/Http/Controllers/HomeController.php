<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return view('home', compact('posts'));
    }
}
