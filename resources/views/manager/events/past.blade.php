<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            過去のスケジュール
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        <x-toastr status="session('status')" />
                      <div class="w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                          <thead>
                            <tr>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">スケジュール名</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">参加人数</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">定員</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">表示・非表示</th>
                              <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($events as $event)
                            <tr>
                              <td class="text-green-500 px-4 py-3"><a href="{{ route('events.show',['event' => $event->id]) }}">{{ $event->name }}</a></td>
                              <td class="px-4 py-3">{{ $event->start_date }}</td>
                              <td class="px-4 py-3">{{ $event->end_date }}</td>
                              <td class="px-4 py-3">******</td>
                              <td class="px-4 py-3">{{ $event->max_people }}</td>
                              <td class="px-4 py-3">{{ $event->is_visible }}</td>
                            </tr>
                              @endforeach
                          </tbody>
                        </table>
                        {{ $events->links() }}
                      </div>
                      <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">   
                      </div>
                    </div>
                  </section>
            </div>
        </div>
    </div>
</x-app-layout>