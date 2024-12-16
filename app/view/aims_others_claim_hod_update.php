<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_others_claim_hod_function.php";
	
	$id = $_POST['id'];
	$claim_id = $_POST['claim_id'];
	$tahun = $_POST['tahun'];
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

            

        
						  
            <form method="post" action="../controller/aims_others_claim_hod_update_exec.php"
            enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id ?>" />
			   <input type="hidden" class="form-control" id="claim_id" name="claim_id" value="<? echo $claim_id ?>" />
			   <input type="hidden" class="form-control" id="month" name="month" value="<? echo $month?>" />
			   <input type="hidden" class="form-control" id="tahun" name="tahun" value="<? echo $tahun?>" />
			   
			   <div class="form-group"  align="left">
								<label>STATUS:</label></br>
								<? if($staffinfo['hod_review_status']=="PENDING") { ?>
								<input type="radio" name="hod_review_status" <?php if($staffinfo['hod_review_status']=="PENDING") {echo "checked";}?> value="PENDING">PENDING&nbsp;&nbsp;
								<input type="radio" name="hod_review_status" <?php if($staffinfo['hod_review_status']=="VERIFIED") {echo "checked";}?> value="VERIFIED">VERIFIED&nbsp;&nbsp;
								<input type="radio" name="hod_review_status" <?php if($staffinfo['hod_review_status']=="DISVERIFIED") {echo "checked";}?> value="DISVERIFIED">DISVERIFIED
								<?} else {?>
									<input type="radio" name="hod_review_status" <?php if($staffinfo['hod_review_status']=="VERIFIED") {echo "checked";}?> value="VERIFIED">VERIFIED&nbsp;&nbsp;
									<input type="radio" name="hod_review_status" <?php if($staffinfo['hod_review_status']=="DISVERIFIED") {echo "checked";}?> value="DISVERIFIED">DISVERIFIED
								<?}?>						
						</div>
                         
				<div class="form-group row" align="left" >
                                 <label class ="control-label col-sm-2" for ="hod_review_date"> VERIFIED BY :</label><br><br>
								 <div class="col-sm-6">
                                 <input type="text" required="" class="form-control" placeholder="" id="hod_review_by" name="hod_review_by" style="text-transform:uppercase" value="<?php echo $_SESSION['SESS_NAME']?>" readonly/>
                                </div>
								</div>
                             <div class="modal-footer">
                             <div align="center">
							<br><br> <br>  <button type="submit" class="btn btn-primary">SAVE</button>
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