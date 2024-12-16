<?php

include ('../model/report_perbelanjaan_functions.php');
require "../model/perbelanjaan_functions.php";

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

<!-- <style>
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
</style> -->


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<?php require "../global/header.php"; ?>
	
    <script src="../../js/highcharts/highcharts.js"></script>
    <script src="../../js/highcharts/modules/data.js"></script>
    <script src="../../js/highcharts/modules/drilldown.js"></script>




</head>

<body>
	<div class="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		</nav>

		<center><h1 style="font-size:40px;font-family:Georgia">Analisa Keseluruhan Rekod Perbelanjaan</h1></center>
	
			
  <div class="header-right">
 
  </div>
</div>
		<br>
		<br>
		
		<div class="col-lg-12">
		
		</br>
	
		
</br>

	
		<!-- <div class="col-lg-12"> -->
		<div class="panel panel-red">
		<div class="panel-heading">
                    <center><b>Bilangan Perbelanjaan</b></center>
        </div>
                <table width="50%" class="table table-striped table-bordered table-hover" >
    			<thead>
						<tr>
							<th width="50%"></th>
							<th width="50%"><center>Bilangan Keseluruhan Perbelanjaan</center></th>
						</tr>
				    </thead>
				    <tbody>
				        <?
				        $datas = getCountRekodPerbelanjaan();
				        while($list = $datas->fetch_assoc()) {
				        ?>
				        <tr>
				            <td align="left"><b>Jumlah Bilangan Perbelanjaan</b></td>
				            <td><center><? echo number_format($list['COUNT']);?></center></td>
				            <?}?>
				        </tr>
				       <!--   <?                
				                                                       
	                                                                                                        
	                                      //$i= 1;
	                                      //$data = getAnalisaPerbelanjaan();
	                                      //while($row_data = $data->fetch_assoc()) {
	                                  ?>
	                                    
	                                      <tr>
	                                       
	                                        <td><?//echo $row_data['belanja']?></td>
	          								<td><center><?//echo $row_data['xcount']?></center></td>
	                                      </tr>
	                                  -->
			    </tbody>
			</table>
		</div>
	</br>

<div class="panel panel-red">
		<div class="panel-heading">
            <center><b>Bilangan Nama Penerima Mengikut Perbelanjaan</b></center>
        </div>
        <table width="50%" class="table table-striped table-bordered table-hover" >
    			<thead>
						<tr>
							<th width="50%"></th>
							<th width="50%"><center>Bilangan Keseluruhan Nama Penerima</center></th>
						</tr>
			    </thead>
    			

    			<tbody>
			        <?
			        $datas = getCountPerbelanjaanMengikutNamaPenerima();
			        while($list = $datas->fetch_assoc()) {
			        ?>
			        <tr>
			            <td align="left"><b>Jumlah Nama Penerima</b></td>
			            <td><center><? echo number_format($list['COUNT']);?></center></td>
			            <?}?>
			        </tr>
			        <!--  <?                
			                                                       
                                                                                                        
                                     // $i= 1;
                                     // $data = getPerbelanjaanMengikutNamaPenerima();
                                     // while($row_data = $data->fetch_assoc()) {
                                  	?>
                                    
                                    <tr>
                                       
                                        <td><?//echo $row_data['penerima']?></td>
          								<td><center><?//echo $row_data['xcount']?></center></td>
                                    </tr>
                                 -->
    			</tbody>
		</table>
		</div>
</br>
		<!-- Table Sasaran Jualan -->
	
			<div class="panel panel-red">
			
				<div class="panel-heading">
					<center><b>Perbelanjaan Bulanan</b></center>
				</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
							<th><center>Januari</center></th>
							<th><center>Februari</center></th>
							<th><center>Mac</center></th>
							<th><center>April</center></th>
							<th><center>Mei</center></th>
							<th><center>Jun</center></th>
							<th><center>Julai</center></th>
							<th><center>Ogos</center></th>
							<th><center>September</center></th>
							<th><center>Oktober</center></th>
							<th><center>November</center></th>
							<th><center>Disember</center></th>
							</tr>
						</thead>
						<tbody>
							<tr>
							<td><center><?echo getTotalPerbelanjaanJan()?></center></td>
							<td><center><?echo getTotalPerbelanjaanFeb()?></center></td>
							<td><center><?echo getTotalPerbelanjaanMac()?></center></td>
							<td><center><?echo getTotalPerbelanjaanApr()?></center></td>
							<td><center><?echo getTotalPerbelanjaanMei()?></center></td>
							<td><center><?echo getTotalPerbelanjaanJun()?></center></td>
							<td><center><?echo getTotalPerbelanjaanJul()?></center></td>
							<td><center><?echo getTotalPerbelanjaanOgos()?></center></td>
							<td><center><?echo getTotalPerbelanjaanSept()?></center></td>
							<td><center><?echo getTotalPerbelanjaanOct()?></center></td>
							<td><center><?echo getTotalPerbelanjaanNov()?></center></td>
							<td><center><?echo getTotalPerbelanjaanDis()?></center></td>
							</tr>
						</tbody>
					</table>
				<!-- /.panel-body -->
			</div>
