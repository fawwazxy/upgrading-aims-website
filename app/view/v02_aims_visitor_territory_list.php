<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";

if($_SESSION['SESS_DEPARTMENT_SUB'] != 'HR' && !in_array($_SESSION['SESS_ROLE'], ['HOD', 'HOC', 'SUPERADMIN']) && !in_array($_SESSION['SESS_ID'],['58','61'])){
    echo "<script type='text/javascript'>
            alert('You are not authorized access this page');
            window.history.back();
            </script>";
    exit();
}

$role = ($_GET['role'] != '') ? $_GET['role'] : 'all';
$qr_location = $_GET['qr_location'] ?: 'all'; //clock in qr location
$filter_status = $_GET['status'] ?: 'all'; //clock in qr location

$disabled = array_keys(array_flip([$role, $qr_location, $filter_status])) == ['all'] ? "disabled" : "";
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

    <style type="text/css">
        .status {
            color:white;
            border-radius: 5px;
            padding:5px;
            font-weight:bold;
            text-align: center;
            pointer-events: none;
        }
    </style>

</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include "../global/menu_top.php"; ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include "../global/menu_left.php"; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    VISITOR <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> MONITORING
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_visitor_migration_message.php"; ?>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <label style="font-size: 18px">Currently in Territory List</label>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <div class="form-group row">
                            <form method="get" action="" name="" id="">
                                <div class="col-md-2">
                                    <label for="Role">Role</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="all">All</option>
                                        <? foreach (getVisitorType('', true) as $index => $name) { ?>
                                            <option value="<? echo $index ?>" <? if ($role == (string)$index) echo 'selected'; ?>><? echo $name ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="qr_location">Clock In QR Location</label>
                                    <select class="form-control" id="qr_location" name="qr_location">
                                        <option value="all">All</option>
                                        <? $getQrLocation = getQrLocation();
                                        while ($location = $getQrLocation->fetch_assoc()){?>
                                            <option value="<? echo $location['qr_location'] ?>" <? if ($location['qr_location'] == $qr_location) echo 'selected'; ?>><? echo $location['qr_location'] ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="qr_location">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="all" <? if ($filter_status == 'all') echo 'selected'; ?>>All</option>
                                        <option value="clockin" <? if ($filter_status == 'clockin') echo 'selected'; ?>>Clocked In</option>
                                        <option value="clockout" <? if ($filter_status == 'clockout') echo 'selected'; ?>>Clocked Out</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <button type="submit" class="btn btn-info" id="filterBtn">Filter</button>
                                    <a href="v02_aims_visitor_territory_list.php" class="btn btn-default <? echo $disabled ?>" style="background-color: rgb(188,188,188)">Reset Filter</a>
                                </div>
                            </form>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="table table-hover" id="dataTable_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 3%">#</th>
                                        <th style="width: 16%">Visitor Details</th>
                                        <th>Purpose</th>
                                        <th style="width: 20%">Clock In</th>
                                        <th style="width: 20%">Clock Out</th>
                                        <th style="width: 10%">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? $i=1;
                                    $attendance_list = getVisitorInTerritory($role, $qr_location, $filter_status);
                                    while ($list = $attendance_list->fetch_assoc()){
                                        if ($list['clock_in_time'] != '' && $list['clock_out_time'] != ''){
                                            $status = 'CLOCKED OUT';
                                            $status_color = 'red';
                                        } else {
                                            $status = 'CLOCKED IN';
                                            $status_color = 'green';
                                        }
                                        ?>
                                        <tr>
                                            <td><? echo $i++?></td>
                                            <td>
                                                <b>Name: </b><? echo $list['name'] ?><br>
                                                <b>IC Number: </b><? echo $list['ic_number'] ?><br>
                                                <b>Company: </b><? echo $list['company'] ?><br>
                                                <b>Role: </b><? echo getVisitorType($list['role']); ?><br>
                                            </td>
                                            <td><? echo nl2br($list['reason']);?></td>
                                            <td><? echo '<b>Time: </b>'.$list['clock_in_time'].'<br> <b>Location: </b>'.$list['clock_in_location'].'<br> <b>QR Location: </b>'.$list['clock_in_qr']; ?></td>
                                            <td><? echo '<b>Time: </b>'.$list['clock_out_time'].'<br> <b>Location: </b>'.$list['clock_out_location'].'<br> <b>QR Location: </b>'.$list['clock_out_qr']; ?></td>
                                            <td><p class="status" style="background-color: <? echo $status_color; ?>"><? echo $status; ?></p></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable_list').DataTable({
            responsive: false,
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [0, 'asc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();
    });
</script>
</body>
</html>