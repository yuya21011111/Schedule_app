<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyPageService {
    
    public static function reservedEvent($events, $string) {
        
        $reservedEvents = [];
        // 昇順
        if($string === 'fromToday') {
            foreach($events->sortBy('start_date') as $event) {
                if(is_null($event->pivot->canceled_date) 
                && $event->start_date >= Carbon::now()->format('Y-m-d 00:00:00')) {
                    $eventInfo = [
                        'id' => $event->id,
                        'name' => $event->name,
                        'start_date' => $event->start_date,
                        'end_date' => $event->end_date,
                        'number_of_people' => $event->pivot->number_of_people
                    ];
                    array_push($reservedEvents, $eventInfo);
                }
            }
        }
        
        // 降順
        if($string === 'past') {
            foreach($events->sortByDesc('start_date') as $event) {
                if(is_null($event->pivot->canceled_date) 
                && $event->start_date < Carbon::now()->format('Y-m-d 00:00:00')) {
                    $eventInfo = [
                        'id' => $event->id,
                        'name' => $event->name,
                        'start_date' => $event->start_date,
                        'end_date' => $event->end_date,
                        'number_of_people' => $event->pivot->number_of_people
                    ];
                    array_push($reservedEvents, $eventInfo);
                }
            }
        }

        return $reservedEvents;

    }
}