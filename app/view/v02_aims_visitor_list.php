<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";

if($_SESSION['SESS_DEPARTMENT_SUB'] != 'HR' && !in_array($_SESSION['SESS_ROLE'], ['HOD', 'HOC', 'SUPERADMIN']) && !in_array($_SESSION['SESS_ID'],['58','61','89','654','192'])){
    echo "<script type='text/javascript'>
            alert('You are not authorized access this page');
            window.history.back();
            </script>";
    exit();
}

$type = ($_GET['type'] != '') ? $_GET['type'] : 'all';
$company = $_GET['company'] ?: 'all';
$gender = ($_GET['gender'] != '') ? $_GET['gender'] : 'all';
$status = ($_GET['status'] != '') ? $_GET['status'] : 'all';

$disabled = array_keys(array_flip([$type, $company, $gender, $status])) == ['all'] ? "disabled" : "";

$visitor_summary = getVisitorSummary();
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
        .modal-dialog-centered {
            margin-top: 18%;
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
                    VISITOR <sub class="version">Version 02</sub>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_visitor_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-lg-12" style="overflow: auto">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 25%; background-color: rgb(0,0,0); color: white">Role</th>
                        <th style="width: 15%; background-color: rgba(145,145,145,0.5)">Total</th>
                        <th style="width: 15%; background-color: rgba(255,145,145,0.5)">Inactive</th>
                        <th style="width: 15%; background-color: rgba(150,211,255,0.5)">Active</th>
                        <th style="width: 30%; background-color: rgba(143,255,0,0.5)">Currently in Territory</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $total_role = $total_inactive = $total_active = $total_in_territory = 0;
                    foreach ($visitor_summary as $index => $list){
                        $visitor_in_territory = getTotalInTerritory($index);?>
                        <tr>
                            <td><? echo getVisitorType($index); ?></td>
                            <td><? echo array_sum($list) ?></td>
                            <td><? echo $list['inactive'] ?: 0 ?></td>
                            <td><? echo $list['active'] ?: 0 ?></td>
                            <td><? echo $visitor_in_territory ?></td>
                        </tr>
                        <?
                        $total_role += array_sum($list);
                        $total_inactive += $list['inactive'];
                        $total_active += $list['active'];
                        $total_in_territory += $visitor_in_territory;
                    } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>All</th>
                        <th><? echo $total_role; ?></th>
                        <th><? echo $total_inactive; ?></th>
                        <th><? echo $total_active; ?></th>
                        <th><? echo $total_in_territory; ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <label for="leave_type" style="font-size: 18px">Visitor & Contractor List</label>
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="v02_aims_visitor_form.php" class="btn btn-primary">New visitor</a>
                                <!--<a href="v02_aims_visitor_alternative_form.php" target="_blank" class="btn btn-primary">Alternative Form</a>-->
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <div class="form-group row">
                            <form method="get" action="">
                                <div class="col-md-2">
                                    <select class="form-control" name="type" id="type">
                                        <option value="all">All Type</option>
                                        <? foreach (getVisitorType('', true) as $index => $name){ ?>
                                            <option value="<? echo $index ?>" <? if ($type == (string)$index) echo 'selected'; ?>>
                                                <? echo $name ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="company" id="company">
                                        <option value="all">All Company</option>
                                        <? $distinct_company = getDistinctCompany();
                                        while ($filter_company = $distinct_company->fetch_assoc()) { ?>
                                            <option value="<? echo $filter_company['company'] ?>" <? if ($filter_company['company'] == $company) echo 'selected'; ?>><? echo $filter_company['company'] ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="all">All Gender</option>
                                        <option value="1" <? if ($gender == '1') echo 'selected'; ?>>Male</option>
                                        <option value="0" <? if ($gender == '0') echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="status" id="status">
                                        <option value="all">All Status</option>
                                        <option value="2" <? if ($status == '2') echo 'selected'; ?>>Active</option>
                                        <option value="1" <? if ($status == '1') echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-info" id="filterBtn">Filter</button>
                                    <a href="v02_aims_visitor_list.php" class="btn btn-default <? echo $disabled ?>" style="background-color: rgb(188,188,188)">Reset Filter</a>
                                </div>
                            </form>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="table table-hover" id="visitor_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 20%">Visitor Details</th>
                                        <th style="width: 15%">Company</th>
                                        <th style="width: 15%">Type</th>
                                        <th style="width: 5%">Status</th>
                                        <th style="width: 5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? $i=1;
                                    $visitor_list = getVisitorList($type, $company, $gender, $status);
                                    while ($list = $visitor_list->fetch_assoc()){

                                        $array_status = [
                                            "2" => [
                                                'status' => 'Verified',
                                                'color' => 'green',
                                            ],
                                            "1" => [
                                                'status' => 'Suspended',
                                                'color' => 'orange',
                                            ],
                                            "0" => [
                                                'status' => 'Pending',
                                                'color' => 'grey',
                                            ]
                                        ];

                                        ?>
                                        <tr>
                                            <td><? echo $i++; ?></td>
                                            <td>
                                                <b>Name: </b><? echo $list['name']; ?><br>
                                                <b>IC Number: </b><? echo $list['ic_number']; ?><br>
                                                <b>Phone Number: </b><? echo $list['phone_number']; ?><br>
                                            </td>
                                            <td><? echo $list['company']; ?></td>
                                            <td><? echo getVisitorType($list['type']); ?></td>
                                            <td><p class="status" style="background-color: <? echo $array_status[$list['status']]['color']; ?>"><? echo $array_status[$list['status']]['status']; ?></p></td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="true">
                                                        <i class="fa fa-caret-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                        <li><a style="display: block" href="../view/v02_aims_visitor_view.php?id=<? echo $list['id'] ?>"><i class="fa fa-eye opt-icon"></i> View</a></li>
                                                        <li><a style="display: block" href="../view/v02_aims_visitor_update.php?id=<? echo $list['id'] ?>&type=<? echo $type; ?>&company=<? echo $company; ?>&gender=<? echo $gender; ?>&status=<? echo $status; ?>">
                                                                <i class="fa fa-pencil opt-icon"></i> Update</a></li>
                                                        <li><a style="display: block;" href="#approveRegModal" data-toggle="modal" data-id="<? echo $list['id'] ?>" data-type="<? echo $type; ?>" data-company="<? echo $company; ?>" data-gender="<? echo $gender; ?>" data-status="<? echo $status; ?>">
                                                                <i class="fa fa-check opt-icon"></i> Change Status</a></li>
                                                        <li><a onclick="confirmDel('../controller/v02_aims_visitor_delete_exec.php?id=<? echo $list["id"] ?>&type=<? echo $type; ?>&company=<? echo $company; ?>&gender=<? echo $gender; ?>&status=<? echo $status; ?>')" style="display: block; color: #d70000">
                                                                <i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
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

<div class="modal fade" id="approveRegModal" tabindex="-1" role="dialog" aria-labelledby="updateApproveRegModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="updateApproveRegModalLabel">Change Status</h4>
            </div>
            <div class="modal-body" id="approveRegModalBody">
                <script type="text/javascript">
                    $('#approveRegModal').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        let type = $(e.relatedTarget).data('type');
                        let company = $(e.relatedTarget).data('company');
                        let gender = $(e.relatedTarget).data('gender');
                        let status = $(e.relatedTarget).data('status');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_update_visitor_status_modal.php',
                            data:{id:id,type:type,company:company,gender:gender,status:status},
                            success:function(html){
                                $('#approveRegModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#visitor_list').DataTable({
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

    function confirmDel(url){
        if (confirm('Are you sure to delete this visitor?')){
            window.location.href = url;
        }
        return false;
    }
</script>
</body>
</html>