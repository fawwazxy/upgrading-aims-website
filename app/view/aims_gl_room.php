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
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
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
                <h1 class="page-header">ROOM</h1>
            </div>
        </div>

        <? $flagScreen="tab_1";
        include ('../global/aims_gl_room_menu.php'); ?>

        <div class="row">
            <div class="panel-heading" style="float: right">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">ROOM LIST</label>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">No.</th>
                                <th>Room Name</th>
                                <th>Bed Type</th>
                                <th>Capacity</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $room = getRoomList($_SESSION['SESS_NAME']);
                            while($list_room = $room ->fetch_assoc()) {

                                $status = $list_room['status'] == "0" ? "NOT AVAILABLE" : "AVAILABLE";
                                $color = $list_room['status'] == "0" ? "red" : "green";
                                ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $list_room['room_no']; ?></td>
                                    <td><? echo $list_room['bed_type']; ?></td>
                                    <td><? echo $list_room['capacity']; ?></td>
                                    <td><? echo "<p style='background-color: $color;' class='status'>$status</p>"; ?></td>
                                    <td><a href='#myModal1' data-toggle='modal' data-id="<? echo $list_room['id'];?>"><span class="material-icons">border_color</span></a></td>
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
                <h4 class="modal-title" id="myModalLabel">Add Room</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/aims_gl_room_exec.php" >

                    <div class="form-group">
                        <label for="room_no">ROOM NO <span style="color: red">*</span></label>
                        <input class="form-control" name="room_no" id="room_no" required autocomplete="">
                    </div>

                    <div class="form-group">
                        <label for="capacity">CAPACITY <span style="color: red">*</span></label>
                        <input class="form-control" name="capacity" id="capacity" required autocomplete="">
                    </div>

                    <div class="form-group">
                        <label for="bed_type">BED TYPE <span style="color: red">*</span></label>
                        <input class="form-control" name="bed_type" id="bed_type" required autocomplete="">
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
                <h4 class="modal-title" id="myModalLabel">Update Room</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'GET',
                            url:'aims_gl_room_update.php',
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
</script>
</body>
</html>