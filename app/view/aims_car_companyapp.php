<?php
include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$app_status = $_GET['app_status'];
if (!isset($app_status) && $app_status == '') {
    $app_status = 'PENDING';
}
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$car= getcarRequestListPendingCompany($_SESSION['SESS_NAME'],$_SESSION['SESS_DEPARTMENT_SUB']);
$admin = 'company';
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

</head>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<style>

    body{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #f2f2f2;
        font-family: 'Poppins';
    }
    h1{
        text-transform: uppercase;
        letter-spacing: 3px;
        color: rgba(0,0,0, 0.45);
    }
    .content__table{
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        min-width: 200px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0, 0.15);

    }
    .content__table thead tr{
        background-color: #f1c40f;
        color: rgba(0,0,0, 0.45);
        text-align: left;
        font-weight: bold;
        text-transform: capitalize;
    }

    .content__table th,
    .content__table td {
        padding: 12px 15px;
    }
    .content__table tbody tr{
        /*border-bottom: 1px solid #aaa;*/
        color: #444;
        text-align: center;
    }
    .content__table tbody tr:nth-of-type(even){
        background-color: rgba(241,196,15,0.30);
    }
    .content__table tbody tr:last-of-type{
        border-bottom: 2px solid #f1c40f;
    }
    .content__table tbody tr.active__row{
        font-weight: bold;
        color: #f1c40f;
    }
    .content__table tbody tr td:hover{
        background-color: #f1c40f;
        color: #444;
        font-weight: bold;
        cursor: pointer;
    }

    .footer{
        font-weight: 600;
        color: #444;}
    .footer a{
        color: #444;
    }
    .footer a:hover{
        background-color: rgba(241,196,15,0.3);
    }

    .btn-group button {
        background-color: #c0c0c0; /* Green background */
        border: 1px solid green; /* Green border */
        color: white; /* White text */
        padding: 5px 5px; /* Some padding */
        cursor: pointer; /* Pointer/hand icon */
        float: left; /* Float the buttons side by side */
    }

    /* Clear floats (clearfix hack) */
    .btn-group:after {
        content: "";
        clear: both;
        display: table;
    }

    .btn-group button:not(:last-child) {
        border-right: none; /* Prevent double borders */
    }

    /* Add a background color on hover */
    .btn-group button:hover {
        background-color:#708090;
    }

    .modal-header{
        background-color:#f1c40f;
    }

    //button approve
      .animate
      {
          transition: all 0.1s;
          -webkit-transition: all 0.1s;
      }

    .action-button
    {
        position: relative;
        padding: 5px 20px;
        margin: 0px 10px 10px 0px;
        float: left;
        border-radius: 8px;
        font-family: 'Pacifico', cursive;
        font-size: 10px;
        color: #FFF;
        text-decoration: none;
    }

    .blue
    {
        background-color: #3498DB;
        border-bottom: 5px solid #2980B9;
        text-shadow: 0px -2px #2980B9;
    }

    .red
    {
        background-color: #E74C3C;
        border-bottom: 5px solid #BD3E31;
        text-shadow: 0px -2px #BD3E31;
    }

    .green
    {
        background-color: #82BF56;
        border-bottom: 5px solid #669644;
        text-shadow: 0px -2px #669644;
    }

    .yellow
    {
        background-color: #F2CF66;
        border-bottom: 5px solid #D1B358;
        text-shadow: 0px -2px #D1B358;
    }

    .action-button:active
    {
        transform: translate(0px,5px);
        -webkit-transform: translate(0px,5px);
        border-bottom: 1px solid;
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
                <h1 class="page-header">Staff Request Vehicle List</h1>
            </div>
        </div>

        <?
        $flagScreen="tab_2";
        include ('../global/menu_car_company.php');
        ?>



        <div class="row">
            <div class="col-lg-12">






                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="content__table" id="dataTables-example">
                        <a href="aims_car_companyapp.php?app_status=PENDING" class="action-button animate blue">NEW LIST</a>
                        <a href="aims_car_companyapp.php?app_status=APPROVE" class="action-button animate green">APPROVED LIST</a>
                        <a href="aims_car_companyapp.php?app_status=DISAPPROVE" class="action-button animate red">DISAPPROVED LIST</a><br><br>
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Staff Info</th>
                            <th>Reason</th>
                            <th>Approvel HOD</th>
                            <th>Status Approvel PIC</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>


                        <?
                        if($app_status == 'PENDING') {
                            $car= getcarRequestListPendingCompany($_SESSION['SESS_NAME'],$_SESSION['SESS_DEPARTMENT']);
                        }
                        else if($app_status == 'APPROVE') {
                            $car= getcarRequestListApproveCompany($_SESSION['SESS_NAME']);
                        }
                        else {
                            $car= getcarRequestListDisapproveCompany($_SESSION['SESS_NAME']);
                        }
                        $i=1;
                        while($row_data1 = $car->fetch_assoc() ) {
                            ?>
                            <tr>
                                <td><? echo $i++;?></td>
                                <td style="vertical-align:left;vertical-align: middle!important;">
                                    <label class="control-label">NAME :</label> <? echo $row_data1['name'];?><br>
                                    <label class="control-label">DESIGNATION : </label> <? echo $row_data1['jawatan'];?>
                                </td>
                                <td style="vertical-align: middle!important;text-align: center;"><? echo $row_data1['reason'];?></td>
                                <td style="text-align:center;vertical-align: middle!important;"><?'<b>'.$row_data1['app_status'].'</b>';
                                    if($row_data1['sbu_hod_app']=="PENDING"){
                                        echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                    else if ($row_data1['sbu_hod_app']=="APPROVE"){
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
                                        ;}
                                    else{
                                        echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>"
                                        ;}'</b>'?>
                                    <br><br><? echo $row_data1['approve_by'];?>
                                    <br><br><? echo $row_data1['hod_date'];?>
                                </td>
                                <td style="text-align:center;vertical-align: middle!important;"><?'<b>'.$row_data1['app_status'].'</b>';
                                    if($row_data1['app_status']=="PENDING"){
                                        echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                    else if ($row_data1['app_status']=="APPROVE"){
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
                                        ;}
                                    else{
                                        echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>"
                                        ;}'</b>'?>
                                    <br><br><? echo $row_data1['name_admin'];?>
                                    <br><br><? echo $row_data1['date_app'];?>
                                </td>
                                <td style="vertical-align: middle!important;text-align: center;">
                                    <div class="btn-group">
                                        <button title="Admin Approvel"><?php echo "<a href='#myModal1' data-toggle='modal' data-id=".$row_data1['admin_id']." data-status=".$admin."><i class='fa fa-tasks'></i></a>"; ?></button>
                                        <button title="Request Info"><?php echo "<a href='#myModal'  data-toggle='modal' data-id=".$row_data1['id']."><i class='fa fa-info-circle'></i></a>"; ?></button>
                                        <button title="Passenger"><?php echo "<a href='#myModal2' data-toggle='modal' data-id=".$row_data1['id']."><i class='fa fa-users'></i></a>"; ?></button>
                                        <button title="Edit"><a href="aims_carReserve_update.php?id=<? echo $row_data1['id']; ?>&status=<? echo $admin; ?>&status1=<? echo $row_data1['app_status']; ?>"><i class='fa fa-edit'></i></a></button>
                                        <? if ($row_data1['taf_id'] != '0') {?>
                                            <button type="button" title="Travel Info"><?php echo "<a href='#myModal5' data-toggle='modal' data-id=". $row_data1['taf_id']."><i class='fa fa-plane'></i></a>"; ?></button>
                                        <?}?>
                                        <button title="Fuel Claim"><a href=""  onclick="return popitup('aims_car_fuelclaim_form.php?id=<? echo $row_data1['id'];?>')"><i class="fa fa-gas-pump"></i></a></button>
                                        <button title="TnG Claim"><a href=""  onclick="return popitup('aims_car_tngclaim_form.php?id=<? echo $row_data1['id'];?>')"><i class='fa fa-credit-card'></i></a></button>
                                    </div>
                                </td>
                            </tr>
                        <?}?>

                        </tbody>
                    </table>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <!--
                <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <!-- Modal -->



    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

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
                            var status = $(e.relatedTarget).data('status');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_car_adUse_add.php',
                                data:{id:rowid,status:status},
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="moda1-title" id="myModalLabel2">CAR RESERVE INFO</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_carReserve_adminInfo.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo3').html(html);
                                }
                            });
                        });

                    </script>
                </div>
            </div>\
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="moda1-title" id="myModalLabel3">CAR RESERVE ADMIN INFO</h4>
                </div>
                <div class="modal-body" id="demo4">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_carpassenger_info.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo4').html(html);
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

    <div class="modal fade modal-xl" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel5">Travel Request</h4>
                </div>
                <div class="modal-body" id="demo5">
                    <script type="text/javascript">
                        $('#myModal5').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_travel_listInfo.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo5').html(html);
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

        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=890');
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>


</body>

</html>