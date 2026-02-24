<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Mis álbumes</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Administrá tus álbumes de fotos</p>
            </div>

            <a href="{{ route('fotografo.albums.create') }}" class="btn-primary">
                Crear álbum
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/20 px-4 py-3 text-green-800 dark:text-green-300 ring-1 ring-green-200 dark:ring-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($albums->isEmpty())
                {{-- Estado vacío --}}
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 dark:ring-gray-700 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Todavía no tenés álbumes</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Creá tu primer álbum para compartir tus fotos con los cosplayers.
                    </p>
                    <a href="{{ route('fotografo.albums.create') }}" class="btn-primary">
                        Crear mi primer álbum
                    </a>
                </div>
            @else
                {{-- Grid de álbumes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($albums as $album)
                        <div
                            class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden hover:shadow-md transition group">

                            {{-- Thumbnail --}}
                            <div
                                class="aspect-video bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center relative overflow-hidden">
                                @if ($album->thumbnail)
                                    <img src="{{ storage_url($album->thumbnail) }}" alt="{{ $album->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                @endif

                                {{-- Badge público/privado (superpuesto) --}}
                                <div class="absolute top-3 right-3">
                                    @if ($album->is_public)
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 ring-1 ring-green-200">
                                            Público
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-800/80 backdrop-blur-sm px-2.5 py-0.5 text-xs font-medium text-white">
                                            Privado
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Contenido del card --}}
                            <div class="p-6">
                                <div class="mb-3">
                                    <h3
                                        class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2 group-hover:text-indigo-600 transition">
                                        {{ $album->title }}
                                    </h3>

                                    @if ($album->event)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            📸 {{ $album->event }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Información adicional --}}
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                    @if ($album->event_date)
                                        <p class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($album->event_date)->format('d/m/Y') }}
                                        </p>
                                    @endif

                                    @if ($album->location)
                                        <p class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $album->location }}
                                        </p>
                                    @endif

                                    @if ($album->description)
                                        <p class="text-gray-700 dark:text-gray-300 mt-3 line-clamp-2">
                                            {{ $album->description }}
                                        </p>
                                    @endif
                                </div>

                                @if ($album->drive_url)
                                    <a href="{{ $album->drive_url }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 mt-4 text-sm text-indigo-600 hover:text-indigo-700">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" />
                                        </svg>
                                        Ver en Drive
                                    </a>
                                @endif
                            </div>

                            {{-- Acciones --}}
                            <div
                                class="border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-6 py-3 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('fotografo.albums.edit', $album) }}"
                                        class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                                        Editar
                                    </a>
                                    <a href="{{ route('fotografo.albums.featured.edit', $album) }}"
                                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                        📸 Destacadas
                                        @if($album->featured_photos_count > 0)
                                            <span class="inline-block ml-1 px-1.5 py-0.5 bg-indigo-100 text-indigo-700 rounded text-xs">{{ $album->featured_photos_count }}</span>
                                        @endif
                                    </a>
                                </div>

                                <form method="POST" action="{{ route('fotografo.albums.destroy', $album) }}"
                                    onsubmit="return confirm('¿Eliminar este álbum? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if ($albums->hasPages())
                    <div class="mt-8">
                        {{ $albums->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
