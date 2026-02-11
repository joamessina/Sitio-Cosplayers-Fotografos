<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Fotógrafos</h2>
    </x-slot>
    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold">Explorá fotógrafos</h3>
                        <p class="text-sm text-gray-600">Entrá a un perfil y mirá sus álbumes.</p>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($fotografos as $f)
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="font-semibold text-gray-900 mb-1">{{ $f->name }}</div>
                            <div class="text-sm text-gray-600 mb-3">
                                @if ($f->photographerProfile && $f->photographerProfile->location)
                                    📍 {{ $f->photographerProfile->location }}
                                @else
                                    Fotógrafo
                                @endif
                            </div>
                            {{-- Botones de acción --}}
                            <div class="flex gap-2">
                                <a href="{{ route('fotografos.show', $f) }}"
                                    class="flex-1 text-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                                    Ver perfil
                                </a>
                                @php
                                    // Determinar username para el portfolio
                                    $username = $f->photographerProfile?->instagram
                                        ?? Str::before($f->email, '@')
                                        ?? $f->name;
                                @endphp
                                @if ($username)
                                <a href="{{ route('portfolio.show', $username) }}"
                                    class="flex-1 text-center px-4 py-2 bg-indigo-600 rounded-lg text-sm text-white hover:bg-indigo-700 transition">
                                    Portfolio
                                </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600 col-span-2">Todavía no hay fotógrafos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>