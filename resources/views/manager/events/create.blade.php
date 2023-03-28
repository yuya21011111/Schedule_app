<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           スケジュール新規登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="max-w-2xl mx-auto">
                    <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('events.store') }}">
            @csrf

            <div>
                <x-label for="event_name" value="イベント名" />
                <x-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" :value="old('event_name')" required autofocus autocomplete="username" />
            </div>
            
            <div class="md:flex justify-between">
                <div class="mt-4">
                    <x-label for="event_date" value="イベント日付" />
                    <x-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" required  />
                </div>

                <div class="mt-4">
                    <x-label for="start_time" value="開始時間" />
                    <x-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" required  />
                </div>

                <div class="mt-4">
                    <x-label for="end_time" value="終了時間" />
                    <x-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" required  />
                </div>
            </div>


            <div class="flex items-center justify-end mt-4">
                

                <x-button class="ml-4">
                   新規登録
                </x-button>
            </div>
        </form>
        </div>
            </div>
        </div>
    </div>
</x-app-layout>
