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

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @forelse($fotografos as $f)
                        <a href="{{ route('fotografos.show', $f) }}"
                           class="border rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="font-semibold text-gray-900">{{ $f->name }}</div>
                            <div class="text-sm text-gray-600">Ver perfil</div>
                        </a>
                    @empty
                        <p class="text-gray-600">Todavía no hay fotógrafos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
