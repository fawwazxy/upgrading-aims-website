<?php
include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";


$car_plate_no=$_GET['car_plate_no'];
if(!isset($car_plate_no)){
    $car_plate_no='';
}

//$start_date=$_GET['start_date'];
//if(!isset($start_date)){
//  $start_date='';
//}
$start_date=($_GET['start_date'])?:'';

$end_date=$_GET['end_date'];
if(!isset($end_date)){
    $end_date='';
}

$status=$_GET['status'];
if(!isset($status)){
    $status='';
}
$mode='daily';

$car = getcarFuelReport($start_date,$end_date,$_SESSION['SESS_NAME'],$car_plate_no,$status,$mode);

$sys = getSys(1)->fetch_assoc();
?>



<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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

    button.print-button {
        width: 60px;
        height: 60px;
    }
    span.print-icon, span.print-icon::before, span.print-icon::after, button.print-button:hover .print-icon::after {
        border: solid 4px #333;
    }
    span.print-icon::after {
        border-width: 2px;
    }

    button.print-button {
        position: relative;
        padding: 0;
        border: 0;

        border: none;
        background: transparent;
    }

    span.print-icon, span.print-icon::before, span.print-icon::after, button.print-button:hover .print-icon::after {
        box-sizing: border-box;
        background-color: #fff;
    }

    span.print-icon {
        position: relative;
        display: inline-block;
        padding: 0;
        margin-top: 20%;

        width: 60%;
        height: 35%;
        background: #fff;
        border-radius: 20% 20% 0 0;
    }

    span.print-icon::before {
        content: " ";
        position: absolute;
        bottom: 100%;
        left: 12%;
        right: 12%;
        height: 110%;

        transition: height .2s .15s;
    }

    span.print-icon::after {
        content: " ";
        position: absolute;
        top: 55%;
        left: 12%;
        right: 12%;
        height: 0%;
        background: #fff;
        background-repeat: no-repeat;
        background-size: 70% 90%;
        background-position: center;
        background-image: linear-gradient(
                to top,
                #fff 0, #fff 14%,
                #333 14%, #333 28%,
                #fff 28%, #fff 42%,
                #333 42%, #333 56%,
                #fff 56%, #fff 70%,
                #333 70%, #333 84%,
                #fff 84%, #fff 100%
        );

        transition: height .2s, border-width 0s .2s, width 0s .2s;
    }

    button.print-button:hover {
        cursor: pointer;
    }

    button.print-button:hover .print-icon::before {
        height:0px;
        transition: height .2s;
    }
    button.print-button:hover .print-icon::after {
        height:120%;
        transition: height .2s .15s, border-width 0s .16s;
    }

    //button divider

      .promo {
          margin: 6em auto;
          max-width: 600px;
          text-align: center;
      }
    .promo em {
        font-family: Georgia, Times New Roman, serif;
        display: inline-block;
        background-color: #ececec;
        color: #194c66;
        width: 3em;
        height: 3em;
        line-height: 3em;
        border-radius: 50%;
        position: relative;
        z-index: 2;
        margin: 0 -1em;
    }
    .butt {
        padding: 0.4em 1em;
        background-color: #f6f6f6;
        border-radius: 4px;
        color: #222;
        text-decoration: none;
        font-weight: 400;
        text-transform: uppercase;
        font-size: 1rem;
        font-family: 'Roboto Condensed', sans-serif;
        line-height: 2;
        display: inline-block;
    }
    .promo .butt {
        min-width: 120px;
    }
    .primary.butt {
        background-color: #248F4D;
        color: #fff;
    }
    .primary.butt:hover {
        background-color: #1a6637;
    }
    .secondary.butt {
        background-color: #0076A8;
        color: #fff;
    }
    .secondary.butt:hover {
        background-color: #005275;
    }

    .button{
        margin-top:20%;
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
                <div class="col-xs-9">
                    <h1 class="page-header"> Transport <?if ($status == 'FUEL'){
                            echo "PETROL";}
                        else if ($status == 'TnG') {
                            echo "TnG";}
                        else {
                            echo "PETROL & TnG";}?> Report (Daily)</h1>
                </div>
                <div class="col-xs-3">
                    <a href="aims_carfuel_report.php?status=FUEL&car_plate_no=<? echo $car_plate_no?>&start_date=<? echo $start_date?>&end_date=<? echo $end_date?>&mode=<? echo $mode?>"><button class="button">Petrol Fuel</button></a>
                    <a href="aims_carfuel_report.php?status=TnG&car_plate_no=<? echo $car_plate_no?>&start_date=<? echo $start_date?>&end_date=<? echo $end_date?>&mode=<? echo $mode?>"><button class="button">Touch N Go</button></a>
                </div>
            </div>
        </div>

        <div class="row">
            <form method="get" action="">
                <div class="col-lg-12">
                    <div class="col-xs-3">
                        <label for="car_plate_no">Choose Vehicle</label>
                        <select  required class="form-control" name="car_plate_no" id="car_plate_no" value="<?echo $car_plate_no?>">
                            <? echo getDropDownCarName($car_plate_no) ;?>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <label for="start_date"> Date From</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<? echo $start_date ?>">
                        <input type="hidden" id="status" value="<? echo $status ?>">
                    </div>
                    <div class="col-xs-2">
                        <label for="end_date"> Date End</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<? echo $end_date ?>">
                    </div>
                    <div class="col-xs-2" style="margin-top: 25px">
                        <button type="submit" class="btn btn-info">Search</button>
                        <a href="aims_carfuel_report.php" class="btn btn-default" style="background-color: #b0b0b0">Reset</a>
                        <a href="aims_carFuel_report_print.php?car_plate_no=<? echo $car_plate_no?>&start_date=<? echo $start_date?>&end_date=<? echo $end_date?>&mode=<? echo $mode?>"
                           class="btn btn-warning">Print</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <table width="100%" class="content__table" id="dataTables-example" border="1">
                        <thead>
                        <tr>
                            <th rowspan="2" style="text-align:center">DATE</th>
                            <th rowspan="2" style="text-align:center">DESTINATION</th>
                            <th colspan="2" style="text-align:center">MILEAGE</th>
                            <th rowspan="2" style="text-align:center">REQUESTED BY</th>
                            <th rowspan="2" style="text-align:center">PURPOSE</th>
                            <th colspan="2" style="text-align:center">BUNKER FUEL</th>
                            <th>PIC</th>

                        </tr>
                        <tr>
                            <th>OUT</th>
                            <th>IN</th>
                            <th title="Receipt Date">DATE </th>
                            <th>PRICE(RM)</th>
                            <th>NAME</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $car = getcarFuelReport($start_date,$end_date,$_SESSION['SESS_NAME'],$car_plate_no,$status,$mode);
                        $i=1;
                        while($list_car = $car->fetch_assoc()) {
                            ?>

                            <tr>
                                <td style="text-align:center"><? echo $list_car['dep_date']; ?></td>
                                <td style="text-align:center"><? echo $list_car['destination']; ?></td>
                                <td style="text-align:center"><? echo $list_car['dep_milage']; ?></td>
                                <td style="text-align:center"><? echo $list_car['return_milage']; ?></td>
                                <td style="text-align:center"><? echo $list_car['request_name']; ?></td>
                                <td style="text-align:center"><? echo $list_car['purpose']; ?></td>
                                <td style="text-align:center" title="Receipt Date"><? echo $list_car['receipt_date']; ?></td>
                                <td style="text-align:center"><? echo 'RM '.number_format($list_car['receipt_fuel'], 2) ?></td>
                                <td style="text-align:center"><? echo $list_car['car_pic']; ?></td>
                            </tr>
                            <? $total += (float)$list_car['receipt_fuel'];?>
                        <?}?>

                        </tbody>
                        <thead>
                        <tr>
                            <th colspan="7"></th>
                            <th style="text-align:center"><?echo 'RM '.number_format($total, 2)?></th>
                            <th></th>

                        </tr>
                        </thead>
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

    -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        function search(){
            var selected_stat=document.getElementById("status").value;
            var selected_car=document.getElementById("car_plate_no").value;
            var selected_start=document.getElementById("start_date").value;
            var selected_end=document.getElementById("end_date").value;

            location.href = "aims_carfuel_report.php?status="+selected_stat+"&car_plate_no="+selected_car+"&start_date="+selected_start+"&end_date="+selected_end;
        }



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