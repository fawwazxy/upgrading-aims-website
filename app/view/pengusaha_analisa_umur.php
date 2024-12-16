<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
//require "../model/funct_report.php";
//echo getNegeri_report();
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
    <script src="../../js/highcharts/modules/exporting.js"></script>
    <script src="../../js/highcharts/modules/export-data.js"></script>
    <script src="../../js/highcharts/modules/data.js"></script>



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

    <div id="page-wrapper">
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
                            text: 'Analisa Pengusaha Mengikut Umur'
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
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                    },
                                    connectorColor: 'silver'
                                }, showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Share',
                            data: [
                                <?
                                $datas = getAnalisaByAge();
                                $curr_count= 0;
                                while($list = $datas->fetch_assoc()) {
                                    //echo $list['description'];
                                    if($curr_count > 0) echo ",";
                                    echo "{";
                                    echo "name: '".$list['kategori']."<br>".$list['bil']."', y:".$list['bil'];

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
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->



</body>

</html>
