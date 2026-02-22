<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('shop.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                Shop
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 dark:text-white font-medium truncate">{{ $shopItem->title }}</span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Galería de fotos --}}
                <div x-data="{ active: 0 }">
                    @if ($shopItem->photos && count($shopItem->photos) > 0)
                        {{-- Foto principal --}}
                        <div class="aspect-square bg-gray-100 dark:bg-gray-800 rounded-2xl overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">
                            @foreach ($shopItem->photos as $i => $photo)
                                <img src="{{ asset('storage/' . $photo) }}"
                                     alt="{{ $shopItem->title }}"
                                     x-show="active === {{ $i }}"
                                     class="w-full h-full object-cover">
                            @endforeach
                        </div>

                        {{-- Miniaturas --}}
                        @if (count($shopItem->photos) > 1)
                            <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                                @foreach ($shopItem->photos as $i => $photo)
                                    <button @click="active = {{ $i }}"
                                            class="shrink-0 w-16 h-16 rounded-lg overflow-hidden ring-2 transition"
                                            :class="active === {{ $i }} ? 'ring-indigo-500' : 'ring-gray-200 dark:ring-gray-700 hover:ring-indigo-300'">
                                        <img src="{{ asset('storage/' . $photo) }}"
                                             alt="miniatura {{ $i + 1 }}"
                                             class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="aspect-square bg-gray-100 dark:bg-gray-800 rounded-2xl ring-1 ring-gray-200 dark:ring-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-600">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Info del ítem --}}
                <div class="flex flex-col gap-6">

                    <div>
                        {{-- Badge estado --}}
                        @if ($shopItem->status === 'sold')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 mb-3">
                                Vendido
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 mb-3">
                                Disponible
                            </span>
                        @endif

                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $shopItem->title }}</h1>
                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-3">
                            ${{ number_format($shopItem->price, 2, ',', '.') }}
                        </p>
                    </div>

                    {{-- Descripción --}}
                    @if ($shopItem->description)
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Descripción</h3>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $shopItem->description }}</p>
                        </div>
                    @endif

                    {{-- Contacto --}}
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-4 ring-1 ring-gray-200 dark:ring-gray-700">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Contacto</h3>

                        @if ($shopItem->instagram)
                            <a href="https://www.instagram.com/{{ $shopItem->instagram }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white px-4 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                @{{ $shopItem->instagram }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Contactá al vendedor por Instagram para coordinar la compra.
                            </p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                El vendedor no indicó un medio de contacto. Visitá su perfil para encontrarlo.
                            </p>
                        @endif
                    </div>

                    {{-- Info del vendedor --}}
                    @php
                        $user = $shopItem->user;
                        $profile = $user->role === 'fotografo' ? $user->photographerProfile : $user->cosplayerProfile;
                        $avatar = $profile?->avatar_path;
                        $username = $profile?->instagram ?? \Illuminate\Support\Str::before($user->email, '@');
                    @endphp

                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                        {{-- Avatar --}}
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center shrink-0">
                            @if ($avatar)
                                <img src="{{ asset('storage/' . $avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Vendedor</p>
                            <a href="{{ route('portfolio.show', $username) }}"
                               class="font-semibold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 truncate block">
                                {{ $user->name }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                @{{ $username }}
                            </p>
                        </div>

                        <a href="{{ route('portfolio.show', $username) }}"
                           class="ml-auto shrink-0 text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                            Ver perfil
                        </a>
                    </div>

                    {{-- Disclaimer --}}
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        Este espacio es exclusivo para ítems relacionados al cosplay (props, ropa, accesorios). La plataforma no interviene en la transacción.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
