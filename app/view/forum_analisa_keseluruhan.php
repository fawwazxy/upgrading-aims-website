<?php

include ('../controller/auth.php');

require "../model/chat_function.php";
require "../model/report_arkib_function.php";

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
        <?
        $flagScreen="tab_3";
        include ('../global/menu_forum.php');
        ?>
        <!-- Table Sasaran Jualan -->
        <div class="col-lg-12">

            <!-- /.panel-heading -->
            <div class="panel-heading">
                <center><b>Bilangan Topik Mengikut Bulan</b></center>
            </div>
            <table width="50%" class="table table-striped table-bordered table-hover" >
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
                    <td><?echo getTotalForumJan()?></td>
                    <td><?echo getTotalForumFeb()?></td>
                    <td><?echo getTotalForumMac()?></td>
                    <td><?echo getTotalForumApr()?></td>
                    <td><?echo getTotalForumMei()?></td>
                    <td><?echo getTotalForumJun()?></td>
                    <td><?echo getTotalForumJul()?></td>
                    <td><?echo getTotalForumOgos()?></td>
                    <td><?echo getTotalForumSept()?></td>
                    <td><?echo getTotalForumOct()?></td>
                    <td><?echo getTotalForumNov()?></td>
                    <td><?echo getTotalForumDis()?></td>
                </tr>
                </tbody>
            </table>
            <!-- /.panel-body -->
        </div>

        <!-- Table Sasaran Jualan -->
        <div class="col-lg-12">

            <!-- /.panel-heading -->
            <div class="panel-heading">
                <center><b>Bilangan Topik Mengikut Tahun</b></center>
            </div>
            <table width="50%" class="table table-striped table-bordered table-hover" >
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

                    <td><?echo getTotalAduanTahun($tahuncurr)?></td>
                    <td><?echo getTotalAduanTahun($tahun1)?></td>
                    <td><?echo getTotalAduanTahun($tahun2)?></td>
                    <td><?echo getTotalAduanTahun($tahun3)?></td>
                    <td><?echo getTotalAduanTahun($tahun4)?></td>
                    <td><?echo getTotalAduanTahun($tahun5)?></td>
                    <td><?echo getTotalAduanTahun($tahun6)?></td>

                </tr>
                </tbody>
            </table>
            <!-- /.panel-body -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">

                    <div class="panel-heading">
                        <center><b>Bilangan Topik Mengikut Kategori</b></center>
                    </div>
                    <table width="50%" class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th width="50px"></th>
                            <th width="50px"><center>Bilangan</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $datas = getCategoryAnalisa();
                        while($list = $datas->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?echo $list['kategori']?></td>
                                <td><center><?echo $list['COUNT']?></center></td>
                            </tr>
                        <?}?>

                        </tbody>
                    </table>
                </div>


                <!-- Table Sasaran Jualan -->
                <div class="col-lg-12">

                    <!-- /.panel-heading -->
                    <div class="panel-heading">
                        <center><b>Bilangan Topik</b></center>
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
                            <td>Popular</td>

                            <?  $datas = getCountPopular();
                            while($list = $datas->fetch_assoc()) { ?>
                                <td><center><?echo $list['COUNT']?></center></td>
                            <?}?>
                        </tr>
                        <tr>
                            <td>Kurang Popular</td>
                            <?  $datas_n = getCountTakPopular();
                            while($listN = $datas_n->fetch_assoc()) { ?>
                                <td><center><?echo $listN['COUNT']?></center></td>
                            <?}?>
                        </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-lg-12">

                    <div class="panel-heading">

                    </div>
                    <table width="100%">
                        <tr>
                            <td colspan="2">
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="container1" style="min-width: 310px; height: 400px;"></div>
                            </td>
                            <td>
                                <div id="container2" style="min-width: 410px; height: 400px;"></div>
                            </td>
                        </tr>


                    </table>

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
                                categories: [<?echo getName().",";?>]
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

                                $datas = getNameStatus();
                                $curr_count= 0;
                                while($list = $datas->fetch_assoc()) {
                                    //echo $list['description'];
                                    if($curr_count > 0) echo ",";
                                    echo "{";
                                    echo "name: '".$list['username']."',";
                                    echo "data:[";
                                    $datas_n = getCountStatus();
                                    $j=0;
                                    while($listN = $datas_n->fetch_assoc()) {
                                        if($j > 0) echo ",";
                                        echo getCount($list['user_id'],$listN['id_topik']);
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

                    <script type="text/javascript">


                        // Build the chart
                        Highcharts.chart('container1', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: 'Analisa Mengikut Jenis'
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
                                    $datas = getCountJenis();
                                    $curr_count= 0;
                                    while($list = $datas->fetch_assoc()) {
                                        if($curr_count > 0) echo ",";
                                        echo "{";
                                        echo "name: '".$list['jenis']."<br>".$list['count']."',y:".$list['count'];
                                        echo "}";
                                        $curr_count++;
                                    }
                                    ?>
                                ]
                            }]
                        });
                    </script>


                    <script type="text/javascript">



                        // Build the chart
                        Highcharts.chart('container2', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: 'Analisa Mengikut Bil. Tajuk Yang Dibalas'
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
                                    showInLegend: false
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
                                    $datas = getCountBalasTajuk();
                                    $curr_count= 0;
                                    while($list = $datas->fetch_assoc()) {
                                        if($curr_count > 0) echo ",";
                                        echo "{";
                                        echo "name: '".$list['tajuk']."<br>".$list['xcount']."',y:".$list['xcount'];
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