<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUsersController extends Controller
{
    private $rules = ['name'=>'required|min:3|max:255',
        'email'=>'required|email|min:3|max:255|unique:users,email',
        'password'=>'required|min:3|max:255',
        'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'role_id'=>'required|numeric',
    ];
    public function index()
    {
        return view('admin_dashboard.users.index', [
            'users' => User::paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.users.create',[
            'roles' => Role::pluck('name', 'id')
        ]);
    }

    public function store(Request $request)
    {
        $validated = request()->validate($this->rules);
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalName();
            $file_extension = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->store('images', 'public');

            $user->image()->create([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);
        }
        return redirect()->route('admin.users.create')->with('success', 'User created successfully');

    }

    public function show(User $user)
    {
        return view('admin_dashboard.users.show', [
            'user' => $user
        ]);
    }


    public function edit(User $user)
    {
        return view('admin_dashboard.users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name', 'id')
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->rules['password'] = 'nullable|min:3|max:255';
        $this->rules['email'] = ['required','email', Rule::unique('users')->ignore($user)];
        $validated = request()->validate($this->rules);
        if ($validated['password']=== null){
            unset($validated['password']);
        }
        $validated['password'] = bcrypt($validated['password']);
        $user->update($validated);
        if ($request->has('image'))
        {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalName();
            $file_extension = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->store('images', 'public');

            $user->image()->update([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);
        }
        return redirect()->route('admin.users.edit',$user)->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()){
            return redirect()->back()->with('error', 'You can not delete yourself');
        }

        User::whereHas('role', function($query){
            $query->where('name', 'admin');
        })->first()->posts()->saveMany($user->posts);

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
