<?php
include ('../controller/auth.php');
require "../model/dashboard_functions.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$current_date = date("Y-m-d");
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
    <style type="text/css">
        .column{
            width: 95%;
            border: 5px solid powderblue;
            padding: 15px;
            margin: 20px;
            text-align: center;
            justify-content: center;
            height: 150px;
        }.option {
             background: #eee;
             display: block;
             padding: 5px 10px 5px;
             color: #000;
             -moz-border-radius: 6px;
             -webkit-border-radius: 6px;
             -khtml-border-radius: 6px;
             border-radius: 6px;
             cursor: pointer;
         }.tableCenter{
              position: inherit;
          }
    </style>
</head>
<body>
<div id="wrapper">
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
        <? include ('notification.php'); ?><br>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dashboard
                    </div>
                    <div class="panel-body">
                        <div><h1><b>Welcome <? echo $_SESSION['SESS_NAME'];?></b></h1></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="column" style="background-color: lavender;" >
                    <div style="background-color: deepskyblue;padding-top: 6px;"><label>CERTIFICATE <b style="color:yellow">WARNING</b> AND <b style="color:orange">DANGER </b> </label></div>
                    <table class="table table-striped table-bordered table-hover tableCenter">
                        <thead>
                        <tr>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 1</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 2</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 3</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 4</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 5</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td  onClick="location.href='aims_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="yellow"><? echo countwoa1();?></font></strong></td>
                            <td  onClick="location.href='aims_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="orange"><? echo countonea1();?></font></strong></td>
                            <td  onClick="location.href='aims2_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="yellow"><? echo countwoa2();?></font></strong></td>
                            <td  onClick="location.href='aims2_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="orange"><? echo countonea2();?></font></strong></td>
                            <td  onClick="location.href='aims3_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="yellow"><? echo countwoa3();?></font></strong></td>
                            <td  onClick="location.href='aims3_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="orange"><? echo countonea3();?></font></strong></td>
                            <td  onClick="location.href='aims4_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="yellow"><? echo countwoa4();?></font></strong></td>
                            <td  onClick="location.href='aims4_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="orange"><? echo countonea4();?></font></strong></td>
                            <td  onClick="location.href='aims5_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="yellow"><? echo countwoa5();?></font></strong></td>
                            <td  onClick="location.href='aims5_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="orange"><? echo countonea5();?></font></strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="column" style="background-color: lavender;" >
                    <div style="background-color: deepskyblue;padding-top: 6px;"><label>CERTIFICATE <b style="color:green">ACTIVE</b> AND <b style="color:red">EXPIRED </b></label></div>
                    <table class="table table-striped table-bordered table-hover tableCenter">
                        <thead>
                        <tr>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 1</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 2</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 3</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 4</center></th>
                            <th colspan="2" bgcolor="#D6DBDF" width="20%" style="vertical-align : middle;text-align:center;"><center>AISHAH AIMS 5</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td  onClick="location.href='aims_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="green"><? echo countaca1();?></font></strong></td>
                            <td  onClick="location.href='aims_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="red"><? echo countexpa1();?></font></strong></td>
                            <td  onClick="location.href='aims2_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="green"><? echo countaca2();?></font></strong></td>
                            <td  onClick="location.href='aims2_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="red"><? echo countexpa2();?></font></strong></td>
                            <td  onClick="location.href='aims3_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="green"><? echo countaca3();?></font></strong></td>
                            <td  onClick="location.href='aims3_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="red"><? echo countexpa3();?></font></strong></td>
                            <td  onClick="location.href='aims4_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="green"><? echo countaca4();?></font></strong></td>
                            <td  onClick="location.href='aims4_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="red"><? echo countexpa4();?></font></strong></td>
                            <td  onClick="location.href='aims5_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="green"><? echo countaca5();?></font></strong></td>
                            <td  onClick="location.href='aims5_cert_list.php';" align="center" bgcolor="#FDFEFE"><strong><font size="3px" color="red"><? echo countexpa5();?></font></strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<? include ('../global/footer.php'); ?>
</body>
</html>