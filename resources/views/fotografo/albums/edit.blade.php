<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Editar álbum
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-6 ring-1 ring-gray-200 dark:ring-gray-700">

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar información del álbum</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Actualizá la información de tu álbum.
                    </p>
                </div>

                <form method="POST" action="{{ route('fotografo.albums.update', $album) }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Título del álbum <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $album->title) }}"
                            required maxlength="255"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: Comic-Con Argentina 2024">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Evento --}}
                    <div>
                        <label for="event" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre del evento
                        </label>
                        <input type="text" name="event" id="event" value="{{ old('event', $album->event) }}"
                            maxlength="255"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
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
                            <label for="event_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fecha del evento
                            </label>
                            <input type="date" name="event_date" id="event_date"
                                value="{{ old('event_date', $album->event_date?->format('Y-m-d')) }}"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ubicación --}}
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ubicación
                            </label>
                            <input type="text" name="location" id="location"
                                value="{{ old('location', $album->location) }}" maxlength="255"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Ej: Buenos Aires, Argentina">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Descripción
                        </label>
                        <textarea name="description" id="description" rows="4" maxlength="1000"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Describe el contenido del álbum, qué tipo de fotos incluye, etc.">{{ old('description', $album->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Máximo 1000 caracteres.
                        </p>
                    </div>

                    {{-- Link de Drive --}}
                    <div>
                        <label for="drive_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Link de Google Drive
                        </label>
                        <input type="url" name="drive_url" id="drive_url"
                            value="{{ old('drive_url', $album->drive_url) }}" maxlength="500"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="https://drive.google.com/drive/folders/...">
                        @error('drive_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            URL completa de la carpeta compartida de Google Drive.
                        </p>
                    </div>

                    {{-- Miniatura del álbum --}}
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Imagen de portada (opcional)
                        </label>

                        @if ($album->thumbnail)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $album->thumbnail) }}" alt="Miniatura actual"
                                    class="w-48 h-48 object-cover rounded-xl ring-2 ring-gray-200 dark:ring-gray-700 shadow-sm">
                                <p class="text-xs text-gray-500 mt-2">Imagen actual (subí una nueva para reemplazarla)
                                </p>
                            </div>
                        @endif

                        <input type="file" name="thumbnail" id="thumbnail"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="block w-full text-sm text-gray-500
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-lg file:border-0
                  file:text-sm file:font-semibold
                  file:bg-indigo-50 file:text-indigo-700
                  hover:file:bg-indigo-100
                  transition">
                        <p class="mt-2 text-xs text-gray-500">JPG, PNG o WEBP. Máximo 2MB. Se verá en el listado
                            público.</p>
                        @error('thumbnail')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Checkbox público --}}
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_public" id="is_public" value="1"
                                {{ old('is_public', $album->is_public) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3">
                            <label for="is_public" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Hacer este álbum público
                            </label>
                            <p class="text-xs text-gray-500 mt-1">
                                Los álbumes públicos serán visibles en tu perfil y en el listado general. Los privados
                                solo vos los ves.
                            </p>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-between pt-4 border-t dark:border-gray-700">
                        <a href="{{ route('fotografo.albums.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            ← Cancelar
                        </a>

                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-700 font-medium">
                            Guardar cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
