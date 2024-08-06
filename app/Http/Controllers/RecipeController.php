<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with('products')->get();
        return view("recipe.list-recipe", compact("recipes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view("recipe.edit-recipe", compact("products"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            'description' => 'bail|required',
            'products' => 'required|array',
            'products.*.id' => 'bail|required|integer|exists:products,id',
            'products.*.quantity' => 'bail|required|integer|min:1',
            "picture" => 'bail|image|max:1024',
        ]);

        $chemin_image = 'Aucune image';

        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->picture->extension();
            $chemin_image = $request->picture->storeAs('recipes', $filename, 'public');
        }

        $recipe = Recipe::create([
            "name" => $request->name,
            "description" => $request->description,
            "image" => $chemin_image,
        ]);

        foreach ($request->products as $product) {
            $recipe->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('recipes.index')->with('success', 'Recette créée avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        return view('recipe.show-recipe', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        $products = Product::all();
        return view('recipe.edit-recipe', compact('recipe', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            'description' => 'bail|required',
            'products' => 'required|array',
            'products.*.id' => 'bail|required|integer|exists:products,id',
            'products.*.quantity' => 'bail|required|integer|min:1',
            "picture" => 'bail|image|max:1024',
        ]);

        $chemin_image = $recipe->image;

        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->picture->extension();
            $chemin_image = $request->picture->storeAs('recipes', $filename, 'public');
        }

        $recipe->update([
            "name" => $request->name,
            "description" => $request->description,
            "image" => $chemin_image,
        ]);

        $recipe->products()->detach();

        foreach ($request->products as $product) {
            $recipe->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('recipes.index')->with('success', 'Recette mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->products()->detach();
        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Recette supprimée avec succès.');
    }
}
