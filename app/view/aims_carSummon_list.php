<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$month = ($_GET['month']) ?: 'all';
$year = ($_GET['year']) ?: date('Y');
$status = ($_GET['status']) ?: 'UNPAID';
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
        <div class="row">
            <div class="col-lg-12">
                <?
                $flagScreen="tab_4";
                include ('../global/menu_car_admin.php');
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <a href="aims_carSummon.php?id=0" class="btn btn-primary" style="float:right;margin: 16px 4px 0 4px">Add</a>
                <h1 class="page-header" style="margin-top: 16px">VEHICLE SUMMON</h1>
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
                <div class="col-lg-2">
                    <select required class="form-control" name="status" id="status">
                        <option value="PAID" <? if ($status == 'PAID') echo 'selected' ?>>Paid</option>
                        <option value="UNPAID" <? if ($status == 'UNPAID') echo 'selected' ?>>Unpaid</option>
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
                        <label>Vehicle summon list</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 7%;">No.</th>
                                <th style="width: 17%">Driver</th>
                                <th style="width: 12%">Plate No</th>
                                <th style="width: 20%;">Summons Details</th>
                                <th style="width: 20%">Offense Details</th>
                                <th style="width: 14%">Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $car = getcarsummonList($month, $year, $status);
                            $i=1;
                            while($list_car = $car->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td class="text-center"><? echo $i++;?></td>
                                    <td>
                                        <b>Driver: </b><? echo !empty($list_car['name']) ? $list_car['name'] : $list_car['guest_name']; ?><br>
                                        <b>Company: </b><? echo !empty($list_car['company_name']) ? $list_car['company_name'] : $list_car['guest_company_name']; ?><br>
                                        <b>Destination: </b><? echo !empty($list_car['destination']) ? $list_car['destination'] : $list_car['guest_destination']; ?>
                                    </td>
                                    <td class="text-center"><? echo !empty($list_car['car_plate_no']) ? $list_car['car_plate_no'] : $list_car['guest_car_plate_no']; ?></td>
                                    <td>
                                        <b>Summon No:</b><br><? echo $list_car['summons_no']; ?><br>
                                        <b>Offense datetime:</b> <? echo $list_car['offense']; ?><br>
                                        <b>Enforcement date:</b> <? echo $list_car['enforcement_date']; ?>
                                    </td>
                                    <td>
                                        <b>Amount:</b> <? echo 'RM'.$list_car['original_amount']; ?><br>
                                        <b>Offense Details:</b> <? echo $list_car['offense_details']; ?><br>
                                        <b>Issued District:</b> <? echo $list_car['issue_distric']; ?>
                                    </td>
                                    <td class="text-center" style="color: <? echo ($list_car['summon_status'] =="UNPAID") ? "red" : "green"; ?>"><? echo ($list_car['summon_status'] =="UNPAID") ? "UNPAID" : "PAID"; ?></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                <li><a style="display: block" href="aims_carSummon_update.php?id=<? echo $list_car['id'];?>" title="Edit">
                                                        <i class="fa fa-edit opt-icon"></i> Edit</a></li>
                                                <li><a style="display: block" href="#myModal1" data-toggle="modal" data-id="<? echo $list_car['id'] ?>" title="Summon Status">
                                                        <i class="fa fa-credit-card opt-icon"></i> Status Summon</a></li>
                                                <li><a style="display: block; color: #b70000" href="../controller/aims_carSummon_delete.php?id=<? echo $list_car['id']; ?>"
                                                       onclick="return confirm('Are you sure you want to delete?')" title="Delete">
                                                        <i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                            </ul>
                                        </div>
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
                    <script>

                        function hideOnClk(id){
                            if(id == "PAID"){
                                document.getElementById("UNPAID").style.display="block";
                                document.getElementById("UNPAID").style.backgroundColor = "red";
                                document.getElementById(id).style.display="none";
                            }else{
                                document.getElementById("PAID").style.display="block";
                                document.getElementById("PAID").style.backgroundColor = "green";
                                document.getElementById(id).style.display="none";
                            }
                        }

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
                                url:'aims_carSummon_updatestatus.php',
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