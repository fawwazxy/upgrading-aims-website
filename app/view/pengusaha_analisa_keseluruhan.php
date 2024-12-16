<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
require "../model/lookup.php";
//require "../model/funct_report.php";
//echo getNegeri_report();
$kod_pkj=$_GET['kod_pkj'];
$kod_ppk=$_GET['kod_ppk'];
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
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="left">
                    <div class="col-xs-8">
                        <label>Pejabat KADA Jajahan (PKJ)<font color="red">&nbsp;**</font></label>
                        <select required class="form-control" id="kod_pkj" name="kod_pkj" value="<?echo $kod_pkj?>"
                                onchange="reloadPKJ(this.value)">
                            <option value="">-- Pilih --</option>
                            <?echo getDropDown("lkp_jajahan","kod_jajahan","nama_pkj",$kod_pkj);?>
                        </select>
                    </div>
                </div>

                <br><br><br>
                <div class="form-group" align="left">
                    <div class="col-xs-8">
                        <label>Pertubuhan Peladang Kawasan (PPK)<font color="red">&nbsp;**</font></label>
                        <select required class="form-control" id="kod_ppk" name="kod_ppk" value="<?echo $kod_ppk?>" onchange="reloadPPK(this.value)">
                            <option value="">-- Pilih --</option>
                            <?echo getDropDownPengusaha("lkp_ppk","kod_ppk","nama_ppk","kod_pkj",$kod_pkj,$kod_ppk);?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <br><br><br>
                <div id="container_pkj" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <div id="container_ppk" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



                <script type="text/javascript">
                    function reloadPKJ(pkj){
                        //console.log(obj);
                        location.href = "pengusaha_analisa_keseluruhan.php?kod_pkj="+pkj;
                    }
                    function reloadPPK(ppk){
                        //console.log(obj);
                        location.href = "pengusaha_analisa_keseluruhan.php?kod_pkj=<?echo $kod_pkj?>&kod_ppk="+ppk;
                    }


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
                    Highcharts.chart('container_pkj', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Analisa PPK Berdasarkan PKJ'
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
                                $datas = getPKJByKodAnalisa($kod_pkj);
                                $curr_count= 0;
                                while($list = $datas->fetch_assoc()) {
                                    //echo $list['description'];
                                    if($curr_count > 0) echo ",";
                                    echo "{";
                                    echo "name: '".$list['nama_ppk']."<br>".$list['bil']."', y:".$list['bil'];

                                    echo "}";
                                    $curr_count++;
                                }
                                ?>
                            ]
                        }]
                    });

                    Highcharts.chart('container_ppk', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Analisa Lot Tanah Berdasarkan PPK'
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
                                $datas = getPPKByPKJAnalisa($kod_pkj,$kod_ppk);
                                $curr_count= 0;
                                while($list = $datas->fetch_assoc()) {
                                    //echo $list['description'];
                                    if($curr_count > 0) echo ",";
                                    echo "{";
                                    echo "name: '".$list['nama_ppk']."<br>".$list['bil']."', y:".$list['bil'];

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
        <!-- /.container_pkj-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->



</body>

</html>
