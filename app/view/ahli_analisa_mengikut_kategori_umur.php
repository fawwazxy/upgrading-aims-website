<?php
require "../model/ahli_functions.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));
$current_date=date("Y-m-d");
$tahun=date("Y");
$bulan=date("m");

$kelab=getKelabPersatuanInfoById(1)->fetch_assoc();


function highlightDay($day_no) {
	if ($day_no==date("w")) {
		echo 'bgcolor="yellow"';
	}
}
function highlightMonth($month_no) {
	if ($month_no==date("m")) {
		echo 'bgcolor="yellow"';
	}
}
function getMonthString($num)
    {

          
      switch($num)
      {
        case 1:
          $month="JANUARI";
          break;
        case 2:
          $month="FEBRUARI";
          break;
        case 3:
          $month="MAC";
          break;
        case 4:
          $month="APRIL";
          break;
        case 5:
          $month="MEI";
          break;
        case 6:
          $month="JUN";
          break;
        case 7:
          $month="JULAI";
          break;
        case 8:
          $month="OGOS";
          break;
        case 9:
          $month="SEPTEMBER";
          break;
        case 10:
          $month="OKTOBER";
          break;
        case 11:
          $month="NOVEMBER";
          break;
        case 12:
          $month="DISEMBER";
          break;
        default:
          $month="Invalid month";
      }
      return $month;
    }


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

function getWeekCount() {
	if ($count<=date("w")) {
		$count=date("w")-$count;
		$date = strtotime("-".$count." day", strtotime(date('d M Y')));
		echo date('d M Y', $date);
	}
}
function getLastWeekPreviousMonth(){
	$date= new DateTime();
	$date->modify("last day of previous month");
    return $date->format("W");
	
}
function getThisWeek(){
	$date= new DateTime();
	$week_no=date("W");
	return $week_no - getLastWeekPreviousMonth();
}
function isDateInRange($startDate, $endDate, $userDate)
   {
    $startT = strtotime($startDate);
    $endT = strtotime($endDate);
    $userT = strtotime($userDate);
   return (($userT >= $startT) && ($userT <= $endT));
   }
// function start_day_of_week(){
			
		// $first_day_of_the_week = 'Sunday';
		// $start_of_the_week     = strtotime("Last $first_day_of_the_week");
		// if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
		// {
			// $start_of_the_week = strtotime('today');
		// }
		// $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
		// $date_format =  'Y-m-d';
		
		// return date($date_format, $start_of_the_week);
		
// }
// function last_day_of_week(){
			
		// $first_day_of_the_week = 'Sunday';
		// $start_of_the_week     = strtotime("Last $first_day_of_the_week");
		// if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
		// {
			// $start_of_the_week = strtotime('today');
		// }
		// $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
		// $date_format =  'Y-m-d';
		
		// return date($date_format, $end_of_the_week);
		
// }
// function getWeeks($date, $rollover)
    // {
        // $cut = substr($date, 0, 8);
        // $daylen = 86400;

        // $timestamp = strtotime($date);
        // $first = strtotime($cut . "00");
        // $elapsed = ($timestamp - $first) / $daylen;

        // $weeks = 1;

        // for ($i = 1; $i <= $elapsed; $i++)
        // {
            // $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            // $daytimestamp = strtotime($dayfind);

            // $day = strtolower(date("l", $daytimestamp));

            // if($day == strtolower($rollover))  $weeks ++;
        // }

        // return $weeks;
    // }


    // //
   
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
	
  <script src="../../js/jquery/moment.js"></script>

<style>
	td.headColor {
  		background-color: #E16300;
  		color: white;
  		font-weight: bold;
	}
</style>

<script language="javascript" type="text/javascript">
setInterval(function () {
    
   location.reload();
     
    
 }, 30000);
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
					    <td width="10%" align="center">
                            <? 
                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $kelab['logo'] ).'" style="height: 100px;"/>';
                        ?>
                        </td>
						<td width="50%" rowspan="2">
							<b>
				                <font size="6"><? echo $kelab['nama'];?></font><br>
				                <font size="4"><? echo $kelab['alamat']?></font><br>
				                <font size="4">Hotline:&nbsp;<? echo $kelab['tel']?></font><br><br>
							</b>
						</td>
						<td width="60%">
							<h1 align="right">
								<font color="blue">
									<div id="MyClockDisplay" class="clock"><? echo date('h:i:s A')?></div>
								</font>
							</h1>
							<h4 align="right">
								<font color="blue">
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
		<!-- Table Sasaran Jualan -->
		<div class="col-lg-12">
			

	
			<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>ANALISA AHLI</b></center>
				</div>
				<table width="100%" class="table  table-bordered">
					
					
					<tbody>
						<tr>
						<?
								$status =  getStatusAhli();
								$arr_status=array();
								while($list_status = $status->fetch_assoc()) { 
									$arr_status[] = $list_status['kod'];
							?> 
								<td align="center" class="headColor" ><? echo $list_status['keterangan']." (".$list_status['kod'].")";?></td>
							<?}?>
							<td align="center" class="headColor">JUM. KESELURUHAN</td>
						
						</tr>
						<tr>
							<?
							foreach ($arr_status as $value) {
							 $jum_keseluruhan+=getBilAhliBYStatus($value);
							?>
								<td align="center"><strong><font size="6"><? echo getBilAhliBYStatus($value);?></font></strong></td>
							<?}?>
							<td align="center"><strong><font size="6"><? echo $jum_keseluruhan;?></font></strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-12">
		<? 
			$i=1;
			$kategori =  getKategoriUmur();
			while($list_kategori = $kategori ->fetch_assoc()) { 
		?>
		<div class="col-lg-4">
			<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>ANALISA AHLI KATEGORI <?echo strtoupper($list_kategori['keterangan']." ( ".$list_kategori['ahli_kategori']." )");?></b></center>
				</div>
				<table width="100%" class="table  table-bordered">
					
					
					<tbody>
						<tr>
						<?
								$status =  getStatusAhli();
								$arr_status=array();
								while($list_status = $status->fetch_assoc()) { 
									$arr_status[] = $list_status['kod'];
							?> 
								<td align="center" class="headColor" style="font-size: 10px;"><? echo $list_status['keterangan']." (".$list_status['kod'].")";?></td>
							<?}?>
							<td align="center" class="headColor" style="font-size: 10px;">JUM. KESELURUHAN</td>
						
						</tr>
						<tr>
							<?
							foreach ($arr_status as $value) {
							$jumlah="jum".$i;
							$$jumlah+=getBilAhliBYStatusAndUmur($value,$list_kategori['kod']);
							?>
								<td align="center"><strong><font size="4"><? echo getBilAhliBYStatusAndUmur($value,$list_kategori['kod']) ;?></font></strong></td>
							<?}?>
							<td align="center"><strong><font size="4"><? echo $$jumlah;?></font></strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?$i++;}?>
	</div>
		<div class="footer-section">
			<div class="copy-section">
				<!--<div class="container">-->
					<center>
						<p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
						Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
					</center>
				<!--</div>-->
			</div>
		</div>
		
	</div>
</body>
</html>