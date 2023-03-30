<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           スケジュール詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="max-w-2xl py-4 mx-auto">
                    <x-validation-errors class="mb-4" />

        {{-- @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif --}}
        <x-alert status="session('status')" />

        <form method="get" action="{{ route('events.edit',['event' => $event->id]) }}">

            <div>
                <x-label for="event_name" value="イベント名" />
                {{ $event->name }}
            </div>

            <div class="mt-4">
                <x-label for="information" value="イベント詳細" />
                {!! nl2br(e($event->information)) !!}
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

            <div class="md:flex justify-between items-end">
                <div class="mt-4">
                    <x-label for="max_people" value="定員数" />
                    {{ $event->max_people }}人
                </div>
                <div class="flex space-x-4 justify-around">
                    <input type="radio" name="is_visible" value="1" checked />表示
                    <input type="radio" name="is_visible" value="0" checked />非表示
                </div>
                <x-button class="ml-4">
                    編集
                 </x-button>
            </div>
        </form>
        </div>
            </div>
        </div>
    </div>
</x-app-layout>
