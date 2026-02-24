<x-app-layout>
    @php
        $user = auth()->user();
    @endphp
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Panel Cosplayer</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Subí tus fotos y encontrá álbumes donde aparezcas.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <button onclick="copyPortfolioUrl()" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Copiar URL del portfolio
                </button>

                <a href="{{ route('cosplayer.fotos.index') }}" class="btn-primary">
                    Subir / ver mis fotos
                </a>

                <a href="{{ route('cosplayer.perfil.edit') }}" class="btn-secondary">
                    Personalizar portfolio
                </a>

                <a href="{{ route('fotografos.index') }}" class="btn-secondary">
                    Explorar fotógrafos
                </a>

                <a href="{{ route('cosplayer.favoritos.index') }}" class="btn-secondary">
                    ❤️ Mis favoritos
                </a>

                <a href="{{ route('mi-shop.index') }}" class="btn-secondary">
                    🛍️ Mi Shop
                </a>
<a href="{{ route('portfolio.show', $user->cosplayerProfile?->instagram ?? Str::before($user->email, '@')) }}"
    target="_blank" class="btn-secondary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
        </path>
    </svg>
    Ver perfil público
</a>
            </div>
        </div>
    </x-slot>

    <div class="page-wrap">
        <div class="container-app space-y-6">

            {{-- Hero --}}
            <div class="rounded-2xl bg-indigo-600 p-6 text-white shadow">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Hola, {{ auth()->user()->name }} 👋</p>
                        <h3 class="text-2xl font-semibold mt-1">Armá tu galería</h3>
                        <p class="text-white/80 mt-1">
                            Guardá tus mejores fotos en un solo lugar para que no se pierdan los links.
                        </p>
                    </div>

                    <a href="{{ route('cosplayer.fotos.index') }}" class="btn-secondary">
                        Subir mi primera foto
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="card p-5">
                    <p class="text-sm text-gray-500">Fotos subidas</p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $photosCount ?? 0 }}</p>
                    <a href="{{ route('cosplayer.fotos.index') }}"
                        class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Ver mi galería →
                    </a>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-gray-500">Encontrar fotos</p>
                    <p class="text-gray-900 mt-2">
                        Explorá fotógrafos y revisá sus álbumes por evento.
                    </p>
                    <a href="{{ route('fotografos.index') }}"
                        class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Explorar fotógrafos →
                    </a>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-gray-500">Álbumes públicos</p>
                    <p class="text-gray-900 mt-2">
                        Mirá los últimos uploads publicados.
                    </p>
                    <a href="{{ route('albumes.index') }}"
                        class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Ver álbumes recientes →
                    </a>
                </div>
            </div>

            {{-- Últimas fotos + Tips --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 card">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Últimas fotos subidas</h3>
                        <a href="{{ route('cosplayer.fotos.index') }}" class="text-sm text-indigo-600 hover:underline">
                            Administrar
                        </a>
                    </div>

                    @if (empty($latestPhotos) || $latestPhotos->isEmpty())
                        <div class="mt-4 rounded-lg bg-gray-50 dark:bg-gray-800 p-6 ring-1 ring-gray-200 dark:ring-gray-700">
                            <p class="text-gray-700">
                                Todavía no subiste fotos. Subí la primera y armamos tu galería.
                            </p>

                            <a href="{{ route('cosplayer.fotos.index') }}" class="btn-primary mt-4">
                                Subir foto
                            </a>
                        </div>
                    @else
                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach ($latestPhotos as $p)
                                <a href="{{ route('cosplayer.fotos.index') }}"
                                    class="group block overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800 ring-1 ring-gray-200 dark:ring-gray-700">
                                    <div class="aspect-square">
                                        <img src="{{ storage_url($p->path) }}" alt="foto"
                                            class="h-full w-full object-cover transition group-hover:scale-105">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Siguiente paso</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Después de las fotos, vamos a implementar álbumes de fotógrafos con links de Drive.
                    </p>

                    <ul class="mt-4 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        <li class="flex gap-2"><span class="text-indigo-600">✓</span> Subida + galería (cosplayer)</li>
                        <li class="flex gap-2"><span class="text-indigo-600">✓</span> Roles separados</li>
                        <li class="flex gap-2"><span class="text-indigo-600">→</span> Álbumes fotógrafo (Drive)</li>
                    </ul>

                    <a href="{{ route('fotografos.index') }}" class="btn-secondary w-full mt-4">
                        Buscar fotógrafos
                    </a>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function copyPortfolioUrl() {
            @php
                $username = auth()->user()->cosplayerProfile?->instagram
                    ?? Str::before(auth()->user()->email, '@')
                    ?? auth()->user()->name;
            @endphp

            const url = "{{ url('/@' . $username) }}";

            navigator.clipboard.writeText(url).then(() => {
                showCopyNotification('URL copiada al portapapeles ✓');
            }).catch(err => {
                console.error('Error al copiar:', err);
                showCopyNotification('Error al copiar', 'error');
            });
        }

        function showCopyNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all transform translate-x-full ${
                type === 'error'
                    ? 'bg-red-50 text-red-800 border border-red-200'
                    : 'bg-green-50 text-green-800 border border-green-200'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);
            setTimeout(() => notification.classList.remove('translate-x-full'), 100);
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }
    </script>
    @endpush
</x-app-layout>
