@extends('layouts.app')

@section('title', isset($recipe) ? 'Éditer la Recette' : 'Ajouter une Recette')

@section('content')
    <h1>{{ isset($recipe) ? 'Éditer une Recette' : 'Ajouter une Recette' }}</h1>

    <form method="POST" action="{{ isset($recipe) ? route('recipes.update', $recipe) : route('recipes.store') }}" enctype="multipart/form-data">
        @csrf
        @if (isset($recipe))
            @method('PUT')
        @endif

        <div>
            <label for="name">Nom</label><br/>
            <input type="text" name="name" value="{{ isset($recipe->name) ? $recipe->name : old('name') }}" id="name" placeholder="Le nom de la recette">
            @error('name')
                <div>{{ $message }}</div>
            @enderror>
        </div>
        <div>
            <label for="description">Description</label><br/>
            <textarea name="description" id="description" lang="fr" rows="10" cols="50" placeholder="Description de la recette">{{ isset($recipe->description) ? $recipe->description : old('description') }}</textarea>
        @error('description')
            <div>{{ $message }}</div>
        @enderror>
        </div>

        <div>
            <label for="picture">Photo</label><br/>
            <input type="file" name="picture" id="picture">
            @error('picture')
                <div>{{ $message }}</div>
            @enderror>
        </div>

        @if(isset($recipe->image))
            <div>
                <span>Image actuelle</span><br/>
                <img src="{{ asset('storage/' . $recipe->image) }}" alt="image de la recette actuelle" style="max-height: 200px;">
            </div>
        @endif

        <h3>Ingrédients</h3>
        @for ($i = 0; $i < 10; $i++)
        <div class="ingredient">
            <select id="products" name="products[]">
                <option value="">-- Choisir un produit --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                            @if(isset($recipe->products[$i]) && $recipe->products[$i]->pivot->product_id == $product->id)
                                selected
                           @endif>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            <input id="quantities" type="number" name="quantities[]"
                   value="{{ isset($recipe->products[$i]) ? $recipe->products[$i]->pivot->quantity : '' }}"
                   placeholder="Quantité">
        </div>
        @endfor
        @error('products')
            <div>{{ $message }}</div>
        @enderror>
        @error('quantities')
        <div>{{ $message }}</div>
        @enderror>
        <div>
            <input type="submit" name="valider" value="Valider">
        </div>
    </form>
@endsection
