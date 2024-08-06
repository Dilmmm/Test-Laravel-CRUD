@extends("layouts.app")
@section("title", "Tous les produits")
@section("content")

	<h1>Tous les produits</h1>

	<p>
		<a href="{{ route('products.create') }}" title="Créer un produit" >Créer un nouveau produit</a>
	</p>
	<table >
		<thead>
			<tr>
				<th>Produits</th>
				<th>Categorie</th>
				<th colspan="2" >Opérations</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($products as $product)
			<tr>
				<td>
					<a href="{{ route('products.show', $product) }}" title="Fiche produit" >{{ $product->name }}</a>
				</td>

				<td>
					<p>{{ $product->category->name }}</p>
				</td>

				<td>
					<a href="{{ route('products.edit', $product) }}" title="Modifier le produit" >Modifier</a>
				</td>
				<td>
					<form method="POST" action="{{ route('products.destroy', $product) }}" >
						@csrf
						@method("DELETE")
						<input type="submit" value="x Supprimer" >
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@endsection
