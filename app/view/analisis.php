<?php

include ('../controller/auth.php');

require "../model/chat_function.php";
require "../model/report_analisis.php";
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

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Jadual Perancangan </h1>

                <?
                $flagScreen="tab_4";
                include ('../global/admin_menu_meeting.php');
                ?>

                <?$flagtahun=$_GET['flagtahun'];
                include ('../global/analisis_menu_tahun.php');

                ?>
                <?
                $tahun = $_GET['tahun'];
                ?>
                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


                <script type="text/javascript">

                    // Create the chart
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Analisa Bil. Respon Staff Mengikut Topik'
                        },
                        xAxis: {
                            categories: [<?echo getMonth().",";?>]
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

                            $datas = getEventCategory();
                            $curr_count= 0;
                            while($list = $datas->fetch_assoc()) {
                                //echo $list['description'];
                                if($curr_count > 0) echo ",";
                                echo "{";
                                echo "name: '".$list['event_type']."',";
                                echo "data:[";
                                $datas_n = getCountEvents();
                                $j=0;
                                while($listN = $datas_n->fetch_assoc()) {
                                    if($j > 0) echo ",";
                                    echo getCount($list['event_type'],$listN['bulan'],$tahun);
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
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th colspan="12">Tahun:<?echo $tahun?></th>
                    </tr>
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
                        <td><?echo getTotalAktiviti(1,$tahun)?></td>
                        <td><?echo getTotalAktiviti(2,$tahun)?></td>
                        <td><?echo getTotalAktiviti(3,$tahun)?></td>
                        <td><?echo getTotalAktiviti(4,$tahun)?></td>
                        <td><?echo getTotalAktiviti(5,$tahun)?></td>
                        <td><?echo getTotalAktiviti(6,$tahun)?></td>
                        <td><?echo getTotalAktiviti(7,$tahun)?></td>
                        <td><?echo getTotalAktiviti(8,$tahun)?></td>
                        <td><?echo getTotalAktiviti(9,$tahun)?></td>
                        <td><?echo getTotalAktiviti(10,$tahun)?></td>
                        <td><?echo getTotalAktiviti(11,$tahun)?></td>
                        <td><?echo getTotalAktiviti(12,$tahun)?></td>
                    </tr>
                    <tr>
                        <th colspan="12">Jumlak Acara Tahunan:<?echo getCountAcaraTahun($tahun)?></th>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-lg-12">
                <h1 class="page-header"></h1>
            </div>
        </div>

        <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
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
            Highcharts.chart('container2', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Status Aktiviti'
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

                            //         style: {
                            //             color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            //         },
                            //         connectorColor: 'silver'
                        },
                        showInLegend: true
                    }
                    // }
                },


                series: [{
                    name: 'Share',
                    data: [
                        <?
                        $datas = getAktivitiStatus($tahun);
                        $curr_count= 0;
                        while($list = $datas->fetch_assoc()) {
                            //echo $list['description'];
                            if($curr_count > 0) echo ",";
                            echo "{";
                            echo "name: '".$list['status']."<br>".$list['kira']."', y:".$list['kira'];

                            echo "}";
                            $curr_count++;
                        }
                        ?>
                    ]
                }]
            });
        </script>

        <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th colspan="12">Tahun:<?echo $tahun?></th>
            </tr>
            <tr>
                <th colspan="6">Bil. Aktiviti Aktif</th>
                <th colspan="6">Bil. Aktiviti Tidak Aktif</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="6"><?echo getCountBatal($tahun)?></th>
                <td colspan="6"><?echo getCountAktif($tahun)?></th>
            </tr>
            <tr>
                <th colspan="12">Jumlah Acara Tahunan:<?echo getCountAcaraTahun($tahun)?></th>
            </tr>
            </tbody>
        </table>



        <? include ('../global/footer.php'); ?>

    </div>

    <!-- /.row -->
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->



</body>

</html>