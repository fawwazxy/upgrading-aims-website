<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: "Arial", serif;
        }
        th, td {
            text-align: center;
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
                <h1 class="page-header">BEVERAGE & TOILETRIES</h1>
            </div>
        </div>

        <? $flagScreen="tab_2";
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
                        <label class="control-label" for="date">Beverage & Toiletries List</label>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 8%">No.</th>
                                <th>Item</th>
                                <th>Code</th>
                                <th style="width: 8%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $item = getItemHkList();
                            while($list_item = $item ->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list_item['item']; ?></td>
                                    <td><? echo $list_item['code']; ?></td>
                                    <td>
                                        <a href='#myModal1' data-toggle='modal' data-id="<? echo $list_item['id']; ?>"><span class="material-icons">border_color</span></a>
                                        <a href="../controller/aims_gl_hk_item_delete_exec.php?id=<? echo $list_item['id']; ?>"><span style="color: red"  title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a>
                                    </td>
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
                <form method="post" action="../controller/aims_gl_hk_item_exec.php" >

                    <div class="form-group">
                        <label for="item">Item Name <span style="color: red">*</span></label>
                        <input class="form-control" name="item" id="item" required onkeyup="convertToUppercase(this)">
                    </div>

                    <div class="form-group">
                        <label for="code">Item Code <span style="color: red">*</span></label>
                        <input class="form-control" name="code" id="code" required onkeyup="convertToUppercase(this)">
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
                <h4 class="modal-title" id="myModalLabel">Update</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'GET',
                            url:'aims_gl_hk_item_update.php',
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

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>

</body>
</html>