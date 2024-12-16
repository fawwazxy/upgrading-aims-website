<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

?>
<?
$booking= getBookingListCheckIn($_SESSION['SESS_NAME'],$_SESSION['SESS_DEPARTMENT_SUB']);
$pic_cout = $_SESSION['SESS_NAME'];
$key_by = $_SESSION['SESS_NAME'];
$department_code=$_GET['department_id'];
$status = $_GET['status'];
if (!isset($status) && $status == '') {
    $status = '1';
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
                    <!-- <li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li> -->

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
                <h1 class="page-header">Booking List</h1>
            </div>
        </div>

        <?
        $flagScreen="tab_2";
        include ('../global/aims_gl_menu1.php');
        ?>

        <div class="row">
            <div class="panel-heading" align="right">

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Booking List</label>&nbsp;&nbsp;
                        <a href="aims_gl_booking_list.php?status=1">CheckIn</a> &nbsp;|&nbsp;
                        <a href="aims_gl_booking_list.php?status=0">CheckOut</a> &nbsp;|&nbsp;
                        <a href="aims_gl_booking_list.php?status=2">Cancel</a>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th rowspan="2" width="5%">No.</th>
                                    <th rowspan="2" width="25%">Client Name</th>
                                    <th rowspan="2" width="15%">Phone No</th>
                                    <th rowspan="2" width="15%">Company</th>
                                    <th colspan="2" width="20%">Check In</th>
                                    <th colspan="2" width="20%">Check out</th>
                                    <th rowspan="2" width="10%">Action</th>
                                </tr>

                                <tr style="font-weight: bold;">
                                    <td>Date</td>
                                    <td>Time</td>
                                    <td>Date</td>
                                    <td style="border-right: inset; ">Time</td>
                                </tr>
                                </thead>

                                <?

                                if($status == '1'){
                                    $booking = getBookingListCheckIn($_SESSION['SESS_NAME']);
                                }
                                else if($status == '0'){
                                    $booking = getBookingListCheckOut($_SESSION['SESS_NAME']);
                                }
                                else{
                                    $booking = getBookingListCancel($_SESSION['SESS_NAME']);
                                }

                                $i=1;
                                while($list_booking = $booking->fetch_assoc()) {
                                ?>

                                <tbody>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list_booking['client_name']; ?></td>
                                    <td><? echo $list_booking['client_phone_no']; ?></td>
                                    <td><? echo $list_booking['company_name']; ?></td>
                                    <td><? echo $list_booking['arrival_date']; ?></td>
                                    <td><? echo $list_booking['arrival_time']; ?></td>
                                    <td><? echo $list_booking['departure_date']; ?></td>
                                    <td><? echo $list_booking['departure_time']; ?></td>

                                    <td>
                                        <? if ($list_booking['status']=='1'){?>
                                            <a href="#myModal2" data-toggle="modal" data-id="<? echo $list_booking['id'];?>"><span style="color:#00bfff" title="Info" class="material-icons">info</span></a>

                                            <a href="aims_gl_booking_update.php?id=<? echo $list_booking['id']; ?>"><span class="material-icons" title="Update">border_color</span></a>

                                            <a href="../controller/aims_gl_booking_cancel_exec.php?id=<? echo $list_booking['id']; ?>&room_id=<?echo $list_booking['room_id']; ?>"><span style="color: red"  class="material-icons" title="Cancel" onclick="return confirm('Are you sure you want to cancel?');">cancel</span></a>

                                            <a href="../controller/aims_gl_verified_key_exec.php?id=<? echo $list_booking['id']; ?>&key_by=<?echo $key_by?>" class="btn btn-success" onclick="return confirm('Are you sure you want to verify room key?');">Verify Room Key</a>

                                            <!-- <a href="aims_gl_bookingform_print.php?id=<? echo $list_booking['id']; ?>" class="btn btn-primary">Print</a> -->

                                            <a href="aims_gl_exchange.php?id=<? echo $list_booking['id']; ?>" class="btn btn-warning" >Change Room</a>

                                            <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_booking['id'];?>&arrival_date=<?echo $list_booking['arrival_date']; ?>&room_id=<?echo $list_booking['room_id']; ?>&bed_id=<?echo $list_booking['bed_id']; ?>"><span style="color: green" class="material-icons"  title="Add Ref No">post_add</span></a>

                                            <!-- <a href="../controller/aims_ReviewedButton_exec.php?travel_claim_id=<? echo $row_data['id'];?>&reviewed_name=<?echo $reviewed_name?>"><button class="btn btn-primary" type="button" onclick="return Confirm()" >REVIEW</button></a> -->

                                            <a href="../controller/aims_gl_checkout_exec.php?id=<? echo $list_booking['id']; ?>&pic_cout=<?echo $pic_cout?>&room_id=<?echo $list_booking['room_id']; ?>"><span style="color: red" class="material-icons" title="Check Out" onclick="return confirm('Are you sure you want to check out?');">logout</span></button></a>

                                            <a href="../controller/aims_gl_booking_delete_exec.php?id=<? echo $list_booking['id']; ?>&room_id=<?echo $list_booking['room_id']; ?>&bed_id=<?echo $list_booking['bed_id']; ?>&locker_id=<?echo $list_booking['locker_id']; ?>"><span style="color: #595959" title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a>
                                        <?}?>



                                        <? if ($list_booking['status']=='0'){?>
                                        <a href="aims_gl_bookingform_print.php?id=<? echo $list_booking['id']; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i>Booking Form</a><?}?>




                                    </td>

                                </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
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

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Room Reservation</h4>
                </div>
                <div class="modal-body" id="demo">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_gl_room_reserv_add.php',
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

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Booking Info</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_gl_booking_info.php',
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
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

    </script>

</body>
</html>