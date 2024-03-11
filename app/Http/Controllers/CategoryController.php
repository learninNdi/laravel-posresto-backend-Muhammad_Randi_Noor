<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // index
    public function index()
    {
        $categories = Category::paginate(5);

        return view('pages.categories.index', compact('categories'));
    }

    // create
    public function create()
    {
        return view('pages.categories.create');
    }

    // store
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|file|max:1024',
        ]);

        // store the request
        $category = new Category;
        $category->name = $request->name;

        if ($request->description)
        {
            $category->description = $request->description;
        }

        $category->image = ($request->file('image')) ? $request->file('image')->store('post-images') : '-';

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    // show
    public function show($id)
    {
        return view('pages.categories.show');
    }

    // edit
    public function edit($id)
    {
        $category = Category::find($id);

        return view('pages.categories.edit', compact('category'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|file|max:1024',
        ]);

        // store the request
        $category = Category::find($id);
        $category->name = $request->name;

        if ($request->description)
        {
            $category->description = $request->description;
        }

        if ($request->file('image'))
        {
            if ($request->oldImage)
            {
                Storage::delete($request->oldImage);
            }

            $category->image = $request->file('image')->store('post-images');
        }

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        // delete the request
        $category = Category::find($id);
        $imageName = $category->image;
        $category->delete();

        if (Storage::exists($imageName)){
            Storage::delete($imageName);
        }

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
