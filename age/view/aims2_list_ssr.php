<?php

include ('../controller/auth.php');


require "../model/lookup.php";

require "../model/aims_ssr_function.php";

$id = $_GET['id'];

$status = $_GET['status'];
if (!isset($status) && $status == '') {
    $status = '1';
}
$sys = getSys(1)->fetch_assoc();
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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">SHIP STORE REQUISITION</h1>
                </div>
				
                <div class="form-group" align="right">
                    <a href="../view/aims_ssr.php" ><button type="button" class="btn btn-primary">Add New</button></a>
                </div>
            </div>

            <?
			
			$flagScreen="tab_2";
			include ('../global/menu_aims_ssr.php');

			?>
            <div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        <div class="panel-heading">
                       <label class="control-label" for="date"> Ship Store Requisition List &nbsp;&nbsp; <?if($status=='1'){echo '&nbsp;<strong><font color="orange">'.'Open'.'</font></strong>';}else{echo '&nbsp;<strong><font color="red">'.'Close'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;&nbsp; 
                        <a href="aims2_list_ssr.php?status=1">OPEN</a> &nbsp;|&nbsp;
                        <a href="aims2_list_ssr.php?status=0">CLOSE</a> 
                    </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                       <th width="5%">Bil.</th>
                                       
                                        <th width="10%">SSR_No</th>
										<th width="10%">Date</th>
										<th width="10%">Vessel</th>
										<th width="10%">Department</th>
										 <th width="10%">Item</th>
										<th width="10%">Location</th>
										<th width="10%">Verified</th>
										<th width="10%">Approved</th>
										<th width="10%">Procument Approved</th>
										<th>Status</th>
										<th>Action</th>
										
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $staff = getSSRList2($status);
                                    $i=1;
                                    while($staff_info = $staff->fetch_assoc()) {
									$status_text = "";
                                    if ($staff_info['status'] == '1') {
                                        $status_text = "Close";
                                        $color = "danger";
                                    }
                                    else {
                                        $status_text = "Open";
                                        $color = "warning";
                                    }
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $staff_info['ssr_no'];?></td>
										<td><?echo $staff_info['ssr_date'];?></td>
										<td><?echo $staff_info['vessel'];?></td>
										<td><?echo $staff_info['department'];?></td>
										<td><?echo $staff_info['item'];?></td>
										<td><?echo $staff_info['location'];?></td>
										
										<td><?if($staff_info['verified_status'] == '1') 
                                            {
                                                echo '<b><font color="green">'.'VERIFIED'.'</font></b>';
                                            }
                                            else {
                                                echo '<b><font color="grey">'.'PENDING'.'</font></b>';
                                            }
                                            ?>
										</td>
										<td><?if($staff_info['approved_status'] == '1') 
                                            {
                                                echo '<b><font color="green">'.'APPROVED'.'</font></b>';
                                            }
                                            else {
                                                echo '<b><font color="grey">'.'PENDING'.'</font></b>';
                                            }
                                            ?>
										</td>
										<td> <?if($staff_info['app_pro_status'] == '1') 
                                            {
                                                echo '<b><font color="green">'.'APPROVED'.'</font></b>';
                                            }
                                            else {
                                                echo '<b><font color="grey">'.'PENDING'.'</font></b>';
                                            }
                                            ?> 
											
											</td>
										
										<td 
										href="#myModal1" data-toggle="modal" data-id="<? echo $staff_info['id'];?>">
                                            <?if($staff_info['status'] == '1') 
                                            {
                                                echo '<b><font color="orange">'.'OPEN'.'</font></b>';
                                            }
                                            else {
                                                echo '<b><font color="red">'.'CLOSE'.'</font></b>';
                                            }
                                            ?>
                                        </td>
                                        <td>
										<a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staff_info['id'];?>">Update</a>
									    <a href="../controller/aims_ssr_delete_exec.php?id=<?echo $staff_info['id'];?>" ><button type="button" class="btn btn-danger" onclick="return confirm('Do you want to delete?');">Delete</button></a>
										<a href="shipstores.php?ssr_no=<?echo $staff_info['ssr_no'];?>&id=<?echo $staff_info['id'];?>" ><button type="button" class="btn btn-success" >SSR shipstore</button></a>
										<button class="btn btn-info" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $telno; ?>&text=Assalamualaikum w.b.t. Boleh proceed untuk yang seterusnya. Boleh terus ke link <?echo $sys['sys_domain'].'/app/view/login.php';?>. Terima kasih')" >WhatsApp &nbsp <span class="fa fa-whatsapp"></button>
										<a href="#myModal2" class="btn btn-success" data-toggle="modal" data-id="<? echo $staff_info['id'];?>">Show Attachment</a>	
										<a onclick="closeApp(<?echo $staff_info['id'] ;?>,<?echo $staff_info['status'] ;?>)" >
										<button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a><br>
										<?echo $staff_info['document_name'];?>
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
          <h4 class="modal-title" id="myModalLabel">Staff Info</h4>
        </div>
        <div class="modal-body" id="demo">
        <script type="text/javascript">
          $('#myModal1').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'aims_ssr_update.php',
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
  
 
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> 
        <div class="modal-body" id="demo1">
        <script type="text/javascript">
          $('#myModal2').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'aims_lampiran_papar.php',
              data:{id:rowid},
              success:function(html){
                $('#demo1').html(html);
              }
            });
          });
        </script>
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
    function closeApp(id,status){
            $.ajax({
            url: "../model/aims_ssr_function.php",
            type: "POST",
            data: {action:"closeApp",id:id,status:status},
            success: function (response) {
                 // you will get response from your php page (what you echo or print)                 
            //$.alert('test here:'+response);
           
            window.location='aims2_list_ssr.php?status=<?echo $status;?>';
        },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
        }
    </script>

</body>

</html>