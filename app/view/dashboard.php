<?php
include ('../controller/auth.php');
require "../model/dashboard_functions.php";

$id = $_SESSION['SESS_ID'];
$thn = ($_GET['tahun']) ?: date('Y');
$nokp = $_SESSION['SESS_NOKP'];
$info = getStaffById($id)->fetch_assoc();
$photo_url = getStaffPhotoUrl($id);
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
    <script src="../../js/jquery.highchartTable.js"></script>
    <style type="text/css">
        .attendance-info{
            background-color: #D6DBDF;
            padding-top: 15px;
            vertical-align : middle;
            text-align:center;
            font-weight: bold;
            width: 33.33%;
        }
        .img-frame{
            width: 128px;
            height: 128px;
            object-fit: cover;
            border-radius: 16px;
            margin-right: 16px;
            border: 3px solid black;
            box-shadow: 0 0 10px #565656;
        }
        ul {
            list-style: none;
            display: table;
            padding: 0;
        }
        li {
            display: table-row;
            margin-left: 0;
        }
        h5 {
            display: table-cell;
            /*padding-right: 1em;*/
            font-weight: bold;
        }
        .column{
            width: auto;
            border: 5px solid powderblue;
            padding: 15px;
            margin: 15px;
            text-align: center;
            justify-content: center;
            height: =uto;
        }
        .option {
            background: #eee;
            display: block;
            padding: 5px 10px 5px;
            color: #000;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            cursor: pointer;
        }
        .tableCenter{
            position: inherit;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <input type="hidden" id="user_session" name="user_session" value="<? echo $nokp; ?>" /> <!-- get user session of nokp for graf ajax -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div>
        <div class="row">
            <? include "../global/it_announcement.php"; ?>
        </div>
        <!--Notification update email/phoneno-->
        <? if (empty($info['email']) || $info['email'] == 'n@a'){?>
        <div class="row">
            <div class="col-lg-12">
                <blockquote class="alert alert-warning">
                    <span style="font-weight: bolder">
                        Kindly request your attention to update your <b>email address / phone number</b>, as it is necessary for our records and future communication purposes.
                        <a style="cursor: pointer" href="#updateEmail" id="modalUpdateEmail" data-toggle="modal" data-id="<? echo $_SESSION['SESS_ID']?>">Click Here!</a>
                    </span><br>
                    <span style="font-size: 12px">
                        Mohon perhatian untuk mengemas kini <b>alamat e-mel / nombor telefon</b> anda, kerana ia perlu untuk rekod kami dan tujuan komunikasi masa hadapan.
                        <a style="cursor: pointer" href="#updateEmail" id="modalUpdateEmail" data-toggle="modal" data-id="<? echo $_SESSION['SESS_ID']?>">Klik sini!</a>
                    </span>
                </blockquote>
            </div>
        </div>
        <? } ?>
        <div class="row">
            <div class="col-lg-12">
                <? include "../view/notification.php"; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Personal information</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-2 text-center">
                                <div class="row">
                                    <img src="../../staffphoto/<? echo $photo_url ?>" alt="staff-photo" class="img-frame">
                                </div>
                                <div class="row" style="margin-top: 8px">
                                    <a href="crop_image_upload.php" class="" style="margin-right: 16px;font-size: 12px; font-weight: bold; ">
                                        Change Picture <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <span style="font-size: 32px; font-weight: bold">Welcome, <? echo $_SESSION['SESS_NAME'];?></span>
                                <ul>
                                    <li><h5>IC Number</h5>: <? echo $_SESSION['SESS_NOKP'] ?></li>
                                    <li><h5>Staff No</h5>: <? echo $_SESSION['SESS_NO_STAFF'] ?></li>
                                    <li><h5>Company</h5>: <? echo $_SESSION['SESS_DEPARTMENT'] ?></li>
                                    <li><h5>Department</h5>: <? echo $_SESSION['SESS_DEPARTMENT_SUB'] ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? if (date('Y-m-d') > '2022-12-06'){ ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-offset-10 col-lg-2">
                        <select  required class="form-control" name="tahun" id="tahun">
                            <?
                            for ($i = 0; $i <= 3; ++$i){
                                $time = strtotime(sprintf('-%d years', $i));
                                $value = date('Y', $time);
                                echo '<option value="'.$value.'" ';
                                if($value==$thn)echo 'selected';// Check if form submitted or not. select the year if yes
                                echo '>'.$value.'</option>';
                            }
                            ?>
                        </select><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!--Attendance Bar Chart-->
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                    </figure>
                </div>
                <div class="row text-center">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="column" style="background-color: aliceblue;" onclick="location.href='analisa_kehadiran_peribadi.php';">
                            <div style="background-color: powderblue;padding-top: 5px;"><label>Attendance </label></div><br>
                            <table class="table table-striped table-bordered table-hover tableCenter">
                                <thead>
                                <tr>
                                    <th class="attendance-info">Total Working Days</th>
                                    <th class="attendance-info">Total of Attendance</th>
                                    <th class="attendance-info">Punctuality Percent</th>
                                </tr>
                                </thead>
                                <?
                                //Kehadiran Awal, Tepat dan Lewat
                                $kehadiran_awal = (getAnalisaKehadiran($_SESSION['SESS_NOKP'],'AWAL')) ?: 0;
                                $kehadiran_tepat = (getAnalisaKehadiran($_SESSION['SESS_NOKP'],'TEPAT')) ?: 0;
                                $kehadiran_lewat = (getAnalisaKehadiran($_SESSION['SESS_NOKP'],'LEWAT')) ?: 0;

                                //Kiraan jumlah hari bekerja

                                $jumlah_hari_bekerja = getAnalisaJumlahHariBekerja($_SESSION['SESS_NOKP'],$_SESSION['SESS_NO_STAFF']);
                                $jumlah_kehadiran = getAnalisaJumlahKehadiran($_SESSION['SESS_NOKP']);

                                $peratusan_kehadiran = ($jumlah_kehadiran != 0) ? ($kehadiran_awal+$kehadiran_tepat)/$jumlah_kehadiran * 100 : 0.00;
                                ?>
                                <tbody>
                                <tr>
                                    <td class="attendance-info" style="background-color: #FDFEFE">
                                        <?echo $jumlah_hari_bekerja;?>
                                    </td>
                                    <td class="attendance-info" style="background-color: #FDFEFE; color: blue">
                                        <?echo $jumlah_kehadiran;?>
                                    </td>
                                    <td class="attendance-info" style="background-color: #FDFEFE; color: brown">
                                        <?echo round($peratusan_kehadiran,0).'%';?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="attendance-info">Early</td>
                                    <td class="attendance-info">Punctual</td>
                                    <td class="attendance-info">Late</td>
                                </tr>
                                <tr>
                                    <td class="attendance-info" style="background-color: #FDFEFE; color: green"><? echo $kehadiran_awal;?></td>
                                    <td class="attendance-info" style="background-color: #FDFEFE; color: purple"><? echo $kehadiran_tepat;?></td>
                                    <td class="attendance-info" style="background-color: #FDFEFE; color: red"><? echo $kehadiran_lewat;?></td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
            </div>
        <? } ?>
        <div class="modal fade" id="updateEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle2" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" id="exampleModalLongTitle2" style="font-size: 120%">UPDATE EMAIL</span>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" id="modal-updateEmail">
                        <!--Modal Script-->
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
    <script type="text/javascript">
        $('#updateEmail').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type:'POST',
                url:'dashboard_update_email.php',
                data:{id:rowid},
                success:function(html){
                    $('#modal-updateEmail').html(html);
                }
            });
        });
        $(document).ready(function() {
            $('table.highchart').highchartTable();
            $("#tahun").change(function(){
                var tahun=$("#tahun").val();

                sendType(tahun);
            });

        });
        function sendType(tahun)
        {
            window.location.href="dashboard.php?tahun="+tahun;
        }
        <? if (date('Y-m-d') > '2022-12-06'){ ?>
        //Bar Graph Baru
        $(document).ready(function() {
            var no_kp = $('#user_session').val();
            var url = new URL(window.location.href);
            var url_tahun = url.searchParams.get("tahun");

            var thn = new Date().getFullYear();  //dapatkan tahun
            if(url_tahun == null){
                url_tahun = thn;
            }

            $.ajax({
                url: "graf_bar_kehadiran_function.php?thn="+url_tahun+"&no_kp="+no_kp,
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

                    var lewat =  getCol(res, 0).map(i=>Number(i));
                    var jumlah =  getCol(res, 1).map(j=>Number(j));
                    var awal =  getCol(res, 2).map(k=>Number(k));

                    console.log(awal);
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Performance Analysis'
                        },
                        subtitle: {
                            text: 'Staff Attendance'
                        },
                        xAxis: {
                            categories: [
                                'Jan',
                                'Feb',
                                'Mar',
                                'Apr',
                                'May',
                                'Jun',
                                'Jul',
                                'Aug',
                                'Sep',
                                'Oct',
                                'Nov',
                                'Dec'
                            ],
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Total Days'
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
                            name: 'Total Attendance',
                            data: jumlah,
                            color: 'rgba(0,0,0,0.8)',
                        }, {
                            name: 'Early/Punctual',
                            data: awal,
                            color: 'rgba(0,186,8,0.8)',
                        },{
                            name: 'Late',
                            data: lewat,
                            color: 'rgba(194,0,0,0.8)',
                        }]
                    });
                }
            });
        });
        <? } ?>
    </script>
</body>
</html>