<?php

include ('../controller/auth.php');

require "../model/aims_cert_function.php";
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

<style>
p{
   font-size: 120%;

}
td,th{
		text-align: center;
	}
</style>

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
                    <h1 class="page-header">Trading and Class Certificates </h1>
                </div>

                <div class="form-group" align="right">
                <a href="#myModal2" class="btn btn-warning" data-toggle="modal" data-id="0">Add New</a>
				<a href="print_cer4.php" class="btn btn-success" >Print</a>
                </div>
            </div>

            <? 
				$flagScreen="tab_4";
				include ('../global/menu_aims_certificate.php'); ?>
			
            <div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Expiry Date of Certificates
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th width="5%">No.</th>
                                        <th width="30%">Certificates</th>
										<th width="30%">Remark</th>
										<th width="20%">Aishah Aims 4</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $sijil = listCert4();
                                    $i=1;
                                    while($ct = $sijil->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $ct['certificate_name'];?> </td>
										<td><?echo $ct['remark'];?> </td>
										<td>
										
											<strong><font size="1" color="blue"><?echo $ct['date_in'];?></font></strong></center>
											<br><br>
											   <?$days = date('Y/m/d');
											   $date_in = $ct['date_in'];
											   $exp = $ct['month2'];
											   $exp1 = $ct['month1'];
											   if(($exp1 <= date('Y-m-d')) && (date('Y-m-d') < $date_in) && (date('Y-m-d') > $exp)){
													echo "<span style='background-color:orange;padding:5px;border-radius:5px;font-weight:bold;color:black;'>WARNING</span><br><font color=red><strong>Almost Expired</strong></font>";
												}
												else if(($exp <= date('Y-m-d')) && (date('Y-m-d') < $exp1)){
													echo "<span style='background-color:yellow;padding:5px;border-radius:5px;font-weight:bold;color:black;'>SOFT REMINDER</span><br><font color=red><strong>Almost Expired</strong></font>";
												}
												else if((date('Y-m-d') < $date_in) && ($exp > date('Y-m-d')) && (date('Y-m-d') < $exp1)){
												echo "<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>ACTIVE</span>";	
											}
											else{
													echo "<span style='background-color:red;padding:5px;border-radius:5px;font-weight:bold;color:black;'>EXPIRED</span><br><font color=red><strong>Already Expired</strong></font>";
												}?>
										
										</td>
										
										<td>
										
										<a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<? echo $ct['id'];?>">Update</a>
                                        <a href="../controller/aims_cert_delete_exec.php?id=<? echo $ct['id']; ?>"><button type="button" class="btn btn-danger" onclick="return confirm ('Do you want to delete?')">Delete</button></a>
        								
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
              url:'aims_cert_update.php',
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
	
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Trading and Class Certificates</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_cert_add.php',
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