<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>

    @stack('styles')
</head>

<body class="font-sans antialiased min-h-screen flex flex-col">

    @include('layouts.navigation')

    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 bg-slate-50">
        {{ $slot }}
    </main>

    {{-- Footer con Cafecito --}}
    {{-- Footer con Cafecito --}}
    <footer class="bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-left">
                    <p class="text-sm text-gray-600">
                        © {{ date('Y') }} Joaquín Messina. Todos los derechos reservados.
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Este sitio y todo su contenido están protegidos por derechos de autor.
                    </p>
                </div>

                {{-- Botón oficial de Cafecito --}}
                <div class="flex items-center gap-3">
                    <p class="text-sm text-gray-600">¿Te gusta el proyecto?</p>
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
