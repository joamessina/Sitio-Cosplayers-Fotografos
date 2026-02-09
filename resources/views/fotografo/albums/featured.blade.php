<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('fotografo.albums.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Fotos Destacadas</h2>
                <p class="text-sm text-gray-600">{{ $album->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="alert-success mb-6">
                    <div class="alert-success-content">
                        <svg class="alert-success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="alert-success-text">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Configurar fotos destacadas</h3>
                    <p class="text-gray-600">
                        Agregá hasta 5 URLs de fotos que se mostrarán destacadas en tu álbum público.
                        Estas fotos aparecerán en un carousel especial.
                    </p>
                </div>

                <form action="{{ route('fotografo.albums.featured.update', $album) }}" method="POST" class="space-y-4">
                    @csrf

                    <div x-data="{
                        urls: {{ json_encode(array_pad($album->featured_photo_urls ?? [], 5, '')) }},
                        addUrl() {
                            if (this.urls.filter(url => url.trim()).length < 5) {
                                const emptyIndex = this.urls.findIndex(url => !url.trim());
                                if (emptyIndex !== -1) {
                                    this.urls[emptyIndex] = '';
                                }
                            }
                        },
                        removeUrl(index) {
                            this.urls[index] = '';
                        },
                        getActiveCount() {
                            return this.urls.filter(url => url.trim()).length;
                        }
                    }">

                        <div class="grid grid-cols-1 gap-4">
                            <template x-for="(url, index) in urls" :key="index">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Foto destacada <span x-text="index + 1"></span>
                                        </label>
                                        <input type="url"
                                            x-model="urls[index]"
                                            :name="'featured_urls[' + index + ']'"
                                            placeholder="https://ejemplo.com/foto.jpg"
                                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <button type="button"
                                        @click="removeUrl(index)"
                                        x-show="url.trim()"
                                        class="mt-6 p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition"
                                        title="Eliminar foto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t">
                            <p class="text-sm text-gray-600" x-text="getActiveCount() + ' de 5 fotos agregadas'"></p>
                        </div>

                        @error('featured_urls')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror

                        @if ($errors->has('featured_urls.*'))
                            <div class="space-y-1 mt-2">
                                @foreach ($errors->get('featured_urls.*') as $error)
                                    <p class="text-red-600 text-sm">{{ $error[0] }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Preview --}}
                    @if($album->featured_photo_urls && count($album->featured_photo_urls) > 0)
                        <div class="mt-8 p-6 bg-gray-50 rounded-xl">
                            <h4 class="font-medium text-gray-900 mb-4">Fotos destacadas actuales:</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                @foreach($album->featured_photo_urls as $index => $url)
                                    <div class="aspect-square rounded-lg bg-gray-200 overflow-hidden">
                                        <img src="{{ $url }}"
                                            alt="Foto destacada {{ $index + 1 }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden w-full h-full items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Botones --}}
                    <div class="flex items-center gap-4 pt-6">
                        <a href="{{ route('fotografo.albums.index') }}" class="btn-back">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver a álbumes
                        </a>

                        <button type="submit" class="btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Guardar fotos destacadas
                        </button>

                        <a href="{{ route('albumes.show', $album) }}" target="_blank" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Ver álbum público
                        </a>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>