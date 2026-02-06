<x-app-layout>
    <x-slot name="header">
        {{-- Breadcrumbs --}}
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
            <a href="{{ route('albumes.index') }}" class="hover:text-indigo-600">Álbumes</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">{{ $album->title }}</span>
        </div>

        <h2 class="text-xl font-semibold text-gray-900">
            {{ $album->title }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Card principal del álbum --}}
            <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">

                {{-- Info del fotógrafo --}}
                <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-200">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <span class="text-lg font-bold text-white">
                            {{ strtoupper(substr($album->user->photographerProfile->display_name ?? $album->user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Fotógrafo</p>
                        <a href="{{ route('fotografos.show', $album->user) }}"
                            class="text-base font-semibold text-gray-900 hover:text-indigo-600">
                            {{ $album->user->photographerProfile->display_name ?? $album->user->name }}
                        </a>
                    </div>
                </div>

                {{-- Título y detalles --}}
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ $album->title }}
                    </h1>

                    @if ($album->event)
                        <p class="text-lg text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $album->event }}
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        @if ($album->event_date)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ \Carbon\Carbon::parse($album->event_date)->format('d/m/Y') }}
                            </div>
                        @endif

                        @if ($album->location)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $album->location }}
                            </div>
                        @endif
                    </div>

                    @if ($album->description)
                        <p class="text-gray-700 mt-4 leading-relaxed">
                            {{ $album->description }}
                        </p>
                    @endif
                </div>

                {{-- Iframe de Drive o mensaje --}}
                {{-- Botón y preview de Drive --}}
                @if ($album->drive_url)
                    @php
                        $embedUrl = \App\Helpers\DriveHelper::getEmbedUrl($album->drive_url);
                    @endphp

                    <div class="space-y-4">
                        {{-- Botón para abrir en Drive --}}
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700">
                                <strong>Fotos del álbum:</strong> Mirá las fotos aquí o abrí en Drive
                            </p>
                            <a href="{{ $album->drive_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition whitespace-nowrap">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" />
                                </svg>
                                Abrir en Drive
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                            </a>
                        </div>

                        @if ($embedUrl)
                            {{-- Preview embebido --}}
                            <div class="rounded-lg overflow-hidden ring-1 ring-gray-200 bg-white">
                                <iframe src="{{ $embedUrl }}" class="w-full"
                                    style="height: 70vh; min-height: 700px;" frameborder="0" allow="autoplay"
                                    allowfullscreen>
                                </iframe>
                            </div>

                            <p class="text-xs text-gray-500 text-center">
                                ✨ Vista previa de Google Drive. Para descargar fotos, <a href="{{ $album->drive_url }}"
                                    target="_blank" class="text-indigo-600 hover:underline">abrí en Drive</a>
                            </p>
                        @else
                            {{-- Fallback si no se pudo extraer el ID --}}
                            <div
                                class="rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 p-8 text-center text-white">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-90" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" />
                                </svg>
                                <h3 class="text-2xl font-bold mb-2">Ver las fotos del álbum</h3>
                                <p class="text-white/90 mb-6">
                                    Las fotos están disponibles en Google Drive
                                </p>
                                <a href="{{ $album->drive_url }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-3 rounded-lg bg-white px-8 py-4 text-lg font-semibold text-indigo-600 hover:bg-gray-50 transition shadow-lg">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" />
                                    </svg>
                                    Abrir álbum en Google Drive
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    {{-- Sin Drive URL --}}
                    <div class="rounded-lg bg-gray-50 p-8 ring-1 ring-gray-200 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-700 font-medium">Este álbum aún no tiene fotos disponibles</p>
                        <p class="text-sm text-gray-600 mt-2">
                            El fotógrafo todavía no agregó el link de Drive con las fotos.
                        </p>
                    </div>
                @endif
            </div>

            {{-- Más álbumes del fotógrafo --}}
            @if ($moreAlbums->isNotEmpty())
                <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        Más álbumes de {{ $album->user->photographerProfile->display_name ?? $album->user->name }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($moreAlbums as $otherAlbum)
                            <a href="{{ route('albumes.show', $otherAlbum) }}"
                                class="group bg-white rounded-xl shadow-sm ring-1 ring-gray-200 overflow-hidden hover:shadow-md transition">
                                <div class="p-5">
                                    <h4
                                        class="font-semibold text-gray-900 group-hover:text-indigo-600 mb-2 line-clamp-2">
                                        {{ $otherAlbum->title }}
                                    </h4>

                                    @if ($otherAlbum->event)
                                        <p class="text-sm text-gray-600 mb-2">
                                            📸 {{ $otherAlbum->event }}
                                        </p>
                                    @endif

                                    @if ($otherAlbum->event_date)
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($otherAlbum->event_date)->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('fotografos.show', $album->user) }}"
                            class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">
                            Ver todos los álbumes de este fotógrafo
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Botón volver --}}
            <div class="text-center">
                <a href="{{ route('albumes.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Volver a todos los álbumes
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
