<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if (auth()->user()->role === 'fotografo')
                        <h3 class="text-lg font-semibold text-gray-900">Panel de fotógrafo</h3>
                        <p class="text-gray-600 mt-1">Cargá tu perfil y compartí tus álbumes para que los cosplayers te
                            encuentren.</p>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('fotografo.perfil.edit') }}"
                                class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                                <div class="font-semibold">Completar mi perfil</div>
                                <div class="text-sm text-gray-600 mt-1">Bio, Instagram y links de contacto.</div>
                            </a>

                            <a href="{{ route('albums.index') }}"
                                class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                                <div class="font-semibold">Mis álbumes</div>
                                <div class="text-sm text-gray-600 mt-1">Agregar enlaces de Drive y ordenarlos.</div>
                            </a>
                        </div>
                    @else
                        <h3 class="text-lg font-semibold text-gray-900">Explorar fotógrafos</h3>
                        <p class="text-gray-600 mt-1">Buscá fotógrafos y encontrá los álbumes donde suben las fotos de
                            tus cosplays.</p>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('fotografos.index') }}"
                                class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                                <div class="font-semibold">Ver fotógrafos</div>
                                <div class="text-sm text-gray-600 mt-1">Listado público con sus perfiles.</div>
                            </a>

                            <a href="{{ route('albums.public') }}"
                                class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                                <div class="font-semibold">Ver álbumes recientes</div>
                                <div class="text-sm text-gray-600 mt-1">Últimos uploads de fotógrafos.</div>
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
