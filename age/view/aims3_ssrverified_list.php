<?php

include ('../controller/auth.php');


require "../model/lookup.php";

require "../model/aims_ssrverified_function.php";

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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">SHIP STORE REQUISITION VERIFICATION</h1>
                </div>
				
                
            </div>

            <?
			
			$flagScreen="tab_3";
			include ('../global/menu_aims_ssrverified.php');

			?>
            <div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        <div class="panel-heading">
                       <label class="control-label" for="date"> Ship Store Requisition List &nbsp;&nbsp; <?if($status=='1'){echo '&nbsp;<strong><font color="orange">'.'Open'.'</font></strong>';}else{echo '&nbsp;<strong><font color="red">'.'Close'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;&nbsp; 
                        <a href="aims3_ssrverified_list.php?status=1">OPEN</a> &nbsp;|&nbsp;
                        <a href="aims3_ssrverified_list.php?status=0">CLOSE</a> 
                    </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="10%">Bil.</th>
                                       
                                        <th width="50%">Info</th>
										
										<th width="20%">Verify</th>
                                      
										 <th width="10%">Status</th>
										<th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $staff = getSSRList3($status);
                                    $i=1;
                                    while($staff_info = $staff->fetch_assoc()) {
									$status_text = "";
                                    if ($staff_info['status'] == '0') {
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
                                        <td style= "text-align:left"> 
										<label class="control-label">SSR No : <?echo $staff_info['ssr_no'];?><br>
										<label class="control-label">SSR Date : <?echo $staff_info['ssr_date'];?><br>
										<label class="control-label">Vessel : <?echo $staff_info['vessel'];?><br>
										<label class="control-label">Location : <?echo $staff_info['location'];?><br>
										<label class="control-label">department : <?echo $staff_info['department'];?><br>
										<label class="control-label">Item :  <?echo $staff_info['item'];?><br>
										<label class="control-label">Added Info : <a href="#myModal2" data-toggle="modal" data-id="<? echo $staff_info['id'];?>"><? echo $staffinfo['document_name'];?></a><br></td>
										
										
										<td style="text-align:center">
										<?'<b>'.$staff_info['verified_status'].'</b>';
										if($staff_info['verified_status']==0){
										    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
										else {
										    echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>"
										;}'</b>'?><br>
										<br><label class="control-label">Name : <? echo $staff_info['verified_name'];?></label>
                                        
                                        <br><label class="control-label">Designation : <? echo $staff_info['verified_designation'];?></label>
                                        
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
											<a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staff_info['id'];?>">VERIFIED</a>
										<br><button class="btn btn-info" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $telno; ?>&text=Assalamualaikum w.b.t. Boleh proceed untuk yang seterusnya. Boleh terus ke link <?echo $sys['sys_domain'].'/app/view/login.php';?>. Terima kasih')" >WhatsApp &nbsp <span class="fa fa-whatsapp"></button>
											
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
              url:'aims_ssrverified_update.php',
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
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
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
            url: "../model/aims_ssrverified_function.php",
            type: "POST",
            data: {action:"closeApp",id:id,status:status},
            success: function (response) {
                 // you will get response from your php page (what you echo or print)                 
            //$.alert('test here:'+response);
           
            window.location='aims3_ssrverified_list.php?status=<?echo $status;?>';
        },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
        }
    </script>

</body>

</html>