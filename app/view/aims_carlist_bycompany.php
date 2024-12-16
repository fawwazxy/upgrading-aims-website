<?php

include ('../controller/auth.php');

require "../model/aims_car_function.php";
require "../model/lookup.php";

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
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
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
                <h1 class="page-header">Transport List</h1>
            </div>
        </div>


        <?
        $flagScreen="tab_1";
        include ('../global/menu_car_company.php');
        ?>


        <div class="row">
            <div class="col-lg-12">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="content__table" id="dataTables-example">
                        <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="15%">Model</th>
                            <th width="10%">No Plate</th>
                            <th width="5%">Type of Car</th>
                            <th width="10%">Owner</th>
                            <th width="20%">PIC 1</th>
                            <th width="20%">PIC 2</th>
                            <th width="10%">Status</th>
                            <th width="5%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $car = getcarListbyStaff($_SESSION['SESS_NAME']);
                        $i=1;
                        while($list_car = $car->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><? echo $i++;?></td>
                                <td style="text-align:center"><? echo $list_car['car_model']; ?></td>
                                <td style="text-align:center"><? echo $list_car['car_plate_no']; ?></td>
                                <td style="text-align:center"><? echo $list_car['car_type']; ?></td>
                                <td style="text-align:center"><? echo $list_car['car_owner']; ?></td>
                                <td style="text-align:center"><? echo $list_car['car_pic']; ?></td>
                                <td style="text-align:center"><? echo $list_car['car_pic2']; ?></td>
                                <td style="text-align:center"><? if($list_car['car_status'] =="1")
                                    {echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>NOT AVAILABLE</span>";}
                                    else {
                                        echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>AVAILABLE</span>";
                                    }?>
                                    <br><br>
                                    <? echo $list_car['update_date']; ?>
                                </td>
                                <td style="vertical-align: middle!important;text-align: center;">
                                    <div class="btn-group">
                                        <button title="Edit"><a href="#myModal1" data-toggle="modal" data-id="<? echo $list_car['id'];?>"><i class='fa fa-edit'></i></a></button>

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
    </div></div>
<!-- /#wrapper -->


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
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'aims_car_updateby_company.php',
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