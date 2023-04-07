<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyPageService {
    
    public static function reservedEvent($events, $string) {
        
        $reservedEvents = [];
        if($string === 'fromToday') {

        }

        if($string === 'past') {

        }

        return $reservedEvents;

    }
}