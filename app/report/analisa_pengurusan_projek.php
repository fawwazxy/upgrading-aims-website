<?php
require "../model/project_management_function.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
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

   
 ?>

 <?      
           

           $id_pesanan_belian = $_GET['id_pesanan_belian'];
 


        
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
           echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:15%;"/>';?></a>

        <h1 style="font-size:60px;">Analisa Pengurusan Projek</h1>

         
  <div class="header-right">
 
  </div>
</div>
		<br>
					<table style="width:100%;height:200px;border:6px solid #CD5C5C;"   >
						<tr>
			
						<?

						//$data = getSupportNamaProjek($nama_projek)->fetch_assoc();



						?>

						<td style="border:6px solid #CD5C5C; " >
						
						<div class="col-lg-12" style="float: left;">
						
						<h3>Syarikat : <?echo $sys['sys_owner']?></h3>
						<h3>Tarikh : <? echo "" . date("Y-m-d") . "<br>";?>

						</div>  

						
					</td>

					<td> <th style="font-size:100px;" ><center><?
						$siap = getTotalSelesai();
						$total= getTotalProject();
						$percent=($siap*100)/$total;
						echo round($percent) ;
						?>%

					</center></th>
					</td>
					</tr>
				</table> 

<br><br>

		
		<br>
		<!-- Table Sasaran Jualan -->
		<div class="col-lg-12">
			<div class="panel panel-red" >
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>Bilangan Projek</b></center>
				</div>
				<table width="50%" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
							<th width="50%"></th>
							<th width="50%"><center>Bilangan</center></th>
						</tr>
					</thead>
				
					<tbody>
						<tr>
							<th><h3>Jumlah Projek</h3></th>
							<td><center><h3><?echo getTotalProject(); ?></h3></center></td>
						</tr>
						<tr>
							<th>Selesai</th>
							<td><center><? echo getTotalSelesai(); ?></center></td>
						</tr>
						
						<tr>
							<th>Dalam Pelaksanaan</th>
							<td><center><? echo getTotalDalamPelaksanaan(); ?></center></td>
						</tr>
						<tr>
							<th>Dalam Penerimaan</th>
							<td><center><? echo getTotalDalamPenerimaann(); ?></center></td>
						</tr>
						
					</tbody>
				</table>
			</div>
			
			<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>Projek Mingguan (<? echo date("F"); ?>)</b></center>
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
										echo "<th ".$_bgcolor."><center>M".$weeks."</center></th>";
										$weeks ++;
										
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

								$weeks = 1;
								$firstofweek = 1;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
										//$weeks ++;
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_bgcolor = "";
										if(isDateInRange($_first, $_last, $date)) $_bgcolor = " bgcolor=\"yellow\"";
										echo "<td ".$_bgcolor."><center>".getWeekProject($_first,$_last)."</center></td>";
										
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										echo "<td width=\"20%\"><center>".getWeekProject($_first,$_last)."</center></td>";
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
					<center><b>Projek Bulanan</b></center>
				</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
							<th>Jan.</th>
							<th>Feb.</th>
							<th>Mac</th>
							<th>April</th>
							<th>May</th>
							<th>Jun</th>
							<th>Julai</th>
							<th>Ogos</th>
							<th>Sept</th>
							<th>Okt.</th>
							<th>Nov.</th>
							<th>Dis</th>
							</tr>
						</thead>
						<tbody>
							<tr>
							<td><?echo getTotalJan()?></td>
							<td><?echo getTotalFeb()?></td>
							<td><?echo getTotalMarch()?></td>
							<td><?echo getTotalApril()?></td>
							<td><?echo getTotalMay()?></td>
							<td><?echo getTotalJune()?></td>
							<td><?echo getTotalJuly()?></td>
							<td><?echo getTotalAugust()?></td>
							<td><?echo getTotalSept()?></td>
							<td><?echo getTotalOct()?></td>
							<td><?echo getTotalNov()?></td>
							<td><?echo getTotalDec()?></td>
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
	$date = new DateTime();
	$current_date=$date->format('d-m-Y');
    $crt_dt = date_format($date,"D d-F-Y");
	//$month = date_format($date,"F Y");
    //$bulan = date_format($date,"m");
	$tahuncurr = date_format($date,"Y");
	


	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun1 = date_format($date,"Y");
	
	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun2 = date_format($date,"Y");
	
	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun3 = date_format($date,"Y");
	

	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun4 = date_format($date,"Y");
	
	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun5 = date_format($date,"Y");
	

	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun6 = date_format($date,"Y");
	
	
	

?> 
						<th><? echo $tahuncurr ?></th>
						<th><? echo $tahun1 ?></th>
						<th><? echo $tahun2 ?></th>
						<th><? echo $tahun3 ?></th>
						<th><? echo $tahun4 ?></th>
						<th><? echo $tahun5 ?></th>
						<th><? echo $tahun6 ?></th>

					</tr>
						</thead>
						<tbody>
							<tr>
			
							<td><?echo getTotalTahun($tahuncurr)?></td>
							<td><?echo getTotalTahun($tahun1)?></td>
							<td><?echo getTotalTahun($tahun2)?></td>
							<td><?echo getTotalTahun($tahun3)?></td>
							<td><?echo getTotalTahun($tahun4)?></td>
							<td><?echo getTotalTahun($tahun5)?></td>
							<td><?echo getTotalTahun($tahun6)?></td>

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


// Radialize the colors
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Analisa Mengikut Status Projek'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b> <br>{point.percentage:.0f} %',
            },
            showInLegend: true
        }

       
                 // style: {
                 //     color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                 // },
                 // connectorColor: 'silver'
            },
    series: [{
        name: 'Share',
        data: [            
            <?
                $datas = getAnalisaStatus();
                $curr_count= 0;
                while($list = $datas->fetch_assoc()) {
                    //echo $list['description'];
                    if($curr_count > 0) echo ",";
                    echo "{";
                    echo "name: '".$list['penerangan']."<br>".$list['countx']."',y:".$list['countx'];
                    echo "}"; 
                $curr_count++;
                }
            ?>
        ]
    }]
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