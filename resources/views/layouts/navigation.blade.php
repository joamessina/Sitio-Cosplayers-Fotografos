<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600 dark:text-gray-400" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        {{-- Sección EXPLORAR (público) --}}
                        <x-nav-link :href="route('fotografos.index')" :active="request()->routeIs('fotografos.*') && !request()->routeIs('fotografo.*')">
                            Fotógrafos
                        </x-nav-link>

                        <x-nav-link :href="route('albumes.index')" :active="request()->routeIs('albumes.*')">
                            Álbumes
                        </x-nav-link>

                        <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*') && !request()->routeIs('mi-shop.*')">
                            Shop
                        </x-nav-link>

                        {{-- Sección MI CUENTA (privado) - Dropdown --}}
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-900 hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none transition ease-in-out duration-150">
                                        <div>Mi Cuenta</div>
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    @if (auth()->user()->role === 'fotografo')
                                        <x-dropdown-link :href="route('fotografo.dashboard')">
                                            📊 Panel
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('fotografo.albums.index')">
                                            📁 Mis álbumes
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('fotografo.perfil.edit')">
                                            👤 Mi perfil
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('mi-shop.index')">
                                            🛍️ Mi Shop
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('feedback.create')">
                                            💬 Feedback
                                        </x-dropdown-link>
                                    @else
                                        <x-dropdown-link :href="route('cosplayer.dashboard')">
                                            📊 Panel
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('cosplayer.fotos.index')">
                                            📸 Mis fotos
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('cosplayer.perfil.edit')">
                                            👤 Mi perfil
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('mi-shop.index')">
                                            🛍️ Mi Shop
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('feedback.create')">
                                            💬 Feedback
                                        </x-dropdown-link>
                                    @endif
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @else
                    {{-- Links para usuarios no logueados --}}
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('fotografos.index')" :active="request()->routeIs('fotografos.*')">
                            Fotógrafos
                        </x-nav-link>

                        <x-nav-link :href="route('albumes.index')" :active="request()->routeIs('albumes.*')">
                            Álbumes
                        </x-nav-link>

                        <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                            Shop
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            <!-- Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6 gap-3">
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

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                {{-- Botones login/register para usuarios no logueados --}}
                <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
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

                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        Registrarse
                    </a>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden gap-1">
                <!-- Dark Mode Toggle (móvil) -->
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

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        @auth
            {{-- Sección EXPLORAR (móvil) --}}
            <div class="pt-2 pb-3 space-y-1 border-b border-gray-200 dark:border-gray-700">
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Explorar
                </div>
                <x-responsive-nav-link :href="route('fotografos.index')" :active="request()->routeIs('fotografos.*') && !request()->routeIs('fotografo.*')">
                    Fotógrafos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('albumes.index')" :active="request()->routeIs('albumes.*')">
                    Álbumes
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*') && !request()->routeIs('mi-shop.*')">
                    Shop
                </x-responsive-nav-link>
            </div>

            {{-- Sección MI CUENTA (móvil) --}}
            <div class="pt-2 pb-3 space-y-1 border-b border-gray-200 dark:border-gray-700">
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Mi Cuenta
                </div>
                @if (auth()->user()->role === 'fotografo')
                    <x-responsive-nav-link :href="route('fotografo.dashboard')" :active="request()->routeIs('fotografo.dashboard')">
                        📊 Panel
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('fotografo.albums.index')" :active="request()->routeIs('fotografo.albums.*')">
                        📁 Mis álbumes
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('fotografo.perfil.edit')" :active="request()->routeIs('fotografo.perfil.*')">
                        👤 Mi perfil
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('mi-shop.index')" :active="request()->routeIs('mi-shop.*')">
                        🛍️ Mi Shop
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('feedback.create')" :active="request()->routeIs('feedback.*')">
                        💬 Feedback
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('cosplayer.dashboard')" :active="request()->routeIs('cosplayer.dashboard')">
                        📊 Panel
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('cosplayer.fotos.index')" :active="request()->routeIs('cosplayer.fotos.*')">
                        📸 Mis fotos
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('cosplayer.perfil.edit')" :active="request()->routeIs('cosplayer.perfil.*')">
                        👤 Mi perfil
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('mi-shop.index')" :active="request()->routeIs('mi-shop.*')">
                        🛍️ Mi Shop
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('feedback.create')" :active="request()->routeIs('feedback.*')">
                        💬 Feedback
                    </x-responsive-nav-link>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            {{-- Menu móvil para usuarios no logueados --}}
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('fotografos.index')" :active="request()->routeIs('fotografos.*')">
                    Fotógrafos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('albumes.index')" :active="request()->routeIs('albumes.*')">
                    Álbumes
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                    Shop
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('login')">
                    Iniciar sesión
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('register')">
                    Registrarse
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
