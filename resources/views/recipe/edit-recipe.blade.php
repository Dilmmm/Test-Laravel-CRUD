@extends("layouts.app")
@section("title", isset($recipe) ? "Éditer une Recette" : "Ajouter une Recette")
@section("content")

    <h1>{{ isset($recipe) ? "Éditer une Recette" : "Ajouter une Recette" }}</h1>

    <form method="POST" action="{{ isset($recipe) ? route('recipes.update', $recipe) : route('recipes.store') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($recipe))
            @method('PUT')
        @endif

        <p>
            <label for="name">Nom</label><br/>
            <input type="text" name="name" value="{{ isset($recipe->name) ? $recipe->name : old('name') }}" id="name" placeholder="Nom de la recette">
        @error("name")
            <div>{{ $message }}</div>
        @enderror
        </p>

        <p>
            <label for="description">Description</label><br/>
            <textarea name="description" id="description" rows="10" cols="50" placeholder="Description de la recette">{{ isset($recipe->description) ? $recipe->description : old('description') }}</textarea>
        @error("description")
        <div>{{ $message }}</div>
        @enderror
        </p>
        @if(isset($recipe->image))
            <p>
                <span>Image actuelle</span><br/>
                <img src="{{ asset('storage/'.$recipe->image) }}" alt="image de la recette actuelle" style="max-height: 200px;" >
            </p>
        @endif

        <p>
            <label for="picture">Photo</label><br/>
            <input type="file" name="picture" id="picture">
        @error("picture")
        <div>{{ $message }}</div>
        @enderror
        </p>

        <label>Produits</label><br/>
        <div id="products">
            @foreach ( $products as $product )
                <div>
                    <input type="checkbox" name="products[{{ $product->id }}][id]" value="{{ $product->id }}"
                        {{ (isset($recipe) && $recipe->products->contains($product->id)) || (old('products.'.$product->id.'.id') == $product->id) ? 'checked' : '' }}>
                    <label>{{ $product->name }}</label>
                    <input type="number" name="products[{{ $product->id }}][quantity]" value="{{ isset($recipe) ? $recipe->products->find($product->id)->pivot->quantity : old('products.'.$product->id.'.quantity') }}" placeholder="Quantité">
                </div>
            @endforeach
        </div>

        <input type="submit" value="Valider">
    </form>

@endsection
