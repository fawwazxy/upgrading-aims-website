<?php
include ('../controller/auth.php');
require "../model/authority_functions.php";
$date_filter = ($_GET['date']) ?: date('Y-m-d');
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
                <h1 class="page-header">Audit Trail</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <form id="filterForm" method="get">
                        <div class="col-lg-2" style="margin-bottom: 8px">
                            <input type="date" name="date" value="<? echo $date_filter ?>" class="form-control" onchange="filterForm.submit()">
                        </div>
                    </form>
                </div>
                <div class="panel panel-default">

                    <div class="panel-heading">
                        Senarai Audit Trail
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th><i>Dummy</i></th>
                                <th>Tarikh & Masa</th>
                                <th>No. Pekerja</th>
                                <th>Nama</th>
                                <th><i>IP Address</i></th>
                                <th>Skrin</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data = getAuditTrail($date_filter);
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i; ?></td>
                                    <td style="width: 7%" class="text-center"><? echo ($row_data['dummy'] == '1')?'<i class="fa fa-check"></i>':''; ?></td>
                                    <td><? echo $row_data['date_access']; ?></td>
                                    <td><? echo $row_data['no_staff']; ?></td>
                                    <td><? echo $row_data['name']; ?></td>
                                    <td><? echo $row_data['audit_ip']; ?></td>
                                    <td><? echo $row_data['audit_link']; ?></td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>
