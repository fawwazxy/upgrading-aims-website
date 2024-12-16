<?php

echo "<script>
alert('This module has been migrated to Aims-Corp. Please visit https://corp.aimsglobal.com.my to use this module.');
window.history.back();
</script>";
exit();

include ('../controller/auth.php');
require "../model/aims_car_function.php";
require "../model/lookup.php";

$car_location=$_GET['car_location'];
if (!isset($car_location) && $car_location == '') {
    $car_location = 'NONE';
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
        min-width: 100px;
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

    //image transaction

      .page-wrappers{
          width:80%;
          margin:0 auto;
      }
    .select-block {
        list-style:none;
        padding:0;
        cursor:default;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;

    }

    .select-block li{
        cursor:default;
        display: inline-block;
        width:50px;
        height:50px;
        line-height:50px;
        text-align: center;
        border: 2px solid #fff;
        border-radius:50%;

    }
    .select-block li.active{
        border-color:#ddd;
    }
    .bg-block img {
        max-width:50%;
    }
    /* musthave style */
    .bg-container {
        position:relative;

    }
    .bg-container:before{
        content: '';
        display: block;
        padding-top: 39.25%;
        height: 0;
    }
    .bg-block {
        position:absolute;
        top:20%;
        left:26%;
        bottom: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        filter: alpha(opacity=0);
        -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
    }

    .bg-block.active {
        filter: alpha(opacity=100);
        -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
        opacity:1;
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
                <h1 class="page-header">CURRENT AVAILABLITY OF VEHICLE & CAR </h1>
            </div>


            <div class="panel-heading">
                <div class="page-wrappers">
                    <div class="bg-container">
                        <div class="bg-block active">
                            <img src="https://m.media-amazon.com/images/I/61CUlR955SL._UY560_.jpg">
                        </div>
                        <div class="bg-block">
                            <img src="https://www.mistercarz.com.my/images/vehicles/proton-x70/colors/proton-x70-color-536716.jpg">
                        </div>
                        <div class="bg-block">
                            <img src="https://static.bangkokpost.com/media/content/20190725/3269535.jpg">
                        </div>
                        <div class="bg-block">
                            <img src="https://www.mitsubishi-motors.com.my/wp-content/uploads/2019/06/asx-2wd.png">
                        </div>
                        <div class="bg-block">
                            <img src="https://carsguide-res.cloudinary.com/image/upload/f_auto%2Cfl_lossy%2Cq_auto%2Ct_default/v1/editorial/mitsubishi-triton-my19-index.png">
                        </div>
                        <div class="bg-block">
                            <img src="https://www.cammalaysia.com.my/wp-content/uploads/2021/04/Placer-X-3.0LV2.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-lg-6">

                <select  required class="form-control" name="car_location" id="car_location">
                    <option value="NONE">-- Choose Location--</option>
                    <? echo getDropDownCarlocation($car_location);?>
                </select>

            </div></div>
        <br><br>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">




                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group" align="right">
                            <a href="aims_carReserve_list.php" class="btn btn-primary"><i class='far fa-file-alt'>&nbsp;&nbsp; LIST REQUEST</i></a>
                        </div>
                        <table width="100%" class="content__table" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">No.</th>
                                <th width="20%">Model</th>
                                <th width="10%">No Plate</th>
                                <th width="7%">Type of Vehicle</th>
                                <th width="13%">Vehicle Location</th>
                                <th width="20%">Status</th>
                                <th width="20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $car = getcarListbyStafff($car_location);
                            $i=1;
                            while($list_car = $car->fetch_assoc()) {
                                ?>

                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td style="text-align:center"><? echo $list_car['car_model']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['car_plate_no']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['car_type']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['car_location']; ?></td>
                                    <td style="text-align:center"><? if($list_car['car_status'] =="1")
                                        {echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>NOT AVAILABLE</span>";}
                                        else {
                                            echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>AVAILABLE</span>";
                                        }?>
                                        <br><br>
                                        <? echo $list_car['update_date']; ?>
                                    </td>
                                    <td>
                                        <a href="aims_carRequest_add.php?id=<? echo $list_car['id']; ?>" class="btn btn-primary" title="Request"><i class='fa fa-arrow-right'></i></a>
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
        </div>
        <!-- /#page-wrapper -->
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#car_location").change(function(){
            var selected_cawangan=$(this).val();
            sendType(selected_cawangan);
        });

    });
    function sendType(type)
    {
        window.location.href="aims_car_proceed_list.php?car_location="+type;

    }
    $(document).ready(function () {
        //save boolean
        var pause = false;
        //save items that with number
        var item=  $('.select-item');
        //save blocks
        var block=  $('.bg-block');
        //variable for counter
        var k =0;


        //interval function works only when pause is false
        setInterval(function () {
            if (!pause) {
                var $this = item.eq(k);

                if (item.hasClass('active'))  {
                    item.removeClass('active');
                };
                block.removeClass('active').eq(k).addClass('active');
                $this.addClass('active');
                //increase k every 1.5 sec
                k++;
                //if k more then number of blocks on page
                if (k >= block.length ) {
                    //rewrite variable to start over
                    k = 0;
                }
            }
            //every 1.5 sec
        }, 1500);


        item.hover(function () {
            //remove active class from all except this
            $(this).siblings().removeClass("active");
            $(this).addClass('active');
            //remove active class from all
            block.removeClass('active');
            //add active class to block item which is accounted as index cliked item
            block.eq($(this).index()).addClass('active');
            //on hover stop interval function
            pause = true;
        }, function () {

            //when hover event ends, start interval function
            pause = false;
        });

    });
</script>

</body>

</html>