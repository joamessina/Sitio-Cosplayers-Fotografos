<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('fotografos.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-900">
                Portfolio de {{ $user->cosplayerProfile->display_name ?? $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Hero Section --}}
            <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-3xl p-8 md:p-12 text-white shadow-xl">
                <div class="flex flex-col md:flex-row items-center gap-8">

                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        <div
                            class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white/30">
                            <span class="text-5xl font-bold text-white">
                                {{ strtoupper(substr($user->cosplayerProfile->display_name ?? $user->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-4xl font-bold mb-2">
                            {{ $user->cosplayerProfile->display_name ?? $user->name }}
                        </h1>

                        <p class="text-white/90 flex items-center justify-center md:justify-start gap-2 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg>
                            Cosplayer
                        </p>

                        @if ($user->cosplayerProfile && $user->cosplayerProfile->bio)
                            <p class="text-lg text-white/95 leading-relaxed max-w-2xl mb-6">
                                {{ $user->cosplayerProfile->bio }}
                            </p>
                        @else
                            <p class="text-white/80 italic mb-6">
                                Este cosplayer está armando su portfolio
                            </p>
                        @endif

                        {{-- Social Links --}}
                        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                            @if ($user->cosplayerProfile && $user->cosplayerProfile->instagram)
                                <a href="https://instagram.com/{{ $user->cosplayerProfile->instagram }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                    @{{ $user - > cosplayerProfile - > instagram }}
                                </a>
                            @endif

                            @if ($user->cosplayerProfile && $user->cosplayerProfile->tiktok)
                                <a href="https://tiktok.com/@{{ $user - > cosplayerProfile - > tiktok }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z" />
                                    </svg>
                                    TikTok
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Galería de Fotos --}}
            @if ($photos->isNotEmpty())
                <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Galería</h2>
                        <p class="text-gray-600 mt-1">Mis mejores cosplays</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($photos as $photo)
                            <div
                                class="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 ring-1 ring-gray-200 hover:ring-2 hover:ring-pink-400 transition cursor-pointer">
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="Cosplay"
                                    class="h-full w-full object-cover transition group-hover:scale-105">

                                {{-- Overlay en hover --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition">
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        @if ($photo->character_name)
                                            <p class="text-white font-medium text-sm">
                                                {{ $photo->character_name }}
                                            </p>
                                        @endif
                                        @if ($photo->series_name)
                                            <p class="text-white/80 text-xs">
                                                {{ $photo->series_name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($user->cosplayerPhotos()->count() > 12)
                        <div class="mt-8 text-center">
                            <p class="text-gray-600 mb-4">
                                Mostrando {{ $photos->count() }} de {{ $user->cosplayerPhotos()->count() }} fotos
                            </p>
                            <button
                                class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium">
                                Ver todas las fotos
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @else
                {{-- Sin fotos --}}
                <div class="bg-white shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Todavía no hay fotos</h3>
                    <p class="text-gray-600">
                        Este cosplayer está preparando su galería.
                    </p>
                </div>
            @endif

            {{-- CTA Section --}}
            <div class="bg-gray-50 rounded-2xl p-8 text-center ring-1 ring-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-2">¿Buscás fotógrafos?</h3>
                <p class="text-gray-600 mb-6">Explorá fotógrafos especializados en eventos y cosplay</p>
                <a href="{{ route('fotografos.index') }}"
                    class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-medium">
                    Ver fotógrafos
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
