<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_others_claim_function.php";
	
	$id = $_POST['id'];
	$stf_id = $_POST['stf_id'];
	$month = $_POST['month'];
	$status = $_POST['status'];
	$tahun = $_POST['tahun'];
	$staffinfo = getLampiranInfo($id)->fetch_assoc();
	
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

            

        
						  
            <form method="post" action="../controller/aims_otherclaim_foto_exec.php" enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id; ?>" />
			   <input type="hidden" class="form-control" id="staff_record_id" name="staff_record_id" value="<? echo $stf_id; ?>" />
			   <input type="hidden" class="form-control" id="month_claim" name="month_claim" value="<? echo $month; ?>" />
			   <input type="hidden" class="form-control" id="total_monthclaim" name="total_monthclaim" value="<? echo $status; ?>" />
			   <input type="hidden" class="form-control" id="tahun" name="tahun" value="<? echo $tahun; ?>" />
			   <div class="form-group"  align="left">
							<label>Attachment&nbsp;<font color="red"><i>(Only pdf/jpeg/jpg/png/gif format file are allowed)</i></font></label>
                            <input type="hidden" name="MAX_FILE_SIZE">
                            <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
														
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