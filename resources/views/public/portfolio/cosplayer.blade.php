<x-app-layout>
    {{-- Variables CSS dinámicas para colores del portfolio --}}
    @push('styles')
    <style>
        :root {
            --portfolio-primary: {{ $user->cosplayerProfile->primary_color ?? '#6366f1' }};
            --portfolio-secondary: {{ $user->cosplayerProfile->secondary_color ?? '#a855f7' }};
        }
        .portfolio-gradient {
            background: linear-gradient(135deg, var(--portfolio-primary), var(--portfolio-secondary));
        }
        .portfolio-primary-bg {
            background-color: var(--portfolio-primary);
        }
        .portfolio-primary-text {
            color: var(--portfolio-primary);
        }
        .portfolio-primary-border {
            border-color: var(--portfolio-primary);
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-900">
                Portfolio de {{ $user->cosplayerProfile->display_name ?? $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Hero Section --}}
            <div class="relative rounded-3xl overflow-hidden text-white shadow-xl">
                {{-- Background: cover image or gradient --}}
                @if($user->cosplayerProfile->cover_path)
                    <div class="absolute inset-0">
                        <img src="{{ asset('storage/' . $user->cosplayerProfile->cover_path) }}" alt="Portada" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50"></div>
                    </div>
                @else
                    <div class="absolute inset-0 portfolio-gradient"></div>
                @endif

                <div class="relative p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center gap-8">

                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        @if($user->cosplayerProfile->avatar_path)
                            <div class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-white/30">
                                <img src="{{ asset('storage/' . $user->cosplayerProfile->avatar_path) }}" alt="{{ $user->cosplayerProfile->display_name ?? $user->name }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white/30">
                                <span class="text-5xl font-bold text-white">
                                    {{ strtoupper(substr($user->cosplayerProfile->display_name ?? $user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-4xl font-bold mb-2">
                            {{ $user->cosplayerProfile->display_name ?? $user->name }}
                        </h1>

                        @if ($user->cosplayerProfile && $user->cosplayerProfile->location)
                            <p class="text-white/90 flex items-center justify-center md:justify-start gap-2 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $user->cosplayerProfile->location }}
                            </p>
                        @endif

                        @if ($user->cosplayerProfile && $user->cosplayerProfile->bio)
                            <p class="text-lg text-white/95 leading-relaxed max-w-2xl mb-6">
                                {{ $user->cosplayerProfile->bio }}
                            </p>
                        @endif

                        {{-- Social Links --}}
                        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                            @if ($user->cosplayerProfile && $user->cosplayerProfile->instagram)
                                <a href="https://instagram.com/{{ $user->cosplayerProfile->instagram }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg text-white font-medium transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                    {{ '@' . $user->cosplayerProfile->instagram }}
                                </a>
                            @endif

                            @if ($user->cosplayerProfile && $user->cosplayerProfile->portfolio_url)
                                <a href="{{ $user->cosplayerProfile->portfolio_url }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                        </path>
                                    </svg>
                                    Sitio Web
                                </a>
                            @endif

                            <button type="button" x-data @click="$dispatch('open-contact-modal')"
                                class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg transition font-medium cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Contactar
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            {{-- Galería de Fotos --}}
            @if ($photos->isNotEmpty())
                <div class="bg-white shadow-sm rounded-2xl p-8 ring-1 ring-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Mi Galería</h2>
                        <p class="text-gray-600 mt-1">{{ $photos->total() }} {{ $photos->total() === 1 ? 'foto' : 'fotos' }}</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($photos as $photo)
                            <div class="gallery-item group relative aspect-square bg-gray-100 rounded-xl overflow-hidden ring-1 ring-gray-200 hover:ring-purple-300 hover:shadow-lg transition">
                                {{-- Skeleton placeholder --}}
                                <div class="skeleton-img absolute inset-0"></div>

                                <img src="{{ asset('storage/' . $photo->path) }}"
                                     alt="{{ $photo->caption ?? 'Foto de cosplay' }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                     onload="this.classList.add('loaded'); this.previousElementSibling.style.display='none'">

                                @if($photo->caption)
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-4">
                                        <p class="text-white text-sm">{{ $photo->caption }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    @if ($photos->hasPages())
                        <div class="mt-8">
                            {{ $photos->links() }}
                        </div>
                    @endif
                </div>
            @else
                {{-- Sin fotos --}}
                <div class="bg-white shadow-sm rounded-2xl p-12 ring-1 ring-gray-200 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Todavía no hay fotos</h3>
                    <p class="text-gray-600">
                        Este cosplayer está preparando su galería.
                    </p>
                </div>
            @endif

        </div>
    </div>

    {{-- Modal de Contacto --}}
    <div x-data="{
            open: {{ $errors->any() ? 'true' : 'false' }},
            sent: {{ session('contact_sent') ? 'true' : 'false' }}
         }"
         x-init="if (sent) open = true"
         @open-contact-modal.window="open = true; sent = false"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">

        {{-- Overlay --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>

        {{-- Modal --}}
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                 class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl p-6 sm:p-8"
                 @click.away="open = false">

                {{-- Cerrar --}}
                <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                {{-- Mensaje enviado --}}
                <template x-if="sent">
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Mensaje enviado</h3>
                        <p class="text-gray-600">Tu mensaje fue enviado correctamente. El destinatario lo recibirá por email.</p>
                        <button @click="open = false" class="mt-6 btn-primary">Cerrar</button>
                    </div>
                </template>

                {{-- Formulario --}}
                <template x-if="!sent">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1" id="modal-title">
                            Contactar a {{ $user->cosplayerProfile->display_name ?? $user->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-6">Enviá un mensaje sin exponer tus datos personales</p>

                        @if($errors->has('rate_limit'))
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                                {{ $errors->first('rate_limit') }}
                            </div>
                        @endif

                        <form action="{{ route('contacto.store', $user) }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="sender_name" class="form-label form-label-required">Tu nombre</label>
                                <input type="text" name="sender_name" id="sender_name" value="{{ old('sender_name') }}" required class="form-input" placeholder="Juan Perez">
                                @error('sender_name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sender_email" class="form-label form-label-required">Tu email</label>
                                <input type="email" name="sender_email" id="sender_email" value="{{ old('sender_email') }}" required class="form-input" placeholder="tu@email.com">
                                @error('sender_email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject" class="form-label">Asunto</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="form-input" placeholder="Consulta sobre sesión de fotos">
                                @error('subject')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="form-label form-label-required">Mensaje</label>
                                <textarea name="message" id="message" rows="4" required class="form-textarea" placeholder="Escribí tu mensaje...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-3 pt-2">
                                <button type="button" @click="open = false" class="btn-secondary">Cancelar</button>
                                <button type="submit" class="btn-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Enviar mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>