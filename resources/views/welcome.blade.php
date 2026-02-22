<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sitio Fotógrafos & Cosplayers</title>

    <!-- FOUC prevention: apply dark class before CSS loads -->
    <script>
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="antialiased bg-slate-50 dark:bg-gray-950">

    {{-- Navbar simple --}}
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600 dark:text-gray-400" />
                        <span class="text-xl font-bold text-gray-900 dark:text-white">Fotógrafos & Cosplayers</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('fotografos.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                        Fotógrafos
                    </a>
                    <a href="{{ route('albumes.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                        Álbumes
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Registrarse
                        </a>
                    @endauth

                    <!-- Dark Mode Toggle -->
                    <button
                        x-data="{
                            dark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                            toggle() {
                                this.dark = !this.dark;
                                localStorage.theme = this.dark ? 'dark' : 'light';
                                document.documentElement.classList.toggle('dark', this.dark);
                            }
                        }"
                        @click="toggle()"
                        class="p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                        title="Cambiar tema"
                        aria-label="Cambiar tema"
                    >
                        <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 opacity-10 dark:opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Conectamos <span class="text-indigo-600">Fotógrafos</span> y <span
                        class="text-pink-600">Cosplayers</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-300">
                    La plataforma para compartir, descubrir y preservar los mejores momentos de eventos y convenciones.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('albumes.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white text-lg font-semibold rounded-lg hover:bg-indigo-700 transition shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Explorar Álbumes
                    </a>
                    <a href="{{ route('fotografos.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-lg font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Ver Fotógrafos
                    </a>
                </div>

                {{-- Stats --}}
                <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-3xl mx-auto">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-indigo-600">{{ $totalFotografos }}</div>
                        <div class="mt-2 text-gray-600 dark:text-gray-400">Fotógrafos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-purple-600">{{ $totalAlbums }}</div>
                        <div class="mt-2 text-gray-600 dark:text-gray-400">Álbumes Públicos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-pink-600">∞</div>
                        <div class="mt-2 text-gray-600 dark:text-gray-400">Recuerdos</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Últimos Álbumes --}}
    @if ($latestAlbums->isNotEmpty())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Últimos Álbumes</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Descubrí los eventos más recientes</p>
                </div>
                <a href="{{ route('albumes.index') }}"
                    class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium">
                    Ver todos
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($latestAlbums as $album)
                    <a href="{{ route('albumes.show', $album) }}"
                        class="group bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden hover:shadow-lg hover:ring-indigo-300 transition">

                        {{-- Placeholder de imagen --}}
                        <div
                            class="aspect-video bg-gradient-to-br from-indigo-100 dark:from-indigo-900/30 to-purple-100 dark:to-purple-900/30 flex items-center justify-center overflow-hidden">
                            @if ($album->thumbnail)
                                <img src="{{ asset('storage/' . $album->thumbnail) }}" alt="{{ $album->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-indigo-300 dark:text-indigo-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 mb-2 line-clamp-1">
                                {{ $album->title }}
                            </h3>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                Por {{ $album->user->photographerProfile->display_name ?? $album->user->name }}
                            </p>

                            @if ($album->event)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    📸 {{ $album->event }}
                                </p>
                            @endif

                            <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-500 mt-3">
                                @if ($album->event_date)
                                    <span>{{ \Carbon\Carbon::parse($album->event_date)->format('d/m/Y') }}</span>
                                @endif
                                @if ($album->location)
                                    <span>📍 {{ Str::limit($album->location, 20) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Cómo Funciona --}}
    <div class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">¿Cómo Funciona?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Simple, rápido y gratis</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/40 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">1. Registrate</h3>
                    <p class="text-gray-600 dark:text-gray-400">Creá tu cuenta como fotógrafo o cosplayer en segundos</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/40 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">2. Subí Álbumes</h3>
                    <p class="text-gray-600 dark:text-gray-400">Compartí tus fotos usando Google Drive</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-pink-100 dark:bg-pink-900/40 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">3. Compartí</h3>
                    <p class="text-gray-600 dark:text-gray-400">Tu portfolio personalizado en una URL única</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer con Cafecito --}}
    <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-left">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        © {{ date('Y') }} Joaquín Messina. Todos los derechos reservados.
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        Este sitio y todo su contenido están protegidos por derechos de autor.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">¿Te gusta el proyecto?</p>
                    <a href='https://cafecito.app/joamessina' rel='noopener' target='_blank'>
                        <img srcset='https://cdn.cafecito.app/imgs/buttons/button_2.png 1x, https://cdn.cafecito.app/imgs/buttons/button_2_2x.png 2x, https://cdn.cafecito.app/imgs/buttons/button_2_3.75x.png 3.75x'
                            src='https://cdn.cafecito.app/imgs/buttons/button_2.png'
                            alt='Invitame un café en cafecito.app' />
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
