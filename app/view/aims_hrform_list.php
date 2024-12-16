<?php
include ('../controller/auth.php');
require "../model/aims_hr_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_lumpur");

$no_staff = $_SESSION['SESS_NO_STAFF'];
$code_department = $_SESSION['SESS_DEPARTMENT'];
$company_name = ($_GET['company_name'])?:'AGHSB';
$flag=$_GET['flg'];
if(!isset($flag)){
    $flag='tb_1';
}
if(!isset($company_name)){
    $company_name='AGHSB';

}
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style type="text/css">
        .material-icons.md-18 {
            font-size: 14px;
        }
    </style>
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
                <h1 class="page-header">Human Resource Form List</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading">
                <div class="row" style="margin-bottom: 16px">
                    <div class="col-lg-4">
                        <form method="get" name="filterForm">
                            <select required class="form-control" name="company_name" id="company_name" onchange="filterForm.submit()">
                                <? echo getdropdown("department","code_department","description",$company_name);?>
                            </select>
                        </form>
                    </div>
                    <div class="col-lg-8">
                        <? if($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){?>
                            <a href="aims_hrform_upload.php"><button type="button" class="btn btn-primary" style="float:right;">Add New</button></a>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Form List</div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Name </th>
                                <th>Upload On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $aims_hr_form = getHrFormList($company_name);
                            while($row_data = $aims_hr_form->fetch_assoc()) {
                                $upload_date= new DateTime($row_data['created_date']);
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row_data['form_name']; ?></td>
                                    <td><?php echo $upload_date->format('Y-m-d'); ?></td>
                                    <td>
                                        <? if($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){?>
                                            <a href="../controller/aims_hrform_delete_exec.php?id=<? echo $row_data['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete?');"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>
                                        <? } ?>
                                        <a href="" onclick="return popitup('aims_hrform_attachment.php?id=<? echo $row_data['id'];?>')"class="btn btn-info"><span class="glyphicon glyphicon-new-window"></span> View</a>
                                        <a href="../controller/aims_hrform_download_exec.php?id=<? echo $row_data['id']; ?>" class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> Download</a>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_hrform_attachment.php',
                            data:'id='+rowid,
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=500,width=815,left=285%,right=100%,top=120%');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>
</body>
</html>
