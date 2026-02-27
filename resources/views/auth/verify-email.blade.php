<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            ¡Gracias por registrarte! Antes de empezar, necesitamos verificar tu dirección de email.
            Te enviamos un link de confirmación a tu casilla. Si no te llegó, podemos enviarte otro.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                Te enviamos un nuevo link de verificación a tu email.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-button>
                    Reenviar email de verificación
                </x-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
