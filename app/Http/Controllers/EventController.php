<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\EventService;
use Database\Seeders\EventSeeder;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();

        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id');
        // dd($reservedPeople);

        $events = DB::table('events')
        ->leftJoinSub($reservedPeople,'reservedPeople',
        function($join){
            $join->on('events.id','=','reservedPeople.event_id');
        })
        ->whereDate('start_date', '>=', $today)
        ->orderBy('start_date', 'asc')
        ->paginate(10);
        return view('manager.events.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        // イベントの重複チェック
        $check = EventService::checkEventDuplication(
            $request['event_date'],$request['start_time'],$request['end_time']);
        
       if($check) {
        session()->flash('status','この時間帯は既に予約が他に存在しています。');
           return view('manager.events.create');
       }

       $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);

       $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);


        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible']
        ]);
        
        session()->flash('status','登録完了！');
        return to_route('events.index');

    }


    public function show(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $users = $event->users;

        $reservations = [];

        foreach($users as $user) {
            $reservedInfo = [
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people,
                'canceled_date' => $user->pivot->canceled_date
            ];
            array_push($reservations,$reservedInfo);
        }
        

        // dd($event,$users);
        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        // イベント時間の確認
        // dd($eventDate,$startTime,$endTime);
        return view('manager.events.show',compact('event','users','reservations','eventDate','startTime','endTime'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $today = Carbon::today()->format('Y年m月d日');
        if($event->eventDate < $today) {
            return abort(404);
        }
        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        // イベント時間の確認
        // dd($eventDate,$startTime,$endTime);
        return view('manager.events.edit',compact('event','eventDate','startTime','endTime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
         // イベントの重複チェック
         $count = EventService::countEventDuplication(
            $request['event_date'],$request['start_time'],$request['end_time']);
        
       if($count > 1) {
        $event = Event::findOrFail($event->id);
        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;
        session()->flash('status','この時間帯は既に予約が他に存在しています。');
           return view('manager.events.edit',compact('event','eventDate','startTime','endTime'));
       }

       $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);

       $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

       $event = Event::findOrFail($event->id);
        
            $event->name = $request['event_name'];
            $event->information = $request['information'];
            $event->start_date = $startDate;
            $event->end_date = $endDate;
            $event->max_people = $request['max_people'];
            $event->is_visible = $request['is_visible'];
            $event->save();
        
        
        session()->flash('status','更新しました。');
        return to_route('events.index');
    }

    public function past() {
        $today = Carbon::today();

        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id');
        
        $events = DB::table('events')
        ->leftJoinSub($reservedPeople,'reservedPeople',
        function($join){
            $join->on('events.id','=','reservedPeople.event_id');
        })
        ->whereDate('start_date', '<' ,$today)
        ->orderBy('start_date','desc')
        ->paginate(10);

        return view('manager.events.past',compact('events'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
