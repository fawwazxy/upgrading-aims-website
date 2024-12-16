<?php

include ('../controller/auth.php');

require "../model/aims_lv_medical_function.php";
require "../model/lookup.php";

?>

<?
    date_default_timezone_set("Asia/Kuala_Lumpur");
	$no_staff = $_SESSION['SESS_NO_STAFF'];
	$staff_record_id = $_GET['staff_record_id'];
	$medical_id = $_GET['medical_id'];
	$app_id = $_GET['app_id'];
    $ver_status = $_GET['ver_status'];
    if (!isset($ver_status) && $ver_status == '') {
        $ver_status = 'PENDING';
    }
    
//     if(!isset($department_code)){
// 				$department_code = $_SESSION['SESS_DEPARTMENT'];

// 			}
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
	<!--simbol loading-->
<style>
           #loader {
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 12px solid #444444;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
        }
          
        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
          
        .center {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            z-index: 99999 ;
        }
        
    </style>
</head>

<body>
    <!--simbol loading-->
    <div id="loader" class="center"></div>

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
                    <h1 class="page-header">Medical List</h1>
                </div>
                
            </div>
			
			 <div class="panel-heading">

				<? 
                    $staff = getStaffInformation($no_staff) -> fetch_assoc();
				?>
				<table width="100%">
                                <tr>
                                    <th width="14%"></th>
                                    <th width="2%"></th>
                                    <th></th>
                                </tr>
                                <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />      
                                <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" /> 
                                <tr>
                                    <td><label>NAME</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $staff['staff_name']?></td>
                                </tr>

                                <tr>
                                    <td><label>IC NUMBER</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $staff['noic']?></td>
                                </tr>

                                <tr>
                                    <td><label>POSITION</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $staff['role_id']?></td>
                                </tr>

                                <tr>
                                    <td><label>DEPARTMENT</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $staff['department_sub'] ?></td>
                                </tr>
                                
                                <tr>
                                    <td><label>COMPANY</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $staff['company_name']?></td>
                                </tr>
</table>

   </div>         
			                  
            <div class="row">
       <!--         <select  required class="form-control" name="department_code" id="department_code">-->
							<!--		<option value="">-- Pilih Syarikat--</option>-->
							<!--		<? echo getDropDown("department","code_department","description",$department_code);?>-->
							<!--</select>-->
                <div class="col-lg-12">
