<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index',[
            'categories' => Category::withCount('posts')->orderBy('posts_count','desc')->paginate(5),
        ]);
    }

    public function show(Category $category)
    {
        $recent_posts = Post::latest()->take(5)->get();
        $Categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();

        $tags = Tag::latest()->take(50)->get();

        return view('categories.show',[
            'recent_posts'=>$recent_posts,
            'Categories'=>$Categories,
            'tags'=>$tags,
            'category'=>$category,
            'posts' => $category->posts()->paginate(10),
        ]);
    }
}
