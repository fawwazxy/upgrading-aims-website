<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$authorize = getBookingById($id)->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <? require "../global/header.php"; ?>

</head>

<style>
    body {

        margin-left: 20px;
        margin-right: 20px;
    }

    table.one{
        width:100%;

    }
    table td{
        padding: 8px;
    }
</style>

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
                <h1 class="page-header">Authorization</h1>
            </div>
        </div>

        <div class="panel-heading" align="right">
            <button class="btn btn-primary" onclick="goBack()">Back</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <input type="hidden" class="form-control" name="id" id="id" value="<? echo $id;?>">
                    <div class="panel panel-body">
                        <table class="one" border="1">
                            <tr>
                                <td colspan="2" width="50%">FULL NAME: <?echo $authorize['client_name'] ;?></td>
                                <td colspan="2" rowspan="2" width="50%">ROOM NO: <?echo $authorize['room_id'] ;?>
                                    <br>
                                    BED NO: <?echo $authorize['bed_id'] ;?>
                                    <br>
                                    LOCKER NO: <?echo $authorize['locker_id'] ;?>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" width="50%">COMPANY: <?echo $authorize['company_name'] ;?></td>
                            </tr>

                            <tr>
                                <td colspan="2" width="50%">ADDRESS: <?echo $authorize['client_address'] ;?> <?echo $authorize['client_city'] ;?> <?echo $authorize['client_postcode'] ;?> <?echo $authorize['client_state'] ;?></td>
                                <td width="25%">ARRIVAL DATE: <?echo '<font>'.date('d/m/Y',strtotime($authorize['arrival_date'])).'</font>' ;?>
                                    <br>
                                    TIME: <?echo $authorize['arrival_time'] ;?></td>
                            </tr>

                            <tr>
                                <td width="25%">IC/PASSPORT NO: <?echo $authorize['client_ic'] ;?></td>
                                <td width="25%">CONTACT NO: <?echo $authorize['client_phone_no'] ;?></td>
                                <td width="25%">DEPARTURE DATE: <? echo '<font>'.date('d/m/Y',strtotime($authorize['departure_date'])).'</font>';?>
                                    <br>
                                    TIME: <?echo $authorize['departure_time'] ;?></td>
                            </tr>

                            <tr>
                                <td width="25%">CITY: <?echo $authorize['client_city'] ;?></td>
                                <td width="25%">STATE: <?echo $authorize['client_state'] ;?></td>
                                <td width="25%">CAR REGISTRATION: <?echo $authorize['client_car'] ;?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div align="center">
                            <td style="center">AUTHORIZED BY :</td>
                            <td style="text-align:center;"><?if($authorize['autho_by'] != '') {
                                    echo $authorize['autho_by'];}
                                else {  echo $_SESSION['SESS_NAME']; }?>
                            </td>
                        </div>
                        <div align="center">
                            <button class="btn btn-primary"><a href="../controller/aims_gl_autho_update_exec.php?id=<? echo $authorize['id']; ?>&autho_by=<?echo $_SESSION['SESS_NAME'];?>" ><span style="color: white" onclick="return confirm('Are you sure you want to authorize?');">Authorize</span></button></a>
                            <br><br>
                        </div>
                    </div>

                    <script>
                        function convertToUppercase(el) {
                            if(!el || !el.value) return;
                            el.value = el.value.toUpperCase();
                        }
                        function goBack() {
                            window.history.back();
                        }
                    </script>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <!-- /#wrapper -->
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#page-wrapper -->

</div>

</body>

</html>