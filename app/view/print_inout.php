<?php

	include ('../controller/auth.php');
	require "../model/aims_inout_function.php";
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
function popitup(url) {
	/*newwindow=window.open(url,'name','height=842,width=595');*/
	newwindow=window.open(url,'name','height=595,width=842');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>



<style>
img {
  float: left;
}

.butt0n{
float:right;
}
</style>



<script>
function myFun() {
 window.location.href="aims_inout_list_hr.php";
}
</script>



</head>

<body>



<br><br><br>

<button class="butt0n" onclick="window.print()">Print</button>
<button class="butt0n" onclick="myFun()">Kembali</button>
 <center><h2> INOUT LIST </h2></center>
<br><br><br>
			  
			  <table border="0">
					<tr>
					<td>
					<label class="control-label">COMPANY:</label>
						</td><td>&nbsp;&nbsp;&nbsp;</td><td>
						  <select  required class="form-control" name="department_code" id="department_code">
									<option value="">-- Pilih Company--</option>
									<? echo getDropDown("department","code_department","description",$department_code);?>
							</select>
						 </td>
						  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
					<label class="control-label">MONTH:</label>
						</td><td>&nbsp;&nbsp;&nbsp;</td><td>
						<select  required class="form-control" name="month" id="month" value="<?echo $month?>">
                          <option value="">-- Choose Month --</option>
                          <? echo getDropDownMonth($month) ;?>
                          </select>
						  </td>
						  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						  
						 
						</tr>
            </table>

			  <br><br><br>


        		<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-body">
                            
                            	<input type="text" name="company_id"  value="<? echo $_SESSION['SESS_COM']; ?>">
                            	<input type="text" name="shortcode"  value="<? echo $shortcode;?>">
                            	<input type="text" name="department_code"  value="<? echo $department_code;?>">
                                <input id="action" name="action" type="hidden" value="upload"/>
                                



                            
                        </div><!--modal-body-->
                    </div>
                <!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

         
                    
						
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
					      <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
								<thead>
									<tr>
										<th width="5%">No.</th>
										<th width="25%">Staff Info</th>
                                        <th width="10%">Date_Mohon</th>   
                                        <th width="25%">Description</th>
                                        <th width="11%">Time_InOut</th>
										<th width="11%">Verified</th>
										<th width="11%">Approve</th>
									</tr>
								</thead>
								<tbody>
								
								<?
									$i= 1;
									$data_staff = getListInOutprint($department_code,$month);
									while($row_data_staff = $data_staff->fetch_assoc()) {
									
									
								?>
							
									<tr class="odd gradeX">
									<td><?php echo $i; ?></td>
									
									    <td>
										    Staff Name : <?php echo $row_data_staff['name']; ?><br>
										    No IC      : <?php echo $row_data_staff['noic']; ?><br>
										    Department : <?php echo $row_data_staff['department_sub']; ?>
										   
										</td>
										
										<td>
										    <?php echo $row_data_staff['date_mohon']; ?><br>
										   
										</td>
								        <td>
								            <?php echo $row_data_staff['description']; ?><br>
								            
								        </td>
										
										 <td>
								            Time In : <?php echo $row_data_staff['time_in']; ?><br>
											Time Out : <?php echo $row_data_staff['time_out']; ?>
								        </td>
										
										 <td>
								            <?if($row_data_staff['verified'] == 'PENDING' ) {
                                                        echo 'PENDING';}
                                                    else if($row_data_staff['verified'] == 'APPROVE') {
                                                        echo 'APPROVE';}
                                                    else if($row_data_staff['verified'] == 'DISAPPROVE') {
                                                        echo 'DISAPPROVE';}
													
								           ?><br><br>
											<? echo $row_data_staff['verified_name'];?>
								            
								        </td>
										
										 <td>
								            <?if($row_data_staff['approve'] == 'PENDING' ) {
                                                        echo 'PENDING';}
                                                    else if($row_data_staff['approve'] == 'APPROVE') {
                                                        echo 'APPROVE';}
                                                    else if($row_data_staff['approve'] == 'DISAPPROVE') {
                                                        echo 'DISAPPROVE';}
													
								           ?><br><br>
											<? echo $row_data_staff['approve_name'];?>
								            
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
		window.location.href="print_inout.php?department_id="+type;
		
	}
	
	function reloadMonth(selected_month,selected_cawangan)
	 {
		window.location.href="print_inout.php?department_id="+selected_cawangan+"&month="+selected_month;
		
	}
    </script>

</body>

</html>