<?php

include ('../controller/auth.php');

require "../model/trial_function.php";
require "../model/lookup.php";

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
            <!--<?include '../global/menu_keselamatan.php'?>-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Senarai Staff</h1>
                </div>
                <div class="form-group" align="right">
                    
                    <a href="../view/trial_staff.php"<?echo $id_sesi?>" ><button type="button" class="btn btn-primary">Add New</button></a>
                </div>
            </div>

            
            <div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Senarai Staff
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="10%">Bil.</th>
                                        <th width="80%">Staff Name</th>
                                        <th width="10%">Telephone No</th>
										<th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $staff = listStaff();
                                    $i=1;
                                    while($staffinfo = $staff->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $staffinfo['staff_name'];?> </td>
										<td><?echo $staffinfo['no_tel'];?> </td>
										
                                        <td>
										<a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">Update</a>
                                            <a href="../controller/trial_delete_exec.php?id=<? echo $staffinfo['id']; ?>"><button type="button" class="btn btn-danger" onclick="return confirm ('Do you want to delete?')">Delete</button></a>
        
                                        </td>
                                    </tr>
                                <?}?> 
                                 
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
              type:'POST',
              url:'trial_staff_update.php',
              data:{id:rowid},
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
  
    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        // Delete row on delete button click
        
		$(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    
    </script>

</body>

</html>