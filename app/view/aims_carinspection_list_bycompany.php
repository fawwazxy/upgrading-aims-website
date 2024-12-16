<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$name = $_GET['name'];
$staff = 'staff';
$car_info = getcarRequestById($id)->fetch_assoc();
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$department_code=$_GET['department_id'];
$statact = $_GET['statact'];
if(!isset($statact)){
    $statact = 'ACTIVE';

}

$month=$_GET['month'];
$year=$_GET['year'];

if(!isset($month)){
    $month=date('m');

}

if(!isset($year)){
    $year=date('Y');

}
$sys = getSys(1)->fetch_assoc();
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
    .div {
        padding: 30px;
    }

    .content__table{
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        min-width: 100px;
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

    @media screen and (max-width: 500px){
        .content__table{display:none;}
        body{background-color: rgba(0,0,0, 0.15);}
        h1{color: rgba(241,196,15,1);
            animation: rotation 5s 1s 1;}
    }

    @keyframes rotation{
        from{transform: rotate(0deg);}
        to{transform: rotate(360deg) scale(2);}
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

    body{
        background-image:url('https://www.meru.in/assets/corporate/inner-pages/images/car-rentals1.png');
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    td,th{
        font-size:10px;
    }
</style>

<body>

<div id="wrapper">


    <div class="div">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Car Inspection</h1>
            </div>
        </div>

        <div class="form-group" align="right">
            <button type="button"><a href="aims_car_login.php">Log Out!</a></button>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Car By Person In Charge</label>
                    </div>





                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="content__table" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">No.</th>
                                <th width="7%">Model</th>
                                <th width="15%">Plate No</th>
                                <th width="15%">Type Car</th>
                                <th width="40%">Company</th>
                                <th width="20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $car = getcarInspectionList2($name);
                            $i=1;
                            while($list_car = $car->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td style="text-align:center"><? echo $i++;?>
                                        <input id="name" name="name" type="hidden" class="input-short" value="<? echo $name;?>" /> </td>
                                    <td style="text-align:center"><? echo $list_car['car_model']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['car_plate_no']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['car_type']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['car_owner']; ?></td>
                                    <td>
                                        <button title="Add"><a href="aims_carinspection_bycompany.php?car_plate_no=<? echo $list_car['car_plate_no']; ?>&status=<? echo $staff?>"><i class="fa fa-plus"></i></a></button>
                                    </td>
                                </tr>
                            <?}?>


                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->

            <div class="row" style="padding-left:30px; padding-bottom:20px;">
                <div class="col-lg-4">


                    <select  required class="form-control" name="year" id="year">
                        <option value="0">-- Choose Year--</option>
                        <? echo getDropDownYearCom($year);?>
                    </select>
                </div>
                <div class="col-lg-4">

                    <!--BUAT TABLE MONTH-->
                    <select  required class="form-control" name="month" id="month">
                        <option value="0">-- Choose Month--</option>
                        <? echo getDropDownMonthCom($month);?>
                    </select>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Car Inspection</label>
                    </div>





                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="content__table" id="dataTable-example" border="1">
                            <thead>
                            <tr>
                                <th width="5%" style="text-align:center">No.</th>
                                <th width="10%" style="text-align:center">No Plate & Fuel</th>
                                <th width="10%" style="text-align:center">Milage</th>
                                <th width="10%" style="text-align:center">Car Accessories</th>
                                <th width="15%" style="text-align:center">Exterior Car</th>
                                <th width="15%" style="text-align:center">Interior Car</th>
                                <th width="11%" style="text-align:center">Update By</th>
                                <th width="14%" style="text-align:center">Remark Admin</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $car = getcarInspectionList3($name,$month);
                            $i=1;
                            while($list_car1 = $car->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td style="text-align:center" rowspan="2"><? echo $i++;?></td>
                                    <td style="text-align:left"> PLATE NO : <? echo $list_car1['car_plate_no']; ?></td>
                                    <td style="text-align:left"> DEPATURE : <? echo $list_car1['dep_milage']; ?></td>
                                    <td style="text-align:center" rowspan="2"><? echo $list_car1['hd_vehicle']; ?></td>
                                    <td style="text-align:center"><? echo $list_car1['exterior_car']; ?></td>
                                    <td style="text-align:center"><? echo $list_car1['interior_car']; ?></td>
                                    <td style="text-align:center" rowspan="2"><? echo $list_car1['created_name']; ?></td>
                                    <td style="text-align:center" rowspan="2"><? if($list_car1['status_remark'] =="CHECK")
                                        {echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>CHECK</span>";}
                                        else if ($list_car1['status_remark'] =="UNCHECK"){
                                            echo "<span style='background-color:grey; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>UNCHECK</span>";
                                        }?><br><br><? echo $list_car1['remark_name']; ?><br><br>
                                        <? echo $list_car1['remark']; ?></td>
                                    <td rowspan="2" >
                                        <button title="Edit"><a href="aims_carinspection_update1.php?id=<? echo $list_car1['id']; ?>&status=<? echo $staff?>&month=<? echo $month?>"><i class='fa fa-edit'></i></a></button>
                                        <button title="Delete"><a href="../controller/aims_carinspection_bycompany_delete_exec.php?id=<? echo $list_car1['id']; ?>&name=<? echo $name?>&month=<? echo $month?>" onclick="return confirm('Are you sure you want to delete?');"><i class='fa fa-trash'></i></a></button>

                                    </td>
                                </tr>

                                <tr>
                                    <td style="text-align:left">FUEL : <? echo $list_car1['fuel']; ?></td>
                                    <td style="text-align:left">RETURN : <? echo $list_car1['return_milage']; ?></td>
                                    <td style="text-align:left">COMMENT : <? echo $list_car1['comment1']; ?></td>
                                    <td style="text-align:left">COMMENT : <? echo $list_car1['comment']; ?></td>
                                </tr>

                            <?}?>


                            </tbody>
                        </table>
                    </div>
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
    var name = document.getElementById("name").value;

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
    function sendType(year,month){
        if(month==undefined){
            window.location.href="aims_carinspection_list_bycompany.php?name="+name+"&year="+year;
        }else{
            window.location.href="aims_carinspection_list_bycompany.php?name="+name+"&year="+year+"&month="+month;
        }


    }
</script>


</body>

</html>