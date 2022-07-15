<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostsController extends Controller
{
    private $rules = [
        'title' => 'required|min:3|max:255',
        'slug' => 'required|min:3|max:255|unique:posts',
        'excerpt' => 'required|max:255',
        'body' => 'required',
        'category_id' => 'required|exists:categories,id',
        'thumbnail' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];
    public function index()
    {
        return view('admin_dashboard.posts.index',[
            'posts'=>Post::with('category')->get(),
        ]);
    }

    public function create()
    {

        return view('admin_dashboard.posts.create',[
            'categories' => Category::pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = request()->validate($this->rules);
        $validated['user_id'] = auth()->id();
        $post = Post::create($validated);
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = time() . '.' . $thumbnail->getClientOriginalName();
            $file_extension = time() . '.' . $thumbnail->getClientOriginalExtension();
            $path = $thumbnail->store('images', 'public');

            $post->image()->create([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);
        }
            return redirect()->route('admin.posts.create')->with('success', 'Post created successfully');

    }

    public function show($id)
    {
    }

    public function edit(Post $post)
    {
        return view('admin_dashboard.posts.edit',[
            'post' => $post,
            'categories' => Category::pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->rules['thumbnail'] = 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $validated = request()->validate($this->rules);
        $post->update($validated);
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = time() . '.' . $thumbnail->getClientOriginalName();
            $file_extension = time() . '.' . $thumbnail->getClientOriginalExtension();
            $path = $thumbnail->store('images', 'public');

            $post->image()->update([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);
        }
        return redirect()->route('admin.posts.edit',$post)->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
