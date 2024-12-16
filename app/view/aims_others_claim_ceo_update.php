<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_others_claim_function.php";
	
	$id = $_POST['id'];
	$claim_id = $_POST['claim_id'];
	$staffinfo = getStaffOcById($claim_id)->fetch_assoc();
	
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

            

        
						  
            <form method="post" action="../controller/aims_others_claim_ceo_exec.php"
            enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id ?>" />
			   <input type="hidden" class="form-control" id="claim_id" name="claim_id" value="<? echo $claim_id ?>" />
			   <input type="hidden" class="form-control" id="month" name="month" value="<? echo $month?>" />
			   <input type="hidden" class="form-control" id="company" name="company" value="<? echo $company?>" />
			    <div class="form-group"  align="left">
								<label>STATUS:</label></br>
								<? if($staffinfo['approve_status']=="PENDING") { ?>
								<input type="radio" name="approve_status" <?php if($staffinfo['approve_status']=="PENDING") {echo "checked";}?> value="PENDING">PENDING&nbsp;&nbsp;
								<input type="radio" name="approve_status" <?php if($staffinfo['approve_status']=="APPROVED") {echo "checked";}?> value="APPROVED">APPROVED&nbsp;&nbsp;
								<input type="radio" name="approve_status" <?php if($staffinfo['approve_status']=="DISAPPROVED") {echo "checked";}?> value="DISAPPROVED">DISAPPROVED
								<?} else {?>
									<input type="radio" name="approve_status" <?php if($staffinfo['approve_status']=="APPROVED") {echo "checked";}?> value="APPROVED">APPROVED&nbsp;&nbsp;
									<input type="radio" name="approve_status" <?php if($staffinfo['approve_status']=="DISAPPROVED") {echo "checked";}?> value="DISAPPROVED">DISAPPROVED
								<?}?>						
						</div>
                         
				<div class="form-group row" align="left" >
                                 <label class ="control-label col-sm-2" for ="hod_review_date"> NAME:</label>
								 <div class="col-sm-6">
                                 <input type="text" required="" class="form-control" placeholder="" id="approve_by" name="approve_by" style="text-transform:uppercase" value="<?php echo $_SESSION['SESS_NAME']?>" readonly/>
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