@extends("layouts.app")
@section("title", $product->nom)
@section("content")

	<h1>{{ $product->nom }}</h1>

	<img src="{{ asset('storage/'.$product->image) }}" alt="Image du produit" style="max-width: 300px;">

	<div>{{ $product->description }}</div>
	<div>{{ $product->category->name }}</div>

	<p><a href="{{ route('products.index') }}" title="Retourner aux produits" >Retourner aux produits</a></p>

@endsection