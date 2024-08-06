<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'recipe_products', 'recipe_id', 'product_id')
                    ->using(RecipeProduct::class)
                    ->withPivot('quantity');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
