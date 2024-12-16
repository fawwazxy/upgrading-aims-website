<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

?>
<?
$client= getClientList($_SESSION['SESS_NAME'],$_SESSION['SESS_DEPARTMENT_SUB']);

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

</head>

<style>
    body{
        font-size: 12.5px;
    }
    th, td{
        text-align: center;
    }
</style>

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
                    <!-- <li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                      </li> -->

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
                <h1 class="page-header">GLOBAL LOUNGE EXPENSES</h1>
            </div>
        </div>

        <?
        $flagScreen="tab_1";
        include ('../global/aims_gl_expenses_menu.php');
        ?>

        <div class="row">
            <div class="panel-heading" align="right">

                <a href="aims_gl_expenses_report.php? " target="_blank">
                    <button type="button" class="btn btn-primary">Report</button></a>

            </div>
            <div class="col-lg-12">
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Housekeeping Expenses List</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>RR No</th>
                                    <th>Check In Date</th>
                                    <th>Room No</th>
                                    <th>Bed No</th>
                                    <th>Housekeeping Date</th>
                                    <th>Status HK</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $utility = getExpensesList();
                                $i=1;
                                while($list_utility = $utility ->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><? echo $i++;?></td>
                                        <td><? echo $list_utility['ref_no']; ?></td>
                                        <td><? echo $list_utility['arrival_date']; ?></td>
                                        <td><? echo $list_utility['room_id']; ?></td>
                                        <td><? echo $list_utility['bed_id']; ?></td>
                                        <td><? echo $list_utility['hk_date']; ?></td>
                                        <td><? echo $list_utility['hk_status']; ?></td>
                                        <td><!-- <a href='#myModal1' data-toggle='modal' data-id="<? echo $list_utility['id'];?>"><span class="material-icons">border_color</span></a> -->

                                            <a href="../view/aims_gl_expenses_update.php?id=<? echo $list_utility['id']; ?>"><span style="color: red"  title="Update" class="material-icons">Update</span></a>

                                            <a href="../controller/aims_gl_expenses_delete_exec.php?id=<? echo $list_utility['id']; ?>"><span style="color: red"  title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a></td>
                                    </tr>
                                <?}?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>

    </div>
    <!-- /#wrapper -->
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
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
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_gl_expenses_update.php',
                                data:'id='+rowid,
                                success:function(html){
                                    $('#demo').html(html);
                                }
                            });
                        });
                    </script>
                </div> <!--modal-body -->
            </div> <!--modal content -->
        </div> <!--modal-dialog -->
    </div> <!--modal fade -->


    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });



    </script>

</body>

</html>