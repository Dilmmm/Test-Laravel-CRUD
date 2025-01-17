<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_products', 'product_id', 'recipe_id')
                    ->using(RecipeProduct::class)
                    ->withPivot('quantity');

    }
}
