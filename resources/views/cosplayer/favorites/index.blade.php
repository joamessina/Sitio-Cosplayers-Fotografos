<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Mis álbumes favoritos</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Álbumes que marcaste como favoritos</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($favoriteAlbums->isEmpty())
                {{-- Estado vacío --}}
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 dark:ring-gray-700 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No tenés álbumes favoritos aún</h3>
                    <p class="text-gray-600 mb-6">
                        Explorá álbumes de fotógrafos y marcá los que más te gusten como favoritos.
                    </p>
                    <a href="{{ route('albumes.index') }}" class="btn-primary">
                        Explorar álbumes
                    </a>
                </div>
            @else
                {{-- Contador de favoritos --}}
                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $favoriteAlbums->total() }} {{ $favoriteAlbums->total() === 1 ? 'álbum favorito' : 'álbumes favoritos' }}
                    </p>
                </div>

                {{-- Grid de álbumes favoritos --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($favoriteAlbums as $album)
                        <div
                            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden hover:shadow-lg hover:ring-pink-300 transition group">

                            {{-- Thumbnail --}}
                            <div
                                class="aspect-video bg-gradient-to-br from-pink-100 dark:from-pink-900/30 to-purple-100 dark:to-purple-900/30 flex items-center justify-center relative overflow-hidden">
                                @if ($album->thumbnail)
                                    <img src="{{ storage_url($album->thumbnail) }}" alt="{{ $album->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <svg class="w-16 h-16 text-pink-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                @endif

                                {{-- Badge de favorito --}}
                                <div class="absolute top-3 right-3">
                                    <div class="bg-pink-500 text-white p-1.5 rounded-full shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3
                                    class="font-semibold text-gray-900 dark:text-white group-hover:text-pink-600 mb-2 line-clamp-1 transition">
                                    {{ $album->title }}
                                </h3>

                                <a href="{{ route('fotografos.show', $album->user) }}"
                                    class="text-sm text-pink-600 hover:text-pink-700 mb-3 inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    {{ $album->user->photographerProfile->display_name ?? $album->user->name }}
                                </a>

                                @if ($album->event)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        📸 {{ $album->event }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-500 mt-3">
                                    @if ($album->event_date)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($album->event_date)->format('d/m/Y') }}
                                        </span>
                                    @endif

                                    @if ($album->location)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                            </svg>
                                            {{ Str::limit($album->location, 20) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 mt-4">
                                    <a href="{{ route('albumes.show', $album) }}"
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Ver álbum
                                    </a>

                                    {{-- Botón para quitar de favoritos --}}
                                    <button onclick="removeFavorite({{ $album->id }})"
                                        class="inline-flex items-center justify-center p-2 border-2 border-pink-300 text-pink-700 rounded-lg hover:bg-pink-50 transition"
                                        title="Quitar de favoritos">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if ($favoriteAlbums->hasPages())
                    <div class="mt-8">
                        {{ $favoriteAlbums->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>

    @push('scripts')
    <script>
        async function removeFavorite(albumId) {
            if (!confirm('¿Quitar este álbum de tus favoritos?')) {
                return;
            }

            try {
                const response = await fetch(`/albums/${albumId}/favorite`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Recargar página para reflejar cambios
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al quitar de favoritos');
            }
        }
    </script>
    @endpush
</x-app-layout>