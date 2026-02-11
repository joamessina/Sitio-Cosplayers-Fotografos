<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar mi perfil
            </h2>
<a href="{{ route('portfolio.show', $user->cosplayerProfile?->instagram ?? Str::before($user->email, '@')) }}"
    target="_blank" class="btn-secondary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
        </path>
    </svg>
    Ver perfil público
</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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

            {{-- Formulario 1: Datos del perfil --}}
            <form action="{{ route('cosplayer.perfil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Card: Fotos de perfil --}}
                <div class="profile-card" x-data="{
                    avatarPreview: '{{ $profile->avatar_path ? asset('storage/' . $profile->avatar_path) : '' }}',
                    coverPreview: '{{ $profile->cover_path ? asset('storage/' . $profile->cover_path) : '' }}',
                    hasAvatar: {{ $profile->avatar_path ? 'true' : 'false' }},
                    hasCover: {{ $profile->cover_path ? 'true' : 'false' }},
                    removeAvatar: false,
                    removeCover: false,
                    handleAvatar(e) {
                        const file = e.target.files[0];
                        if (file) {
                            this.avatarPreview = URL.createObjectURL(file);
                            this.hasAvatar = true;
                            this.removeAvatar = false;
                        }
                    },
                    handleCover(e) {
                        const file = e.target.files[0];
                        if (file) {
                            this.coverPreview = URL.createObjectURL(file);
                            this.hasCover = true;
                            this.removeCover = false;
                        }
                    },
                    clearAvatar() {
                        this.avatarPreview = '';
                        this.hasAvatar = false;
                        this.removeAvatar = true;
                        this.$refs.avatarInput.value = '';
                    },
                    clearCover() {
                        this.coverPreview = '';
                        this.hasCover = false;
                        this.removeCover = true;
                        this.$refs.coverInput.value = '';
                    }
                }">
                    <div class="profile-section-header">
                        <div class="profile-section-icon profile-section-icon--indigo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="profile-section-title">Fotos de perfil</h3>
                            <p class="profile-section-subtitle">Avatar y foto de portada para tu portfolio</p>
                        </div>
                    </div>

                    {{-- Foto de portada --}}
                    <div>
                        <label class="form-label">Foto de portada</label>
                        <div class="relative w-full aspect-[3/1] rounded-lg border-2 border-dashed border-gray-300 overflow-hidden cursor-pointer hover:border-indigo-400 transition"
                             @click="$refs.coverInput.click()">
                            <template x-if="coverPreview && !removeCover">
                                <img :src="coverPreview" class="w-full h-full object-cover" alt="Preview portada">
                            </template>
                            <template x-if="!coverPreview || removeCover">
                                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm">Click para elegir imagen (max 10MB)</span>
                                </div>
                            </template>
                        </div>
                        <input type="file" name="cover" accept="image/*" class="hidden" x-ref="coverInput" @change="handleCover($event)">
                        <input type="hidden" name="remove_cover" :value="removeCover ? '1' : '0'">
                        <template x-if="hasCover && !removeCover">
                            <button type="button" @click.prevent="clearCover()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Eliminar portada
                            </button>
                        </template>
                        @error('cover')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Avatar --}}
                    <div>
                        <label class="form-label">Avatar</label>
                        <div class="flex items-center gap-4">
                            <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200 cursor-pointer hover:border-indigo-400 transition flex-shrink-0"
                                 @click="$refs.avatarInput.click()">
                                <template x-if="avatarPreview && !removeAvatar">
                                    <img :src="avatarPreview" class="w-full h-full object-cover" alt="Preview avatar">
                                </template>
                                <template x-if="!avatarPreview || removeAvatar">
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div>
                                <button type="button" @click="$refs.avatarInput.click()" class="btn-secondary text-sm">
                                    Elegir imagen
                                </button>
                                <p class="form-hint mt-1">Imagen cuadrada, max 2MB</p>
                                <template x-if="hasAvatar && !removeAvatar">
                                    <button type="button" @click.prevent="clearAvatar()" class="text-sm text-red-600 hover:text-red-800 mt-1">
                                        Eliminar avatar
                                    </button>
                                </template>
                            </div>
                        </div>
                        <input type="file" name="avatar" accept="image/*" class="hidden" x-ref="avatarInput" @change="handleAvatar($event)">
                        <input type="hidden" name="remove_avatar" :value="removeAvatar ? '1' : '0'">
                        @error('avatar')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- Columna izquierda --}}
                    <div class="profile-card">
                        <div class="profile-section-header">
                            <div class="profile-section-icon profile-section-icon--indigo">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="profile-section-title">Información pública</h3>
                                <p class="profile-section-subtitle">Visible en tu perfil y portfolio</p>
                            </div>
                        </div>

                        {{-- Nombre --}}
                        <div>
                            <label for="display_name" class="form-label form-label-required">
                                Nombre a mostrar
                            </label>
                            <input type="text" name="display_name" id="display_name"
                                value="{{ old('display_name', $profile->display_name ?? '') }}" required
                                class="form-input">
                            <p class="form-hint">Este es el nombre que verán los demás usuarios</p>
                            @error('display_name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Biografía --}}
                        <div>
                            <label for="bio" class="form-label">Biografía</label>
                            <textarea name="bio" id="bio" rows="4" maxlength="500" class="form-textarea">{{ old('bio', $profile->bio ?? '') }}</textarea>
                            <p class="form-hint">Máximo 500 caracteres</p>
                            @error('bio')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ubicación --}}
                        <div>
                            <label for="location" class="form-label">Ubicación</label>
                            <div class="relative">
                                <span class="input-icon-left">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                </span>
                                <input type="text" name="location" id="location"
                                    value="{{ old('location', $profile->location ?? '') }}"
                                    placeholder="Buenos Aires, Argentina" class="form-input form-input--with-icon-left">
                            </div>
                            @error('location')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Columna derecha --}}
                    <div class="profile-card">
                        <div class="profile-section-header">
                            <div class="profile-section-icon profile-section-icon--purple">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="profile-section-title">Redes sociales</h3>
                                <p class="profile-section-subtitle">Enlaces a tus perfiles</p>
                            </div>
                        </div>

                        {{-- Instagram --}}
                        <div>
                            <label for="instagram" class="form-label">Instagram</label>
                            <div class="relative">
                                <span class="input-prefix">@</span>
                                <input type="text" name="instagram" id="instagram"
                                    value="{{ old('instagram', $profile->instagram ?? '') }}" placeholder="usuario"
                                    class="form-input form-input--with-prefix">
                            </div>
                            <p class="form-hint">Solo el nombre de usuario, sin el @</p>
                            @error('instagram')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Portfolio URL --}}
                        <div>
                            <label for="portfolio_url" class="form-label">Portfolio / Sitio web</label>
                            <div class="relative">
                                <span class="input-icon-left">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                        </path>
                                    </svg>
                                </span>
                                <input type="url" name="portfolio_url" id="portfolio_url"
                                    value="{{ old('portfolio_url', $profile->portfolio_url ?? '') }}"
                                    placeholder="https://tu-portfolio.com"
                                    class="form-input form-input--with-icon-left">
                            </div>
                            <p class="form-hint">Link a tu portfolio, página web o redes</p>
                            @error('portfolio_url')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preview --}}
                        <div class="portfolio-preview">
                            <div class="portfolio-preview-content">
                                <div class="portfolio-preview-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="portfolio-preview-label">Tu URL de portfolio</p>
                                    @php
                                        $username = $profile->instagram ?? explode('@', $user->email)[0];
                                    @endphp
                                    <p class="portfolio-preview-url">{{ url('/@' . $username) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección: Personalización de colores --}}
                <div class="profile-card">
                    <div class="profile-section-header">
                        <div class="profile-section-icon profile-section-icon--purple">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 21h10a2 2 0 002-2v-4a2 2 0 00-2-2H7M7 21V9a2 2 0 012-2h10M9 5v10"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="profile-section-title">Personalización</h3>
                            <p class="profile-section-subtitle">Colores de tu portfolio</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" 
                        x-data="{
                            primaryColor: '{{ old('primary_color', $profile->primary_color ?? '#6366f1') }}',
                            secondaryColor: '{{ old('secondary_color', $profile->secondary_color ?? '#a855f7') }}'
                        }">
                        
                        {{-- Color primario --}}
                        <div>
                            <label for="primary_color" class="form-label form-label-required">Color primario</label>
                            <div class="flex items-center gap-3">
                                <input type="color" 
                                    name="primary_color" 
                                    id="primary_color"
                                    x-model="primaryColor"
                                    class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer">
                                <div class="flex-1">
                                    <input type="text"
                                        x-model="primaryColor"
                                        class="form-input text-sm font-mono uppercase">
                                </div>
                            </div>
                            <p class="form-hint">Color principal de tu portfolio (botones, enlaces)</p>
                            @error('primary_color')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Color secundario --}}
                        <div>
                            <label for="secondary_color" class="form-label form-label-required">Color secundario</label>
                            <div class="flex items-center gap-3">
                                <input type="color" 
                                    name="secondary_color" 
                                    id="secondary_color"
                                    x-model="secondaryColor"
                                    class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer">
                                <div class="flex-1">
                                    <input type="text"
                                        x-model="secondaryColor"
                                        class="form-input text-sm font-mono uppercase">
                                </div>
                            </div>
                            <p class="form-hint">Color para acentos y gradientes</p>
                            @error('secondary_color')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preview de colores --}}
                        <div class="md:col-span-2 mt-4 p-4 rounded-lg border border-gray-200 bg-gray-50">
                            <p class="text-sm font-medium text-gray-700 mb-3">Vista previa:</p>
                            <div class="flex flex-wrap gap-3 items-center">
                                <button type="button"
                                    :style="`background-color: ${primaryColor}; color: white;`"
                                    class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                                    Botón primario
                                </button>

                                <div class="flex items-center gap-2">
                                    <span :style="`background: linear-gradient(135deg, ${primaryColor}, ${secondaryColor});`"
                                        class="w-8 h-8 rounded-lg shadow-sm"></span>
                                    <span class="text-sm text-gray-600">Gradiente</span>
                                </div>

                                <span :style="`color: ${primaryColor};`" class="text-sm font-medium underline">
                                    Enlace de ejemplo
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones del formulario --}}
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('cosplayer.dashboard') }}" class="btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>

                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </form>

            {{-- Formulario 2: Visibilidad de fotos --}}
            @if($photos->count() > 0)
                <div class="mt-10">
                    <form action="{{ route('cosplayer.perfil.updatePhotos') }}" method="POST">
                        @csrf

                        <div class="profile-card">
                            <div class="profile-section-header">
                                <div class="profile-section-icon profile-section-icon--indigo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="profile-section-title">Fotos del portfolio</h3>
                                    <p class="profile-section-subtitle">Seleccioná cuáles se muestran en tu perfil público</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-4 text-sm text-gray-600">
                                <button type="button" onclick="toggleAll(true)" class="text-indigo-600 hover:underline">
                                    Seleccionar todas
                                </button>
                                <span class="text-gray-300">|</span>
                                <button type="button" onclick="toggleAll(false)" class="text-indigo-600 hover:underline">
                                    Deseleccionar todas
                                </button>
                                <span class="ml-auto font-medium" id="photo-counter"></span>
                            </div>

                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                @foreach($photos as $photo)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" 
                                            name="visible_photos[]" 
                                            value="{{ $photo->id }}"
                                            class="photo-checkbox sr-only peer"
                                            {{ $photo->is_public ? 'checked' : '' }}>
                                        
                                        <div class="aspect-square rounded-lg overflow-hidden ring-2 ring-transparent peer-checked:ring-indigo-500 peer-checked:ring-offset-2 transition-all">
                                            <img src="{{ asset('storage/' . $photo->path) }}" 
                                                alt="{{ $photo->caption ?? 'Foto' }}"
                                                class="h-full w-full object-cover peer-checked:opacity-100 opacity-50 transition-opacity">
                                        </div>
                                        
                                        <div class="absolute top-2 right-2 w-6 h-6 rounded-full bg-white shadow-md flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div class="flex justify-end pt-6 border-t border-gray-200 mt-6">
                                <button type="submit" class="btn-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Guardar visibilidad
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
    <script>
        function toggleAll(state) {
            document.querySelectorAll('.photo-checkbox').forEach(cb => {
                cb.checked = state;
            });
            updateCounter();
        }

        function updateCounter() {
            const total = document.querySelectorAll('.photo-checkbox').length;
            const checked = document.querySelectorAll('.photo-checkbox:checked').length;
            document.getElementById('photo-counter').textContent = `${checked} de ${total} visibles`;
        }

        // Inicializar contador al cargar
        document.addEventListener('DOMContentLoaded', () => {
            updateCounter();
            
            // Agregar listener a cada checkbox
            document.querySelectorAll('.photo-checkbox').forEach(cb => {
                cb.addEventListener('change', updateCounter);
            });
        });
    </script>
    @endpush
</x-app-layout>