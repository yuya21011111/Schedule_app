<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function dashboard() {
        return view('dashboard');
    }

    public function detail($id) {
        $event = Event::findOrfail($id);
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id', $event->id)
        ->first();

        if(!is_null($reservedPeople)) {
            $reservedPeople = $event->max_people - $reservedPeople->number_of_people;
        }
        else {
            $reservedPeople = $event->max_people;
        }

        return view('event-detail', compact('event','reservedPeople'));
    }

    public function reserve(Request $request) {
        $event = Event::findOrFail($request->id);
        $reservedPeople = DB::table('reservations')
        ->select('event_id',DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id',$request->id)
        ->first();

        if(is_null($reservedPeople) 
        || $event->max_people >= $reservedPeople->number_of_people + $request->reserved_people) {
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $request['id'],
                'number_of_people' => $request['reserved_people'],
            ]);
            
            session()->flash('status','予約完了！');
            return to_route('dashboard');
        }
        else {
            session()->flash('status','この人数では予約が行えません。');
            return view('dashboard');
        }
    }
}
