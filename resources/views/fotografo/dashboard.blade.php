<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Panel Fotógrafo</h2>
                <p class="text-sm text-gray-600">
                    Administrá tu perfil y tus álbumes.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('fotografo.perfil.edit') }}" class="btn-primary">
                    Editar mi perfil
                </a>

                <a href="{{ route('fotografo.albums.index') }}" class="btn-secondary">
                    Mis álbumes
                </a>
            </div>
        </div>
    </x-slot>

    <div class="page-wrap">
        <div class="container-app space-y-6">

            {{-- Hero --}}
            <div class="rounded-2xl bg-indigo-600 p-6 text-white shadow">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Hola, {{ auth()->user()->name }} 👋</p>
                        <h3 class="text-2xl font-semibold mt-1">Bienvenido a tu panel</h3>
                        <p class="text-white/80 mt-1">
                            Desde acá podés gestionar tu perfil y tus álbumes de fotos.
                        </p>
                    </div>

                    <a href="{{ route('fotografo.perfil.edit') }}" class="btn-secondary">
                        Completar perfil
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="card p-5">
                    <p class="text-sm text-gray-500">Mi perfil</p>
                    <p class="text-gray-900 mt-2">
                        Configurá tu información pública y redes sociales.
                    </p>
                    <a href="{{ route('fotografo.perfil.edit') }}"
                        class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Editar perfil →
                    </a>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-gray-500">Álbumes</p>
                    <p class="text-gray-900 mt-2">
                        Creá álbumes y compartí tus fotos con links de Drive.
                    </p>
                    <a href="{{ route('fotografo.albums.index') }}"
                        class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Ver álbumes →
                    </a>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-gray-500">Perfil público</p>
                    <p class="text-gray-900 mt-2">
                        Mirá cómo ven tu perfil los demás usuarios.
                    </p>
                    <a href="{{ route('fotografos.show', auth()->user()) }}" target="_blank"
                        class="text-sm text-indigo-600 hover:underline mt-3 inline-block">
                        Ver perfil público →
                    </a>
                </div>
            </div>

            {{-- Próximos pasos --}}
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900">Próximos pasos</h3>
                <p class="text-sm text-gray-600 mt-2">
                    Actualmente estamos en la Fase 1: Perfiles de fotógrafo.
                </p>

                <ul class="mt-4 space-y-2 text-sm text-gray-700">
                    <li class="flex gap-2"><span class="text-indigo-600">✓</span> Completar tu perfil público</li>
                    <li class="flex gap-2"><span class="text-indigo-600">→</span> Crear álbumes (Fase 2)</li>
                    <li class="flex gap-2"><span class="text-gray-400">○</span> Integración con Google Drive (Fase 4)
                    </li>
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
