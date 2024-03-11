<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // index
    public function index()
    {
        $products = Product::paginate(10);

        return view('pages.products.index', compact('products'));
    }

    // create
    public function create()
    {
        $categories = DB::table('categories')->get();

        return view('pages.products.create', compact('categories'));
    }

    // store
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|boolean',
            'is_favorite' => 'required|boolean',
            'category_id' => 'required',
            'image' => 'nullable|image|file|max:1024',
        ]);

        // store the request
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;
        $product->category_id = $request->category_id;

        if ($request->description)
        {
            $product->description = $request->description;
        }

        $product->image = ($request->file('image')) ? $request->file('image')->store('post-images') : '-';

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    // show
    public function show($id)
    {
        return view('pages.products.show');
    }

    // edit
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        return view('pages.products.edit', compact('product', 'categories'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|boolean',
            'is_favorite' => 'required|boolean',
            'category_id' => 'required',
            'image' => 'nullable|image|file|max:1024',
        ]);

        // store the request
        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;
        $product->category_id = $request->category_id;

        if ($request->description)
        {
            $product->description = $request->description;
        }

        if ($request->file('image'))
        {
            if ($request->oldImage)
            {
                Storage::delete($request->oldImage);
            }

            $product->image = $request->file('image')->store('post-images');
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        // delete the request
        $product = Product::find($id);
        $imageName = $product->image;
        $product->delete();

        if (Storage::exists($imageName)){
            Storage::delete($imageName);
        }

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
