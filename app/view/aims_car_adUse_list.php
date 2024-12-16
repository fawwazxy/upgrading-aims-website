<?php
require "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$admin = 'admin';

$app_status = ($_GET['app_status']) ?: 'PENDING';
$department_code=($_GET['department_id']) ?: $_SESSION['SESS_DEPARTMENT'];
$no_plate = ($_GET['no_plate']) ?: '0';

$color_array = ['PENDING' => 'GREY', 'APPROVE' => 'GREEN', 'DISAPPROVE' => 'RED'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?
    require "../global/header.php";
    include "../custom-css/transport-module.php";
    ?>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <style>
        .transport-status{
            padding:5px;
            border-radius:5px;
            font-weight:bold;
            color:white;
        }
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab a {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 16px;
            text-decoration: none;
            color: #000000;
            border-radius: 5%;
        }

        /* Change background color of buttons on hover */
        .tab a:hover {
            background-color: #ddd;
            text-decoration: none;
        }

        /* Create an active/current tablink class */
        .tab a.active {
            background-color: #FFA500;
        }

        /* Style the tab content */
        .tabContent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>
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
                $flagScreen="tab_2";
                include "../global/menu_car_admin.php";
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="margin-top: 16px">Transport Request List</h1>
            </div>
        </div>

        <div class="row" style="margin:0 0 16px">
            <form method="get" action="">
                <input type="hidden" name="app_status" value="<? echo $app_status?>">
                <div class="col-lg-2" style="width: 320px">
                    <select required class="form-control" name="no_plate" id="no_plate">
                        <option value="0" <? if($no_plate == '0') echo 'selected' ?>>All Car</option>
                        <? echo getDropDownCarName($no_plate) ;?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-info">Filter</button>
                </div>
            </form>
        </div>

        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <div class="tab">
                    <a href="aims_car_adUse_list.php?app_status=PENDING&no_plate=<? echo $no_plate ?>" class="tabLinks <? if($app_status=="PENDING") echo 'active'?>">
                        NEW </a>
                    <a href="aims_car_adUse_list.php?app_status=APPROVE&no_plate=<? echo $no_plate ?>" class="tabLinks <? if($app_status=="APPROVE") echo 'active'?>">
                        APPROVED </a>
                    <a href="aims_car_adUse_list.php?app_status=DISAPPROVE&no_plate=<? echo $no_plate ?>" class="tabLinks <? if($app_status=="DISAPPROVE") echo 'active'?>">
                        REJECTED </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="dataTables-example" style="width: 100%;">
                            <thead>
                            <tr>
                                <th style="width: 7%">No.</th>
                                <th style="width: 30%">Staff & Request Info</th>
                                <th style="width: 22%">Reason</th>
                                <th style="width: 17%">EC/CEO/HOD Status</th>
                                <th style="width: 16%">Status Approval </th>
                                <th style="width: 8%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $car = getTransportRequestList($_SESSION['SESS_NOKP'], $no_plate, $app_status);
                            $i=1;
                            while($row = $car->fetch_assoc() ) {
                                ?>
                                <tr>
                                    <td class="text-center"><? echo $i++;?></td>
                                    <td>
                                        <label class="control-label">Name : </label> <? echo $row['name'];?><br>
                                        <label class="control-label">Designation : </label> <? echo $row['jawatan'];?><br>
                                        <label class="control-label">Applied on : </label> <? echo date('d/m/Y h:i:sa', strtotime($row['created_date']));?>
                                    </td>
                                    <td><? echo $row['purpose'];?></td>
                                    <td class="text-center">
                                        <p class="transport-status" style='background-color:<? echo $color_array[$row['sbu_hod_app']] ?>;'> <? echo $row['sbu_hod_app']?> </p>
                                        <p><? echo $row['approve_by'];?></p>
                                        <p><? echo $row['hod_date'];?></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="transport-status" style='background-color:<? echo $color_array[$row['app_status']] ?>;'> <? echo $row['app_status']?> </p>
                                        <p><? echo $row['name_admin'];?></p>
                                        <p><? echo ($row['date_app'] == '0000-00-00 00:00:00') ? "" : $row['date_app'];?></p>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                <li><a style="display: block" title="Admin Approval" href="#adminApprovalModal" data-toggle="modal" data-id="<? echo $row['admin_id'] ?>" data-status="<? echo $admin; ?>">
                                                        <i class="fa fa-check-square opt-icon"></i>Admin Approval</a></li>
                                                <li><a style="display: block" title="Request Info" href="#requestInfoModal" data-toggle="modal" data-id="<? echo $row['id'] ?>">
                                                        <i class="fa fa-info-circle opt-icon"></i> Request Info</a></li>
                                                <li><a style="display: block" title="Car Summon" href="aims_carSummon.php?id=<? echo $row['id']; ?>" target="_blank">
                                                        <i class="fa fa-car opt-icon"></i> Car Summon</a></li>
                                                <li><a style="display: block" title="Passenger" href="#passengerModal" data-toggle="modal" data-id="<? echo $row['id'] ?>">
                                                        <i class="fa fa-users opt-icon"></i> Passenger</a></li>
                                                <li><a style="display: block" title="Edit" href="aims_carReserve_update.php?id=<? echo $row['id']; ?>&status=<? echo $admin; ?>&status1=<? echo $row['app_status']; ?>" target="_blank">
                                                        <i class="fa fa-edit opt-icon"></i> Edit</a></li>
                                                <li><a style="display: block" title="Print" href="aims_carRequest_print.php?id=<? echo $row['id'];?>" target="_blank">
                                                        <i class="fa fa-print opt-icon"></i> Print</a></li>
                                                <? if ($row['taf_id'] != '0') {?>
                                                    <li><a style="display: block" title="Travel Info" href="#travelInfoModal" data-toggle="modal" data-id="<? echo $row['taf_id'] ?>">
                                                            <i class="fa fa-plane opt-icon"></i> Travel Info</a></li>
                                                <?}?>
                                                <li><a style="display: block" title=" Fuel Claim" href="aims_car_claim_form.php?id=<? echo $row['id'];?>&status=FUEL" target="_blank">
                                                        <i class="fa fa-gas-pump opt-icon"></i> Fuel Claim</a></li>
                                                <li><a style="display: block" title="TnG Claim" href="aims_car_claim_form.php?id=<? echo $row['id'];?>&status=TnG" target="_blank">
                                                        <i class="fa fa-credit-card opt-icon"></i> TnG Claim</a></li>
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
</div>


<div class="modal fade" id="adminApprovalModal" tabindex="-1" role="dialog" aria-labelledby="adminApprovalModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="adminApprovalModalTitle">Update Reserve Info</h4>
            </div>
            <div class="modal-body" id="adminApprovalModalBody">
                <script type="text/javascript">
                    $('#adminApprovalModal').on('show.bs.modal', function (e) {
                        let rowid = $(e.relatedTarget).data('id');
                        let status = $(e.relatedTarget).data('status');
                        $.ajax({
                            type:'GET',
                            url:'aims_car_adUse_add.php',
                            data:{id:rowid,status:status},
                            success:function(html){
                                $('#adminApprovalModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="requestInfoModal" tabindex="-1" role="dialog" aria-labelledby="requestInfoModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="requestInfoModalTitle">Car Reserve Info</h4>
            </div>
            <div class="modal-body" id="requestInfoModalBody">
                <script type="text/javascript">
                    $('#requestInfoModal').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_carReserve_adminInfo.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#requestInfoModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passengerModal" tabindex="-1" role="dialog" aria-labelledby="passengerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="passengerModalTitle">Passenger Info</h4>
            </div>
            <div class="modal-body" id="passengerModalBody">
                <script type="text/javascript">
                    $('#passengerModal').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_carpassenger_info.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#passengerModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-xl" id="travelInfoModal" tabindex="-1" role="dialog" aria-labelledby="travelInfoModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="travelInfoModalTitle">Travel Info</h4>
            </div>
            <div class="modal-body" id="travelInfoModalBody">
                <script type="text/javascript">
                    $('#travelInfoModal').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_travel_listInfo.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#travelInfoModalBody').html(html);
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

    function popitup(url) {
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>
</body>
</html>