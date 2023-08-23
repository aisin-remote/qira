<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ auth()->user()->posisi === 'ADMIN' ? __('Admin Dashboard') : __('User Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        @if (auth()->user()->posisi === 'ADMIN')
            {{-- Konten khusus admin --}}
            <p>Welcome to the Admin Dashboard!</p>
        @else
            {{-- Konten khusus user --}}
            <p>Welcome to the User Dashboard!</p>
        @endif
    </div>
</x-app-layout>
