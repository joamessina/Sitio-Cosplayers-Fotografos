<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Álbumes de Fotos</h2>
                <p class="text-sm text-gray-600">Explorá álbumes de eventos y convenciones</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filtros --}}
            <div x-data="{ showAdvanced: {{ request()->hasAny(['buscar', 'fecha_exacta', 'fecha_desde', 'fecha_hasta', 'orden']) && !in_array(request('orden'), ['', 'recientes']) ? 'true' : 'false' }} }"
                 class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-6 ring-1 ring-gray-200 dark:ring-gray-700 mb-6">
                <form method="GET" action="{{ route('albumes.index') }}" class="space-y-4">

                    {{-- Filtros básicos --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Filtro por fotógrafo --}}
                        <div>
                            <label for="fotografo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fotógrafo
                            </label>
                            <select name="fotografo" id="fotografo"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos los fotógrafos</option>
                                @foreach ($fotografos as $fotografo)
                                    <option value="{{ $fotografo->id }}"
                                        {{ request('fotografo') == $fotografo->id ? 'selected' : '' }}>
                                        {{ $fotografo->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filtro por evento --}}
                        <div>
                            <label for="evento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Evento
                            </label>
                            <input type="text" name="evento" id="evento" value="{{ request('evento') }}"
                                placeholder="Ej: Comic-Con"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Filtro por ubicación --}}
                        <div>
                            <label for="ubicacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ubicación
                            </label>
                            <input type="text" name="ubicacion" id="ubicacion" value="{{ request('ubicacion') }}"
                                placeholder="Ej: Buenos Aires"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    {{-- Toggle para filtros avanzados --}}
                    <div class="border-t dark:border-gray-700 pt-4">
                        <button type="button" @click="showAdvanced = !showAdvanced"
                            class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                            <svg class="w-4 h-4 transition-transform" :class="showAdvanced ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <span x-text="showAdvanced ? 'Ocultar filtros avanzados' : 'Mostrar filtros avanzados'"></span>
                        </button>
                    </div>

                    {{-- Filtros avanzados --}}
                    <div x-show="showAdvanced" x-transition class="border-t dark:border-gray-700 pt-4 space-y-4">

                        {{-- Búsqueda por texto --}}
                        <div>
                            <label for="buscar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Búsqueda por texto
                            </label>
                            <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}"
                                placeholder="Buscar en títulos, descripciones y eventos..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Busca en títulos, descripciones y nombres de eventos</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            {{-- Fecha exacta --}}
                            <div>
                                <label for="fecha_exacta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fecha exacta del evento
                                </label>
                                <input type="date" name="fecha_exacta" id="fecha_exacta" value="{{ request('fecha_exacta') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            {{-- Fecha desde --}}
                            <div>
                                <label for="fecha_desde" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Desde fecha
                                </label>
                                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            {{-- Fecha hasta --}}
                            <div>
                                <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Hasta fecha
                                </label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        {{-- Ordenamiento --}}
                        <div>
                            <label for="orden" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ordenar por
                            </label>
                            <select name="orden" id="orden"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="recientes" {{ request('orden') === 'recientes' ? 'selected' : '' }}>Más recientes</option>
                                <option value="antiguos" {{ request('orden') === 'antiguos' ? 'selected' : '' }}>Más antiguos</option>
                                <option value="evento_az" {{ request('orden') === 'evento_az' ? 'selected' : '' }}>Evento A-Z</option>
                                <option value="evento_za" {{ request('orden') === 'evento_za' ? 'selected' : '' }}>Evento Z-A</option>
                                <option value="fecha_evento" {{ request('orden') === 'fecha_evento' ? 'selected' : '' }}>Fecha del evento</option>
                            </select>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-700 font-medium">
                            Buscar
                        </button>

                        @if (request()->hasAny(['fotografo', 'evento', 'ubicacion', 'buscar', 'fecha_exacta', 'fecha_desde', 'fecha_hasta', 'orden']))
                            <a href="{{ route('albumes.index') }}"
                                class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-6 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium">
                                Limpiar filtros
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Resultados --}}
            @if ($albums->isEmpty())
                {{-- Estado vacío --}}
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 dark:ring-gray-700 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        @if (request()->hasAny(['fotografo', 'evento', 'ubicacion', 'buscar', 'fecha_exacta', 'fecha_desde', 'fecha_hasta']))
                            No se encontraron álbumes con esos filtros
                        @else
                            Todavía no hay álbumes públicos
                        @endif
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        @if (request()->hasAny(['fotografo', 'evento', 'ubicacion', 'buscar', 'fecha_exacta', 'fecha_desde', 'fecha_hasta']))
                            Probá ajustando los filtros de búsqueda.
                        @else
                            Los álbumes públicos de los fotógrafos aparecerán aquí.
                        @endif
                    </p>
                </div>
            @else
                {{-- Contador de resultados --}}
                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $albums->total() }} {{ $albums->total() === 1 ? 'álbum encontrado' : 'álbumes encontrados' }}
                    </p>
                </div>

                {{-- Grid de álbumes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($albums as $album)
                        <div
                            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden hover:shadow-lg hover:ring-indigo-300 transition group">

                            {{-- Thumbnail con skeleton --}}
                            <div
                                class="gallery-item aspect-video bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center relative overflow-hidden">
                                @if ($album->thumbnail)
                                    <div class="skeleton-img absolute inset-0"></div>
                                    <img src="{{ storage_url($album->thumbnail) }}" alt="{{ $album->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                        onload="this.classList.add('loaded'); this.previousElementSibling.style.display='none'">
                                @else
                                    <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                @endif
                            </div>

                            <div class="p-5">
                                <h3
                                    class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 mb-2 line-clamp-1 transition">
                                    {{ $album->title }}
                                </h3>

                                <a href="{{ route('fotografos.show', $album->user) }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-700 mb-3 inline-flex items-center gap-1">
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

                                <div class="flex items-center gap-3 text-xs text-gray-500 mt-3">
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
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Ver álbum
                                    </a>

                                    {{-- Botón de favorito (solo para cosplayers loggeados) --}}
                                    @if (auth()->check() && auth()->user()->role === 'cosplayer')
                                        <button
                                            onclick="toggleFavorite({{ $album->id }}, this)"
                                            data-favorited="{{ $album->is_favorited_by_user ? 'true' : 'false' }}"
                                            class="favorite-btn inline-flex items-center justify-center p-2 border-2 rounded-lg transition {{ $album->is_favorited_by_user ? 'border-red-300 text-red-600 bg-red-50' : 'border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800' }}"
                                            title="{{ $album->is_favorited_by_user ? 'Quitar de favoritos' : 'Agregar a favoritos' }}">
                                            <svg class="w-5 h-5" fill="{{ $album->is_favorited_by_user ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </button>
                                    @endif

                                    @if ($album->drive_url)
                                        <a href="{{ $album->drive_url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center p-2 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                                            title="Abrir en Google Drive">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if ($albums->hasPages())
                    <div class="mt-8">
                        {{ $albums->withQueryString()->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>

    @if (auth()->check() && auth()->user()->role === 'cosplayer')
    @push('scripts')
    <script>
        async function toggleFavorite(albumId, button) {
            const isFavorited = button.dataset.favorited === 'true';
            const method = isFavorited ? 'DELETE' : 'POST';

            // Cambio visual inmediato
            button.disabled = true;

            try {
                const response = await fetch(`/albums/${albumId}/favorite`, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Actualizar el estado visual del botón
                    if (data.action === 'added') {
                        button.dataset.favorited = 'true';
                        button.classList.remove('border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
                        button.classList.add('border-red-300', 'text-red-600', 'bg-red-50');
                        button.querySelector('svg').setAttribute('fill', 'currentColor');
                        button.title = 'Quitar de favoritos';
                    } else if (data.action === 'removed') {
                        button.dataset.favorited = 'false';
                        button.classList.remove('border-red-300', 'text-red-600', 'bg-red-50');
                        button.classList.add('border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
                        button.querySelector('svg').setAttribute('fill', 'none');
                        button.title = 'Agregar a favoritos';
                    }

                    // Mostrar mensaje temporal
                    showMessage(data.message);
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error al actualizar favoritos', 'error');
            } finally {
                button.disabled = false;
            }
        }

        function showMessage(message, type = 'success') {
            // Crear elemento de notificación temporal
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all transform translate-x-full ${type === 'error' ? 'bg-red-50 text-red-800 border border-red-200' : 'bg-green-50 text-green-800 border border-green-200'}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animar entrada
            setTimeout(() => notification.classList.remove('translate-x-full'), 100);

            // Eliminar después de 3 segundos
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }
    </script>
    @endpush
    @endif
</x-app-layout>
