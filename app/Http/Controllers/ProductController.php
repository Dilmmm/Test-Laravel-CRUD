<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();

    return view("product.liste", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::distinct()->get();
       return view("product.edit", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            "picture" => 'bail|image|max:1024',
            "description" => 'bail|required',
            'category_id' => 'bail|integer|exists:categories,id',
        ]);


        $chemin_image = 'Aucune image';


        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->picture->extension();
            $chemin_image = $request->picture->storeAs('products', $filename, 'public');
        }

        Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "image" => $chemin_image,
            'category_id' => $request->category_id,

        ]);


        return redirect(route("products.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view("product.show", compact("product"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::distinct()->get();
        return view("product.edit", compact("product", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'bail|required|string|max:255',
            'description' => 'bail|required',
            'category_id' => 'bail|integer|exists:categories,id',
        ];

        if ($request->hasFile('picture')) {
            $rules['picture'] = 'bail|required|image|max:1024';
        }

        $this->validate($request, $rules);

        if ($request->hasFile('picture')) {
            if ($product->image && $product->image !== 'Aucune image') {
                Storage::disk('public')->delete($product->image);
            }

            $filename = time() . '.' . $request->picture->extension();
            $chemin_image = $request->picture->storeAs('products', $filename, 'public');
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => isset($chemin_image) ? $chemin_image : $product->image,
        ]);

        return redirect(route('products.show', $product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && $product->image !== 'Aucune image') {
            Storage::disk('public')->delete($product->image);
        }

    $product->delete();

    return redirect(route('products.index'));
    }
}
