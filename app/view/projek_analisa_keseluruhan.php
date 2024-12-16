<?php
require "../model/projek_analisa_functions.php";
//require "../model/lookup.php";
//$kod_projek = $_GET['kod_projek'];
//$data_projek = getProjectByKod($kod_projek)->fetch_assoc();
//$noic = $_GET['noic'];
//$data_staff = getStaffByNoic($noic)->fetch_assoc();
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;

//date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));

function highlightDay($day_no) {
	if ($day_no==date("w")) {
		echo 'bgcolor="yellow"';
	}
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
                            &nbsp;&nbsp;<strong><font size="5">ANALISA SEMASA PROJEK</font></strong>
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
        	<div class="col-lg-7">
        		<div class="panel panel-red">
				<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Harian Projek(<? echo date("F"); ?>)</b></center>
					</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th width="12.5%"></th>
								<th width="12.5%" <?php highlightDay(0); ?>><center>Ahad<br><?php echo date("d M Y",strtotime(getPastDate(0))); ?></center></th>
								<th width="12.5%" <?php highlightDay(1); ?>><center>Isnin<br><?php echo date("d M Y",strtotime(getPastDate(1))); ?></center></th>
								<th width="12.5%" <?php highlightDay(2); ?>><center>Selasa<br><?php echo date("d M Y",strtotime(getPastDate(2))); ?></center></th>
								<th width="12.5%" <?php highlightDay(3); ?>><center>Rabu<br><?php echo date("d M Y",strtotime(getPastDate(3))); ?></center></th>
								<th width="12.5%" <?php highlightDay(4); ?>><center>Khamis<br><?php echo date("d M Y",strtotime(getPastDate(4))); ?></center></th>
								<th width="12.5%" <?php highlightDay(5); ?>><center>Jumaat<br><?php echo date("d M Y",strtotime(getPastDate(5))); ?></center></th>
								<th width="12.5%" <?php highlightDay(6); ?>><center>Sabtu<br><?php echo date("d M Y",strtotime(getPastDate(6))); ?></center></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td><font color='blue'><h5><strong>Bil. Projek</strong></h5></font></td>
								<?for ($x = 0; $x < 7; $x++) {?>
								    <td <?php highlightDay($x); ?>><center><font color="blue"><h5><?php echo getBilanganProjekDay(getPastDate($x)); ?></h5></font></center></td>
								<?}?>
							</tr>
							<tr>
								<td><font color='#1E8449'><h5><strong>Bil. Sub Projek</strong></h5></font></td>
								<?for ($x = 0; $x < 7; $x++) {?>
								    <td <?php highlightDay($x); ?>><center><font color="#1E8449"><h5><?php echo getBilanganSubProjekDay(getPastDate($x)); ?></h5></font></center></td>
								<?}?>
							</tr>
						</tbody>
					</table>
				<!-- /.panel-body -->
				</div>
        	</div>
        	<div class="col-lg-5">
				<div class="panel panel-red">
				<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Mingguan Projek (<? echo date("F"); ?>)</b></center>
					</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
							<?  
								echo "<th width='27%'></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = date('n'); // Month ID, 1 through to 12.
								$year = date('Y'); // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 1;
								$firstofweek = 1;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									// if($day == strtolower($rollover)){  
										// $weeks ++;
										// $_first=$year."-".$month."-".$firstofweek;
										// $firstofweek=$i+1;
										// $_last=$year."-".$month."-".($i);
										
										// if(isDateInRange($_first, $_last, $date) ){
										// echo "<th bgcolor=\"yellow\"><center>M".$weeks."</center></th>";
										// }else{
										// echo "<th><center>M".$weeks."</center></th>";
										// }
										
									// }
									if($day == strtolower($rollover)){  
										//$weeks ++;
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_bgcolor = "";
										if(isDateInRange($_first, $_last, $date)) $_bgcolor = " bgcolor=\"yellow\"";
										echo "<th width='100px'".$_bgcolor."><center>Minggu ".$weeks."</center></th>";
										$weeks ++;
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i+1;
										$_last=$year."-".$month."-".($i);
										echo "<th><center>Minggu ".$weeks."</center></th>";
										$weeks ++;
									}
								}
								?>
							</tr>
						</thead>
						<tbody>
							<tr>
							    
								
								<?  
								echo "<td><font color='blue'><h4><strong>Bil. Projek</strong></h4></font></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = date('n'); // Month ID, 1 through to 12.
								$year = date('Y'); // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 1;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
								
										//$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";

										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="#884EA0";}
										echo "<td ".$_bgcolor."><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeek($_first, $_last)
										."</strong></h4></font></center></td>";
										
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);$_fcolor = "blue";
										$_bgcolor = "";

										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="#884EA0";}
										echo "<td ".$_bgcolor."><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganProjekWeek($_first, $_last)
										."</strong></h4></font></center></td>";
									}
								}
								?>
							</tr>
							<tr>
							    
								
								<?  
								echo "<td><font color='#1E8449'><h4><strong>Bil. Sub Projek</strong></h4></font></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = date('n'); // Month ID, 1 through to 12.
								$year = date('Y'); // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 1;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
								
										//$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "#1E8449";
										$_bgcolor = "";

										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="#884EA0";}
										echo "<td ".$_bgcolor."><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganSubProjekWeek($_first, $_last)
										."</strong></h4></font></center></td>";
										
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);$_fcolor = "#1E8449";
										$_bgcolor = "";

										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="#884EA0";}
										echo "<td ".$_bgcolor."><center><font color='".$_fcolor."'><h4><strong>".
										getBilanganSubProjekWeek($_first, $_last)
										."</strong></h4></font></center></td>";
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
						<center><b>Analisa Bulan Projek</b></center>
					</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
								<?  
									echo "<td></td>";
									$months = array("Jan", "Feb", "Mac","Apr","Mei","Jun","Jul","Ogos","Sep","Okt","Nov","Dis");
									$arrlength = count($months);
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										
											$_bgcolor = "";
											if(intval($i) == intval($date_month-1)) $_bgcolor = " bgcolor=\"yellow\"";
											echo "<th ".$_bgcolor."><center>".$months[$i]."</center></th>";
									}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
								   <?  
								   echo "<th width='20%'><font color='blue'><h4><strong>Bil. Projek</strong></h4></font></th>";
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										$noofmonth = "";
										if(strlen($i+1)==1) {
											$noofmonth = $date_year.'0'.($i+1);
										}else{
											$noofmonth = $date_year.''.($i+1);
										}
											$_fcolor = "blue";
											$_bgcolor = "";
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="#884EA0";}
											echo "<td width='6.67%' ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekMonth($noofmonth)."</strong></h4></center></font></td>";
									}
									?>
								</tr>
								<tr>
								   <?  
								   echo "<th width='20%'><font color='#1E8449'><h4><strong>Bil. Sub Projek</strong></h4></font></th>";
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										$noofmonth = "";
										if(strlen($i+1)==1) {
											$noofmonth = $date_year.'0'.($i+1);
										}else{
											$noofmonth = $date_year.''.($i+1);
										}
											$_fcolor = "#1E8449";
											$_bgcolor = "";
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="#884EA0";}
											echo "<td width='6.67%' ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getBilanganSubProjekMonth($noofmonth)."</strong></h4></center></font></td>";
									}
									?>
								</tr>
							</tbody>
						</table>
					
					<!-- /.panel-body -->
				</div>
			</div>
	        <div class="col-lg-5">
		        <div class="panel panel-red">
					<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Tahunan Projek</b></center>
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
									echo "<td><font color='blue'><h4><strong>Bil. Projek</strong></h4></font></td>";
									for ($i = 0; $i < 4; $i++)
									{
											$_bgcolor = "";
											$_fcolor = "blue";
											if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="#884EA0";}
											echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getBilanganProjekYear(($date_year-$i))."</h4></strong></center></font></td>";
									}
									?>
								</tr>
								<tr>
								   <?
									echo "<td><font color='#1E8449'><h4><strong>Bil. Sub Projek</strong></h4></font></td>";
									for ($i = 0; $i < 4; $i++)
									{
											$_bgcolor = "";
											$_fcolor = "#1E8449";
											if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="#884EA0";}
											echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getBilanganSubProjekYear(($date_year-$i))."</h4></strong></center></font></td>";
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
        <script type="text/javascript">
        	$(document).ready(function() {
        
				$("#kod_projek").change(function(){

					var selected_projek=$(this).val();
					sendProject(selected_projek);
				});

				$("#noic").change(function(){

					var selected_staff=$(this).val();
					sendStaff(selected_staff);
				});
				/*
				$("#jabatan").change(function(){
					if($("#cawangan_kod").val()==''){
						alert('SILA PILIH CAWANGAN DAHULU!');
						$("#jabatan").val('');
					}else{
						var selected_jabatan=$(this).val();
						var cawangan = $("#cawangan_kod").val();
						sendType2(selected_jabatan,cawangan);
					}
				});
				*/

			});
			function sendProject(project)
			{
				window.location.href="projek_analisa_keseluruhan.php?kod_projek="+project;
			}
			function sendStaff(noic)
			{
				window.location.href="projek_analisa_keseluruhan.php?noic="+noic;
			}
			/*
			function sendType2(jabatan,cawangan)
			{
				window.location.href="analisa_kakitangan_tidak_hadir_semasa.php?cawangan_kod="+cawangan+"&jabatan="+jabatan;
			}
			*/

        </script>
    </div>

</body>
</html>