<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_lv_medicalapp_function.php";
	
	$id = $_POST['id'];
	$staffinfo = getStaffById($id)->fetch_assoc();
	
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

            

        
						  
            <form method="post" action="../controller/aims_lv_medical_appupdate_exec.php"
            enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $staffinfo['id'] ?>" />
			   
			   <div class="form-group"  align="left">
								<label>STATUS:</label></br>
								<input type="radio" name="app_status" <?php if($staffinfo['app_status']=="PENDING") {echo "checked";}?> value="PENDING">PENDING
								&emsp;<input type="radio" name="app_status" <?php if($staffinfo['app_status']=="APPROVED") {echo "checked";}?> value="APPROVED">APPROVE
								&emsp;<input type="radio" name="app_status" <?php if($staffinfo['app_status']=="DISAPPROVED") {echo "checked";}?> value="DISAPPROVED">DISAPPROVE								
						</div>
                         
				<div class="form-group row" align="left" >
                                 <label class ="control-label col-sm-2" for ="app_date"> NAME:</label>
								 <div class="col-sm-6">
                                 <input type="text" required="" class="form-control" placeholder="" id="app_name" name="app_name" style="text-transform:uppercase" value="<?php echo $_SESSION['SESS_NAME']?>" />
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