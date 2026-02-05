<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perfil de {{ $user->photographerProfile->display_name ?? $user->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Card del perfil --}}
            <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
                <div class="flex flex-col md:flex-row gap-6">

                    {{-- Avatar placeholder (puedes agregar foto después) --}}
                    <div class="flex-shrink-0">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr($user->photographerProfile->display_name ?? $user->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    {{-- Información del perfil --}}
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $user->photographerProfile->display_name ?? $user->name }}
                        </h1>

                        @if ($user->photographerProfile && $user->photographerProfile->location)
                            <p class="text-sm text-gray-600 mt-1 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $user->photographerProfile->location }}
                            </p>
                        @endif

                        @if ($user->photographerProfile && $user->photographerProfile->bio)
                            <p class="text-gray-700 mt-4 leading-relaxed">
                                {{ $user->photographerProfile->bio }}
                            </p>
                        @else
                            <p class="text-gray-500 italic mt-4">
                                Este fotógrafo todavía no agregó una biografía.
                            </p>
                        @endif

                        {{-- Enlaces sociales --}}
                        <div class="flex flex-wrap gap-3 mt-6">
                            @if ($user->photographerProfile && $user->photographerProfile->instagram)
                                <a href="https://instagram.com/{{ $user->photographerProfile->instagram }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                    {{ '@' . $user->photographerProfile->instagram }}

                                </a>
                            @endif

                            @if ($user->photographerProfile && $user->photographerProfile->portfolio_url)
                                <a href="{{ $user->photographerProfile->portfolio_url }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                        </path>
                                    </svg>
                                    Portfolio
                                </a>
                            @endif

                            @if (
                                !$user->photographerProfile ||
                                    (!$user->photographerProfile->instagram && !$user->photographerProfile->portfolio_url))
                                <p class="text-sm text-gray-500 italic">
                                    Sin enlaces agregados
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

{{-- Sección de álbumes --}}
<div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Álbumes</h2>
            <p class="text-sm text-gray-600 mt-1">
                {{ $albums->count() }} {{ $albums->count() === 1 ? 'álbum público' : 'álbumes públicos' }}
            </p>
        </div>
    </div>
    
    @if($albums->isEmpty())
        {{-- Estado vacío --}}
        <div class="rounded-lg bg-gray-50 p-8 ring-1 ring-gray-200 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-700 font-medium">Este fotógrafo todavía no tiene álbumes públicos</p>
            <p class="text-sm text-gray-600 mt-2">
                Los álbumes aparecerán aquí cuando el fotógrafo los marque como públicos.
            </p>
        </div>
    @else
        {{-- Grid de álbumes --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($albums as $album)
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-200 overflow-hidden hover:shadow-md transition">
                    
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $album->title }}
                        </h3>
                        
                        @if($album->event)
                            <p class="text-sm text-gray-600">
                                📸 {{ $album->event }}
                            </p>
                        @endif

                        {{-- Información adicional --}}
                        <div class="space-y-2 mt-4 text-sm text-gray-600">
                            @if($album->event_date)
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($album->event_date)->format('d/m/Y') }}
                                </p>
                            @endif

                            @if($album->location)
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $album->location }}
                                </p>
                            @endif

                            @if($album->description)
                                <p class="text-gray-700 mt-3 line-clamp-3">
                                    {{ $album->description }}
                                </p>
                            @endif
                        </div>

                        @if($album->drive_url)
                            <a href="{{ $album->drive_url }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 mt-4 rounded-lg bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z"/>
                                </svg>
                                Ver fotos en Drive
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

            {{-- Botón volver --}}
            <div class="text-center">
                <a href="{{ route('fotografos.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Volver al listado de fotógrafos
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
