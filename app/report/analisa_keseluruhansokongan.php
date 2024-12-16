<?php
require "../model/support_function.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));

$tahun=date('Y');
$bulan=date('m');

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

   $nama_projek = $_GET['nama_projek'];
?>

<style>
	<style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 1px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  .header-right {
    float: none;
  }
}
</style>


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
      <script src="../../js/highcharts/highcharts.js"></script>
    <script src="../../js/highcharts/modules/exporting.js"></script>
    <script src="../../js/highcharts/modules/export-data.js"></script>



</head>
<body  >
	<div class="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="header">
  <a href="<? echo $sys['sys_domain']; ?>" class="logo"><? $com = getCompany()->fetch_assoc();
           echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:10%;"/>';?></a>

        <h1 style="font-size:40px;font-family:Comic Sans MS">Analisa Tiket Aduan Keseluruhan</h1>

         
  <div class="header-right">
 
  </div>
</div>
		<br>
					
			

<br><br>

		
		<br>
		<!-- Table Sasaran Jualan -->
		<div class="col-lg-12">
			<div class="panel panel-red" >
				<!-- /.panel-heading -->
				<div class="panel-heading">
					
				</div>
				<table width="50%" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
							<th width="40%">Sistem</th>
							<th width="40%"><center>Bilangan</center></th>
							<th width="20%"><center>Jumlah Tidak Terima Sokongan</center></th>
						</tr>
					</thead>
				
					<tbody>
						<!-- dapatkan maklumat aduan berdasarkan projek (start)-->
						<? $data=getNamaSistem();
							while ($list=$data->fetch_assoc()){
						?>
						<tr>
							<td>
								<?php echo $list['kod_projek'].' - '.$list['nama_projek']; ?>
							</td>
							<td>
								<b>Jumlah keseluruhan aduan : <?php echo $list['bilangan_projek']; ?><br></b>
									<?
	                                    $i= 1;
	                                    $row_data = getcountStatus($list['kod_projek']);
	                                    while($list_data = $row_data->fetch_assoc()) {
	                                    	echo $list_data['keterangan']." : ".$list_data['countST']."<br>"; 
	                                    }
	                                ?>
							</td>
							<td>
								<center><b><font color="red" size="100px"><?echo getCountRejected('',$list['kod_projek']);?></font></b></center>
							</td>
						</tr>
						<?}?>
						<!-- dapatkan maklumat aduan berdasarkan projek (end)-->
					</tbody>
				</table>
			</div>
			
			<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>Aduan Mingguan (<? echo date("F"); ?>)</b></center>
				</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
							<?  
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
										//$_fcolor = "blue";
										$_bgcolor = "";
										if(isDateInRange($_first, $_last, $date)) $_bgcolor = " bgcolor=\"yellow\"";
										echo "<th ".$_bgcolor."><center>M".$weeks."</center></th>";
										//$weeks ++;
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										echo "<th width=\"20%\"><center>M".$weeks."</center></th>";
										$weeks ++;
									}
								}
								?>
							</tr>
						</thead>
							<tbody>
							<tr>
							    
								
								<?  
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
										//$_fcolor = "blue";
										$_bgcolor = "";
										if(isDateInRange($_first, $_last, $date)) $_bgcolor = " bgcolor=\"yellow\"";
										echo "<td ".$_bgcolor."><center><b>".getWeekAduanAll($_first,$_last)."</b></center></td>";
										
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										echo "<td width=\"20%\"><center><b>".getWeekAduanAll($_first,$_last)."</b></center></td>";
									}
								}
								?>
							</tr>
						</tbody>
					</table>
				
				<!-- /.panel-body -->
			</div>
			<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>Aduan Bulanan</b></center>
				</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
							<?  
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
										
										
										echo "<th ".$_bgcolor."><center>".$months[$i]."</center></a></th>";
								}
								?>
							</tr>
						</thead>

						<tbody>
							<tr>
								<?
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
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="red";}
											echo "<td width='6.67%' ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getTotalAduanBulan($noofmonth)."</strong></h4></center></font></td>";
									}
								?>
							</tr>
						</tbody>
					</table>
				<!-- /.panel-body -->
			</div>


			<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>Tahunan</b></center>
				</div>
				<table width="100%" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							
						<?
							for ($i = 0; $i < 7; $i++)
							{
								$_bgcolor = "";
								$_fcolor = "black";
								if($i == 0) {$_bgcolor = " bgcolor=\"yellow\"";$_fcolor="blue";}
								echo "<th width='15%' ".$_bgcolor."><font color='".$_fcolor."'><center>".($date_year-$i)."</center></font></th>";
							}
							?>
						</tr>
					</thead>
					<tbody>
						<tr>
						   <?
							for ($i = 0; $i < 7; $i++)
							{
								$_bgcolor = "";
								$_fcolor = "blue";
								if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="red";}
								echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getTotalAduanTahunAll($date_year-$i)."</h4></strong></center></font></td>";
							}
							?>
						</tr>
					</tbody>
				</table>
			<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>


        <div class="row">
            <div class="col-lg-12">
                <!--h1 class="page-header">Pemasaran</h1-->
            </div>
        </div>
                <div class="row">
                <div class="col-lg-12">

                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



        



  <script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Analisa Kesuluruhan'
    },
    xAxis: {
        categories: [<?echo getSystem_report().",";?>]
    },
    yAxis: {
        title: {
            text: ''
        }

    },
    legend: {
        enabled: true
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> daripada keseluruhan<br/>'
    },
    series: [
            <?

         $datas = getSupportStatus();
         $curr_count= 0;
         while($list = $datas->fetch_assoc()) {
             //echo $list['description'];
             if($curr_count > 0) echo ",";
             echo "{";
             echo "name: '".$list['keterangan']."',";
             echo "data:[";
            $datas_n = getCountSupportX();
                 $j=0;
                 while($listN = $datas_n->fetch_assoc()) {
                     if($j > 0) echo ",";
                     echo getCountSupportY($list['status_tindakan'],$listN['kod_projek']);
                     $j++;
                 }
             echo "]";  
             echo "}"; 
             $curr_count++;
         }
     ?>
    ]

});
        </script>



        

                </div>
                <!-- /.col-lg-12 -->
            </div>
           

                <!-- /.row -->
            <!-- /.container-fluid -->
      


		<div class="footer-section">
			<div class="copy-section">
				<!--<div class="container">-->
					<!-- <center>
						<p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
						Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
					</center> -->
				<!--</div>-->
			</div>
		</div>
		
	</div>

</body>
</html>