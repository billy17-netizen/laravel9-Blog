<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdminPostsController extends Controller
{
    private $rules = [
        'title' => 'required|min:3|max:255',
        'slug' => 'required|min:3|max:255|',
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
        if ($request->hasFile('thumbnail'))
        {
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
        $tags = explode(',', $request->input('tags'));
        $tags_ids = [];
        foreach($tags as $tag){
            $tag_ob = Tag::create(['name' => $tag]);
            $tags_ids[] = $tag_ob->id;
        }
        if (count($tags_ids) > 0) {
            $post->tags()->sync($tags_ids);
        }
        return redirect()->route('admin.posts.create')->with('success', 'Post created successfully');

    }

    public function show($id)
    {
    }

    public function edit(Post $post)
    {
        $tags = '';
         foreach ($post->tags as $key=>$tag)
         {
             $tags .= $tag->name;
             if ($key !== count($post->tags) - 1){
                 $tags .= ', ';
             }
         }
        return view('admin_dashboard.posts.edit',[
            'post' => $post,
            'tags' => $tags,
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
        $tags = explode(',', $request->input('tags'));
        $tags_ids = [];
        foreach($tags as $tag) //tag1, tag2, tag3
        {
            $tag_exist = $post->tags()->where('name',trim($tag))->count();
            if ($tag_exist == 0) {
                $tag_ob = Tag::create(['name' => trim($tag)]);
                $tags_ids[] = $tag_ob->id;
            }
        }
        if (count($tags_ids) > 0) {
            $post->tags()->syncWithoutDetaching($tags_ids);
        }
        return redirect()->route('admin.posts.edit',$post)->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->tags()->delete();
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