</br>


			<div class="panel panel-red">
				
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
						<th><center><? echo $tahuncurr ?></center></th>
						<th><center><? echo $tahun1 ?></center></th>
						<th><center><? echo $tahun2 ?></center></th>
						<th><center><? echo $tahun3 ?></center></th>
						<th><center><? echo $tahun4 ?></center></th>
						<th><center><? echo $tahun5 ?></center></th>
						<th><center><? echo $tahun6 ?></center></th>

					</tr>
						</thead>
						<tbody>
							<tr>

							<td><center><?echo getTotalPerbelanjaanTahun($tahuncurr)?></center></td>
							<td><center><?echo getTotalPerbelanjaanTahun($tahun1)?></center></td>
							<td><center><?echo getTotalPerbelanjaanTahun($tahun2)?></center></td>
							<td><center><?echo getTotalPerbelanjaanTahun($tahun3)?></center></td>
							<td><center><?echo getTotalPerbelanjaanTahun($tahun4)?></center></td>
							<td><center><?echo getTotalPerbelanjaanTahun($tahun5)?></center></td>
							<td><center><?echo getTotalPerbelanjaanTahun($tahun6)?></center></td>

							</tr>
						</tbody>
					</table>
				<!-- /.panel-body -->
			</div>
		</div>
		<!-- </div> -->
			<!-- /.panel -->
		
<!-- </br> -->
            <!-- <div class="row"> -->
	            <div class="col-lg-12">
	                <div class="panel-heading">
              
                </div>
	           
<table width="100%">
<tr>
    <td colspan="2">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </td>
</tr>
<br>
<tr>
    <td>
        <div id="container1" style="min-width: 310px; height: 400px;"></div>
    </td>
</tr>
</br>
<tr>
    <td>
        <div id="container2" style="min-width: 410px; height: 400px; "></div>
    </td>
</tr>


</table>
</br>
                
                


<br>

<script type="text/javascript">


// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Analisa Mengikut Nama Penerima'
    },
    xAxis: {
        type: 'category'
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
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
    },

    "series": [
        {
            "name": "Nama Penerima",
            "colorByPoint": false,
            "data": [

                <?
                        
                    $datas_n = getNamaPenerima_table();
                    $j=0;
                    while($listN = $datas_n->fetch_assoc()) {
                        if($j > 0) echo ",";
                        echo "{";
                        echo "name: '".$listN['penerima']."',";
                        echo "y: ".$listN['xcount']."";
                        echo "}";

                        $j++;
                    }
                        
                    
                ?>
            ]
        }
    ]
    
    
});
        </script>
        

        <script type="text/javascript">


// Radialize the colors

// Build the chart
Highcharts.chart('container1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Analisa Mengikut Jenis Perbelanjaan'
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
                $datas = getCountPerbelanjaan();
                $curr_count= 0;
                while($list = $datas->fetch_assoc()) {
                    //echo $list['description'];
                    if($curr_count > 0) echo ",";
                    echo "{";
                    echo "name: '".$list['belanja']."<br>".$list['count']."',y:".$list['count'];
                    echo "}"; 
                $curr_count++;
                }
            ?>
        ]
    }]
});
        </script>


<script type="text/javascript">


// Radialize the colors


// Build the chart
Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Analisa Status Baucar Bayaran'
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
                $datas = getAnalisaStatusPerbelanjaan();
                $curr_count= 0;
                while($list = $datas->fetch_assoc()) {
                    //echo $list['description'];
                    if($curr_count > 0) echo ",";
                    echo "{";
                    echo "name: '".$list['keterangan']."<br>".$list['xcount']."',y:".$list['xcount'];
                    echo "}"; 
                $curr_count++;
                }
            ?>
        ]
    }]
});
        </script>

  
   </div>


                </div>

     
           </div>


		
			</div>
		</div>
		
	</div>

</body>
</html>