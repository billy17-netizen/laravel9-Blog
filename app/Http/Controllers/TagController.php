<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {

    }

    public function show(Tag $tag)
    {
        $recent_posts = Post::latest()->take(5)->get();
        $Categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();

        $tags = Tag::latest()->take(50)->get();

        return view('tags.show',[
            'tag' => $tag,
            'recent_posts'=>$recent_posts,
            'Categories'=>$Categories,
            'tags'=>$tags,
            'posts' => $tag->posts()->paginate(5),
        ]);
    }
}
