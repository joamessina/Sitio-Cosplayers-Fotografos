<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sesión expirada
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">

                {{-- Icono --}}
                <div class="text-center mb-6">
                    <div class="mx-auto w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Tu sesión se venció</h1>
                    <p class="text-gray-600 dark:text-gray-400">Esto pasa por seguridad después de un tiempo sin actividad.</p>
                </div>

                {{-- Mensaje principal --}}
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-yellow-800 dark:text-yellow-300 mb-2">¿Qué significa esto?</h3>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                        No te preocupes, <strong>no hiciste nada mal</strong>. Por seguridad, las sesiones expiran automáticamente.
                        Solo necesitás recargar la página para continuar.
                    </p>
                </div>

                {{-- Auto-refresh countdown --}}
                <div id="autoRefresh" class="text-center mb-6 hidden">
                    <p class="text-gray-600 dark:text-gray-400">
                        Recargando automáticamente en <span id="countdown" class="font-bold text-indigo-600 dark:text-indigo-400">5</span> segundos...
                    </p>
                    <button onclick="cancelAutoRefresh()" class="mt-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline">
                        Cancelar
                    </button>
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row gap-3 items-center justify-center">
                    <button onclick="location.reload()"
                            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        🔄 Recargar página
                    </button>
                    <a href="{{ url('/') }}"
                       class="w-full sm:w-auto text-center bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-6 rounded-lg transition-colors">
                        🏠 Ir al inicio
                    </a>
                </div>

                {{-- Activar auto-refresh --}}
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button onclick="startAutoRefresh()"
                            id="enableAutoRefresh"
                            class="w-full text-center text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                        ⚡ Activar recarga automática (5 seg)
                    </button>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let countdownInterval;
        let isAutoRefreshActive = false;

        function startAutoRefresh() {
            if (isAutoRefreshActive) return;

            isAutoRefreshActive = true;
            document.getElementById('enableAutoRefresh').classList.add('hidden');
            document.getElementById('autoRefresh').classList.remove('hidden');

            let seconds = 5;
            const countdownElement = document.getElementById('countdown');

            countdownInterval = setInterval(() => {
                seconds--;
                countdownElement.textContent = seconds;

                if (seconds <= 0) {
                    location.reload();
                }
            }, 1000);
        }

        function cancelAutoRefresh() {
            isAutoRefreshActive = false;
            clearInterval(countdownInterval);
            document.getElementById('autoRefresh').classList.add('hidden');
            document.getElementById('enableAutoRefresh').classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>