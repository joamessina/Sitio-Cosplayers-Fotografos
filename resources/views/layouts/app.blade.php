<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- FOUC prevention: apply dark class before CSS loads -->
    <script>
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>

    @stack('styles')
</head>

<body class="font-sans antialiased min-h-screen flex flex-col bg-slate-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    @include('layouts.navigation')

    <!-- Page Heading -->
    <header class="bg-white dark:bg-gray-900 shadow dark:shadow-none dark:border-b dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 bg-slate-50 dark:bg-gray-950">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-4">

            {{-- Aviso de privacidad sobre fotos --}}
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

                {{-- Botón oficial de Cafecito --}}
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

    @stack('scripts')
</body>

</html>
