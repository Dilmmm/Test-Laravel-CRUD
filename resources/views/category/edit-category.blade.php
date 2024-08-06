@extends("layouts.app")
@section("title", "Ajouter une catégorie")
@section("content")




@if (isset($category))
	<h1>Editer une catégorie</h1>

	<form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data" >

	<!-- <input type="hidden" name="_method" value="PUT"> -->
	@method('PUT')

@else
	<h1>Ajouter une catégorie</h1>

	<form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data" >
	@endif
		
		@csrf
		
		<p>
			<label for="name" >Nom</label><br/>
			<input type="text" name="name" value="{{ isset($category->nom) ? $category->name: old('name') }}" id="name" placeholder="Le nom de la catégorie" >
			@error("nom")
			<div>{{ $message }}</div>
			@enderror
		</p>
	
		<input type="submit" name="valider" value="Valider" >
	</form>

@endsection