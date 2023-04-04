<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventService {
    public static function checkEventDuplication($eventDate,$startTime,$endTime) {
        $check = DB::table('events')
        ->whereDate('start_date',$eventDate)
        ->whereTime('end_date','>=',$startTime)
        ->whereTime('start_date','<',$endTime)
        ->exists();
        return $check;
    }

    public static function countEventDuplication($eventDate,$startTime,$endTime) {
        $count = DB::table('events')
        ->whereDate('start_date',$eventDate)
        ->whereTime('end_date','>=',$startTime)
        ->whereTime('start_date','<',$endTime)
        ->count();
        return $count;
    }

    public static function joinDateAndTime($date,$time) {
        $join = $date ." " . $time;
        $dateTime = Carbon::createFromFormat(
            'Y-m-d H:i',$join
        );

        return $dateTime;
    }

    public static function getWeekEvents($startDate,$endDate) {

        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id');

        $events = DB::table('events')
        ->leftJoinSub($reservedPeople,'reservedPeople',
        function($join){
            $join->on('events.id','=','reservedPeople.event_id');
        })
        ->whereBetween('start_date', [$startDate,$endDate])
        ->orderBy('start_date', 'asc')
        ->get();
        return $events;
    }
}