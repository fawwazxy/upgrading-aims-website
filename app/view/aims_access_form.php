<?php

include ('../controller/auth.php');

require "../model/aims_access_function.php";
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
                <h1 class="page-header">Access Form</h1>
            </div>
        </div>

        <div class="panel-heading" align="right">

        </div>

        <div class="panel-heading" align="right">

            <a href="#myModal1" data-toggle="modal" ><button type="button" class="btn btn-primary">Add New</button></a>


        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User Access
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">


                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="10%">No.</th>
                                    <th width="30%">Staff Name</th>
                                    <th width="20%">Vehicle Access</th>
                                    <th width="20%">Gl Access</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i= 1;
                                $access = getDataList();
                                while($aims_access = $access->fetch_assoc()) {

                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <b><?php echo $aims_access['name']; ?></b>
                                        </td>
                                        <td>
                                            <b><?php

                                                if ($aims_access['vehicle_access'] == 1){
                                                    ?>PIC<?
                                                } else if ($aims_access['vehicle_access'] == 2){
                                                    ?>Admin<?
                                                }
                                                else{
                                                    ?>NO<?
                                                }?></b>
                                        </td>
                                        <td>
                                            <b><?php
                                                if ($aims_access['gl_access'] == 1){
                                                    ?>Admin<?
                                                }else{
                                                    ?>No<?
                                                }
                                                ?></b></b>
                                        </td>
                                        <td>
                                            <?php echo "<a href='#myModal' class='btn btn-info btn-small' data-toggle='modal' data-id=".$aims_access['id'].">Update</a>"; ?>

                                            <a href="../controller/aims_delete_access_exec.php?id=<? echo $aims_access['id']; ?>"><button class="btn btn-warning" type="button" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                        </td>

                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>

                            </table>
                        </div>

                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- /.container-fluid -->
                </div>

                <!-- /#page-wrapper -->

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
                <h4 class="modal-title" id="myModalLabel">Update Staff Access</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');

                        $.ajax({
                            type:'POST',
                            url:'aims_access_update_modal.php',
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">Add Access</h4>
            </div>
            <div class="modal-body" id="demo4">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo4').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_access_add_modal.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo4').html(html);
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
</body>

</html>