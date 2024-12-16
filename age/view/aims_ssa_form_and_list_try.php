<?php

include ('../controller/auth.php');

require "../model/aims_ssa_function.php";
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
                    <h1 class="page-header">SSA List</h1>
                </div>
                <div class="form-group" align="right">
                <a href="#myModal2" class="btn btn-primary" data-toggle="modal" data-id="0">Tambah Baharu</a>
                </div>
            </div>

            <?
			$flagScreen="tab_1";
			include ('../global/menu_aims_ssa.php');
			?>
	
            <div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        <div class="panel-heading">
                            SSA Required List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th width="10%">No.</th>
                                        <th width="10%">SSA No.</th>
                                        <th width="20%">Date</th>
                                        <th width="30%">Vessel</th>
										<th width="30%">Location</th>
										<th width="30%">Department</th>
										<th width="40%">SSA Raised</th>
										<th width="40%">SSA Required Description</th>
										<th width="40%">Model No.</th>
										<th width="40%">Remedial Action</th>
										<th width="40%">Assistance Required</th>
										<th width="40%">Added Info</th>
										<th width="40%">Action</th>
										
										
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $staff = listSSAaa1();
                                    $i=1;
                                    while($staffinfo = $staff->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $staffinfo['ssa_no'];?> </td>
										<td><?echo $staffinfo['date'];?> </td>
										<td><?echo $staffinfo['vessel'];?> </td>
										<td><?echo $staffinfo['location'];?> </td>
										<td><?echo $staffinfo['department'];?> </td>
										<td><?echo $staffinfo['ssa_raised'];?> </td>
										<td><?echo $staffinfo['aa'];?> </td>
										<td><?echo $staffinfo['bb'];?> </td>
										<td><?echo $staffinfo['cc'];?> </td>
										<td><?echo $staffinfo['dd'];?> </td>
										<td>
										<a href="#myModalImg" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>"><? echo $staffinfo['ee_name'];?></a></td>
                                        <td>
										<a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">Update</a>
                                        <a href="../controller/aims_ssa_delete_exec.php?id=<? echo $staffinfo['id']; ?>"><button type="button" class="btn btn-danger" onclick="return confirm ('Do you want to delete?')">Delete</button></a>
        										<a href="" onclick="return popitup('aims_ssa_pic.php?id=<? echo $staffinfo['id']; ?>')"><button type="button" class="btn btn-info">View Image</button></a>
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
    <div class="modal-dialog modal-lg">
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
              url:'aims_ssa_update.php',
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
    
	
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Kad Pelawat</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_ssa_form_try.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
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