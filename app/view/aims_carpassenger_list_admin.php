<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarRequestById($id)->fetch_assoc();

$month=$_GET['month'];
$year=$_GET['year'];
if(!isset($month)){
    $month=$date_month;
    $year=$date_year;
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

    <? require "../global/header.php"; ?>

</head>

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
        $flagScreen="tab_1";
        include ('../global/menu_car_admin.php');
        ?>

        <br>
        <br>


        <div class="row" style="padding-left:20px; padding-bottom:20px;">
            <table border="0">
                <tr><td>
                        <label class="control-label">MONTH:</label>
                    </td><td>&nbsp;&nbsp;&nbsp;</td><td>
                        <select  required class="form-control" name="month" id="month" value="<?echo $month?>">
                            <option value="">-- Choose Month --</option>
                            <? echo getDropDownMonth($month) ;?>
                        </select>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>

            </table>
        </div>



        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Car Passenger</label>
                    </div>





                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">No.</th>
                                <th width="15%">Date</th>
                                <th width="35%">Name Applicant</th>
                                <th width="35%">Name Passenger</th>
                                <th width="35%">Designation</th>
                                <th width="35%">Department</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $car = getcarPassengerList1($month);
                            $i=1;
                            while($list_car = $car->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td style="text-align:center"><? echo $list_car['dep_date']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['name']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['name_passenger']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['jawatan']; ?></td>
                                    <td style="text-align:center"><? echo $list_car['description']; ?></td>

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
    <!-- /#wrapper -->



    <script>
        $(document).ready(function() {
            $("#month").change(function(){

                var selected_month=$(this).val();
                reloadMonth(selected_month);

            });

        });

        function reloadMonth(month){
            //console.log(cawangan);
            location.href = "aims_carpassenger_list_admin.php?month="+month;
        }




    </script>

</body>

</html>