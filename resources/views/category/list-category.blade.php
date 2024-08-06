@extends("layouts.app")
@section("title", "Toutes les catégories")
@section("content")

	<h1>Toutes les catégories</h1>
    @foreach($categories as $category)
        <div>
            {{ $category->name }}
            <form method="POST" action="{{ route('categories.destroy', $category) }}" >
                @csrf
                @method("DELETE")
                <input type="submit" value="x Supprimer" >
            </form>
        </div>
	@endforeach
@endsection