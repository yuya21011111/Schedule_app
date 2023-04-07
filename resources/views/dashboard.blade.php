<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            スケージュール表
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="event-calendar mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-toastr status="session('status')" />
                @livewire('calendar')
            </div>
        </div>
    </div>
</x-app-layout>
