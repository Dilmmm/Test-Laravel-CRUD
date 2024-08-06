@extends('layouts.app')

@section('title', 'Liste des Recettes')

@section('content')
    <h1>Liste des Recettes</h1>

    @if ($recipes->isEmpty())
        <p>Aucune recette disponible.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Image</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($recipes as $recipe)
                <tr>
                    <td>
                        <a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->name }}</a>
                    </td>
                    <td>{{ $recipe->description }}</td>
                    <td>
                        @if ($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}" style="max-height: 100px;">
                        @else
                            Pas d'image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('recipes.edit', $recipe) }}">Modifier</a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('recipes.create') }}">Ajouter une nouvelle recette</a>
@endsection
