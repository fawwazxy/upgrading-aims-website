<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

if(in_array($_SESSION['SESS_NOKP'],['920529115513','950728035572','940718115430'])){ // zuhdi, syuhada, syamimy
    echo "<script type='text/javascript'>
            window.location.href='../view/aims_gl_admin.php';
            </script>";
    exit();
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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: "Arial", serif;
        }
        th, td {
            text-align: center;
        }
        .status {
            padding: 2px 5px;
            border-radius: 5px;
            font-weight:bold;
            color: #FFFFFF;
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

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">CLIENT COMPANY</h1>
            </div>
        </div>

        <? $flagScreen="tab_1";
        include ('../global/aims_gl_settings_menu.php'); ?>

        <div class="row">
            <div class="panel-heading" style="float: right">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">CLIENT COMPANY LIST</label>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 8%">No</th>
                                <th>Company Code</th>
                                <th>Company Name</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 8%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $cc = getCompanyClientList($_SESSION['SESS_NAME']);
                            while($list_cc = $cc ->fetch_assoc()) {

                                $status = $list_cc['status'] == "0" ? "INACTIVE" : "ACTIVE";
                                $color = $list_cc['status'] == "0" ? "red" : "green";
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list_cc['code_company']; ?></td>
                                    <td><? echo $list_cc['company_name']; ?></td>
                                    <td><? echo "<p style='background-color: $color;' class='status'>$status</p>"; ?></td>
                                    <td><a href='#myModal1' data-toggle='modal' data-id="<? echo $list_cc['id'];?>"><span class="material-icons">border_color</span></a></td>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add New</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/aims_gl_client_company_exec.php">

                    <div class="form-group">
                        <label for="code_company">Company Code <span style="color: red">*</span></label>
                        <input class="form-control" placeholder=" " name="code_company" id="code_company" onkeyup="convertToUppercase(this)" required>
                    </div>

                    <div class="form-group">
                        <label for="company_name">Company Name <span style="color: red">*</span></label>
                        <input class="form-control" placeholder=" " name="company_name" id="company_name" onkeyup="convertToUppercase(this)" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Client Company</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'GET',
                            url:'aims_gl_client_company_update.php',
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function convertToUppercase(el){
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>

</body>
</html>