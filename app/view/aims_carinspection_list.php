<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarRequestById($id)->fetch_assoc();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://kit.fontawesome.com/a076d05399.js" rel="stylesheet">

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
                <h1 class="page-header">Car Request</h1>
            </div>
        </div>


        <?

        $flagScreen="tab_4";

        include ('../global/menu_carReserve.php');
        ?>

        <br>

        <div class="form-group" align="right">
        </div>


        <div class="row">
            <div class="col-lg-12"><!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="content__table" id="dataTables-example">
                        <thead>
                        <tr>
                            <th width="7%">No.</th>
                            <th width="15%">Staff</th>
                            <th width="7%">Fuel</th>
                            <th width="15%">Car Requirement</th>
                            <th width="15%">Exterior Car</th>
                            <th width="15%">Interior Car</th>
                            <th width="20%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $car = getcarInspectionList($_SESSION['SESS_NAME']);
                        $i=1;
                        while($list_car = $car->fetch_assoc()) {
                            ?>
                            <tr>
                                <td style="text-align:center"><? echo $i++;?></td>
                                <td style="text-align:left"><b>Nama : <? echo $list_car['name']; ?></b><br>
                                    <b>No plate : <? echo $list_car['car_plate_no']; ?></b><br>
                                    <b>Date : <? echo $list_car['dep_date']; ?></b>
                                </td>
                                <td style="text-align:center"><? echo $list_car['fuel']; ?></td>
                                <td style="text-align:center"><? echo $list_car['hd_vehicle']; ?></td>
                                <td style="text-align:center"><? echo $list_car['exterior_car']; ?><br><br>
                                    <p style="text-align:left">COMMENT :<? echo $list_car['comment1']; ?></p></td>
                                <td style="text-align:center"><? echo $list_car['interior_car']; ?><br><br>
                                    <p style="text-align:left">COMMENT :<? echo $list_car['comment']; ?></p></td>
                                <td style="vertical-align: middle!important;text-align: center;">
                                    <div class="btn-group">
                                        <button title="Edit"><a href="aims_carinspection_update.php?id=<? echo $list_car['id']; ?>"><i class='fa fa-edit'></i></a></button>
                                        <button onclick="return confirm('Are you sure you want to delete?');"> <a href="../controller/aims_car_inspection_delete_exec.php?id=<? echo $list_car['id'];?>"><i class="fa fa-trash" title="Delete"></i></a></button>
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_carinspection_add.php',
                                data:'id='+rowid,
                                success:function(html){
                                    $('#demo1').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

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
                                url:'aims_carinspection_update.php',
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