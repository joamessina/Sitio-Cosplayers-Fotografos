<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Error del servidor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">

                {{-- Icono --}}
                <div class="text-center mb-6">
                    <div class="mx-auto w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">¡Ups! Algo salió mal</h1>
                    <p class="text-gray-600 dark:text-gray-400">Tuvimos un problemita técnico de nuestro lado.</p>
                </div>

                {{-- Mensaje principal --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Tranqui, no fue tu culpa</h3>
                    <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                        <li>✅ <strong>No hiciste nada mal</strong> - es un problema técnico nuestro</li>
                        <li>🔧 Nuestro equipo ya fue notificado del error</li>
                        <li>⚡ Generalmente se soluciona solo en unos minutos</li>
                    </ul>
                </div>

                {{-- Qué hacer --}}
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">¿Qué podés hacer?</h3>
                    <ol class="text-sm text-gray-600 dark:text-gray-400 space-y-1 list-decimal list-inside">
                        <li><strong>Recargá la página</strong> - muchas veces se arregla así</li>
                        <li><strong>Esperá unos minutos</strong> y volvé a intentar</li>
                        <li>Si persiste, probá <strong>ir al inicio</strong> y navegar desde ahí</li>
                    </ol>
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row gap-3 items-center justify-center">
                    <button onclick="location.reload()"
                            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        🔄 Intentar de nuevo
                    </button>
                    <a href="{{ url('/') }}"
                       class="w-full sm:w-auto text-center bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-6 rounded-lg transition-colors">
                        🏠 Ir al inicio
                    </a>
                </div>

                {{-- Contacto --}}
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        ¿El problema persiste después de varios intentos?
                    </p>
                    <a href="{{ route('contact') }}"
                       class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium text-sm">
                        📧 Contanos qué pasó
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>