<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-white text-lg font-semibold">MES RECETTES</a>
        <ul class="flex space-x-4">
            <li>
                <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white">Produits</a>
            </li>
            <li>
                <a href="{{ route('recipes.index') }}" class="text-gray-300 hover:text-white">Recettes</a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-white">Catégories</a>
            </li>
        </ul>
    </div>
</nav>
