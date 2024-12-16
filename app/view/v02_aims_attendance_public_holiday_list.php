<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$year = $_POST['year'];
$public_holidays = getPublicHolidayByYear($year);
$i=1;
?>
<table class="table table-hover" id="public-list">
    <thead>
    <tr>
        <th colspan="4">List for year: <? echo $year ?></th>
    </tr>
    <tr>
        <th style="width: 10%">#</th>
        <th style="width: 20%">Date</th>
        <th style="width: 20%">Day</th>
        <th style="width: 50%">Description</th>
    </tr>
    </thead>
    <tbody>
    <? if ($public_holidays->num_rows < 1){ ?>
        <tr>
            <td colspan="4" class="text-center text-muted">No <b>Public Holiday</b> were added</td>
        </tr>
    <? } ?>
    <? foreach ($public_holidays as $list){ ?>
        <tr>
            <td><? echo $i++; ?></td>
            <td><? echo date('d/m/Y', strtotime($list['date'])); ?></td>
            <td><? echo date('l', strtotime($list['date'])); ?></td>
            <td><? echo $list['description']; ?></td>
        </tr>
    <? } ?>
    </tbody>
</table>