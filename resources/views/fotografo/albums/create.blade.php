<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear álbum
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl p-6 ring-1 ring-gray-200">

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Información del álbum</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Completá la información de tu álbum para compartirlo con cosplayers.
                    </p>
                </div>

                <form method="POST" action="{{ route('fotografo.albums.store') }}" class="space-y-6">
                    @csrf

                    {{-- Título --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título del álbum <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            maxlength="255"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: Comic-Con Argentina 2024">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Evento --}}
                    <div>
                        <label for="event" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del evento
                        </label>
                        <input type="text" name="event" id="event" value="{{ old('event') }}" maxlength="255"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: Comic-Con Argentina">
                        @error('event')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            El nombre del evento o convención.
                        </p>
                    </div>

                    {{-- Fecha y ubicación en grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Fecha del evento --}}
                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha del evento
                            </label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ubicación --}}
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                Ubicación
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                maxlength="255"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Ej: Buenos Aires, Argentina">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea name="description" id="description" rows="4" maxlength="1000"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Describe el contenido del álbum, qué tipo de fotos incluye, etc.">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Máximo 1000 caracteres.
                        </p>
                    </div>

                    {{-- Link de Drive --}}
                    <div>
                        <label for="drive_url" class="block text-sm font-medium text-gray-700 mb-2">
                            Link de Google Drive
                        </label>
                        <input type="url" name="drive_url" id="drive_url" value="{{ old('drive_url') }}"
                            maxlength="500"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="https://drive.google.com/drive/folders/...">
                        @error('drive_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            URL completa de la carpeta compartida de Google Drive.
                        </p>
                    </div>

                    {{-- Checkbox público --}}
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_public" id="is_public" value="1"
                                {{ old('is_public') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3">
                            <label for="is_public" class="text-sm font-medium text-gray-700">
                                Hacer este álbum público
                            </label>
                            <p class="text-xs text-gray-500 mt-1">
                                Los álbumes públicos serán visibles en tu perfil y en el listado general. Los privados
                                solo vos los ves.
                            </p>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-between pt-4 border-t">
                        <a href="{{ route('fotografo.albums.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900">
                            ← Cancelar
                        </a>

                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-700 font-medium">
                            Crear álbum
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
