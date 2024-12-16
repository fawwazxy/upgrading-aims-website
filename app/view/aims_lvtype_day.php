<?php

include ('../controller/auth.php');

require "../model/aims_lv_analysis_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;

function getPastDate($count) {
    if ($count>=date("w")) {
        $count=date("w")-$count;
        $date = strtotime("-".$count." day", strtotime(date('d M Y')));
        return date('Y-m-d', $date);
        //echo date('d', $date);
    }
    else
    {
        $count=date("w")-$count;
        $date = strtotime("-".$count." day", strtotime(date('d M Y')));
        return date('Y-m-d', $date);
    }
}

 $date = $_GET['id'];

?>

<style>
td{
	text-align:center;
}
</style>

<div class="row">
                <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Leave Info</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										 <th>Annual Leave</th>
										 <th>Medical Leave</th>
										 <th>Compassionate Leave</th>
										 <th>Leave Without Pay</th>
										 <th>Leave Without Record</th>
									</tr>
								</thead>
								<tbody>
							
									<tr class="odd gradeX">
										<td><? echo getAnalisaTotalCutiByDayAL(getPastDate($date))?></td>
										<td><? echo getAnalisaTotalCutiByDayMC(getPastDate($date))?></td>
										<td><? echo getAnalisaTotalCutiByDayCL(getPastDate($date))?></td>
										<td><? echo getAnalisaTotalCutiByDayLP(getPastDate($date))?></td>
								        <td><? echo getAnalisaTotalCutiByDayURL(getPastDate($date))?></td>
									</tr>
								
								
							
								</tbody>

							</table>