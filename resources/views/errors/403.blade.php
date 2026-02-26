<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sin permisos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">

                {{-- Icono --}}
                <div class="text-center mb-6">
                    <div class="mx-auto w-16 h-16 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No tenés permisos</h1>
                    <p class="text-gray-600 dark:text-gray-400">Esta sección es privada o requiere permisos especiales.</p>
                </div>

                {{-- Explicación --}}
                <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-orange-800 dark:text-orange-300 mb-2">¿Por qué veo esto?</h3>
                    <ul class="text-sm text-orange-700 dark:text-orange-300 space-y-1">
                        <li>🔐 La página es privada y necesitás iniciar sesión</li>
                        <li>👤 Tu cuenta no tiene permisos para ver esta sección</li>
                        <li>⏰ Tu sesión puede haber expirado</li>
                    </ul>
                </div>

                {{-- Acciones según el estado --}}
                @auth
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Estás logueado como {{ auth()->user()->name }}</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            Esta sección puede ser solo para {{ auth()->user()->role === 'fotografo' ? 'cosplayers' : 'fotógrafos' }} o requerir permisos específicos.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 items-center justify-center">
                        <a href="{{ auth()->user()->role === 'fotografo' ? route('fotografo.albums.index') : route('cosplayer.fotos.index') }}"
                           class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                            📁 Ir a mi panel
                        </a>
                        <a href="{{ url('/') }}"
                           class="w-full sm:w-auto bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                            🏠 Ir al inicio
                        </a>
                    </div>
                @else
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">No estás logueado</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            Necesitás iniciar sesión para acceder a esta sección.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 items-center justify-center">
                        <a href="{{ route('login') }}"
                           class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                            🔑 Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                           class="w-full sm:w-auto bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                            📝 Crear cuenta
                        </a>
                    </div>
                @endauth

                {{-- Volver atrás --}}
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                    <button onclick="window.history.back()"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 font-medium text-sm">
                        ← Volver a la página anterior
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>