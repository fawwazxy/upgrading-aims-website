<?php
require "../controller/auth.php";
require "../../lib/db/connection.php";
function getSys($sys_id) {
    $conn=db();
    $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}
function getTempStaff(){
    $sql = "SELECT t.*, s.name, s.noic, s.no_staff FROM temp_staff t LEFT JOIN staff s ON s.noic = t.staff_ic";
    return db()->query($sql);
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <? require "../global/header.php"; ?>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" >
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
                    Temporary Staff
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Upload Excel of staff number
                    </div>
                    <div class="panel-body">
                        <form action="../controller/overwrite_staff_no_exec.php" method="post" name="staff_excel" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-lg-5">
                                    <input type="file" class="form-control" name="csv_file">
                                </div>
                                <div class="col-lg-2">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Temporary Staff Table</label>
                        <a class="btn btn-sm btn-success" style="float: right" href="../controller/run_update_staff_no.php?staff=all">
                            Run staff number update (All) <i class="fa fa-arrow-right"></i></a>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Staff IC</th>
                                <th>Temp IC</th>
                                <th>Staff No</th>
                                <th>Temp No</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $list = getTempStaff();
                            $i=1;
                            while($staff = $list->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++.'.'; ?></td>
                                    <td><?php echo $staff['id']; ?></td>
                                    <td><?php echo $staff['name']; ?></td>
                                    <td><?php echo $staff['noic']; ?></td>
                                    <td><?php echo $staff['staff_ic']; ?></td>
                                    <td><?php echo $staff['no_staff']; ?></td>
                                    <td><?php echo $staff['staff_no']; ?></td>
                                    <td class="text-center">
                                        <a href="../controller/run_update_staff_no.php?staff=<? echo $staff['staff_ic']; ?>"
                                           class="btn btn-sm btn-success"><? echo $staff['staff_ic'] ?> &nbsp;
                                            <i class="fa fa-arrow-right"></i></a>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true,
                order: [0, 'asc'],
                aLengthMenu: [
                    [50, 100, 200, -1],
                    [50, 100, 200, "All"]
                ],
            });
        });
    </script>
</div>
</body>
</html>