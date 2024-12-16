<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_ssrverified_function.php";
	
	$id = $_POST['id'];
	$staff_info = getStaffById($id)->fetch_assoc();
	
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

<style>
 table.one {
			border-collapse:collapse;
            width:100%;
			height:20%;
 }
</style>

<body>



        <!-- Navigation -->
     

            <!-- /.navbar-header -->
          

            <!-- /.navbar-top-links -->

            

        
						  
            <form method="post" action="../controller/aims_ssrverified_update_exec.php"
            enctype="multipart/form-data"> 
			
			<input type="hidden" class="form-control" id="id" name="id" value="<? echo $staff_info['id'] ?>" />
			   
			
                         
							<div class="form-group row" align="left">
					<div class="col-xs-4">
						<label>SSR No<font color="red">**</font>&nbsp;</label><br>
                        <input type="text" required="" class="form-control" placeholder="" id="ssr_no" name="ssr_no" value="<? echo $staff_info['ssr_no'] ?>" readonly />
					</div>

					<div class="col-xs-4">
						<label>SSR Date<font color="red">**</font>&nbsp;</label><br>
                        <input type="date" required="" class="form-control" placeholder="" id="ssr_date" name="ssr_date" value="<? echo $staff_info['ssr_date'] ?>" readonly />
					</div>
					
					<div class="col-xs-4">
						<label>Vessel<font color="red">**</font>&nbsp;</label><br>
                        <input type="text" required="" class="form-control" placeholder="" id="vessel" name="vessel" value="<? echo $staff_info['vessel'] ?>" readonly />
					</div>
						
				</div>
			   
			   
				 <div class="form-group row" align="left">
					<div class="col-xs-4">
						 <label>Department</label><br>
 
								  <input type="radio" id="department" name="department" <?php if ($staff_info['department']  == 'DECK') echo 'checked="checked"'; ?> value="DECK" disabled readonly/>
								  <label for="department"> Deck</label><br>
								  
								  <input type="radio" id="Department" name="department" <?php if ($staff_info['department']  == 'ENGINE') echo 'checked="checked"'; ?> value="ENGINE" disabled readonly/>
								  <label for="Department"> Engine</label><br>
								  
					</div>

					<div class="col-xs-4">
						<label>Location<font color="red">**</font>&nbsp;</label><br>
                        <input type="text" required="" class="form-control" placeholder="" id="location" name="location" value="<? echo $staff_info['location'] ?>" readonly/>
					</div>
					
					<div class="col-xs-4">
						<label>Item</label><br>
								 
                                 <input type="radio"  id="item" name="item" <?php if ($staff_info['item']  == 'DECKSTORES') echo 'checked="checked"'; ?> value="DECKSTORES" disabled readonly />
								  <label for="item"> Deck Stores</label><br>
								  
								  <input type="radio"  id="item" name="item" <?php if ($staff_info['item']  == 'ENGINESTORE') echo 'checked="checked"'; ?> value="ENGINESTORE" disabled readonly />
								  <label for="item"> Engine Store</label><br>
								  
								  <input type="radio" id="item" name="item" <?php if ($staff_info['item']  == 'SPAREPART') echo 'checked="checked"'; ?> value="SPAREPART" disabled readonly />
								  <label for="item"> Spare Part</label><br>
					</div>
						
				</div>		
 
					<table class="one" border="1">
				<tr><br><br>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Quantity Approved</th>
				<th style="text-align:center;">unit</th>
				<th style="text-align:center;">Quantity Required</th>
				<th style="text-align:center;">Balance</th>
				<th style="text-align:center;">Total</th>
				<th style="text-align:center;">Remarks</th>
				</tr>
				<?
                                    $staff = getStaffById($id);
                                    $i=1;
                                    while($staffinfo = $staff->fetch_assoc()) {
									
                                ?>
				<tr>
				<td align="center" ><?echo $i++;?></td>
				<td style="padding:30px;" align="center" type="text" size="20" name="description" ><? echo $staffinfo['description']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="quantity_approved"><? echo $staffinfo['quantity_approved']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="unit"><? echo $staff_info['unit'] ;?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="quantity_required"><? echo $staffinfo['quantity_required']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="balance"><? echo $staffinfo['balance']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="sparepart_no"><? echo $staffinfo['sparepart_no']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="remarks"><? echo $staffinfo['remarks']; ?></td>
				</tr>
					<?}?>		
				</table>
				
				<br><br>
				<div class="form-group row" align="left">
					<div class="col-xs-6">
						<label>Verified Name</label><br>
                        <input type="text" class="form-control" placeholder="" id="verified_name" name="verified_name" value="<? echo $_SESSION['SESS_NAME'] ?>" readonly/>
					</div>
					
					<div class="col-xs-6">
						<label>Verified Designation</label><br>
                        <input type="text" class="form-control" placeholder="" id="verified_designation" name="verified_designation" value="<? echo $staff_info['verified_designation'] ?>" />
					</div>					
				</div>
					  
					
								<div class="form-group"  align="left">
								<label>Status:</label></br>
								<input type="radio" name="verified_status" <?php if($staff_info['verified_status']=="0") {echo "checked";}?> value="0"> PENDING
								<input type="radio" name="verified_status" <?php if($staff_info['verified_status']=="1") {echo "checked";}?> value="1"> VERIFIED
								
								</div>

                     
					  
                            <br> 
                             <div class="modal-footer">
                                    <div align="left">
                          <button type="submit" class="btn btn-primary">VERIFIED</button>
							</div>    
                            </div>
         </form>
                       

    <!-- /#wrapper -->
  

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    </script>

</body>

</html>