<br><br><br><br>
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>Medical List</label>&nbsp;&nbsp;&nbsp;
                            <a href="aims_lv_medicalver_list.php?ver_status=PENDING">New</a> &nbsp;|&nbsp;
                            <a href="aims_lv_medicalver_list.php?ver_status=VERIFIED">Verified</a> &nbsp;|&nbsp;
                            <a href="aims_lv_medicalver_list.php?ver_status=DISAPPROVED">Disapproved</a> &nbsp;|&nbsp; 
                            <a href="aims_lv_medicalver_list.php?ver_status=COMPLETE">Complete</a> &nbsp;|&nbsp;
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th style="text-align:center;" width="5%">No.</th>
                                        <th style="text-align:center;" width="30%">Staff Info</th>
										<th style="text-align:center;" width="20%">Info</th>
										<th style="text-align:center;" width="25%">Attachment</th> 
										<th style="text-align:center;" width="40%">Total Balance</th>
										<th style="text-align:center;" width="10%">Remarks</th>
										<!-- <th style="text-align:center;" width="10%">Verified Date</th> -->
										<th style="text-align:center;" width="10%">HR Verify</th>
										<th style="text-align:center;" width="10%">CFO Approval </th>
										<th style="text-align:center;" width="10%">CEO Approval</th>
										<th style="text-align:center;">Action</th>
										
                                    </tr>
                                </thead>
                                <tbody>
                                <?

                                if($ver_status == 'PENDING')
                                    {
                                        $staff= getSenaraiMedicalBaru($_SESSION['SESS_DEPARTMENT_SUB']);
                                    }
                                    else if ($ver_status == 'VERIFIED') 
                                    {
                                        $staff= getSenaraiMedicalVerified();
                                    }
                                    else if ($ver_status == 'DISAPPROVED') 
                                    {
                                        $staff= getSenaraiMedicalDisapproved();
                                    }
                                    else if ($ver_status == 'COMPLETE') 
                                    {
                                        $staff= getSenaraiMedicalComplete();
                                    }

                                    // $staff = listhr();
                                    $i=1;
                                    while($staffinfo = $staff->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $staffinfo['name'];?> <br>
										<?echo $staffinfo['noic'];?>  <br>
										<?echo $staffinfo['department_sub'];?>  <br>
										<?echo $staffinfo['department_id'];?>  <br>
										<?echo $staffinfo['company_name'];?><br>
										<!-- RM <?echo $staffinfo['total_mec'];?></td> -->
										
										<td>
										<label class="control-label">Date:</label><br> <?echo $staffinfo['mec_date'];?><br>
										<label class="control-label">Description:</label> <?echo $staffinfo['description'];?> <br>
										<?$created_date= new DateTime($staffinfo['created_date']);?>
									    <label class="control-label">Date Applied:</label><br> <?echo $created_date->format('Y-m-d');?>  
										</td>
										
										
										<td>
										<? if($ver_status == 'COMPLETE'){ } 
										else{?>
										<? if($staffinfo['document'] != ''){ ?>
										    <a href="#myModal2" class="btn btn-info" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">Show Attachment</a>
									    <?} else { ?>
									    <center><b><font color="red">NO ATTACHMENT</font></b></center>
										<? }} ?>
										
                                      <!--   <?if($staffinfo['document_type'] == 'jpg' || $staffinfo['document_type'] == 'jpeg' || $staffinfo['document_type'] == 'png' || $staffinfo['document_type'] == 'gif') {
                                                echo '<img width="200" height="100" src="data:image/jpeg;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>';}
                                         else if($staffinfo['document_type'] == 'pdf') {
                                                echo '<object width="200" height="100" data="data:application/pdf;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>'.'" type="application/pdf"></object>';}
                                            ?> -->

                                        </td> 
										
										<td>
										<label class="control-label">Total Medical : RM<?echo $staffinfo['baki_claim'];?><br>
										<label class="control-label">Total Claim : RM<?echo $staffinfo['total_claim'];?> <br>
										<!--<label class="control-label">Balance : RM<?echo $staffinfo['jumlah_claim'];?> -->
										</td>
										
										<td><?echo $staffinfo['remarks'];?></td>
										
										
										
										
										<td>
										<?'<b>'.$staffinfo['ver_status'].'</b>';
										if($staffinfo['ver_status']=="PENDING"){
										    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
										else if($staffinfo['ver_status']=="DISAPPROVED"){
										    echo"<span style='background-color:red; padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>";}
										else if($staffinfo['ver_status']=="COMPLETE"){
										    echo"<span style='background-color:orange; padding:5px;border-radius: 5px; font-weight:bold;color:white;'>COMPLETE</span>";}
										else {
										    echo"<span style='background-color:green; padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>";}'</b>'
										    ?>
										<br><br>
										<?echo $staffinfo ['ver_name'];?>
                                        <br>
                                        <br>
                                        <?'<b>'.$staffinfo['ver_date'].'</b>';
                                        if($staffinfo['ver_status'] == 'VERIFIED' || $staffinfo['ver_status'] == 'COMPLETE'){
                                            echo $staffinfo['ver_date'];}?>
										</td>
										
										<td>
										<?'<b>'.$staffinfo['appcfo_status'].'</b>';
										if($staffinfo['appcfo_status']=='PENDING'){
										    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
										else if($staffinfo['appcfo_status']=='APPROVED'){
										    echo"<span style='background-color:GREEN;padding:5px;border-radius:5px;font-weight:bold;color:white;'>APPROVED</span>";}
										else {
										    echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
										;}'</b>'?>
										<br><br>
										<?echo $staffinfo['appcfo_name'];?>
                                        <br><br>
                                        <?'<b>'.$staffinfo['appcfo_date'].'</b>';
                                        if($staffinfo['appcfo_status'] == 'APPROVED'){
                                            echo $staffinfo['appcfo_date'];}?>
										
                                        </td>
										
										<td>
										<?'<b>'.$staffinfo['app_status'].'</b>';
										if($staffinfo['app_status']=='PENDING'){
										    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
										else if($staffinfo['app_status']=='APPROVED'){
										    echo"<span style='background-color:GREEN;padding:5px;border-radius:5px;font-weight:bold;color:white;'>APPROVED</span>";}
										else {
										    echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
										;}'</b>'?>
										<br><br>
										<?echo $staffinfo['app_name'];?>
                                        <br><br>
                                        <?'<b>'.$staffinfo['app_date'].'</b>';
                                        if($staffinfo['app_status'] == 'APPROVED'){
                                            echo $staffinfo['app_date'];}?>
										
										
                                        </td>
										
										
										<td>
										
                                            <a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">Verify</a>
                                      
                                       <a href="aims_lv_medicalhr_form.php?id=<?echo $staffinfo['id'];?>"><button type="button" class="btn btn-warning">HR department</button></a>
									   <a class="view" target="blank" href="aims_lv_cetak.php?id=<?echo $staffinfo['id'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>Print Slip</button></a>
								    <? if($staffinfo['ver_status'] == 'VERIFIED'){?>
										<a href="../controller/button_complete_medical_exec.php?app_id=<? echo $staffinfo['app_id'];?>"><button class="btn btn-primary" type="button" onclick="return Confirm()">Complete</button></a>
								    <?}?>
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
          <h4 class="modal-title" id="myModalLabel">Verified</h4>
        </div>
        <div class="modal-body" id="demo">
        <script type="text/javascript">
          $('#myModal1').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'aims_lv_medicalver_update.php',
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
              url:'aims_lv_medicalpic.php',
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
        // Delete row on delete button click
        
		$(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
//         $("#department_code").change(function(){
// 		 var selected_cawangan=$(this).val();
// 		 sendType(selected_cawangan);
// 		 });

    });
// 	 function sendType(type)
// 	 {
// 		window.location.href="aims_lv_medicalver_list.php?ver_status="+$ver_status+"&department_id="+type;
		
// 	}
    </script>
    <!--loading simbol-->
    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector(
                  "body").style.visibility = "hidden";
                document.querySelector(
                  "#loader").style.visibility = "visible";
            } else {
                document.querySelector(
                  "#loader").style.display = "none";
                document.querySelector(
                  "body").style.visibility = "visible";
            }
        };
    </script>

</body>

</html>



