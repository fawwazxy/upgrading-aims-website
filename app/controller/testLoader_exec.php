<?php
//echo "This is testloader page for IT maintenance purpose only";

require "../model/v02_attendance_function.php";

echo getIndividualCalendar(524, 2023, true);
/*$start_time = "08:00:00";
$end_time = "17:00:00";
$break_time = "01:00:00";

$work_seconds = 8 * 60 * 60;
$break_seconds = 1 * 60 * 60;
$work_period = $work_seconds + $break_seconds;

echo "<br>Start time: ".date('h:iA', strtotime($start_time));
echo "<br>End time: ".date('h:iA', strtotime($end_time));
echo "<br>End time using add seconds: ".date('h:iA',strtotime($start_time) + $work_period);
echo "<br>Break hour using seconds: ".secondToHours($break_seconds);

function secondToHoursMinutesSeconds($seconds){
    $hours = floor($seconds / (60 * 60)); $seconds -= $hours*(60*60); // update seconds balance
    $minutes = floor($seconds / 60);
    $seconds = $seconds - ($minutes*60); // update seconds balance
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

function secondToHours($seconds){
    return number_format($seconds / 60 / 60, 2)." hours";
}*/