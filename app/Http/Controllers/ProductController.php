<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::latest()
            ->paginate(20)
            ->withQueryString();

        return view('panel.pages.product.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('panel.pages.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'status' => 'required',
        ], [
            '*.required' => ':attribute cannot be empty.',
            '*.max' => ':attribute cannot be more than :max characters.',
            'picture.image' => ':attribute must be an image.',
            'picture.mimes' => ':attribute must be a file of type: jpeg, png, jpg.',
            'picture.max' => ':attribute cannot be more than 2MB.',
        ]);

        $input = $request->all();

        if ($request->hasFile('picture')) {
        $filename = time() . '.' . $request->file('picture')->extension();
        $request->file('picture')->storeAs('public/product', $filename);
        $input['picture'] = $filename;
        }   



        $input['slug'] = rand(99, 999) . '-' . Str::slug($input['name']);

        Product::create($input);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('panel.pages.product.edit', [
            'data' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'status' => 'required',
        ], [
            '*.required' => ':attribute cannot be empty.',
            '*.max' => ':attribute cannot be more than :max characters.',
            'picture.image' => ':attribute must be an image.',
            'picture.mimes' => ':attribute must be a file of type: jpeg, png, jpg.',
            'picture.max' => ':attribute cannot be more than 2MB.',
        ]);

        $input = $request->all();

        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->file('picture')->extension();
            $request->file('picture')->storeAs('public/product', $filename);
            $input['picture'] = $filename;

            if ($product->picture && file_exists(storage_path('app/public/product/' . $product->picture))) {
                unlink(storage_path('app/public/product/' . $product->picture));
            }
        }

        if ($input['name'] != $product->name) {
            $input['slug'] = rand(99, 999) . '-' . Str::slug($input['name']);
        }

        $product->update($input);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->picture && file_exists(storage_path('app/public/product/' . $product->picture))) {
            unlink(storage_path('app/public/product/' . $product->picture));
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }
}
