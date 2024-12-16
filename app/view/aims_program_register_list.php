<?php
include "../controller/auth.php";
require "../model/dashboard_functions.php";
$program = getProgramRegistered();
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
                <h1 class="page-header">
                    AIMS-PORTAL MOBILE BETA <i class="fa fa-caret-right"></i> LIST
                    <a href="dashboard.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to Dashboard
                    </a></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Registered user for <b>AIMS-PORTAL MOBILE BETA</b> version
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="programRegister">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 20%">Model</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 10%">No. Staff</th>
                                <th style="width: 20%">Details</th>
                                <th style="width: 10%">Phone</th>
                                <th style="width: 15%">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            while ($row = $program->fetch_assoc()){ ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td>
                                        <p><? echo $row['description']; ?></p>
                                        <b class="text-center" style="padding: 4px 16px; background-color: rgba(78,216,16,0.51); border: 1px solid black; border-radius: 10px">
                                            <? echo date('d/m/Y h:i A', strtotime($row['created_at'])); ?></b>
                                    </td>
                                    <td><? echo $row['name']; ?></td>
                                    <td><? echo $row['no_staff']; ?></td>
                                    <td>
                                        <b>Company: </b><? echo $row['department_id']; ?><br>
                                        <b>Department: </b><? echo $row['department_sub']; ?><br>
                                        <b>Branch: </b><? echo $row['cawangan_kod']; ?>
                                    </td>
                                    <td><? echo $row['phone']; ?></td>
                                    <td><? echo $row['email']; ?></td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#programRegister').DataTable({
            responsive: false,
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [0, 'asc'],
        });

        $('[data-toggle="popover"]').popover();
    });
</script>
</body>
</html>
