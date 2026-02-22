<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Shop de Cosplay</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Props, ropa y accesorios cosplay de la comunidad</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($items->isEmpty())
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 dark:ring-gray-700 text-center">
                    <div class="text-5xl mb-4">🛍️</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Todavía no hay publicaciones</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Sé el primero en publicar algo para vender.</p>
                    @auth
                        <a href="{{ route('mi-shop.create') }}" class="btn-primary mt-6 inline-flex">
                            Publicar ítem
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary mt-6 inline-flex">
                            Iniciar sesión para publicar
                        </a>
                    @endauth
                </div>
            @else
                {{-- Header con acción --}}
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $items->total() }} publicacion{{ $items->total() !== 1 ? 'es' : '' }}
                    </p>
                    @auth
                        <a href="{{ route('mi-shop.create') }}" class="btn-primary">
                            + Publicar ítem
                        </a>
                    @endauth
                </div>

                {{-- Grid de cards --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($items as $item)
                        <a href="{{ route('shop.show', $item) }}"
                           class="group bg-white dark:bg-gray-900 rounded-2xl ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden hover:ring-indigo-400 dark:hover:ring-indigo-500 transition shadow-sm hover:shadow-md">

                            {{-- Foto principal --}}
                            <div class="aspect-square bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                @if ($item->photos && count($item->photos) > 0)
                                    <img src="{{ asset('storage/' . $item->photos[0]) }}"
                                         alt="{{ $item->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Badge vendido --}}
                                @if ($item->status === 'sold')
                                    <div class="absolute top-2 left-2 bg-gray-900/80 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                        Vendido
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="p-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $item->title }}</p>
                                <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                    ${{ number_format($item->price, 2, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">
                                    por {{ $item->user->name }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if ($items->hasPages())
                    <div class="mt-8">
                        {{ $items->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
