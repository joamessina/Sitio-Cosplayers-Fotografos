<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Mi Shop</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Gestioná tus publicaciones de venta</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('shop.index') }}" class="btn-secondary">
                    Ver shop público
                </a>
                <a href="{{ route('mi-shop.create') }}" class="btn-primary">
                    + Nueva publicación
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash message --}}
            @if (session('status'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            @if ($items->isEmpty())
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 dark:ring-gray-700 text-center">
                    <div class="text-5xl mb-4">🛍️</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Todavía no publicaste nada</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                        Publicá props, ropa o accesorios de cosplay que ya no uses.
                    </p>
                    <a href="{{ route('mi-shop.create') }}" class="btn-primary mt-6 inline-flex">
                        Crear primera publicación
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($items as $item)
                        <div class="bg-white dark:bg-gray-900 rounded-2xl ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden shadow-sm">

                            {{-- Foto --}}
                            <a href="{{ route('shop.show', $item) }}" class="block">
                                <div class="aspect-[4/3] bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                    @if ($item->photos && count($item->photos) > 0)
                                        <img src="{{ asset('storage/' . $item->photos[0]) }}"
                                             alt="{{ $item->title }}"
                                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-600">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Badge estado --}}
                                    <div class="absolute top-2 left-2">
                                        @if ($item->status === 'active')
                                            <span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Activo</span>
                                        @elseif ($item->status === 'sold')
                                            <span class="bg-gray-700 text-white text-xs font-semibold px-2 py-1 rounded-full">Vendido</span>
                                        @else
                                            <span class="bg-yellow-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Inactivo</span>
                                        @endif
                                    </div>
                                </div>
                            </a>

                            {{-- Info --}}
                            <div class="p-4">
                                <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $item->title }}</p>
                                <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                    ${{ number_format($item->price, 2, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>

                                {{-- Acciones --}}
                                <div class="flex gap-2 mt-4">
                                    <a href="{{ route('mi-shop.edit', $item) }}"
                                       class="flex-1 text-center px-3 py-2 text-sm bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                        Editar
                                    </a>

                                    <form action="{{ route('mi-shop.destroy', $item) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar esta publicación? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-2 text-sm bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/40 transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if ($items->hasPages())
                    <div class="mt-6">
                        {{ $items->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
