<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Services\EventService;

class Calendar extends Component
{
    public $currentDate;
    public $currentWeek;
    public $day;
    public $sevenDaysLater;
    public $events;

    public function mount() {
        $this->currentDate = Carbon::today();
        $this->sevenDaysLater = $this->currentDate->copy()->addDays(7);
        $this->currentWeek = [];

        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d') 
        );

        for($i = 0; $i < 7; $i++) {
            $this->day = Carbon::today()->addDays($i)->format('m月d日');
            array_push($this->currentWeek,$this->day);
        }
        
        // 7日の日付を表示
        // dd($this->currentWeek);
    }

    public function getDate($date) {
        $this->currentDate = $date;
        $this->currentWeek = [];
        $this->sevenDaysLater = Carbon::parse($this->currentDate)->addDays(7);

        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d') 
        );

        for($i = 0; $i < 7; $i++) {
            $this->day = Carbon::parse($this->currentDate)->addDays($i)->format('m月d日');
            array_push($this->currentWeek,$this->day);
        }
        
    }
    public function render()
    {
        return view('livewire.calendar');
    }
}
