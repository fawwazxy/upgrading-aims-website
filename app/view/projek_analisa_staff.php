<?php
require "../model/projek_analisa_functions.php";
//require "../model/lookup.php";


$noic = $_GET['noic'];
$data_staff = getStaffByNoic($noic)->fetch_assoc();
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = date("Y-m-d");

//date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
$current_week = date("W",strtotime(date("n")));
$current_month = date("Ym");


//to get current week of the month
$firstDayOfMonth    = date("Y-m-1");
//$currentDate        = "2016-11-22";
$dtCurrent          = new \DateTime($current_date);
$dtFirstOfMonth     = new \DateTime($firstDayOfMonth);
$numWeeks           = 1 + ( intval($dtCurrent->format("W")) - 
                            intval($dtFirstOfMonth->format("W")));
if(strlen($numWeeks)<2){$numWeeks='0'.$numWeeks;}

$week = $_GET['week'];
if($week ==''){
	$week = $numWeeks;
		
}else{
	$week = $_GET['week'];
}

$select_month = $_GET['month'];
if($select_month ==''){
	$select_month = $date_year.$date_month;
	$month_only = $date_month;
	$year_only = $date_year;
}else{
	$select_month = $_GET['month'];
	$split_date=str_split($select_month, 4);
	$month_only =$split_date[1] ;
	$year_only = $split_date[0];
}

$start_date = $_GET['date'];
if($start_date==''){
	$start_date=$current_date;
}else{
	$start_date = $_GET['date'];
}

function highlightDay($day_no) {
	if ($day_no==date("w")) {
		echo 'bgcolor="yellow"';
	}
}

