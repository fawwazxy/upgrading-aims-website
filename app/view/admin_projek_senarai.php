<?php
include ('../controller/auth.php');
require "../model/projek_internal_task_functions.php";
//require "../model/lookup.php";
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
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tugasan Kakitangan</h1>
            </div>
        </div>
        <div class="form-group" align="right">
            <!-- <a href="projek_task_tambah.php?page=admin"><button type="button" class="btn btn-primary">Tambah Baharu</button></a>-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Tugasan Kakitangan</label>&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 10%">Bil.</th>
                                <th style="width: 25%">Maklumat Petugas</th>
                                <th style="width: 25%">Maklumat Tugasan</th>
                                <th style="width: 20%">Bil. Tugasan Tertunggak</th>
                                <th style="width: 20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $tugasan = getStafTask();
                            while($list_tugasan = $tugasan->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td>
                                        Nama : <br><strong><?echo $list_tugasan['name']?></strong>
                                        <br>No. Kad Pengenalan : <br><strong><?echo $list_tugasan['noic']?></strong>
                                        <br>No. Staff : <br><strong><?echo $list_tugasan['no_staff']?></strong>
                                    </td>
                                    <td>
                                        Untuk Pelaksanaan : <strong><span style="color: red; font-size: large; "><? echo getBilTaskByCategory('TODO',$list_tugasan['noic']);?></span></strong>
                                        <br>Dalam Pelaksanan : <strong><span style="color: orange; font-size: large; "><? echo getBilTaskByCategory('INPROGRESS',$list_tugasan['noic']);?></span></strong>
                                        <br>Siap : <strong><span style="color: green; font-size: large; "><? echo getBilTaskByCategory('DONE',$list_tugasan['noic']);?></span></strong>
                                    </td>
                                    <td style="font-size: 70px; align-content: center; text-align: center">
                                        <strong><span style="color: red; "><? echo getBilTaskOverdue($list_tugasan['noic']);?></span></strong>
                                    </td>
                                    <td>
                                        <a href="senarai_tugasan_staf.php?nokp=<?echo $list_tugasan['noic'];?>"><button type="button" class="btn btn-primary">Paparan Tugasan</button></a>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>