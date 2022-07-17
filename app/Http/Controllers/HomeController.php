<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest('id')
            ->approved()
            ->withCount('comments')->paginate(10);
        $recent_posts = Post::latest()->take(5)->get();
        $Categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();

        $tags = Tag::latest()->take(50)->get();
        return view('home',[
            'posts'=>$posts,
            'recent_posts'=>$recent_posts,
            'Categories'=>$Categories,
            'tags'=>$tags,
        ]);
    }
}
