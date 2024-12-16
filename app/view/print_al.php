<?php

	include ('../controller/auth.php');
	require "../model/staff_function.php";
	require "../model/lookup.php";

?>
<?
            $id = $_GET['id'];
			$no_staff = $_GET['no_staff'];
			$tahun = $_GET['tahun'];
			$department_code=$_GET['department_id'];
			$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
			$statact = $_GET['statact'];
			$month=$_GET['month'];
			if(!isset($statact)){
				$statact = 'ACTIVE';

			}
		
			if(!isset($department_code)){
				$department_code = $_SESSION['SESS_DEPARTMENT'];
				$month=$date_month;
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
    
    <? require "../global/header.php"; ?>


<script language="javascript" type="text/javascript">
<!--

// -->
</script>



<style>
img {
  float: left;
}

.butt0n{
float:right;
}

 @media print {
        #printPageButton {
        display: none;
    }
    } 

    @media print {
      #html-content-holder {
        display: none;
      }
      #btn-Preview-Image {
        display: none;
      }
      #btn-back {
        display: none;
      }
    } 
    
    
</style>

<script>
    function myFun(){
        window.location.href="list_cuti_HR_AL.php";
    }
    
</script>
<script type="text/javascript">
 
        function SwapDivsWithClick(div1,div2)
        {
           d1 = document.getElementById(div1);
           d2 = document.getElementById(div2);
           if( d2.style.display == "none" )
           {
              d1.style.display = "none";
              d2.style.display = "block";
           }
           else
           {
              d1.style.display = "block";
              d2.style.display = "none";
           }
        }

</script>

</head>

<body>

<div id="swapper-first" style="display:block;" onclick="SwapDivsWithClick('swapper-first','swapper-other')">
<img id="logo"  
src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;"/>
</div>
<div id="swapper-other" style="display:none;" onclick="SwapDivsWithClick('swapper-first','swapper-other')">
<img id="logo"
src="../../resources/images/avsb-logo.PNG" style="width:440px;height:90px;margin-left:15px;"/>
</div>

<br><br><br>
<div style="text-align:right;">
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Print"/>
    <button id="btn-back" onclick="myFun()">Back</button>
    <br><br>
</div>
<hr style="height:2px;color:gray;background-color:gray">
 <center><h2>ANNUAL LEAVE LIST</h2></center>
<br><br><br>
			  
			  <table border="0">
					<tr>
					<td>
					<label class="control-label">COMPANY:</label>
						</td><td>&nbsp;&nbsp;&nbsp;</td><td>
						  <select  required class="form-control" name="department_code" id="department_code">
									<option value="">-- CHOOSE COMPANY--</option>
									<? echo getDropDown("department","code_department","description",$department_code);?>
							</select>
						 </td>
						  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
					<label class="control-label">MONTH:</label>
						</td><td>&nbsp;&nbsp;&nbsp;</td><td>
						<select  required class="form-control" name="month" id="month" value="<?echo $month?>">
                          <option value="">-- CHOOSE MONTH --</option>
                          <? echo getDropDownMonth($month) ;?>
                          </select>
						  </td>
						  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						  
						 
						</tr>
            </table>

			  <br><br><br>

         
                    
						
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
					      <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Staff Information</th>
										<th>Type of Leave & Number of Leave</th>
										<th>Support</th>
                                        <th>Approvement HOD/CEO</th>
										<th>Leave Status</th>
									</tr>
								</thead>
								<tbody>
								
								<?
									$i= 1;
									$data_staff = getListAL($department_code,$month);
									while($row_data_staff = $data_staff->fetch_assoc()) {
									
									
								?>
							
									<tr class="odd gradeX">
									<td><?php echo $i; ?></td>
									<td>
									DATE START: <br><? echo $row_data_staff['date_lv_from'];?><br>
									DATE END: <br><? echo $row_data_staff['date_lv_to'];?>
									</td>
									
										
										
									<td>
									NAME : <? echo $row_data_staff['name'];?><br>
									DEPARTMENT : <? echo $row_data_staff['department_sub'];?><br>
									IC NO	   : <? echo $row_data_staff['no_staff'];?><br>
									REASON	   : <? echo $row_data_staff['reason_leave'];?>
									</td>
										
									<td>
									TYPE OF LEAVE : <? if($row_data_staff['type_leave'] == 'AL' ) {
                                                        echo 'Annual leave';}
                                                    else if($row_data_staff['type_leave'] == 'MC') {
                                                        echo 'Medical leave';}
                                                    else if($row_data_staff['type_leave'] == 'LP') {
                                                        echo 'Leave Without Pay';}
													else if($row_data_staff['type_leave'] == 'CL') {
                                                        echo 'Compassionate Leave';}	
                                                    else {
													echo 'Leave Without Record'; }?><br>
									NUM. OF LEAVE  : <? echo $row_data_staff['total_lv_req'];?> days
									</td>
										
                                    <td><? echo $row_data_staff['support'];?><br><? echo $row_data_staff['support_by'];?></td>
									<td><? echo $row_data_staff['approvement'];?><br><? echo $row_data_staff['pelulus'];?></td>

									<td>
									TYPE OF LEAVE : <? echo $row_data_staff['jenis_cuti'];?><br>
									ENTITLED: <b><? echo $row_data_staff['total_cuti'];?></b> days<br>
									BALANCE : <b><? echo $row_data_staff['baki_cuti'];?></b> days<br>
								<!--	BAKI CUTI PERMOHONAN : <? echo $row_data_staff['baki_cuti_pohon'];?> -->
									</td>
									
                                       
									</tr>
								<?php $i++; } ?>
							
								</tbody>

							</table>

                        </div>

           
           

                <!-- /.row -->
            <!-- /.container-fluid -->
        

        <!-- /#page-wrapper -->

    
    <!-- /#wrapper -->


	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#department_code").change(function(){
		 var selected_cawangan=$(this).val();
		 sendType(selected_cawangan);
		 });
		 
		 $("#month").change(function(){
					if($("#department_code").val()==''){
						alert('SELECT DEPARTMENT!')
						$("#month").val('');
					}else{
						var selected_month=$(this).val();
						var selected_cawangan=$("#department_code").val();
						reloadMonth(selected_month,selected_cawangan);

					}
				});

    });
	
	

	
	 function sendType(type)
	 {
		window.location.href="print_al.php?department_id="+type;
		
	}
	
	function reloadMonth(selected_month,selected_cawangan)
	 {
		window.location.href="print_al.php?department_id="+selected_cawangan+"&month="+selected_month;
		
	}
    </script>

</body>

</html>