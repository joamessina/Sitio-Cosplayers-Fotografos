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

    </head>
    <body>
        <div class="font-sans text-gray-900 dark:text-gray-100 antialiased min-h-screen flex flex-col bg-gray-100 dark:bg-gray-950">
            <div class="flex-1">
                {{ $slot }}
            </div>

            {{-- Footer legal --}}
            <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            © {{ date('Y') }} Joaquín Messina. Todos los derechos reservados.
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                            Este sitio y todo su contenido están protegidos por derechos de autor.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
