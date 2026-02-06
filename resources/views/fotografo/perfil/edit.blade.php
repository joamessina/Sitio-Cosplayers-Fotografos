<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar mi perfil
            </h2>
            <a href="{{ route('portfolio.show', $user->photographerProfile->instagram ?? Str::before($user->email, '@')) }}"
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

            @if (session('success'))
                <div class="alert-success">
                    <div class="alert-success-content">
                        <svg class="alert-success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="alert-success-text">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('fotografo.perfil.update') }}" method="POST" class="space-y-6">
                @csrf

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

                {{-- Botones --}}
                <div class="form-actions">
                    <a href="{{ route('fotografo.dashboard') }}" class="btn-back">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al dashboard
                    </a>

                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
