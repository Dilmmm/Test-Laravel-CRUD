<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::distinct()->get();
        return view("category.list-category", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::distinct()->get();
        return view("category.edit-category", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,['name'=> 'bail|required|string|max:255']);
        Category::create(["name" => $request->name]);

        return redirect(route("categories.index"));

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view("category.edit-category", compact("category"));
     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'bail|required|string|max:255',
        ];

        $this->validate($request, $rules);

        $category->update(['name' => $request->name,]);

        return redirect(route('categories.show', $category));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        
    $category->delete();

    return redirect(route('categories.index'));
    }
}
