<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CosplayAR — Fotógrafos y Cosplayers de Argentina</title>

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

    {{-- Navbar --}}
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600 dark:text-gray-400" />
                        <span class="text-xl font-bold text-gray-900 dark:text-white">CosplayAR</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('fotografos.index') }}" class="hidden sm:block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                        Fotógrafos
                    </a>
                    <a href="{{ route('albumes.index') }}" class="hidden sm:block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                        Álbumes
                    </a>
                    <a href="{{ route('shop.index') }}" class="hidden sm:block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                        Shop
                    </a>

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
                        aria-label="Cambiar tema"
                    >
                        <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Mi panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Registrarse gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 opacity-10 dark:opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
            <div class="text-center">
                <span class="inline-block bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                    🇦🇷 La comunidad cosplay argentina
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Tu portfolio de <span class="text-indigo-600">cosplay</span><br>en un solo lugar
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-300">
                    Fotógrafos y cosplayers: mostrá tu trabajo, conectá con la comunidad y vendé tus props. Todo gratis.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                    @guest
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white text-lg font-semibold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 dark:shadow-none">
                            Creá tu portfolio gratis
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @endguest
                    <a href="{{ route('albumes.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-lg font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Explorar álbumes
                    </a>
                </div>

                {{-- Stats --}}
                <div class="mt-16 grid grid-cols-3 gap-8 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-indigo-600">{{ $totalFotografos }}</div>
                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">Fotógrafos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-pink-600">{{ $totalCosplayers }}</div>
                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">Cosplayers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-purple-600">{{ $totalAlbums }}</div>
                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">Álbumes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Para quién es --}}
    <div class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">¿Sos fotógrafo o cosplayer?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">La plataforma está diseñada para los dos</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Fotógrafo --}}
                <div class="bg-indigo-50 dark:bg-gray-800 rounded-2xl p-8 ring-1 ring-indigo-200 dark:ring-indigo-700">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/60 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Para fotógrafos</h3>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-500 font-bold mt-0.5">✓</span>
                            Portfolio público con URL propia (<span class="font-mono text-sm">/@tu-usuario</span>)
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-500 font-bold mt-0.5">✓</span>
                            Álbumes organizados por evento y fecha
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-500 font-bold mt-0.5">✓</span>
                            Los cosplayers te contactan directo desde tu perfil
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-500 font-bold mt-0.5">✓</span>
                            Vendé prints y servicios desde el shop
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-6 inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-semibold hover:opacity-80">
                        Registrarme como fotógrafo
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                {{-- Cosplayer --}}
                <div class="bg-pink-50 dark:bg-gray-800 rounded-2xl p-8 ring-1 ring-pink-200 dark:ring-pink-700">
                    <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/60 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Para cosplayers</h3>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold mt-0.5">✓</span>
                            Galería personal con tus mejores fotos
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold mt-0.5">✓</span>
                            Portfolio público para mostrar tus cosplays
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold mt-0.5">✓</span>
                            Guardá y organizá álbumes de fotógrafos favoritos
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold mt-0.5">✓</span>
                            Vendé props, ropa y accesorios en el shop
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-6 inline-flex items-center gap-2 text-pink-600 dark:text-pink-400 font-semibold hover:opacity-80">
                        Registrarme como cosplayer
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Últimos Álbumes --}}
    @if ($latestAlbums->isNotEmpty())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Últimos álbumes</h2>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Los eventos más recientes de la comunidad</p>
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
                        <div class="aspect-video bg-gradient-to-br from-indigo-100 dark:from-indigo-900/30 to-purple-100 dark:to-purple-900/30 flex items-center justify-center overflow-hidden">
                            @if ($album->thumbnail)
                                <img src="{{ storage_url($album->thumbnail) }}" alt="{{ $album->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-indigo-300 dark:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 mb-1 line-clamp-1">
                                {{ $album->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                Por {{ $album->user->photographerProfile->display_name ?? $album->user->name }}
                            </p>
                            @if ($album->event)
                                <p class="text-sm text-gray-600 dark:text-gray-400">📸 {{ $album->event }}</p>
                            @endif
                            <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500 mt-2">
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

    {{-- CTA final --}}
    @guest
        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 py-16">
            <div class="max-w-2xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">¿Listo para empezar?</h2>
                <p class="text-indigo-100 text-lg mb-8">
                    Registrate gratis y tené tu portfolio online en minutos.
                </p>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-600 text-lg font-bold rounded-xl hover:bg-indigo-50 transition shadow-lg">
                    Crear mi cuenta gratis
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    @endguest

    {{-- Footer --}}
    <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-4">
            <div class="border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 bg-white dark:bg-gray-800/50">
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    <span class="font-semibold text-gray-600 dark:text-gray-300">Privacidad del contenido:</span>
                    Las fotos e imágenes subidas a este sitio son de uso exclusivo dentro de la plataforma para exhibición de portfolios y publicaciones de shop.
                    No serán compartidas, vendidas ni utilizadas con fines comerciales ajenos al sitio.
                    Si querés dar de baja tu cuenta o solicitar la eliminación de tu contenido, escribinos a
                    <a href="mailto:{{ config('mail.from.address') }}" class="underline hover:text-gray-700 dark:hover:text-gray-200">{{ config('mail.from.address') }}</a>
                    y procesaremos tu solicitud dentro de los <span class="font-medium">7 días hábiles</span>.
                </p>
            </div>
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
