<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Feedback</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Contanos qué pensás, reportá un bug o mandanos una idea</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash success --}}
            @if (session('status'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-4 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errores --}}
            @if ($errors->has('rate_limit'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl text-sm">
                    {{ $errors->first('rate_limit') }}
                </div>
            @endif

            @if ($errors->any() && !$errors->has('rate_limit'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Mandanos tu opinión</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tu feedback nos ayuda a mejorar la plataforma</p>
                    </div>
                </div>

                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', auth()->user()?->name) }}"
                               maxlength="100"
                               required
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', auth()->user()?->email) }}"
                               maxlength="150"
                               required
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tipo <span class="text-red-500">*</span>
                        </label>
                        <select name="type"
                                id="type"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="suggestion" {{ old('type') === 'suggestion' ? 'selected' : '' }}>💡 Sugerencia</option>
                            <option value="bug"        {{ old('type') === 'bug'        ? 'selected' : '' }}>🐛 Bug / Problema</option>
                            <option value="other"      {{ old('type') === 'other'      ? 'selected' : '' }}>💬 Otro</option>
                        </select>
                    </div>

                    {{-- Mensaje --}}
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mensaje <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message"
                                  id="message"
                                  rows="5"
                                  maxlength="2000"
                                  required
                                  placeholder="Contanos con detalle..."
                                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('message') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Mínimo 10 caracteres, máximo 2000</p>
                    </div>

                    <button type="submit"
                            class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Enviar feedback
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
