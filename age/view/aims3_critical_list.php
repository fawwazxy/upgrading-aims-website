<?php

include ('../controller/auth.php');


require "../model/lookup.php";

require "../model/aims_critical_function.php";

$id = $_GET['id'];

$mnt=$_GET['mnt'];
$yr=$_GET['yr'];

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
		
		<?
			$flagScreen="tab_3";
			include ('../global/menu_aims_critical.php');

			?>
			
			
		
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">MONTHLY CRITICAL SPAREPARTS ROB </h1>
                </div>
                
            </div>
			

			<?
			
			$flag=$_GET['flg'];
			include ('../global/menu_bulan_vessel3.php');
			?>
			
			<br>
			
			<div class="form-group" align="right">
                    <a href="../view/aims_critical.php" ><button type="button" class="btn btn-primary">Add New</button></a>
            </div>
			
			
            <div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        <div class="panel-heading">
                           MONTHLY CRITICAL SPAREPARTS ROB LIST
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
									  <th width="10%">Bil.</th>
                                        <th width="80%">Part name</th>
                                       
                                        <th width="10%">Minimum</th>
										<th width="80%">Balance</th>
										<th width="80%">Used</th>
										<th width="80%">Supply</th>
										
										<th width="80%">ROB</th>
										  <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $staff = listStaffaa3($month,$year);
                                    $i=1;
                                    while($staff_info = $staff->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $staff_info['part_name'];?></td>
										<td><?echo $staff_info['minimum'];?></td>
										<td><?echo $staff_info['balance'];?></td>
										<td><?echo $staff_info['used'];?></td>
										<td><?echo $staff_info['supply'];?></td>
										<td><?echo $staff_info['rob'];?></td>
										
										
                                        <td>
											<a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staff_info['id'];?>">Update</a>
											
                                            <a href="../controller/aims_critical_delete_exec.php?id=<?echo $staff_info['id'];?>" ><button type="button" class="btn btn-danger" onclick="return confirm('Do you want to delete?');">Delete</button></a>
											
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
	<!-- function popup -->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Critical Info</h4>
        </div>
        <div class="modal-body" id="demo">
        <script type="text/javascript">
          $('#myModal1').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'aims_critical_update.php',
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
		$(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    
    </script>
	
	<script>
	
		$(document).ready(function() {
	            $("#month").change(function(){

					var selected_month=$(this).val();
					reloadMonth(selected_month);
				});

				$("#year").change(function(){
					if($("#month").val()=='' && $("#year").val()=='' ){
						alert('SELECT MONTH AND YEAR!')
						$("#year").val('');
					}else{
						var selected_year=$(this).val();
						var selected_month = $("#month").val();
						reloadYear(selected_month,selected_year);

					}
				});

		    });



		    function reloadMonth(month){
	            //console.log(cawangan);
	            location.href = "aims3_critical_list.php?month="+month;
	        }
	        function reloadYear(selected_month,selected_year){
	            //console.log(obj);
	            location.href = "aims3_critical_list.php?month="+selected_month+"&year="+selected_year;
	        }
	
	</script>

</body>

</html>