<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Url-Shortner') }}
        </h2>
    </x-slot>

    <div>
        @livewire('shortner')
    </div>
</x-app-layout>
