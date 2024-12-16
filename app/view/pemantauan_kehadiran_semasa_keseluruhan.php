<?php
session_start();
$dept_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
//include ('../controller/auth.php');
require_once("../../util/qrcode.php");
require "../model/kehadiran_functions.php";

$dateSelection=$_GET['dt'];
$com = getCompanyDetails(1)->fetch_assoc();
$tab_dept=$_GET['tab_dept'];

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
    <style>
        th {text-align:center;
            color: black;

        }

    </style>


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        setInterval(function () {

            location.reload();


        }, 30000);
        setInterval(function () {
            var date = new Date();
            $('#timeRunningDate').html(moment().format('ddd MMM D YYYY, HH:mm:ss '));

            showTime();
        }, 1000);

        function showTime(){
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";

            if(h == 0){
                h = 12;
            }

            if(h > 12){
                h = h - 12;
                session = "PM";
            }

            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            var time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerHTML = time;
            document.getElementById("MyClockDisplay").textContent = time;
            //$('#timeRunningDate').html(time);



            //setTimeout(showTime, 1000);

        }


    </script>


</head>

<body id="refresh">
<div class="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <table align="left" border="0" width="100%">
                <tr bgcolor="yellow">
                    <td width="10%" align="right">
                        <?
                        echo '<img src="data:image/png;base64,'.base64_encode( $sys['logo'] ).'" style="height:100px" />';
                        ?>
                    </td>
                    <td  align="left" width="50%" rowspan="2">
                        &nbsp;&nbsp;<? echo '<h3><b>'.$com['name'].'</b></h3>';?><? echo '<h5><b>No. Pendaftaran: '.$com['registration_no'].'</b></h5>';?><? echo '<h5><b>'.$com['address'].'</b></h5>';?>
                    </td>
                    <td width="60%">
                        <h1 align="right">
                            <font color="blue">
                                <div id="MyClockDisplay" class="clock"><? echo date('h:i:s A')?></div>
                            </font>
                        </h1>
                        <h4 align="right">
                            <font color="blue">
                                <span id="timeRunningDate"><? echo date('D M d Y, H:i:s ')?></span>
                            </font>
                        </h4>
                    </td>
                    <td width="30%">&emsp;&emsp;</td>
                </tr>
            </table>
        </div>
    </nav>
    <br>


    <div class="col-lg-12">



        <div class="panel panel-red">
            <!-- /.panel-heading -->
            <div class="panel-heading">
                <center><b>ANALISA KEHADIRAN SEMASA KESELURUHAN</b></center>
            </div>
            <table width="100%" class="table  table-bordered">

                <thead>
                <th align="center" width="20%">Bil. Staf</th>
                <th align="center" width="20%">Awal</th>
                <th align="center" width="20%">Tepat</th>
                <th align="center"  width="20%">Lewat</th>
                <th align="center" width="20%">% Kehadiran</th>
                </thead>

                <?php
                $bil_staf = getBilStafDipantauKeseluruhan($dept_sub);
                $bil_staf_awal=getBilStafHadirByStatusKehadiran("AWAL", $dept_sub);
                $bil_staf_tepat=getBilStafHadirByStatusKehadiran("TEPAT", $dept_sub);
                $bil_staf_lewat=getBilStafHadirByStatusKehadiran("LEWAT", $dept_sub);

                if($bil_staf==0){
                    $peratus = 0.00;
                }else{
                    $peratus=($bil_staf_awal+$bil_staf_tepat+$bil_staf_lewat)/$bil_staf*100;
                }

                ?>
                <tbody>
                <td align="center"><strong><font size="6" color="black"><? echo $bil_staf;?></font></strong></td>
                <td align="center"><strong><font size="6" color="green"><? echo $bil_staf_awal;?></font></strong></td>
                <td align="center"><strong><font size="6" color="blue"><? echo $bil_staf_tepat;?></font></strong></td>
                <td align="center"><strong><font size="6" color="red"><? echo $bil_staf_lewat;?></font></strong></td>
                <td align="center"><strong><font size="6" color="black"><? echo number_format($peratus,2);?> %</font></strong></td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        <?
        $datas =  getDepartmentByStaff($dept_sub);
        $i=1;
        while($list_dept = $datas->fetch_assoc()) { ?>
            <a href="pemantauan_kehadiran_semasa_dept.php?department_id=<? echo $list_dept['department_id']; ?>" target="_blank" >
                <div class="col-lg-4">
                    <div class="panel panel-red">
                        <!-- /.panel-heading -->
                        <div class="panel-heading">
                            <center><b><? echo $list_dept['description'];?></b></center>
                        </div>
                        <table width="100%" class="table  table-bordered">

                            <thead>
                            <th align="center" width="20%">Bil. Staf</th>
                            <th align="center" width="20%">Awal</th>
                            <th align="center" width="20%">Tepat</th>
                            <th align="center" width="20%">Lewat</th>
                            <th align="center" width="20%">% Kehadiran</th>
                            </thead>

                            <?php
                            $bil_staf = getBilStafDipantauKeseluruhanByDept($list_dept['department_id']);
                            $bil_staf_awal=getBilStafHadirByStatusKehadiranByDept("AWAL",$list_dept['department_id']);
                            $bil_staf_tepat=getBilStafHadirByStatusKehadiranByDept("TEPAT",$list_dept['department_id']);
                            $bil_staf_lewat=getBilStafHadirByStatusKehadiranByDept("LEWAT",$list_dept['department_id']);

                            if($bil_staf==0){
                                $peratus = 0.00;
                            }else{
                                $peratus=($bil_staf_awal+$bil_staf_tepat+$bil_staf_lewat)/$bil_staf*100;
                            }

                            ?>
                            <tbody>
                            <td align="center"><strong><font size="4" color="black"><? echo $bil_staf;?></font></strong></td>
                            <td align="center"><strong><font size="4" color="green"><? echo $bil_staf_awal;?></font></strong></td>
                            <td align="center"><strong><font size="4" color="blue"><? echo $bil_staf_tepat;?></font></strong></td>
                            <td align="center"><strong><font size="4" color="red"><? echo $bil_staf_lewat;?></font></strong></td>
                            <td align="center"><strong><font size="4" color="black"><? echo number_format($peratus,2);?> %</font></strong></td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </a>
        <?}?>
    </div>



</div>
<div class="footer-section">
    <div class="copy-section">
        <!--<div class="container">-->
        <center>
            <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
                Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
        </center>
        <!--</div>-->
    </div>
</div>
</body>

</html>
