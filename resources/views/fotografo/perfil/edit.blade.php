<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar mi perfil
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl p-6 ring-1 ring-gray-200">

                @if (session('status'))
                    <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-green-800 ring-1 ring-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Información pública</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Esta información será visible para todos los usuarios que visiten tu perfil.
                    </p>
                </div>

                <form method="POST" action="{{ route('fotografo.perfil.update') }}" class="space-y-6">
                    @csrf

                    {{-- Nombre a mostrar --}}
                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre a mostrar <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="display_name" id="display_name"
                            value="{{ old('display_name', $profile->display_name) }}" required maxlength="255"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: Juan Pérez Photography">
                        @error('display_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Este es el nombre que verán los demás usuarios.
                        </p>
                    </div>

                    {{-- Biografía --}}
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Biografía
                        </label>
                        <textarea name="bio" id="bio" rows="4" maxlength="500"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Contá un poco sobre vos, tu experiencia como fotógrafo, qué tipo de eventos cubrís...">{{ old('bio', $profile->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Máximo 500 caracteres.
                        </p>
                    </div>

                    {{-- Instagram --}}
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">
                            Instagram
                        </label>
                        <div class="flex rounded-lg shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                @
                            </span>
                            <input type="text" name="instagram" id="instagram"
                                value="{{ old('instagram', $profile->instagram) }}" maxlength="100"
                                class="flex-1 rounded-none rounded-r-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="tu_usuario">
                        </div>
                        @error('instagram')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Solo el nombre de usuario, sin el @.
                        </p>
                    </div>

                    {{-- Portfolio URL --}}
                    <div>
                        <label for="portfolio_url" class="block text-sm font-medium text-gray-700 mb-2">
                            Portfolio / Sitio web
                        </label>
                        <input type="url" name="portfolio_url" id="portfolio_url"
                            value="{{ old('portfolio_url', $profile->portfolio_url) }}" maxlength="255"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="https://tu-portfolio.com">
                        @error('portfolio_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Link a tu portfolio, página web o redes sociales principales.
                        </p>
                    </div>

                    {{-- Ubicación --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Ubicación
                        </label>
                        <input type="text" name="location" id="location"
                            value="{{ old('location', $profile->location) }}" maxlength="255"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: Buenos Aires, Argentina">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Ciudad y país donde trabajás principalmente.
                        </p>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-between pt-4 border-t">
                        <a href="{{ route('fotografo.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            ← Volver al dashboard
                        </a>

                        <div class="flex gap-3">
                            <a href="{{ route('fotografos.show', auth()->user()) }}" target="_blank"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Ver perfil público
                            </a>

                            <button type="submit"
                                class="rounded-lg bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-700 font-medium">
                                Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
