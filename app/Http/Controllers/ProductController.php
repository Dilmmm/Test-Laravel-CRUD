<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    $products = Product::all();

    return view("product.liste", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view("product.edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            "picture" => 'bail|image|max:1024',
            "content" => 'bail|required',
            'categorie_id' => 'bail|integer|exists:categories,id',
        ]);
    

        $chemin_image = 'Aucune image';

    
        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->picture->extension();
            $chemin_image = $request->picture->storeAs('products', $filename, 'public');
        }
        
        Product::create([
            "nom" => $request->name,
            "description" => $request->content,
            "image" => $chemin_image,
            'categorie_id' => 1,
            //'categorie_id' => $request->categorie_id,
            
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
        return view("product.edit", compact("product"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'bail|required|string|max:255',
            'content' => 'bail|required',
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
            'nom' => $request->name,
            'description' => $request->content,
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
