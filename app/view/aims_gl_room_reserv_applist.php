<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

$sys = getSys(1)->fetch_assoc();
$applicant_status = $_GET['applicant_status'];
if (!isset($applicant_status) && $applicant_status == '') {
    $applicant_status = '0';
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

</head>

<style>
    body{
        font-size: 12.5px;
    }
    th, td{
        text-align: center;
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
                <h1 class="page-header">Applicant Room Reservation List</h1>
            </div>
        </div>

        <?
        $flagScreen="tab_2";
        include ('../global/aims_gl_menu2.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Room Reservation List</label> &nbsp;&nbsp;
                        <a href="aims_gl_room_reserv_applist.php?applicant_status=0">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_gl_room_reserv_applist.php?applicant_status=1">DONE</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width=" 10%">NO.</th>
                                <th>RR NO</th>
                                <th>CLIENT</th>
                                <th>STATUS</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?

                            if($applicant_status == 0){
                                $rr = getRoomReservAppListPending();
                            }
                            else{
                                $rr = getRoomReservAppListDone();
                            }
                            $i=1;
                            while($list_rr = $rr->fetch_assoc()) {

                                $applicant_date = new DateTime($list_rr['applicant_date'])
                                ?>


                                <tr>
                                    <td><? echo $i++;?>
                                        <!-- <? echo $list_rr['booking_id'];?> --></td>
                                    <td><? echo $list_rr['ref_no']; ?></td>
                                    <td><? echo $list_rr['client_company_id']; ?></td>
                                    <td style='text-align:center'>
                                        <?php $list_rr['applicant_by'];
                                        if($list_rr['applicant_status']=='0'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else {
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DONE</span>
                                                        <br><br>".$list_rr['applicant_by']."<br>".$applicant_date->format('d-m-Y').""; }
                                        ?>
                                    </td>
                                    </td>
                                    <td>
                                        <? if ($list_rr['applicant_status']=='0'){?>

                                            <a href="aims_gl_room_reserv_appupdate.php?id=<? echo $list_rr['id'];?>&ref_no=<? echo $list_rr['ref_no'];?>&client_company_id=<? echo $list_rr['client_company_id'];?>&booking_id=<? echo $list_rr['booking_id'];?>" class="btn btn-info" data-toggle="" data-id="">Confirm</a>
                                        <?}?>
                                    </td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'aims_gl_room_reserv_update.php',
                            data:'id='+rowid,
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>
</html>