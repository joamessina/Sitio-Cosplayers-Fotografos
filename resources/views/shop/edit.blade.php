<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('mi-shop.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                Mi Shop
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 dark:text-white font-medium truncate">Editar: {{ $shopItem->title }}</span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Errores --}}
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Editar publicación</h2>

                <form id="editForm"
                      action="{{ route('mi-shop.update', $shopItem) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Título <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $shopItem->title) }}"
                               maxlength="255"
                               required
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Descripción
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  maxlength="2000"
                                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description', $shopItem->description) }}</textarea>
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Precio (ARS) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">$</span>
                            <input type="number"
                                   name="price"
                                   id="price"
                                   value="{{ old('price', $shopItem->price) }}"
                                   min="0"
                                   step="0.01"
                                   required
                                   class="w-full pl-8 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Instagram --}}
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Instagram para contacto
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">@</span>
                            <input type="text"
                                   name="instagram"
                                   id="instagram"
                                   value="{{ old('instagram', $shopItem->instagram) }}"
                                   maxlength="100"
                                   placeholder="tu_usuario"
                                   class="w-full pl-8 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado
                        </label>
                        <select name="status"
                                id="status"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="active" {{ old('status', $shopItem->status) === 'active' ? 'selected' : '' }}>
                                Activo (visible en el shop)
                            </option>
                            <option value="sold" {{ old('status', $shopItem->status) === 'sold' ? 'selected' : '' }}>
                                Vendido (visible con badge)
                            </option>
                            <option value="inactive" {{ old('status', $shopItem->status) === 'inactive' ? 'selected' : '' }}>
                                Inactivo (no visible)
                            </option>
                        </select>
                    </div>

                    {{-- Fotos actuales --}}
                    @if ($shopItem->photos && count($shopItem->photos) > 0)
                        <div x-data="{ coverPhoto: @json($shopItem->photos[0]) }">
                            <input type="hidden" name="cover_photo" :value="coverPhoto">

                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Fotos actuales
                            </label>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                @foreach ($shopItem->photos as $photo)
                                    <div class="relative group" x-data="{ markedForDelete: false }">
                                        {{-- Marco: indigo si es portada --}}
                                        <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 transition"
                                             :class="coverPhoto === @json($photo) ? 'ring-2 ring-indigo-500' : 'ring-1 ring-gray-200 dark:ring-gray-700'">
                                            <img src="{{ storage_url($photo) }}"
                                                 alt="foto"
                                                 class="w-full h-full object-cover">
                                        </div>

                                        {{-- Overlay eliminar --}}
                                        <label class="absolute inset-0 flex items-center justify-center bg-red-600/80 rounded-xl cursor-pointer transition"
                                               :class="markedForDelete ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'">
                                            <input type="checkbox"
                                                   name="remove_photos[]"
                                                   value="{{ $photo }}"
                                                   class="sr-only"
                                                   @change="markedForDelete = $el.checked">
                                            <span class="text-white text-sm font-bold" x-show="!markedForDelete">✕ Eliminar</span>
                                            <span class="text-white text-sm font-bold" x-show="markedForDelete" x-cloak>✓ Se eliminará</span>
                                        </label>

                                        {{-- Botón portada --}}
                                        <button type="button"
                                                @click.stop="coverPhoto = @json($photo)"
                                                class="absolute bottom-2 left-2 z-10 rounded-lg px-2.5 py-1 text-xs font-bold shadow-lg transition-all"
                                                :class="coverPhoto === @json($photo) ? 'bg-indigo-600 text-white ring-2 ring-white' : 'bg-black/60 text-white hover:bg-indigo-500'">
                                            <span x-show="coverPhoto === @json($photo)">★ Portada</span>
                                            <span x-show="coverPhoto !== @json($photo)" x-cloak>Usar de portada</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg">
                                💡 <strong>Clic en una foto</strong> para eliminarla. La foto con <strong class="text-indigo-600 dark:text-indigo-400">★ Portada</strong> es la que se muestra en el listado del shop.
                            </p>
                        </div>
                    @endif

                    {{-- Agregar fotos nuevas --}}
                    @php $currentCount = count($shopItem->photos ?? []); @endphp
                    @if ($currentCount < 10)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Agregar fotos nuevas (hasta {{ 10 - $currentCount }} más)
                            </label>
                            <input type="file"
                                   name="new_photos[]"
                                   id="filepond"
                                   multiple
                                   accept="image/jpeg,image/png,image/jpg,image/webp">
                        </div>
                    @endif

                    {{-- Botones --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            Guardar cambios
                        </button>
                        <a href="{{ route('mi-shop.index') }}"
                           class="px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition text-center">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @if ($currentCount < 10)
    @push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        .filepond--panel-root {
            background-color: #f9fafb;
            border: 2px dashed #e5e7eb;
            border-radius: 1rem;
        }
        .filepond--drop-label { color: #6b7280; }
        .dark .filepond--panel-root {
            background-color: #1f2937;
            border-color: #4b5563;
        }
        .dark .filepond--drop-label { color: #9ca3af; }
        .dark .filepond--item-panel { background-color: #374151; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );

        const pond = FilePond.create(document.querySelector('#filepond'), {
            allowMultiple: true,
            maxFiles: {{ 10 - $currentCount }},
            maxFileSize: '50MB',
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
            labelIdle: 'Arrastrá fotos nuevas o <span class="filepond--label-action">navegá</span>',
            labelMaxFileSizeExceeded: 'Archivo muy grande',
            labelMaxFileSize: 'Máximo: {filesize}',
            labelFileTypeNotAllowed: 'Solo imágenes JPG, PNG o WEBP',
        });

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Agregar archivos de FilePond
            pond.getFiles().forEach(fileItem => {
                formData.append('new_photos[]', fileItem.file);
            });

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text().then(html => {
                        document.open();
                        document.write(html);
                        document.close();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar: ' + error.message);
            });
        });
    </script>
    @endpush
    @endif
</x-app-layout>
