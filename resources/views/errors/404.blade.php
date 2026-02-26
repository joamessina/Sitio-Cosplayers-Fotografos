<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Página no encontrada
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">

                {{-- Icono --}}
                <div class="text-center mb-6">
                    <div class="mx-auto w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m6-12H3.828C2.818 4 2 4.818 2 5.828V10a4 4 0 004 4h12a4 4 0 004-4V5.828C22 4.818 21.182 4 20.172 4z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Esta página no existe</h1>
                    <p class="text-gray-600 dark:text-gray-400">La página que buscás no se encuentra disponible.</p>
                </div>

                {{-- Posibles causas --}}
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">¿Qué pudo haber pasado?</h3>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>🔗 El enlace puede estar mal escrito o desactualizado</li>
                        <li>📱 La página pudo haber sido movida o eliminada</li>
                        <li>⌨️ Puede haber un error de tipeo en la URL</li>
                    </ul>
                </div>

                {{-- Enlaces útiles --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <a href="{{ route('welcome') }}"
                       class="bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-lg flex items-center justify-center mr-3">
                                🏠
                            </div>
                            <div>
                                <h4 class="font-semibold text-indigo-900 dark:text-indigo-200">Página principal</h4>
                                <p class="text-xs text-indigo-700 dark:text-indigo-300">Volver al inicio</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('albumes') }}"
                       class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                📸
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-900 dark:text-blue-200">Álbumes</h4>
                                <p class="text-xs text-blue-700 dark:text-blue-300">Ver álbumes de fotos</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('fotografos') }}"
                       class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4 hover:bg-green-100 dark:hover:bg-green-900/50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center mr-3">
                                👥
                            </div>
                            <div>
                                <h4 class="font-semibold text-green-900 dark:text-green-200">Fotógrafos</h4>
                                <p class="text-xs text-green-700 dark:text-green-300">Ver fotógrafos</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('shop') }}"
                       class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 hover:bg-yellow-100 dark:hover:bg-yellow-900/50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-800 rounded-lg flex items-center justify-center mr-3">
                                🛍️
                            </div>
                            <div>
                                <h4 class="font-semibold text-yellow-900 dark:text-yellow-200">Shop</h4>
                                <p class="text-xs text-yellow-700 dark:text-yellow-300">Productos en venta</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Botón principal --}}
                <div class="text-center">
                    <button onclick="window.history.back()"
                            class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-6 rounded-lg transition-colors mr-3">
                        ← Volver atrás
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>