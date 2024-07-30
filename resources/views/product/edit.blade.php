@extends("layouts.app")
@section("title", "Ajouter un Produit")
@section("content")




@if (isset($product))
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
			<label for="name" >Nom du produit</label><br/>
			<input type="text" name="name" value="{{ isset($product->nom) ? $product->nom : old('nom') }}" id="name" placeholder="Le nom du produit" >
			@error("nom")
			<div>{{ $message }}</div>
			@enderror
		</p>
		@if(isset($product->image))
		<p>
			<span>Image actuelle</span><br/>
			<img src="{{ asset('storage/'.$product->image) }}" alt="image du produit actuelle" style="max-height: 200px;" >
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
			<label for="content" >Desciption</label><br/>
			<textarea name="content" id="content" lang="fr" rows="10" cols="50" placeholder="description du produit" >{{ isset($product->description) ? $product->description : old('description') }}</textarea>
			@error("content")
			<div>{{ $message }}</div>
			@enderror
		</p>
		<input type="submit" name="valider" value="Valider" >
	</form>

@endsection