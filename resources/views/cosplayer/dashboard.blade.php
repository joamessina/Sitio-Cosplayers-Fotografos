<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Panel Cosplayer</h2>
                <p class="text-sm text-gray-600">
                    Subí tus fotos y encontrá álbumes donde aparezcas.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('cosplayer.photos.index') }}" class="btn-primary">
                    Subir / ver mis fotos
                </a>

                <a href="{{ route('fotografos.index') }}" class="btn-secondary">
                    Explorar fotógrafos
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

                    <a href="{{ route('cosplayer.photos.index') }}" class="btn-secondary">
                        Subir mi primera foto
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="card p-5">
                    <p class="text-sm text-gray-500">Fotos subidas</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $photosCount ?? 0 }}</p>
                    <a href="{{ route('cosplayer.photos.index') }}" class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Ver mi galería →
                    </a>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-gray-500">Encontrar fotos</p>
                    <p class="text-gray-900 mt-2">
                        Explorá fotógrafos y revisá sus álbumes por evento.
                    </p>
                    <a href="{{ route('fotografos.index') }}" class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Explorar fotógrafos →
                    </a>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-gray-500">Álbumes públicos</p>
                    <p class="text-gray-900 mt-2">
                        Mirá los últimos uploads publicados.
                    </p>
                    <a href="{{ route('albums.public') }}" class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Ver álbumes recientes →
                    </a>
                </div>
            </div>

            {{-- Últimas fotos + Tips --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 card">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Últimas fotos subidas</h3>
                        <a href="{{ route('cosplayer.photos.index') }}" class="text-sm text-indigo-600 hover:underline">
                            Administrar
                        </a>
                    </div>

                    @if(empty($latestPhotos) || $latestPhotos->isEmpty())
                        <div class="mt-4 rounded-lg bg-gray-50 p-6 ring-1 ring-gray-200">
                            <p class="text-gray-700">
                                Todavía no subiste fotos. Subí la primera y armamos tu galería.
                            </p>

                            <a href="{{ route('cosplayer.photos.index') }}" class="btn-primary mt-4">
                                Subir foto
                            </a>
                        </div>
                    @else
                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($latestPhotos as $p)
                                <a href="{{ route('cosplayer.photos.index') }}"
                                   class="group block overflow-hidden rounded-lg bg-gray-100 ring-1 ring-gray-200">
                                    <div class="aspect-square">
                                        <img src="{{ asset('storage/'.$p->path) }}"
                                             alt="foto"
                                             class="h-full w-full object-cover transition group-hover:scale-105">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900">Siguiente paso</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Después de las fotos, vamos a implementar álbumes de fotógrafos con links de Drive.
                    </p>

                    <ul class="mt-4 space-y-2 text-sm text-gray-700">
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
</x-app-layout>
