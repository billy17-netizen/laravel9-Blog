<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class AdminCommentsController extends Controller
{
    private  $rules = [
        'post_id' => 'required|numeric',
        'the_comment' => 'required|min:3|max:255',
    ];
    public function index()
    {
        return view('admin_dashboard.comments.index',[
            'comments' => Comment::with('user')->orderBy('id','desc')->paginate(50),
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.comments.create', [
            'posts' => Post::pluck('title','id'),
        ]);
    }

    public function store(Request $request, Comment $comment)
    {
        $validated = $request->validate($this->rules);
        $validated['user_id'] = auth()->user()->id;
        Comment::create ($validated);
        return redirect()->route('admin.comments.create')->with('success', 'Comment created successfully');
    }

    public function show($id)
    {
    }

    public function edit(Comment $comment)
    {
        return view('admin_dashboard.comments.edit', [
            'posts' => Post::pluck('title','id'),
            'comment' => $comment,
        ]);
    }

    public function update(Request $request,  Comment $comment)
    {

        $validated = $request->validate($this->rules);
        $comment->update($validated);
        return redirect()->route('admin.comments.edit',$comment)->with('success', 'Comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully');
    }
}
