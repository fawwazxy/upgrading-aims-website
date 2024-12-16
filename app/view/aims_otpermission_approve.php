<?php

include ('../controller/auth.php');

require "../model/aims_ot_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_lumpur");

$id = $_GET['id'];
$no_staff = $_SESSION['SESS_NO_STAFF'];
$approved_by = $_SESSION['SESS_NAME'];
$company = $_SESSION['SESS_DEPARTMENT'];
$code_department = $_SESSION['SESS_DEPARTMENT_SUB'];
$approved_status = $_GET['approved_status'];
$month=$_GET['month'];
$year=$_GET['year'];

if(!isset($month)){
    $month=date('m');

}

if(!isset($year)){
    $year=date('Y');

}

if (!isset($approved_status) && $approved_status == '') {
    $approved_status = 'PENDING';
}


$staff = getStaffInformation($no_staff) -> fetch_assoc();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <? require "../global/header.php"; ?>

</head>

<style type="text/css">



</style>
<script type="text/javascript">

    function un_check(){
        for (var i = 0; i < document.frmactive.elements.length; i++) {
            var e = document.frmactive.elements[i];
            if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                e.checked = document.frmactive.allbox.checked;
            }}}

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
</script>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" >

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
                <h1 class="page-header">
                    OVERTIME PERMISSION APPROVE
                    <!--<a href="v02_aims_otpermission_approve.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>
        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>


        <div class="form-group" align="right">
        </div>

        <br><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Overtime Permission Request List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_otpermission_approve.php?approved_status=PENDING">New</a> &nbsp;|&nbsp;
                        <a href="aims_otpermission_approve.php?approved_status=APPROVED">Approved</a> &nbsp;|&nbsp;
                        <a href="aims_otpermission_approve.php?approved_status=DISAPPROVED">Disapproved</a> &nbsp;|&nbsp;
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <input type="checkbox" id="select_all"/><font size='4'> Select All</font>

                        <? $data=getCheckboxApproveOtp($id,$_SESSION['SESS_NAME']); ?>
                        <form name="frmactive" method="post" action="">
                            <table border="0">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="APPROVE" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="DISAPPROVE" />
                                    </td>
                                </tr>
                            </table><br>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>From</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Applied On</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?

                                if($approved_status == 'PENDING') {
                                    $ot = getOtPermissionPending($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF']);
                                }
                                else if($approved_status == 'APPROVED') {
                                    $ot = getOtPermissionApproved($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF']);
                                }
                                else {
                                    $ot = getOtPermissionDisapproved($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF']);
                                }

                                $i=1;
                                while($otp = $ot->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?>
                                            <align="center">
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $otp['id']; ?>" />

                                        </td>
                                        <td><?php echo $otp['staff_name']; ?></td>
                                        <td><?php echo $otp['otp_date']; ?></td>
                                        <td><?php echo $otp['otp_description']; ?></td>
                                        <td><center><?php echo $otp['created_date']; ?></center></td>
                                        <td><?php
                                            if($otp['approved_status'] == 'PENDING'){
                                                echo "<span style='background-color:WHITE;padding:5px;border-radius:5px;font-weight:bold;color:GREY;'>PENDING</span>";
                                            }
                                            else if($otp['approved_status'] == 'APPROVED') {
                                                echo "<center><span style='background-color:WHITE;padding:5px;border-radius:5px;font-weight:bold;color:GREEN;'>APPROVED</span>
													<br>".$otp['approved_date']."<center>";
                                            }
                                            else{
                                                echo "<center><span style='background-color:WHITE;padding:5px;border-radius:5px;font-weight:bold;color:RED;'>DISAPPROVED</span>
													<br>".$otp['approved_date']."<center>";
                                            }
                                            ?>
                                        </td>
                                        <td>

                                            <?php
                                            if($otp['otp_remark'] != ''){
                                                echo $otp['otp_remark'];
                                            }else{
                                                echo "<a href='#myModal' class='btn btn-info btn-small' data-toggle='modal' data-id=".$otp['id'].">ADD REMARK</a>";
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <? if($approved_status == 'PENDING') { ?>
                                                <a href="#myModal2" class="btn btn-success" data-toggle="modal" data-id="<? echo $otp['id'] ?>">ACTION</a>
                                                <!--	<a href="../controller/aims_otpapp_exec.php?id=<? echo $otp['id']; ?>&approved_by=<? echo $approved_by; ?>&approved_status=APPROVED"><button class="btn btn-success">APPROVE</button></a>
											<a href="../controller/aims_otpapp_exec.php?id=<? echo $otp['id']; ?>&approved_by=<? echo $approved_by; ?>&approved_status=DISAPPROVED"><button class="btn btn-danger">DISAPPROVE</button></a> -->
                                            <?}else if($approved_status == 'APPROVED'){ ?>
                                                <!--	<a href="../controller/aims_otpapp_exec.php?id=<? echo $otp['id']; ?>&approved_by=<? echo $approved_by; ?>&approved_status=DISAPPROVED"><button class="btn btn-danger">DISAPPROVE</button></a> -->
                                                <a href="#myModal2" class="btn btn-success" data-toggle="modal" data-id="<? echo $otp['id'] ?>">ACTION</a>
                                            <?}else{ ?>
                                                <a href="#myModal2" class="btn btn-success" data-toggle="modal" data-id="<? echo $otp['id'] ?>">ACTION</a>
                                                <!--	<a href="../controller/aims_otpapp_exec.php?id=<? echo $otp['id']; ?>&approved_by=<? echo $approved_by; ?>&approved_status=APPROVED"><button class="btn btn-success">APPROVE</button></a> -->
                                            <?} ?>

                                        </td>
                                    </tr>
                                <? } ?>


                                </tbody>

                            </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->



    <!-- Edit Modal HTML -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">ADD REMARK</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_otpermission_remark.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Overtime Permission</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_otpermission_action.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo2').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
            $("#year,#month").change(function(){
                var selected_year=$("#year").val();
                var selected_month=$("#month").val();
                sendType(selected_year,selected_month);
            });

        });
    </script>

</body>

</html>