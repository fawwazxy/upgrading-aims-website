<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarRequestById($id)->fetch_assoc();

$month=($_GET['month']) ?: date('m');
$year=($_GET['year']) ?: date('Y');
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row" style="padding-top: 16px">
            <div class="col-md-12">
                <?
                $flagScreen="tab_3";
                include ('../global/menu_car_admin.php');
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="margin-top: 16px">TRANSPORT INSPECTION</h1>
            </div>
        </div>
        <div class="row">
            <form action="" method="get">
                <div class="col-lg-2">
                    <select required class="form-control" name="month" id="month">
                        <option value="all">All</option>
                        <? echo getDropDownMonthInspec($month);?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select required class="form-control" name="year" id="year">
                        <? echo getDropDownYearInspec($year);?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-info">Filter</button>
                </div>
            </form>
        </div>


        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Car Inspection list</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">No.</th>
                                <th style="width: 17%">Staff</th>
                                <th style="width: 8%">Fuel</th>
                                <th style="width: 15%">Car Accessories</th>
                                <th style="width: 15%">Exterior Car</th>
                                <th style="width: 15%">Interior Car</th>
                                <th style="width: 15%">Admin Action</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $car = getCarInspectionListAdmin($month, $year);
                            $i=1;
                            while($list_car = $car->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td class="text-center"><? echo $i++;?></td>
                                    <td style="text-align:left">
                                        <b>NAME:</b> <? echo $list_car['name']; ?><br>
                                        <b>NO PLATE:</b> <? echo $list_car['car_plate_no']; ?><br>
                                        <b>DATE:</b> <? echo $list_car['dep_date']; ?>
                                    </td>
                                    <td class="text-center"><? echo $list_car['fuel']; ?></td>
                                    <td class="text-center"><? echo $list_car['hd_vehicle']; ?></td>
                                    <td class="text-center">
                                        <? echo $list_car['exterior_car']; ?><br>
                                        <b>COMMENT:</b> <? echo $list_car['comment1']; ?></td>
                                    <td class="text-center">
                                        <? echo $list_car['interior_car']; ?><br>
                                        <b>COMMENT:</b> <? echo $list_car['comment']; ?></td>
                                    <td class="">
                                        <b>STATUS:</b><br>&nbsp;<? echo $list_car['admin_action']; ?><br>
                                        <b>DATE:</b><br>&nbsp;<? echo ($list_car['date_action'] != '0000-00-00 00:00:00') ? $list_car['date_action'] : " <i style='font-size: 12px' class='text-muted'>- not available -</i>"; ?><br>
                                        <b>COSTING:</b><br>&nbsp;<? echo 'RM '.$list_car['costing']; ?><br>
                                        <b>DESCRIPTION:</b><br>&nbsp;<? echo ($list_car['description']) ?: " <i style='font-size: 12px' class='text-muted'>- not available -</i>"; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<? echo $list_car['id'] ?>" data-month="<? echo $month ?>"><i class='fa fa-edit'></i></a>
                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
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
                            let rowid = $(e.relatedTarget).data('id');
                            let month = $(e.relatedTarget).data('month');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_carinspection_adminact.php',
                                data:{id:rowid,month:month},
                                success:function(html){
                                    $('#demo').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>=

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</body>
</html>