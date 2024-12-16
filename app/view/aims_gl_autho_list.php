<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

if(in_array($_SESSION['SESS_NOKP'],['950728035572','940718115430'])){ // syuhada, syamimy
    echo "<script type='text/javascript'>
            window.location.href='../view/aims_gl_admin.php';
            </script>";
    exit();
}

$id = $_GET['id'];
$autho_by = $_SESSION['SESS_NAME'];
$authorize= getAuthoList($autho_by);
$autho_status = $_GET['autho_status'];
if (!isset($autho_status) && $autho_status == '') {
    $autho_status = 'PENDING';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: "Arial", serif;
        }
        th, td {
            text-align: center;
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
                <h1 class="page-header">Booking Authorization List</h1>
            </div>
        </div>

        <? $flagScreen="tab_1";
        include ('../global/aims_gl_menu2.php'); ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Authorization List</label>&nbsp;&nbsp;
                        <a href="aims_gl_autho_list.php?autho_status=PENDING">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_gl_autho_list.php?autho_status=AUTHORIZE">AUTHORIZED</a>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width: 5%;">No.</th>
                                <th rowspan="2">Booking Info</th>
                                <th rowspan="2">Room Info</th>
                                <th rowspan="2" style="width: 10%;">Status</th>
                                <th rowspan="2" style="width: 10%;">Action</th>
                            </tr>
                            </thead>
                            <?
                            $i= 1;
                            if($autho_status == 'PENDING'){
                                $authorize= getAuthorizeNew();
                            } else{
                                $authorize= getAuthorizeDone();
                            }
                            while($list_authorize = $authorize->fetch_assoc()) {

                            $autho_date = new DateTime($list_authorize['autho_date'])
                            ?>
                            <tbody>
                            <tr>
                                <td><? echo $i++;?></td>
                                <td style="text-align: left">
                                    NAME:<?echo $list_authorize['client_name'];?> <br>
                                    IC:<?echo $list_authorize['client_ic'];?>  <br>
                                    COMPANY:<?echo $list_authorize['client_name'];?><br>
                                    PHONE NO: <?echo $list_authorize['client_phone_no'];?><br>
                                    CHECK IN: <?echo date('d-m-Y', strtotime($list_authorize['arrival_date'])).' '.date('h:i a', strtotime($list_authorize['arrival_time']));?><br>
                                    CHECK OUT: <?echo date('d-m-Y', strtotime($list_authorize['departure_date'])).' '.date('h:i a', strtotime($list_authorize['departure_time']));?><br>
                                </td>
                                <td>
                                    ROOM NO:<?echo $list_authorize['room_id'];?> <br>
                                    BED NO:<?echo $list_authorize['bed_id'];?>  <br>
                                    LOCKER NO:<?echo $list_authorize['locker_id'];?><br>
                                </td>
                                <td style='text-align:center'>
                                    <?
                                    if($list_authorize['autho_status']=='PENDING'){
                                        echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                    else{
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>AUTHORIZED</span><br><br>".$list_authorize['autho_by']."<br>".$autho_date->format('d-m-Y').""; }
                                    ?>
                                </td>
                                <td>
                                    <? if ($list_authorize['autho_status']=='PENDING'){?>
                                        <a href="aims_gl_autho_update.php?id=<? echo $list_authorize['id']; ?>"
                                           class="btn btn-primary">Authorize</a>
                                    <?}?>
                                </td>
                            </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>