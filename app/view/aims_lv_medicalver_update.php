<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_lv_medicalver_function.php";
	
	$id = $_POST['id'];
	$staffid = getStaffById($id)->fetch_assoc();
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
     

            <!-- /.navbar-header -->
          

            <!-- /.navbar-top-links -->

            

        
						  
            <form method="post" action="../controller/aims_lv_medicalver_update_exec.php"> 

			
			   <input type="hidden" class="form-control" id="medical_id" name="medical_id" value="<? echo $id ?>">
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $staffid['id']; ?>">
			   <input type="hidden" class="form-control" id="staff_record_id" name="staff_record_id" value="<? echo $staffid['staff_record_id']; ?>">
			   <input type="hidden" class="form-control" id="total_claim" name="total_claim" value="<? echo $staffid['total_claim']; ?>">

			   
			   <div class="form-group"  align="left">
								<label>STATUS: <?php echo $staffid['ver_status']; ?> </label></br>
								<input type="radio" id="ver_status" name="ver_status" <?php if($staffid['ver_status']=="PENDING") {echo "checked";}?> value="PENDING"> PENDING
								<input type="radio" id="ver_status" name="ver_status" <?php if($staffid['ver_status']=="VERIFIED") {echo "checked";}?> value="VERIFIED"> VERIFY
								<input type="radio" id="ver_status" name="ver_status" <?php if($staffid['ver_status']=="DISAPPROVED") {echo "checked";}?> value="DISAPPROVED"> DISAPPROVE
				</div>
                         
				<div class="form-group row" align="left" >
                                 <label class ="control-label col-sm-2" for ="ver_date"> NAME:</label>
								 <div class="col-sm-6">
                                 <input type="text" required="" class="form-control" placeholder="" id="ver_name" name="ver_name" style="text-transform:uppercase" value="<?php echo $_SESSION['SESS_NAME']?>" />
                                </div>
								</div>

                            <br> 
							
                             <div class="modal-footer">
                             <div align="center">
							<br><br> <br>  <button type="submit" class="btn btn-primary">SAVE</button>
                            </div>    
                            </div><br>
         </form>
                       

    <!-- /#wrapper -->
  

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	
	
	
    </script>

</body>

</html>