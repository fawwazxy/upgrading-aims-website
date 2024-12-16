<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_others_claim_function.php";
	
	$id = $_POST['id'];
	$month=$_POST['month'];
	$total=$_POST['total'];
	$tahun=$_POST['tahun'];
	$staffinfo = getStaffOcById2($id,$tahun)->fetch_assoc();
	
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

            

        
						  
            <form method="post" action="../controller/aims_others_claim_hr_exec.php" enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id; ?>" />
			   <input type="hidden" class="form-control" id="month_claim" name="month_claim" value="<? echo $month; ?>" />
			   <input type="hidden" class="form-control" id="total_expenses" name="total_expenses" value="<? echo $total; ?>" />
			   <input type="hidden" class="form-control" id="tahun" name="tahun" value="<? echo $tahun; ?>" />
			   
			   
			   <div class="form-group"  align="left">
								<label>STATUS:</label></br>
								<input type="radio" name="hr_review_status" <?php if($staffinfo['hr_review_status']=="PENDING") {echo"checked";}?> value="PENDING">PENDING &nbsp;&nbsp;
								<input type="radio" name="hr_review_status" <?php if($staffinfo['hr_review_status']=="REVIEW") {echo"checked";}?> value="REVIEW">REVIEW &nbsp;&nbsp;
								<input type="radio" name="hr_review_status" <?php if($staffinfo['hr_review_status']=="DISAPPROVE") {echo"checked";}?> value="DISAPPROVE">DISAPPROVE
														
				</div>
                         
				<div class="form-group row" align="left" >
                                 <label class ="control-label col-sm-2" for ="hr_review_date"> REVIEW BY:</label>
								 <div class="col-sm-6">
                                 <input type="text" required="" class="form-control" placeholder="" id="hr_review_by" name="hr_review_by" style="text-transform:uppercase" value="<?php echo $_SESSION['SESS_NAME']?>" readonly/>
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