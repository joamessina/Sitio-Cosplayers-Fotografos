<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('fotografos.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-900">
                Portfolio de {{ $user->photographerProfile->display_name ?? $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Hero Section --}}
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl p-8 md:p-12 text-white shadow-xl">
                <div class="flex flex-col md:flex-row items-center gap-8">

                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        <div
                            class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white/30">
                            <span class="text-5xl font-bold text-white">
                                {{ strtoupper(substr($user->photographerProfile->display_name ?? $user->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-4xl font-bold mb-2">
                            {{ $user->photographerProfile->display_name ?? $user->name }}
                        </h1>

                        @if ($user->photographerProfile && $user->photographerProfile->location)
                            <p class="text-white/90 flex items-center justify-center md:justify-start gap-2 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <p class="text-lg text-white/95 leading-relaxed max-w-2xl mb-6">
                                {{ $user->photographerProfile->bio }}
                            </p>
                        @endif

                        {{-- Social Links --}}
                        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                            @if ($user->photographerProfile && $user->photographerProfile->instagram)
                                <a href="https://instagram.com/{{ $user->photographerProfile->instagram }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                    @{{ $user - > photographerProfile - > instagram }}
                                </a>
                            @endif

                            @if ($user->photographerProfile && $user->photographerProfile->portfolio_url)
                                <a href="{{ $user->photographerProfile->portfolio_url }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                        </path>
                                    </svg>
                                    Sitio Web
                                </a>
                            @endif

                            <a href="{{ route('fotografos.show', $user) }}"
                                class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Perfil Completo
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Álbumes Destacados --}}
            @if ($albums->isNotEmpty())
                <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Álbumes Destacados</h2>
                            <p class="text-gray-600 mt-1">Explorá el trabajo reciente</p>
                        </div>

                        <a href="{{ route('fotografos.show', $user) }}"
                            class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium">
                            Ver todos
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($albums as $album)
                            <a href="{{ route('albumes.show', $album) }}"
                                class="group bg-white rounded-xl shadow-sm ring-1 ring-gray-200 overflow-hidden hover:shadow-lg hover:ring-indigo-300 transition">

                                {{-- Placeholder de imagen --}}
                                <div
                                    class="aspect-video bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>

                                <div class="p-5">
                                    <h3
                                        class="font-semibold text-gray-900 group-hover:text-indigo-600 mb-2 line-clamp-1">
                                        {{ $album->title }}
                                    </h3>

                                    @if ($album->event)
                                        <p class="text-sm text-gray-600 mb-2">
                                            📸 {{ $album->event }}
                                        </p>
                                    @endif

                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                        @if ($album->event_date)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
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
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                </svg>
                                                {{ Str::limit($album->location, 20) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Sin álbumes --}}
                <div class="bg-white shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Todavía no hay álbumes públicos</h3>
                    <p class="text-gray-600">
                        Este fotógrafo está preparando su portfolio.
                    </p>
                </div>
            @endif

            {{-- CTA Section --}}
            <div class="bg-gray-50 rounded-2xl p-8 text-center ring-1 ring-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-2">¿Te gusta este portfolio?</h3>
                <p class="text-gray-600 mb-6">Explorá más fotógrafos y sus trabajos</p>
                <a href="{{ route('fotografos.index') }}"
                    class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-medium">
                    Ver todos los fotógrafos
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
