<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Fotos
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card de Upload Múltiple --}}
            <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Subí tus mejores fotos</h2>
                <p class="text-sm text-gray-600 mb-6">
                    Esto es tu galería personal (MVP). Después la conectamos con fotógrafos.
                </p>

                <form action="{{ route('cosplayer.fotos.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      id="uploadForm">
                    @csrf

                    {{-- FilePond multi-upload --}}
                    <div class="mb-6">
                        <input type="file" 
                               name="photos[]" 
                               id="filepond"
                               multiple 
                               accept="image/jpeg,image/png,image/jpg,image/webp">
                    </div>

                    {{-- Descripción opcional (para todas las fotos) --}}
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción (opcional)
                        </label>
                        <input type="text" 
                               name="description" 
                               id="description"
                               maxlength="120"
                               placeholder="Ej: Cosplay de Genshin Impact - Convención 2024"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">
                            Esta descripción se aplicará a todas las fotos que subas (máx. 120 caracteres)
                        </p>
                    </div>

                    {{-- Botón submit --}}
                    <button type="submit" 
                            id="submitBtn"
                            class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="submitText">Subir fotos</span>
                        <span id="submitLoading" class="hidden">Subiendo...</span>
                    </button>
                </form>
            </div>

            {{-- Galería de fotos subidas --}}
            @if ($photos->isNotEmpty())
                <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Mi Galería</h2>
                            <p class="text-sm text-gray-500 mt-1">Arrastrá las fotos para reordenar tu galería</p>
                        </div>
                        <div id="reorderStatus" class="text-sm text-green-600 font-medium hidden">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Orden guardado
                        </div>
                    </div>

                    <div id="sortableGallery" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($photos as $photo)
                            <div class="gallery-item group relative aspect-square bg-gray-100 rounded-xl overflow-hidden ring-1 ring-gray-200 cursor-grab active:cursor-grabbing"
                                 data-id="{{ $photo->id }}">
                                {{-- Skeleton placeholder --}}
                                <div class="skeleton-img absolute inset-0"></div>

                                <img src="{{ asset('storage/' . $photo->path) }}"
                                     alt="{{ $photo->caption ?? 'Foto de cosplay' }}"
                                     class="w-full h-full object-cover"
                                     onload="this.classList.add('loaded'); this.previousElementSibling.style.display='none'">

                                {{-- Ícono de drag --}}
                                <div class="absolute top-2 left-2 bg-black/50 text-white rounded-lg p-1.5 opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                    </svg>
                                </div>

                                {{-- Overlay con acciones --}}
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                    <form action="{{ route('cosplayer.fotos.destroy', $photo) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar esta foto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-700">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>

                                @if($photo->caption)
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                                        <p class="text-white text-xs">{{ $photo->caption }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    @if ($photos->hasPages())
                        <div class="mt-6">
                            {{ $photos->links() }}
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- Scripts de FilePond --}}
    @push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        .filepond--root {
            font-family: inherit;
        }
        .filepond--panel-root {
            background-color: #f9fafb;
            border: 2px dashed #e5e7eb;
            border-radius: 1rem;
        }
        .filepond--drop-label {
            color: #6b7280;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        // Registrar plugins
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );

        // Configurar FilePond
        const pond = FilePond.create(document.querySelector('#filepond'), {
            allowMultiple: true,
            maxFiles: 10,
            maxFileSize: '5MB',
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
            labelIdle: 'Arrastrá tus fotos o <span class="filepond--label-action">navegá</span>',
            labelFileProcessing: 'Subiendo',
            labelFileProcessingComplete: 'Subida completa',
            labelTapToCancel: 'click para cancelar',
            labelTapToRetry: 'click para reintentar',
            labelTapToUndo: 'click para deshacer',
            labelButtonRemoveItem: 'Eliminar',
            labelButtonAbortItemLoad: 'Cancelar',
            labelButtonRetryItemLoad: 'Reintentar',
            labelButtonAbortItemProcessing: 'Cancelar',
            labelButtonUndoItemProcessing: 'Deshacer',
            labelButtonRetryItemProcessing: 'Reintentar',
            labelButtonProcessItem: 'Subir',
            labelMaxFileSizeExceeded: 'Archivo muy grande',
            labelMaxFileSize: 'Tamaño máximo: {filesize}',
            labelFileTypeNotAllowed: 'Tipo de archivo no válido',
            fileValidateTypeLabelExpectedTypes: 'Se esperan imágenes JPG, PNG o WEBP',
        });

        // Manejar submit
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir submit normal

            const files = pond.getFiles();
            if (files.length === 0) {
                alert('Seleccioná al menos una foto');
                return;
            }

            // Mostrar loading
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitText').classList.add('hidden');
            document.getElementById('submitLoading').classList.remove('hidden');

            // Crear FormData manualmente con los archivos de FilePond
            const formData = new FormData();

            // Agregar token CSRF
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            // Agregar descripción si existe
            const description = document.getElementById('description').value;
            if (description) {
                formData.append('description', description);
            }

            // Agregar archivos de FilePond
            files.forEach((fileItem, index) => {
                formData.append('photos[]', fileItem.file);
            });

            // Enviar via fetch
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.redirected) {
                    // Si es redirect (éxito), redirigir
                    window.location.href = response.url;
                } else {
                    return response.text().then(text => {
                        throw new Error(`Error ${response.status}: ${text}`);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al subir las fotos: ' + error.message);

                // Restaurar botón
                document.getElementById('submitBtn').disabled = false;
                document.getElementById('submitText').classList.remove('hidden');
                document.getElementById('submitLoading').classList.add('hidden');
            });
        });

        // Drag & drop para reordenar fotos
        const gallery = document.getElementById('sortableGallery');
        if (gallery) {
            Sortable.create(gallery, {
                animation: 200,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function() {
                    const items = gallery.querySelectorAll('[data-id]');
                    const order = Array.from(items).map(item => parseInt(item.dataset.id));

                    const status = document.getElementById('reorderStatus');

                    fetch('{{ route("cosplayer.fotos.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && status) {
                            status.classList.remove('hidden');
                            setTimeout(() => status.classList.add('hidden'), 2000);
                        }
                    })
                    .catch(err => console.error('Error al reordenar:', err));
                }
            });
        }
    </script>
    @endpush
</x-app-layout>