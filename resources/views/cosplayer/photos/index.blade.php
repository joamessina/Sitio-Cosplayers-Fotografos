<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis fotos
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl p-6 ring-1 ring-gray-200">
                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-green-800 ring-1 ring-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Subí tus mejores fotos
                        </h3>
                        <p class="text-sm text-gray-600">
                            Esto es tu galería personal (MVP). Después la
                            conectamos con fotógrafos.
                        </p>
                    </div>

                    <form action="{{ route('cosplayer.photos.store') }}" method="POST" enctype="multipart/form-data"
                        class="flex flex-col sm:flex-row sm:items-end gap-3">
                        @csrf

                        <div class="space-y-2">
                            <input type="file" name="photo" accept="image/*" required
                                class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white file:text-sm file:font-medium hover:file:bg-indigo-700" />

                            @error('photo')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div id="photoPreview" class="hidden items-center gap-3">
                                <img id="photoPreviewImg"
                                    class="h-12 w-12 rounded-lg object-cover ring-1 ring-gray-200" />
                                <div class="text-sm">
                                    <p id="photoPreviewName" class="font-medium text-gray-800"></p>
                                    <p id="photoPreviewMeta" class="text-gray-500"></p>
                                </div>
                                <button type="button" id="photoPreviewClear"
                                    class="ml-auto rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50">
                                    Quitar
                                </button>
                            </div>
                        </div>

                        <div class="min-w-[220px]">
                            <input type="text" name="caption" placeholder="Descripción (opcional)" maxlength="120"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('caption')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                            Subir
                        </button>
                    </form>
                </div>

                <hr class="my-6" />

                @if ($photos->isEmpty())
                    <p class="text-gray-600">Todavía no subiste fotos.</p>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach ($photos as $p)
                            <div class="overflow-hidden rounded-xl ring-1 ring-gray-200 bg-white">
                                <div class="aspect-square bg-gray-50">
                                    <img src="{{ asset('storage/' . $p->path) }}" alt="foto"
                                        class="w-full h-full object-cover" />
                                </div>

                                <div class="p-3 space-y-2">
                                    @if ($p->caption)
                                        <p class="text-sm text-gray-800">
                                            {{ $p->caption }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500 italic">
                                            Sin descripción
                                        </p>
                                    @endif

                                    <form method="POST" action="{{ route('cosplayer.photos.destroy', $p) }}"
                                        onsubmit="return confirm('¿Eliminar esta foto?');" class="mt-3">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="rounded-lg bg-white px-3 py-1.5 text-sm text-red-600 hover:bg-gray-50">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $photos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const input = document.getElementById("photoInput");
            const wrap = document.getElementById("photoPreview");
            const img = document.getElementById("photoPreviewImg");
            const nameEl = document.getElementById("photoPreviewName");
            const metaEl = document.getElementById("photoPreviewMeta");
            const clearBtn = document.getElementById("photoPreviewClear");

            function fmt(bytes) {
                const mb = bytes / (1024 * 1024);
                return mb >= 1 ?
                    `${mb.toFixed(2)} MB` :
                    `${(bytes / 1024).toFixed(0)} KB`;
            }

            input?.addEventListener("change", () => {
                const f = input.files?.[0];
                if (!f) {
                    wrap.classList.add("hidden");
                    wrap.classList.remove("flex");
                    return;
                }

                nameEl.textContent = f.name;
                metaEl.textContent = `${fmt(f.size)} • ${f.type || "imagen"}`;
                img.src = URL.createObjectURL(f);

                wrap.classList.remove("hidden");
                wrap.classList.add("flex");
            });

            clearBtn?.addEventListener("click", () => {
                input.value = "";
                wrap.classList.add("hidden");
                wrap.classList.remove("flex");
                img.removeAttribute("src");
                nameEl.textContent = "";
                metaEl.textContent = "";
            });
        </script>
    @endpush
</x-app-layout>
