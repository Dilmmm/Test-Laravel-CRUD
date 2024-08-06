@extends("layouts.app")
@section("title", "Ajouter un Produit")
@section("content")




@if ( isset($product) )
	<h1>Editer un Produit</h1>

	<form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" >

	<!-- <input type="hidden" name="_method" value="PUT"> -->
	@method('PUT')

@else
	<h1>Ajouter un Produit</h1>

	<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" >
	@endif

		@csrf

		<p>
			<label for="name" >Nom</label><br/>
			<input type="text" name="name" value="{{ isset($product->name) ? $product->name: old('name') }}" id="name" placeholder="Le nom du produit" >
			@error("name")
			<div>{{ $message }}</div>
			@enderror
		</p>
		<label for="category_id" >Catégorie</label><br/>
		<select name="category_id" id="category_id">
			@foreach ( $categories as $category )
                <option value="{{ $category->id }}"
                    {{ old('category_id', isset($product) ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
			@endforeach
		</select>
		@if(isset($product->image))
		<p>
			<span>Image actuelle</span><br/>
			<img src="{{ asset('storage/'.$product->image) }}" alt="image du produit actuel" style="max-height: 200px;" >
		</p>
		@endif
		<p>
			<label for="picture" >Photo</label><br/>
			<input type="file" name="picture" id="picture" >
			@error("picture")
			<div>{{ $message }}</div>
			@enderror
		</p>
		<p>
			<label for="description" >Desciption</label><br/>
			<textarea name="description" id="description" lang="fr" rows="10" cols="50" placeholder="description du produit" >{{ isset($product->description) ? $product->description : old('description') }}</textarea>
			@error("description")
			<div>{{ $message }}</div>
			@enderror
		</p>
		<input type="submit" name="valider" value="Valider" >
	</form>

@endsection
