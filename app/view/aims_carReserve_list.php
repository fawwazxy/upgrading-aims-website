<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$staff = 'staff';
$list_car = getcarRequestById($id)->fetch_assoc();
///aims/app/view/aims_car_login.php -> TRANSPORT PERSON IN CHARGE INSPECTION
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <? require "../global/header.php"; ?>

</head>

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
                <h1 class="page-header"> Transport Request List</h1>
            </div>
        </div>

        <?
        $flagScreen="tab_2";
        include ('../global/menu_carReserve.php');
        ?>




        <div class="row">
            <div class="col-lg-12">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="content__table" id="dataTables-example">
                        <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="30%">Name</th>
                            <th width="15%">Approval HOD/CEO/CHAIRMAN</th>
                            <th width="15%">Approval Admin</th>
                            <th width="15%">Status Summon</th>
                            <th width="25%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $car = getcarRequestList($_SESSION['SESS_NAME']);
                        $i=1;
                        while($list_car = $car->fetch_assoc()) {
                            ?>

                            <tr>
                                <td><? echo $i++;?></td>
                                <td style="text-align:center"><? echo $list_car['name']; ?></td>
                                <td style="text-align:center"><? if($list_car['sbu_hod_app'] =="PENDING")
                                    {echo "<span style='background-color:Grey; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";}
                                    else if ($list_car['sbu_hod_app'] =="APPROVE"){
                                        echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVED</span>";
                                    }
                                    else {
                                        echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>DISAPPROVE</span>";
                                    }?>
                                </td>
                                <td style="text-align:center"><? if($list_car['app_status'] =="PENDING")
                                    {echo "<span style='background-color:Grey; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";}
                                    else if ($list_car['app_status'] =="APPROVE"){
                                        echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVED</span>";
                                    }
                                    else {
                                        echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>DISAPPROVE</span>";
                                    }?>
                                </td>
                                <td style="text-align:center"><? if($list_car['summon_status'] =="PAID")
                                    {echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PAID</span>";}
                                    else if ($list_car['summon_status'] =="UNPAID"){
                                        echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>UNPAID</span>";
                                    }
                                    else {
                                        echo "<span style=' padding:5px; border-radius: 5px; font-weight: bold; color:BLACK;'>-</span>";
                                    }?>
                                </td>
                                <td style="vertical-align: middle!important;text-align: center;">
                                    <div class="btn-group">
                                        <button title="Request Info"><a href="#myModal1" data-toggle="modal" data-id="<? echo $list_car['id']; ?>"><i class='fa fa-info-circle'></i></a></button>

                                        <button title="Edit"><a href="aims_carReserve_update.php?id=<? echo $list_car['id']; ?>&status=<? echo $staff ?>"><i class='fa fa-edit'></i></a></button>

                                        <button onclick="return confirm('Are you sure you want to delete?');" title="Delete"><a href="../controller/aims_carReserve_delete_exec.php?id=<? echo $list_car['id']; ?>"><i class="fa fa-trash"></i></a></button>

                                        <button title="Passenger"><?php echo "<a href='#myModal' data-toggle='modal' data-id=".$list_car['id']."><i class='fa fa-users'></i></a>"; ?></button>
                                        <button title="Inspection"><a href="aims_carinspection_add.php?id=<? echo $list_car['id'];?>"><i class="fa fa-car"></i></a></button>
                                        <button title="Print"><a href="aims_carRequest_print.php?id=<? echo $list_car['id'];?>"><i class="fa fa-print"></i></a></button>
                                        <button title="Fuel Claim"><a href=""  onclick="return popitup('aims_car_fuelclaim_form.php?id=<? echo $list_car['id'];?>')"><i class='fas fa-gas-pump'></i></a></button>
                                        <button title="TnG Claim"><a href=""  onclick="return popitup('aims_car_tngclaim_form.php?id=<? echo $list_car['id'];?>')"><i class='fa fa-credit-card'></i></a></button>
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

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <!-- Modal -->


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="moda1-title" id="myModalLabel1">CAR RESERVE Info</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_carReserve_info.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo3').html(html);
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add passenger</h4>
                </div>
                <div class="modal-body" id="demo">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_carpassenger_add.php',
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
    -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
    <script language="javascript" type="text/javascript">

        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=890');
            if (window.focus) {newwindow.focus()}
            return false;
        }

    </script>

</body>

</html>