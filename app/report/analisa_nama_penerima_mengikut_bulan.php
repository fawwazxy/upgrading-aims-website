
<?php

    include ('../controller/auth.php');
    require "../model/perbelanjaan_functions.php";
    require "../model/report_perbelanjaan_functions.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>

 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>

    <script src="../../js/highcharts/highcharts.js"></script>
    <script src="../../js/highcharts/modules/data.js"></script>
    <script src="../../js/highcharts/modules/drilldown.js"></script>


<script language="javascript" type="text/javascript">


</script>


</head>

<body>

    <div id="wrapper">


        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <!-- /.navbar-header -->
            <? include ('../global/menu_top.php'); ?>
            


            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--li>
                            <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                        </li-->

                        <? include ('../global/menu_left.php'); ?>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<div class="panel-heading" align="right">
       <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
   </div>

        <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <!--h1 class="page-header">Pemasaran</h1-->
            </div>
        </div>
                <div class="row">
                <div class="col-lg-12">


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


        <script type="text/javascript">

// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Analisa Nama Penerima Mengikut Bulan'
    },
    xAxis: {
        categories: [<?echo getMonth1().",";?>]
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
    series: [
     <?

         $datas = getPenerima_table();
         $curr_count= 0;
         while($list = $datas->fetch_assoc()) {
             //echo $list['description'];
             if($curr_count > 0) echo ",";
             echo "{";
             echo "name: '".$list['nama_penerima']."',";
             echo "data:[";
                 $datas_n = getCountStatus1();
                 $j=0;
                 while($listN = $datas_n->fetch_assoc()) {
                     if($j > 0) echo ",";
                     echo getCount($list['penerima'],$listN['bulan']);
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

                </div>
                <!-- /.col-lg-12 -->
            </div>
           

                <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>



</body>

</html>