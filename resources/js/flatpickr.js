import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js"
 
// 30日まで指定可能にする
flatpickr("#event_date",{
    "locale" : Japanese,
    minDate: "today",
    maxDate: new Date().fp_incr(30)
});

// 30日まで指定可能にする
flatpickr("#calendar",{
    "locale" : Japanese,
    minDate: "today",
    maxDate: new Date().fp_incr(30)
});

// 24時間の時間指定をする。
const setting = {
    "locale" : Japanese,
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    minTime: "10:00",
    maxTime: "02:30",
    minuteIncrement: 30
}

flatpickr("#start_time",setting);
flatpickr("#end_time",setting);