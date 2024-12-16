<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_ot_function.php";
	
	$id = $_POST['id'];
	$month=$_POST['month'];
	$total=$_POST['total'];
	$tahun=$_POST['tahun'];
	$r1_5 = $_POST['r1_5'];
	$s1_5 = $_POST['s1_5'];
	$t1_5 = $_POST['t1_5'];
	$r2 = $_POST['r2'];
	$s2 = $_POST['s2'];
	$t2 = $_POST['t2'];
	$r3 = $_POST['r3'];
	$s3 = $_POST['s3'];
	$t3 = $_POST['t3'];
	$r4 = $_POST['r4'];
	$s4 = $_POST['s4'];
	$t4 = $_POST['t4'];
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

            

        
						  
            <form method="post" action="../controller/aims_ot_hr_exec.php" enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id; ?>" />
			   <input type="hidden" class="form-control" id="month_claim" name="month_claim" value="<? echo $month; ?>" />
			   <input type="hidden" class="form-control" id="r1_5" name="r1_5" value="<? echo $r1_5 ?>" />
			   <input type="hidden" class="form-control" id="s1_5" name="s1_5" value="<? echo $s1_5 ?>" />
			   <input type="hidden" class="form-control" id="t1_5" name="t1_5" value="<? echo $t1_5 ?>" />
			   <input type="hidden" class="form-control" id="r2" name="r2" value="<? echo $r2 ?>" />
			   <input type="hidden" class="form-control" id="s2" name="s2" value="<? echo $s2 ?>" />
			   <input type="hidden" class="form-control" id="t2" name="t2" value="<? echo $t2 ?>" />
			   <input type="hidden" class="form-control" id="r3" name="r3" value="<? echo $r3 ?>" />
			   <input type="hidden" class="form-control" id="s3" name="s3" value="<? echo $s3 ?>" />
			   <input type="hidden" class="form-control" id="t3" name="t3" value="<? echo $t3 ?>" />
			   <input type="hidden" class="form-control" id="r4" name="r4" value="<? echo $r4 ?>" />
			   <input type="hidden" class="form-control" id="s4" name="s4" value="<? echo $s4 ?>" />
			   <input type="hidden" class="form-control" id="t4" name="t4" value="<? echo $t4 ?>" />
			   
			   <input type="hidden" class="form-control" id="total_monthclaim" name="total_monthclaim" value="<? echo $total; ?>" />
			   <input type="hidden" class="form-control" id="tahun" name="tahun" value="<? echo $tahun; ?>" />
			   <input type="hidden" class="form-control" id="company_id" name="company_id" value="<? echo $staffinfo['company_id']; ?>" />
			   
			   <div class="form-group row" align="left" >
					<div class="col-sm-8">
                                 <label class="control-label"> TOTAL CLAIM: RM <? echo $total; ?></label>
                    </div>
				</div>
			   
			   
			   <div class="form-group"  align="left">
								<label>STATUS:</label></br>
								<? if($staffinfo['review_status']=="PENDING") { ?>
								<input type="radio" name="review_status" <?php if($staffinfo['review_status']=="PENDING") {echo "checked";}?> value="PENDING">PENDING&nbsp;&nbsp;
								<input type="radio" name="review_status" <?php if($staffinfo['review_status']=="REVIEWED") {echo "checked";}?> value="REVIEWED">REVIEW&nbsp;&nbsp;
								<input type="radio" name="review_status" <?php if($staffinfo['review_status']=="REJECTED") {echo "checked";}?> value="REJECTED">REJECT
								<?} else {?>
									<input type="radio" name="review_status" <?php if($staffinfo['review_status']=="REVIEWED") {echo "checked";}?> value="REVIEWED">REVIEW&nbsp;&nbsp;
									<input type="radio" name="review_status" <?php if($staffinfo['review_status']=="REJECTED") {echo "checked";}?> value="REJECTED">REJECT
								<?}?>						
				</div>
                         
				<div class="form-group row" align="left" >
					<div class="col-sm-8">
                                 <label class="control-label"> REVIEW BY :</label>
                                 <input type="text" required="" class="form-control" placeholder="" id="review_by" name="review_by" style="text-transform:uppercase" value="<?php echo $_SESSION['SESS_NAME']?>" readonly/>
                    </div>
				</div>
                
				<div class="modal-footer">
                    <div align="center">
						<button type="submit" class="btn btn-primary">SAVE</button>
                    </div>    
                </div>
         </form>
                       

    <!-- /#wrapper -->
  

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	
	
	
    </script>

</body>

</html>