function getPastDate($count, $date_begin) {
	
	// --- Get global variables value
	$week = $GLOBALS['week'];
	$year = $GLOBALS['year_only'];
	$month = $GLOBALS['month_only'];
	$yearmonth = $year.'-'.$month;

	// --- Get day name
	switch($count)
	{
		case '0': $day = 'sunday'; break;
		case '1': $day = 'monday'; break;
		case '2': $day = 'tuesday'; break;
		case '3': $day = 'wednesday'; break;
		case '4': $day = 'thursday'; break;
		case '5': $day = 'friday'; break;
		case '6': $day = 'saturday'; break;
		default: $day = 'sunday'; break;
	}

	// --- Detect week and decide
	switch($week)
	{
		case '01': $date = date("Y-m-d", strtotime("first ".$day." of ".$yearmonth)); break;
		case '02': $date = date("Y-m-d", strtotime("second ".$day." of ".$yearmonth)); break;
		case '03': $date = date("Y-m-d", strtotime("third ".$day." of ".$yearmonth)); break;
		case '04': $date = date("Y-m-d", strtotime("fourth ".$day." of ".$yearmonth)); break;
		case '05': $date = date("Y-m-d", strtotime("fifth ".$day." of ".$yearmonth)); break;
		default: $date = date("Y-m-d", strtotime("first ".$day." of ".$yearmonth));  break;
	}

	// --- Get the day value (0-31)
	$getDay = intval(date('j', strtotime($date)));

	// --- If week is first, check if Sunday not fall on 01 of the month, thus it must be on 2nd week. 
	// --- Apply to other as well but increase by 1
	// --- If date get is not current month, then fetch previous month but on the fifth or fourth week, depends
	if($week == '01')
	{
		if( ($count == '0' && $getDay > 1) || ($count == '1' && $getDay > 2) || ($count == '2' && $getDay > 3) || ($count == '3' && $getDay > 4) || ($count == '4' && $getDay > 5) || ($count == '5' && $getDay > 6) )
		{
			$lastmonth = intval($month) - 1;
			if($nextMonth < 1)
			{
				$nextMonth = 12; // Month limit is 1 or 12, cannot be 0 or -1
			}
			if(strlen($lastmonth) < 2)
			{
				$lastmonth = '0'.$lastmonth;
			}
			$date = date("Y-m-d", strtotime("fifth ".$day." of ".$year.'-'.$lastmonth));

			$getMonth = intval(date('m', strtotime($date)));
			if($getMonth == $month)
			{
				$date = date("Y-m-d", strtotime("fourth ".$day." of ".$year.'-'.$lastmonth));
			}
		}
	}
	else if($week == '02') // --- Same concept as first week but different value (Refer calendar JUNE 2019)
	{
		if( ($count == '0' && $getDay > 8) || ($count == '1' && $getDay > 9) || ($count == '2' && $getDay > 10) || ($count == '3' && $getDay > 11) || ($count == '4' && $getDay > 12) || ($count == '5' && $getDay > 13) )
		{
			$date = date("Y-m-d", strtotime("first ".$day." of ".$yearmonth)); 
		}
	} 
	else if($week == '03') // --- Same concept as first week but different value (Refer calendar JUNE 2019)
	{
		if( ($count == '0' && $getDay > 15) || ($count == '1' && $getDay > 16) || ($count == '2' && $getDay > 17) || ($count == '3' && $getDay > 18) || ($count == '4' && $getDay > 19) || ($count == '5' && $getDay > 20) )
		{
			$date = date("Y-m-d", strtotime("second ".$day." of ".$yearmonth)); 
		}
	}
	else if($week == '04') // --- Same concept as first week but different value (Refer calendar JUNE 2019)
	{
		if( ($count == '0' && $getDay > 22) || ($count == '1' && $getDay > 23) || ($count == '2' && $getDay > 24) || ($count == '3' && $getDay > 25) || ($count == '4' && $getDay > 26) || ($count == '5' && $getDay > 27) )
		{
			$date = date("Y-m-d", strtotime("third ".$day." of ".$yearmonth)); 
		}
	}
	else if($week == '05') 
	{
		// --- Get the last date of the month as middle divider
		// --- Because not all day occur 5 times in a week
		// --- Some 4 some 5

		$lastdate = date("Y-m-t", strtotime($yearmonth)); // Get last date of the month
		$lastdateDay = date("w", strtotime($lastdate)); // 0 - 6

		$getMonth = date('m', strtotime($date)); // Get the month of decided week
		$nextMonth = (intval($month) + 1); // Get the next month value
		if($nextMonth > 12)
		{
			$nextMonth = $nextMonth % 12;	// Month limit is 12, cannot be 13
		}
		if(strlen($nextMonth) < 2)
		{
			$nextMonth = "0".$nextMonth;
		}

		// --- If month get from result > requested month, and the day is less than (e.g: Thursday > Friday) and the day is not Sunday
		// --- Then take the last month fourth week result
		if(intval($getMonth) > intval($month) && $count < ($lastdateDay + 1 ) && $lastdateDay != 0)
		{
			$date = date("Y-m-d", strtotime("fourth ".$day." of ".$yearmonth)); 
		}

		// --- If month get from result < next month, and the day is greater (e.g: Monday > Sunday)
		// --- Then take the next month first week result
		else if(intval($getMonth) < $nextMonth && $count > ($lastdateDay + 1 ))
		{
			$date = date("Y-m-d", strtotime("first ".$day." of ".$year.'-'.$nextMonth));
		}
	}

	return $date;
}


function isDateInRange($startDate, $endDate, $userDate)
{
	$startT = strtotime($startDate);
	$endT = strtotime($endDate);
	$userT = strtotime($userDate);
	return (($userT >= $startT) && ($userT <= $endT));
}

function getMonthString($num)
    {

          
      switch($num)
      {
        case 1:
          $month="Januari";
          break;
        case 2:
          $month="Februari";
          break;
        case 3:
          $month="Mac";
          break;
        case 4:
          $month="AprilL";
          break;
        case 5:
          $month="Mei";
          break;
        case 6:
          $month="Jun";
          break;
        case 7:
          $month="Julai";
          break;
        case 8:
          $month="Ogos";
          break;
        case 9:
          $month="September";
          break;
        case 10:
          $month="Oktober";
          break;
        case 11:
          $month="November";
          break;
        case 12:
          $month="Disember";
          break;
        default:
          $month="Invalid month";
      }
      return $month;
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php require "../global/header.php"; ?>    
<link href="../../js/jquery/jquery-ui.min.css" rel="stylesheet" type="text/css" />
     <!--<link href="../../js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>-->
     <script src="../../js/jquery/jquery-ui.min.js"></script>
<style type="text/css">
	td.a{
		padding-bottom: 15px;	}
	#menu {
		background: hsla(1,0%,100%,.9);
		position: absolute;
		top: 50;
		right: 0;
		left: 0;
		min-height: 100%;
		padding-top: 10px;
	}
	td.red{
		color: red;
	}
	td.green{
		color: green;
	}
	td.blue{
		color: blue;
	}
	td.orange{
		color: orange;
	}
	td.brown{
		color: brown;
	}td a {
		width: 100%;
		display: block;
		height: 100%;
	}
