<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('mi-shop.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                Mi Shop
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 dark:text-white font-medium">Nueva publicación</span>
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
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Publicar ítem</h2>

                <form id="shopForm"
                      action="{{ route('mi-shop.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    {{-- Título --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Título <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               maxlength="255"
                               placeholder="Ej: Espada cosplay Attack on Titan"
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
                                  placeholder="Describí el estado, medidas, materiales, etc."
                                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Máximo 2000 caracteres</p>
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
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   placeholder="0.00"
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
                                   value="{{ old('instagram') }}"
                                   maxlength="100"
                                   placeholder="tu_usuario"
                                   class="w-full pl-8 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Sin @. Solo letras, números, puntos y guiones bajos.</p>
                    </div>

                    {{-- Fotos --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fotos (hasta 10, máx. 50MB c/u)
                        </label>
                        <input type="file"
                               name="photos[]"
                               id="filepond"
                               multiple
                               accept="image/jpeg,image/png,image/jpg,image/webp">
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                id="submitBtn"
                                class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="submitText">Publicar</span>
                            <span id="submitLoading" class="hidden">Publicando...</span>
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
            maxFiles: 10,
            maxFileSize: '50MB',
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
            labelIdle: 'Arrastrá fotos o <span class="filepond--label-action">navegá</span>',
            labelMaxFileSizeExceeded: 'Archivo muy grande',
            labelMaxFileSize: 'Máximo: {filesize}',
            labelFileTypeNotAllowed: 'Solo imágenes JPG, PNG o WEBP',
            fileValidateTypeLabelExpectedTypes: 'JPG, PNG o WEBP',
        });

        document.getElementById('shopForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            document.getElementById('submitText').classList.add('hidden');
            document.getElementById('submitLoading').classList.remove('hidden');

            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            const fields = ['title', 'description', 'price', 'instagram'];
            fields.forEach(field => {
                const el = document.getElementById(field);
                if (el && el.value) formData.append(field, el.value);
            });

            pond.getFiles().forEach(fileItem => {
                formData.append('photos[]', fileItem.file);
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
                        // Extraer errores del HTML de respuesta
                        document.open();
                        document.write(html);
                        document.close();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al publicar: ' + error.message);
                submitBtn.disabled = false;
                document.getElementById('submitText').classList.remove('hidden');
                document.getElementById('submitLoading').classList.add('hidden');
            });
        });
    </script>
    @endpush
</x-app-layout>
