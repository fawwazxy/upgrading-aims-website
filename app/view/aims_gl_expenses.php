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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
                <h1 class="page-header">GLOBAL LOUNGE EXPENSES</h1>
            </div>
        </div>

        <? $flagScreen="tab_1";
        include ('../global/aims_gl_expenses_menu.php'); ?>

        <div class="row">
            <div class="panel-heading" style="float: right">
                <a href="aims_gl_expenses_report.php? " target="_blank">
                    <button type="button" class="btn btn-primary">Report</button></a>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Housekeeping Expenses List</label>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="width: 8%">No</th>
                                    <th>RR No</th>
                                    <th>Check In Date</th>
                                    <th>Room No</th>
                                    <th>Bed No</th>
                                    <th>Housekeeping Date</th>
                                    <th style="width: 8%">Status HK</th>
                                    <th style="width: 8%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? $i=1;
                                $utility = getExpensesList($_SESSION['SESS_NAME']);
                                while($list_utility = $utility ->fetch_assoc()) {

                                    $status = $list_utility['hk_status'] == "NO" ? "NO" : "YES";
                                    $color = $list_utility['hk_status'] == "NO" ? "red" : "green";
                                    ?>
                                    <tr>
                                        <td><? echo $i++;?></td>
                                        <td><? echo $list_utility['ref_no']; ?></td>
                                        <td><? echo $list_utility['arrival_date']; ?></td>
                                        <td><? echo $list_utility['room_id']; ?></td>
                                        <td><? echo $list_utility['bed_id']; ?></td>
                                        <td><? echo $list_utility['hk_date']; ?></td>
                                        <td><? echo "<p style='background-color: $color;' class='status'>$status</p>"; ?></td>
                                        <td>
                                            <a href='#myModal1' data-toggle='modal' data-id="<? echo $list_utility['id']; ?>"><span class="material-icons">border_color</span></a>
                                            <a href="../controller/aims_gl_expenses_delete_exec.php?id=<? echo $list_utility['id']; ?>"><span style="color: red"  title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a>
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
        <? include ('../global/footer.php'); ?>
    </div>

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Update Housekeeping Expenses</h4>
                </div>
                <div class="modal-body" id="demo">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            $.ajax({
                                type:'GET',
                                url:'aims_gl_expenses_update.php',
                                data:{id:rowid},
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