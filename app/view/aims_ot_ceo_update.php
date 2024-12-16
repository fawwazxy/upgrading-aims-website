<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_ot_function.php";
	
	$id = $_POST['id'];
	$month = $_POST['month'];
	$staffinfo = getStaffOcById($id,$month)->fetch_assoc();
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

            

        
						  
            <form method="post" action="../controller/aims_ot_ceo_update_exec.php" enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id ?>" />
			   <input type="hidden" class="form-control" id="month" name="month" value="<? echo $month?>" />
			   
			   <div class="form-group"  align="left">
								<label>STATUS:</label></br>
								<? if($staffinfo['approved_status']=="PENDING") { ?>
								<input type="radio" name="approved_status" <?php if($staffinfo['approved_status']=="PENDING") {echo "checked";}?> value="PENDING">PENDING&nbsp;&nbsp;
								<input type="radio" name="approved_status" <?php if($staffinfo['approved_status']=="APPROVED") {echo "checked";}?> value="APPROVED">APPROVE&nbsp;&nbsp;
								<input type="radio" name="approved_status" <?php if($staffinfo['approved_status']=="DISAPPROVED") {echo "checked";}?> value="DISAPPROVED">DISAPPROVE
								<?} else {?>
									<input type="radio" name="approved_status" <?php if($staffinfo['approved_status']=="APPROVED") {echo "checked";}?> value="APPROVED">APPROVE&nbsp;&nbsp;
									<input type="radio" name="approved_status" <?php if($staffinfo['approved_status']=="DISAPPROVED") {echo "checked";}?> value="DISAPPROVED">DISAPPROVE
								<?}?>						
				</div>
                         
				<div class="form-group row" align="left" >
					<div class="col-sm-8">
                                 <label class="control-label"> APPROVED BY :</label>
                                 <input type="text" required="" class="form-control" placeholder="" id="approved_by" name="approved_by" style="text-transform:uppercase" value="<?php echo $_SESSION['SESS_NAME']?>" readonly/>
                    </div>
				</div>
                             <div class="modal-footer">
                             <div align="center">
								<button type="submit" class="btn btn-primary">SAVE</button>
                            </div>    
                            </div>
         </form>
                       
 </div>
    <!-- /#wrapper -->
  

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	
	
	
    </script>

</body>

</html>