<?php

   include ('../controller/auth.php');

   require "../model/aims_analysis_function.php";
	
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_year = date(Y);
	$current_date = $date_year;

	//date_default_timezone_set("Asia/Kuala_Lumpur");
	$current_year=date("Y");
	$id = $_GET['id'];
	$company_id = $_GET['company_id'];
	$year=$_GET['year'];
	
		
?>

<!DOCTYPE html>
<html lang="en">

<head>
<style type="text/css">
       

   
@media print {
    #html-content-holder {
    display: none;
  }
  #btn-Preview-Image {
    display: none;
  }
}

.button{color:blue;} 

    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
    <script src="../../js/highcharts/highcharts.js"></script>
    <script src="../../js/highcharts/modules/exporting.js"></script>
    <script src="../../js/highcharts/modules/export-data.js"></script>
    <script src="../../js/highcharts/modules/data.js"></script>
    <script src="../../js/jquery.highchartTable.js"></script>

<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

</head>

<body>
			

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           	<h3 class="page-header">AIMS GLOBAL GROUP SDN BHD PERFORMANCES </h3>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
<?   //if($_SESSION['SESS_ROLE']=="ADMIN" || $_SESSION['SESS_ROLE']=="SUPERADMIN"){?>
<?   if($_SESSION['SESS_ROLE']=="SUPERADMIN"){?>
    <?}else{?>
        <div class="col-lg-6">
       

        <div class="col-lg-4" >
            			
                        <select  required class="form-control" name="year" id="year" >
                            
                            <?php
                                for ($i = 0; $i <= 12; ++$i){
                                    $time = strtotime(sprintf('-%d years', $i));
                                    $value = date('Y', $time);
                                    echo '<option value="'.$value.'" ';
                                    if($value==$year)echo 'selected';// Check if form submitted or not. select the year if yes
                                    echo '>'.$value.'</option>';
	}}
	?>
	
                        </select><br>
					<div class="button">
					<input id="btn-Preview-Image" type="button" onclick="window.location.href = 'aims_analysis_report.php';" value="Back"/>
					</div> 
			
					
          </div>
      </div>
                <div class="col-lg-12">

                    <figure class="highcharts-figure">
                        <div id="container"></div>
<!--                        <p class="highcharts-description text-center">-->
<!--                            Your Description here-->
<!--                        </p>-->
                    </figure>
                    <!-- /.panel -->
                </div>
				
 <script>
    $(document).ready(function() {
  $('table.highchart').highchartTable();
    $("#year").change(function(){
         var year=$("#year").val();
         
         sendType(year);
         });

    });
     function sendType(year)
     {
            window.location.href="aims_analysis_performance.php?year="+year;
     }

     //Bar Graph Baru
    $(document).ready(function() {
        
        var url = new URL(window.location.href);
        var url_tahun = url.searchParams.get("year");

        var year = new Date().getFullYear();  //dapatkan year
        if(url_tahun == null){
            url_tahun = year;
        }

        //buat ajax
        $.ajax({
            url: "../model/graf_bar_payment_function.php?year="+url_tahun,
            type: "GET",
            dataType: "json",
            success: function (res) {

                function getCol(matrix, col){
                    var column = [];
                    for(var i=0; i<matrix.length; i++){
                        column.push(matrix[i][col]);
                    }
                    return column;
                }
                var company =  getCol(res, 0);
                var total_unpaid =  getCol(res, 1).map(k=>Number(k));
                var total_paid =  getCol(res, 2).map(l=>Number(l));
                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'AIMS GLOBAL GROUP SDN BHD <?echo $year;?>'
                    },
                    xAxis: {
                        categories: company,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Payment (RM)'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        },
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.0f}'
                            }
                        }
                    },
                    series: [{
                        name: 'PAID',
                        data: total_paid,
                        color: 'rgba(101, 33, 68, 0.8)',
                    }, {
                        name: 'UNPAID',
                        data: total_unpaid,
                        color: 'rgba(230, 83, 159, 0.8)',
                    }]
                });
            }
        });
    });
</script>


</body>

</html>

