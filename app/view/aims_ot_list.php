<?php

include ('../controller/auth.php');

require "../model/aims_ot_function.php";
require "../model/lookup.php";



?>
<?

$name = $_SESSION['SESS_NAME'] ;
$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$company = $_SESSION['SESS_DEPARTMENT'];
$department = $_SESSION['SESS_DEPARTMENT_SUB'];
$noic = $_SESSION['SESS_NOKP'];
$sys = getSys(1)-> fetch_assoc();
$flag=$_GET['flg'];
?>
<?
$staff = getOtStaffInfo($no_staff) -> fetch_assoc();
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

    .material-icons.md-18 { font-size: 20px; }
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
                <h1 class="page-header">
                    Overtime Claim
                    <!--<a href="v02_aims_ot_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>
        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>


        <?
        $flag="tab_1";
        include ('../global/aims_ot_menu.php');
        ?>

        <div class="row">
            <div class="panel-heading" align="right">



                <table width="100%" >
                    <tr>
                        <th width="14%"></th>
                        <th width="2%"></th>
                        <th></th>
                    </tr>

                    <tr>
                        <td><label>Name</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $name; ?></td>
                    </tr>

                    <tr>
                        <td><label>IC No</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $noic; ?></td>
                    </tr>

                    <tr>
                        <td><label>Company</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $company; ?></td>
                    </tr>

                    <tr>
                        <td><label>Department</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $department; ?></td>
                    </tr>

                </table>

            </div>
            <div class="panel-heading" align="right">
                <div align="right">
                    <a href="aims_ot_form.php?no_staff=<? echo $no_staff;?>&staff_record_id=<?echo $staff['staff_record_id'];?>"><button class="btn btn-primary">Overtime Form</button></a>
                </div>

            </div>
        </div>   <!-- /.panel-heading -->
        <div class="row">
            <div class="col-1g-12">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <label>REMINDER: PLEASE FILL UP CLAIM BEFORE 15th DAY OF EVERY MONTH.<br>
                            FOR OVERTIME DATE <font color="red">OVER 15th, PLEASE CHOOSE NEXT MONTH AS THE MONTH CLAIM.</font></label>
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Month Claim</th>
                                <th>Date/Day</th>
                                <th width="10%">Time</th>
                                <th>Working Period</th>
                                <th>Work Description</th>
                                <th>HOD Status</th>
                                <th>HR Status</th>
                                <th>CEO/CHAIRMAN Status</th>
                                <th>Payment Status (In Development)</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $overtime = getOtList($_SESSION['SESS_NO_STAFF']);
                            $i=1;
                            while($ot = $overtime->fetch_assoc()) {

                            $start_ot= date('h:i a', strtotime($ot['start_ot']));
                            $end_ot= date('h:i a', strtotime($ot['end_ot']));
                            ?>

                            <tr>


                                <td><?php echo $i++; ?></td>
                                <td><?php echo $ot['month_claim']; ?></td>
                                <td><?php echo $ot['date_ot']; ?><br><?php echo $ot['day_ot']; ?></td>
                                <td>
                                    <b>Start:</b><br> <?php echo $start_ot; ?>
                                    <br>
                                    <b>End:</b><br> <?php echo $end_ot; ?>
                                </td>

                                <td><?php echo $ot['working_hours']; ?></td>
                                <td><?php echo $ot['description_ot']; ?></td>

                                <td>
                                    <?'<b>'.$ot['verify_status'].'</b>';
                                    if($ot['verify_status']==PENDING){
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius:5px;font-weight:bold;color:GREY;'>PENDING</span><br><center>".$ot['hod_remark']."</center>";}
                                    else if($ot['verify_status']==VERIFIED){
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius: 5px; font-weight:bold;color:GREEN;'>VERIFIED</span><br>".$ot['hod_remark']."</center>";}

                                    else {
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius: 5px; font-weight:bold;color:RED;'>REJECTED</span><br><center>".$ot['hod_remark']."</center>";}

                                    ?>
                                </td>

                                <td>
                                    <?'<b>'.$ot['review_status'].'</b>';
                                    if($ot['review_status']==PENDING){
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius:5px;font-weight:bold;color:GREY;'>PENDING</span></center>";}
                                    else if($ot['review_status']==REVIEWED){
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius: 5px; font-weight:bold;color:GREEN;'>REVIEWED</span></center>";}

                                    else {
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius: 5px; font-weight:bold;color:RED;'>REJECTED</span></center>";}

                                    ?>


                                <td>
                                    <?'<b>'.$ot['approved_status'].'</b>';
                                    if($ot['approved_status']==PENDING){
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius:5px;font-weight:bold;color:GREY;'>PENDING</span></center>";}
                                    else if($ot['approved_status']==APPROVED){
                                        echo"<center><span style='background-color:WHITE;;padding:5px;border-radius: 5px; font-weight:bold;color:GREEN;'>APPROVED</span></center>";}

                                    else {
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius: 5px; font-weight:bold;color:RED;'>DISAPPROVED</span></center>";}

                                    ?>
                                </td>

                                </td>


                                <td>
                                    <?'<b>'.$ot['payment_status'].'</b>';
                                    if($ot['payment_status']==OPEN){
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius:5px;font-weight:bold;color:RED;'>OPEN</span></center>";}
                                    else {
                                        echo"<center><span style='background-color:WHITE;padding:5px;border-radius: 5px; font-weight:bold;color:GREEN;'>CLOSE</span></center>";}

                                    ?>
                                </td>

                                <td>
                                    <?	'<b>'.$ot['review_status'].'</b>';
                                    if($ot['review_status']==PENDING){ ?>
                                        <a href="#updateOT" class="edit" data-toggle="modal" data-id="<? echo $ot['id'];?>"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                        <a href="../controller/aims_otdelete_exec.php?id=<? echo $ot['id']; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class="material-icons" style="color: red;" data-toggle="tooltip" title="Delete">&#xE872;</i></a>

                                        <? if ($ot['document_name'] != '') {?>
                                            <!--		<a href="#myModal2" data-toggle="modal" data-id="<? echo $ot['id'];?>"><span class="material-icons md-18" title="Attachment">file_present</span></a> -->
                                            <a href="" onclick="return popitup('aims_ot_attachment.php?id=<? echo $ot['id'];?>')"><span class="material-icons md-18" title="Attachment">file_present</span></a>
                                            <!--	<a href="" onclick="return popitup('aims_ot_attachment.php?id=<? echo $ot['id'];?>')"><button type="button" class="btn btn-primary">ATTACHMENT</button></a> -->
                                        <?	}
                                    }
                                    else if($ot['review_status']==REVIEWED){	?>
                                        <a href="../controller/aims_otdelete_exec.php?id=<? echo $ot['id']; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class="material-icons" style="color: red;" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                        <?
                                        if ($ot['document_name'] != '') {?>
                                            <a href="" onclick="return popitup('aims_ot_attachment.php?id=<? echo $ot['id'];?>')"><span class="material-icons md-18" title="Attachment">file_present</span></a>
                                        <?	}
                                    }
                                    else	{ ?>
                                        <? if ($ot['document_name'] != '') {?>
                                            <a href="" onclick="return popitup('aims_ot_attachment.php?id=<? echo $ot['id'];?>')"><span class="material-icons md-18" title="Attachment">file_present</span></a>
                                        <?	}
                                    } ?>




                                </td>

                                <? }?>



                            </tr>
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

</div>
<!-- /#wrapper -->

<div class="modal fade" id="updateOT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">EDIT OVERTIME CLAIM</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#updateOT').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_ot_update.php',
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


<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <!--Content-->
        <div class="modal-content">

            <!--Body-->
            <div class="modal-body" id="demo2">

                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');

                        $.ajax({
                            type:'POST',
                            url:'aims_ot_attachment.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo2').html(html);
                            }
                        });
                    });
                </script>

            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline- btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!--/.Content-->

    </div>
</div>





<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }

</script>



</body>

</html>