</style>

<script language="javascript" type="text/javascript">
// setInterval(function () {
    
//   location.reload();
     
    
// }, 30000);
setInterval(function () {
     var date = new Date();
    $('#timeRunningDate').html(moment().format('ddd MMM D YYYY, HH:mm:ss '));
       
    showTime();
}, 1000);

function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerHTML = time;
    document.getElementById("MyClockDisplay").textContent = time;
    //$('#timeRunningDate').html(time);
    
    

    //setTimeout(showTime, 1000);
    
}


</script>

</head>
<body id="refresh">

    

    <div class="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <table align="left" border="0" width="100%">
                    <tr bgcolor="yellow">
                        <td width="10%" align="right">
                        </td>
                        <td  align="center" width="70%" rowspan="2">
                            &nbsp;&nbsp;<strong><font size="5">ANALISA SEMASA TUGASAN <?if($noic==''){ echo 'STAF';}else if($noic!=''){ echo "<br>".$data_staff['name']." (".$data_staff['no_staff'].")";}?></font></strong>
                        </td>
                        <td width="60%">
                            <h1 align="right">
                                <font color="black">
                                    <div id="MyClockDisplay" class="clock"><? echo date('h:i:s A')?></div>
                                </font>
                            </h1>
                            <h4 align="right">
                                <font color="black">
                                    <span id="timeRunningDate"><? echo date('D M d Y, H:i:s ')?></span>
                                </font>
                            </h4>
                        </td>
                        <td width="30%">&emsp;&emsp;</td>
                    </tr>
                </table>
            </div>
        </nav>
        <br>
        <div class="col-lg-12">
        	<div class="col-lg-4">
        		
        	</div>
        	<div class="col-lg-4">
        		<label>Carian Staf : </label>
                <input type="text" placeholder="Sila masukkan nama/ no.staff/ no. kad pengenalan staf" class="form-control" name="carian" id="carian" value="<?if($noic!=''){echo $data_staff['no_staff'].' - '.$data_staff['name'];}?>" onfocus="javascript:$(this).autocomplete('search','');">
            	<input type="hidden" name="noic" id="noic" value="" /> 
        	</div>
        	<div class="col-lg-4">
        		<div align="left">
	        		<label>&emsp;</label><br><button class="btn btn-warning" onclick="window.location.href='../view/projek_analisa_staff.php'"><i class="fa fa-undo">&nbsp;Tetapan Semula </i></button>
	        	</div>
        	</div>
	        <script type="text/javascript">

	        	$(document).ready(function () {
	        		$('#carian').autocomplete({
			            source: function (request, result) {
			            	//alert(request.term);
			                $.ajax({
			                    url: "../model/projek_analisa_functions.php",
								data:{action:"staff_detail",search:request.term}, 
			                    type: "POST",
			                    dataType: "json",
			                    success: function(data) {
									result(data);
									console.log(data);
								},error: function(jqXHR, textStatus, errorThrown) {
					             	console.log(textStatus, errorThrown);
						        }
			                });
			            },
			             minLength: 0,
						  open: function() {

						  },
			            select: function (event, ui) {
							$('#carian').val(ui.item.label); // display the selected text
							$('#noic').val(ui.item.value);
							//alert(ui.item.value); // save selected id to input
							window.location.href="projek_analisa_staff.php?noic="+ui.item.value+"&month=<?echo $select_month?>&week=<?echo $week?>";
							return false;
						}
			        });

			    });

	        </script>
        </div>
        <br>
        <br>
        <br>
        <br>
	    <!--analisa week-->
	    <div class="col-lg-12">
		<!-- analisa_day-->

			<div class="col-lg-8">
        		<div class="panel panel-red">
					<div class="panel-heading">
						<center><b>Analisa Harian Tugasan (<? echo getMonthString($month_only); ?>)</b></center>
					</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th width="12.5%"></th>
								<th width="12.5%" <?php highlightDay(0); ?>><center>Ahad<br><?php echo date("d M Y",strtotime(getPastDate(0,$start_date)));?></center></th>
								<th width="12.5%" <?php highlightDay(1); ?>><center>Isnin<br><?php echo date("d M Y",strtotime(getPastDate(1,$start_date)));?></center></th>
								<th width="12.5%" <?php highlightDay(2); ?>><center>Selasa<br><?php echo date("d M Y",strtotime(getPastDate(2,$start_date)));?></center></th>
								<th width="12.5%" <?php highlightDay(3); ?>><center>Rabu<br><?php echo date("d M Y",strtotime(getPastDate(3,$start_date)));?></center></th>
								<th width="12.5%" <?php highlightDay(4);?>><center>Khamis<br><?php echo date("d M Y",strtotime(getPastDate(4,$start_date)));?></center></th>
								<th width="12.5%" <?php highlightDay(5);?>><center>Jumaat<br><?php echo date("d M Y",strtotime(getPastDate(5,$start_date)));?></center></th>
								<th width="12.5%" <?php highlightDay(6); ?>><center>Sabtu<br><?php echo date("d M Y",strtotime(getPastDate(6,$start_date)));?></center></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td><font color='red'><h4><strong>Untuk Pelaksanaan</strong></h4></font></td>
								<?for ($x = 0; $x < 7; $x++) {?>
								    <td <?php highlightDay($x); ?>><center><font color="red"><?php if($week ==$current_week && $select_month ==$current_month){echo getBilanganProjekDayStatus(getPastDate($x, $start_date),$kod_projek,$noic,'TODO');}else{echo getBilanganProjekDayStatus(getPastDate($x, $start_date),$kod_projek,$noic,'TODO');} ?></font></center></td>
								<?}?>
							</tr>
							<tr>
								<td><font color='orange'><h4><strong>Dalam Pelaksanaan</strong></h4></font></td>
								<?for ($y = 0; $y < 7; $y++) {?>
								    <td <?php highlightDay($y); ?>><center><font color="orange"><?php if($week ==$current_week && $select_month ==$current_month){echo getBilanganProjekDayStatus(getPastDate($y, $start_date),$kod_projek,$noic,'INPROGRESS');}else{echo getBilanganProjekDayStatus(getPastDate($y, $start_date),$kod_projek,$noic,'INPROGRESS');}  ?></font></center></td>
								<?}?>
							</tr>
							<tr>
								<td><font color='green'><h4><strong>Selesai</strong></h4></font></td>
								<?for ($z = 0; $z < 7; $z++) {?>
								    <td <?php highlightDay($z); ?>><center><font color="green"><?php if($week ==$current_week && $select_month ==$current_month){echo getBilanganProjekDayStatus(getPastDate($z, $start_date),$kod_projek,$noic,'DONE');}else{echo getBilanganProjekDayStatus(getPastDate($z, $start_date),$kod_projek,$noic,'DONE');}  ?></font></center></td>
								<?}?>
							</tr>
						</tbody>
					</table>
				</div>
        	</div>
        	
        	<div class="col-lg-4">
				<div class="panel panel-red">

					<div class="panel-heading">
						<center><b>Analisa Mingguan Tugasan (<? echo getMonthString($month_only); ?>)</b></center>
					</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<?  
								echo "<td></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = $month_only; // Month ID, 1 through to 12.
								$year = $year_only; // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 0;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
										$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="red";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="red";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<th width='100px'".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center>M ".$weeks."</center></a></th>";
										
										
									}else if($total_days== $i){
										$weeks ++;
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="red";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="red";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<th width='100px'".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center>M ".$weeks."</center></a></th>";
									}
								}
								?>
							
							</tr>
						</thead>
						<tbody>
							<tr>
							    
								
								<?  
								echo "<td><font color='red'><h4><strong>Untuk Pelaksanaan</strong></h4></font></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = $month_only; // Month ID, 1 through to 12.
								$year = $year_only; // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 0;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
										$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="red";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="red";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<td ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeekStatus($_first, $_last,$kod_projek,$noic,'TODO')
										."</strong></h4></font></center></a></td>";
										
										
									}else if($total_days== $i){
										$weeks ++;
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="red";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="red";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<td ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeekStatus($_first, $_last,$kod_projek,$noic,'TODO')
										."</strong></h4></font></center></a></td>";
									}
								}
								?>
							</tr>
							<tr>
							    
								
								<?  
								echo "<td><font color='orange'><h4><strong>Dalam Pelaksanaan</strong></h4></font></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = $month_only; // Month ID, 1 through to 12.
								$year = $year_only; // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 0;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
								
										$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="orange";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="orange";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<td ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeekStatus($_first, $_last,$kod_projek,$noic,'INPROGRESS')
										."</strong></h4></font></center></a></td>";
										
										
									}else if($total_days== $i){
										$weeks ++;
										$firstofweek=$firstofweek+1;
										$_first=$year."-".$month."-".$firstofweek;
										//$_first=$year."-".$month."-".$firstofweek;
										//$firstofweek=$i;
										$_last=$year."-".$month."-".($i);$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="orange";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="orange";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<td ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeekStatus($_first, $_last,$kod_projek,$noic,'INPROGRESS')
										."</strong></h4></font></center></a></td>";
									}
								}
								?>
							</tr>
							<tr>
							    
								
								<?  
								echo "<td><font color='green'><h4><strong>Selesai</strong></h4></font></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = $month_only; // Month ID, 1 through to 12.
								$year = $year_only; // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 0;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
								
										$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="green";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="green";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<td ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeekStatus($_first, $_last,$kod_projek,$noic,'DONE')
										."</strong></h4></font></center></a></td>";
										
										
									}else if($total_days== $i){
										$weeks ++;
										$firstofweek=$firstofweek+1;
										$_first=$year."-".$month."-".$firstofweek;
										//$_first=$year."-".$month."-".$firstofweek;
										//$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";
										if($week==$weeks){$_bgcolor = " bgcolor=\"#DAF7A6\"";$_fcolor="green";}
										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="green";}
										if(strlen($weeks)<2){$week_chosen='0'.$weeks;}
										echo "<td ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_month."&week=".$week_chosen."'><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeekStatus($_first, $_last,$kod_projek,$noic,'DONE')
										."</strong></h4></font></center></a></td>";
									}
								}
								?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
	        
        </div>

	    <div class="col-lg-12">
	    	<div class="col-lg-7">
		        <div class="panel panel-red">
					<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Bulan Tugasan</b></center>
					</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
								<?  
									echo "<td></td>";
									$months = array("Jan", "Feb", "Mac","Apr","Mei","Jun","Jul","Ogos","Sep","Okt","Nov","Dis");
									$arrlength = count($months);
									//echo $start_date;
									//$previous_week = strtotime($start_date." ".$week."week");
									//$start_week = strtotime("last sunday",$previous_week);
									//$end_week = strtotime("next saturday",$start_week);

									//$start_week = date("Y-m-d",$start_week);
									//$end_week = date("d",$end_week);

									//echo '<br>'.$start_week.' to '.$end_week ;

									for ($i = 0; $i < $arrlength; $i++)
									{

											
											$_bgcolor = "";
											
											if(strlen(intval($i+1))==1){
												$select_months = $date_year.'0'.intval($i+1);
												$bulan = '0'.($i+1);

											}else if(strlen(intval($i+1))==2){
												$select_months = $date_year.intval($i+1);
												$bulan = ($i+1);
											}
											if($select_months == $select_month){
												$_bgcolor = " bgcolor=\"#DAF7A6\"";
											}
											if(intval($i) == intval($date_month-1)) {$_bgcolor = " bgcolor=\"yellow\"";}
											
											
											echo "<th ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$select_months."&week=".$week."'><center>".$months[$i]."</center></a></th>";
									}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
								   <?  
								   echo "<th width='20%'><font color='red'><h4><strong>Untuk Pelaksanaan</strong></h4></font></th>";
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										$noofmonth = "";
										if(strlen($i+1)==1) {
											$noofmonth = $date_year.'0'.($i+1);
											$bulan = '0'.($i+1);
										}else{
											$noofmonth = $date_year.''.($i+1);
											$bulan = ($i+1);
										}
											$_fcolor = "blue";
											$_bgcolor = "";
											if($noofmonth == $select_month){
												$_bgcolor = " bgcolor=\"#DAF7A6\"";
												$_fcolor="green";
											}
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="red";}
											
											echo "<td width='6.67%' ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$noofmonth."&week=".$week."'><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekMonthStatus($noofmonth,$kod_projek,$noic,'TODO')."</strong></h4></center></font></a></td>";
									}
									?>
								</tr>
								<tr>
								   <?  
								   echo "<th width='20%'><font color='orange'><h4><strong>Dalam Pelaksanaan</strong></h4></font></th>";
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										$noofmonth = "";
										if(strlen($i+1)==1) {
											$noofmonth = $date_year.'0'.($i+1);
											$bulan = '0'.($i+1);
										}else{
											$noofmonth = $date_year.''.($i+1);
											$bulan = ($i+1);
										}
											$_fcolor = "blue";
											$_bgcolor = "";
											if($noofmonth == $select_month){
												$_bgcolor = " bgcolor=\"#DAF7A6\"";
												$_fcolor="orange";
											}
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="orange";}
											
											echo "<td width='6.67%' ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$noofmonth."&week=".$week."'><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekMonthStatus($noofmonth,$kod_projek,$noic,'INPROGRESS')."</strong></h4></center></font></a></td>";
									}
									?>
								</tr>

								<tr>
								   <?  
								   echo "<th width='20%'><font color='green'><h4><strong>Selesai</strong></h4></font></th>";
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										$noofmonth = "";
										if(strlen($i+1)==1) {
											$noofmonth = $date_year.'0'.($i+1);
											$bulan = '0'.($i+1);
										}else{
											$noofmonth = $date_year.''.($i+1);
											$bulan = ($i+1);
										}
											$_fcolor = "blue";
											$_bgcolor = "";
											if($noofmonth == $select_month){
												$_bgcolor = " bgcolor=\"#DAF7A6\"";
												$_fcolor="green";
											}
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="green";}

											echo "<td width='6.67%' ".$_bgcolor."><a href='../view/projek_analisa_staff.php?noic=".$noic."&month=".$noofmonth."&week=".$week."'><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekMonthStatus($noofmonth,$kod_projek,$noic,'DONE')."</strong></h4></center></font></a></td>";
									}
									?>
								</tr>
							</tbody>
						</table>
					
					<!-- /.panel-body -->
				</div>
			</div>
	        <!-- analisa_year-->
	        <div class="col-lg-5">
		        <div class="panel panel-red">
					<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Tahunan Tugasan</b></center>
					</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									
								<?
									echo "<th width='40%'></th>";
									for ($i = 0; $i < 4; $i++)
									{
										
											$_bgcolor = "";
											if($i == 0) $_bgcolor = " bgcolor=\"yellow\"";
											echo "<th width='15%' ".$_bgcolor."><center>".($date_year-$i)."</center></th>";
									}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
								   <?
									echo "<td><font color='red'><h4><strong>Untuk Pelaksanaan</strong></h4></font></td>";
									for ($i = 0; $i < 4; $i++)
									{
											$_bgcolor = "";
											$_fcolor = "blue";
											if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="red";}
											echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekYearStatus(($date_year-$i),$kod_projek,$noic,'TODO')."</h4></strong></center></font></td>";
									}
									?>
								</tr>
								<tr>
								   <?
									echo "<td><font color='orange'><h4><strong>Dalam Pelaksanaan</strong></h4></font></td>";
									for ($i = 0; $i < 4; $i++)
									{
											$_bgcolor = "";
											$_fcolor = "blue";
											if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="orange";}
											echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekYearStatus(($date_year-$i),$kod_projek,$noic,'INPROGRESS')."</h4></strong></center></font></td>";
									}
									?>
								</tr>
								<tr>
								   <?
									echo "<td><font color='green'><h4><strong>Selesai</strong></h4></font></td>";
									for ($i = 0; $i < 4; $i++)
									{
											$_bgcolor = "";
											$_fcolor = "blue";
											if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="green";}
											echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekYearStatus(($date_year-$i),$kod_projek,$noic,'DONE')."</h4></strong></center></font></td>";
									}
									?>
								</tr>
							</tbody>
						</table>
					
					<!-- /.panel-body -->
				</div>
			</div>
	    </div>

        <br>
        <div class="footer-section">
            <div class="copy-section">
                <!--<div class="container">-->
                    <center>
                        <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
                        Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a></p>
                    </center>
                <!--</div>-->
            </div>
        </div>
        
    </div>

</body>
</html>