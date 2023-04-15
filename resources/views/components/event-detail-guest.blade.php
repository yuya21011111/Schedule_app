<x-calendar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           スケジュール詳細
        </h2>
    </x-slot>

    <div class="pt-4 pb-2">
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

        <form method="get" action="{{ route('login') }}">
            @csrf

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
                    {{ $event->eventDAte }}
                </div>

                <div class="mt-4">
                    <x-label for="start_time" value="開始時間" />
                    {{ $event->startTime }}
                </div>

                <div class="mt-4">
                    <x-label for="end_time" value="終了時間" />
                   {{ $event->endTime }}
                </div>
            </div>

            <div class="md:flex justify-between items-end">
                <div class="mt-4">
                    <x-label for="max_people" value="定員数" />
                    {{ $event->max_people }}人
                </div>
                <div class="mt-4">
                @if($isReserved === null) <!-- 予約していれば予約人数は表示しない -->
                    @if($reservedPeople <= 0) <!-- 満員の場合は満員と表示 -->
                        <span class="text-red-500 text-xs">このイベントは満員です。</span>
                    @else
                    <x-label for="reserved_people" value="予約人数" />
                    <select name="reserved_people">
                        @for($i = 1; $i <= $reservedPeople; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @endif
                @else
                    <select>
                            <option value="-">-</option>
                    </select>
                @endif
                </div>
                @if($isReserved === null) <!-- 予約済みかの判定 -->
                <input type="hidden" name="id" value="{{ $event->id }}">
                @if($reservedPeople > 0)
                <x-button class="ml-4">
                    予約
                 </x-button>
                @endif
            </div>
            @else 
                <span class="text-xs text-red-500">このイベントは既に予約済みです。</span>
            @endif
        </form>
        </div>
            </div>
        </div>
    </div>
</x-calendar-layout>
