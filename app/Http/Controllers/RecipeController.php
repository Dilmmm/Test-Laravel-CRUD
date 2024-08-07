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
            'name' => 'required|string|max:255',
            'picture' => 'image|max:1024',
            'description' => 'required',
            'products.*' => 'nullable|integer|exists:products,id',
            'quantities.*' => 'nullable|integer|min:1',
        ]);
        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
        $validProducts = [];

        $filteredProducts = array_filter($products, fn($product) => !is_null($product) && $product !== '');;
        $filteredQuantities = array_filter($quantities, fn($value) => !is_null($value) && $value !== '');


        foreach ($filteredProducts as $key => $product) {
            if (isset($filteredQuantities[$key]) && $filteredQuantities[$key] >= 1) {
                $validProducts[$product] = $filteredQuantities[$key];
            }
        }
        if (count($validProducts) < 2) {
            return back()->withErrors(['products' => 'Vous devez ajouter au moins deux ingrédients avec des quantités (minimum 1).'])->withInput();
        }

        $chemin_image = 'Aucune image';

        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->picture->extension();
            $chemin_image = $request->picture->storeAs('recipes', $filename, 'public');
        }

        $recipe = Recipe::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $chemin_image,
        ]);


        foreach ($validProducts as $product_id => $quantity) {
            $recipe->products()->attach($product_id, ['quantity' => $quantity]);
        }

        return redirect()->route('recipes.index');
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
            'name' => 'required|string|max:255',
            'picture' => 'image|max:1024',
            'description' => 'required',
            'products.*' => 'nullable|integer|exists:products,id',
            'quantities.*' => 'nullable|integer|min:1',
        ]);

        $chemin_image = $recipe->image;

        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->picture->extension();
            $chemin_image = $request->picture->storeAs('recipes', $filename, 'public');
        }

        $recipe->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $chemin_image,
        ]);

        $recipe->products()->detach();
        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i] && $quantities[$i]) {
                $recipe->products()->attach($products[$i], ['quantity' => $quantities[$i]]);
            }
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
