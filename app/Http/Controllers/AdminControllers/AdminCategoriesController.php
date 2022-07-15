<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoriesController extends Controller
{

    private $rules = [
        'name' => 'required|min:3|max:255',
        'slug' => 'required|min:3|max:255|unique:categories,slug',
    ];
    public function index()
    {
        return view('admin_dashboard.categories.index',[
            'categories' => Category::with('user')->orderBy('id','desc')->paginate(50),
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules);
        $validatedData['user_id'] = auth()->user()->id;
        Category::create($validatedData);
        return redirect()->route('admin.categories.create')->with('success', 'Category created successfully');
    }

    public function show(Category $category)
    {
        return view('admin_dashboard.categories.show',[
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin_dashboard.categories.edit',[
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $this->rules['slug']=['required', Rule::unique('categories')->ignore($category)];
        $validatedData = $request->validate($this->rules);
        $category->update($validatedData);
        return redirect()->route('admin.categories.edit',$category)->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $default_category_id = Category::where('name','Uncategorized')->first()->id;

        if ($category->name === "Uncategorized")
            abort(404);
        $category->posts()->update(['category_id' => $default_category_id]);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
