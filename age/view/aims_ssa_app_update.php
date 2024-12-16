<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";	
	require "../model/aims_ssa_app_function.php";

	$id = $_POST['id'];
	$staffinfo = getSSAid($id)->fetch_assoc();
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
<style>
p{
   font-size: 120%;

}
td,th{
		text-align: center;
	}
</style>

    <div id="wrapper">

        <!-- Navigation -->
        
            
            <form method="post" action="../controller/aims_ssa_app_exec.php"
            enctype="multipart/form-data">  
			<input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $staffinfo['id'] ?>" />
				  
                         <div class="form-group" align="left">
                            <label><font color="red">** Required</font></label>
                            <br>
							<br>
							
		
							<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>SSA. No</label><br>
                                 <input type="text" class="form-control" placeholder="" id="ssa_no" name="ssa_no" value="<? echo $staffinfo['ssa_no'] ?>" readonly/>
                                </div></div> 
								
                                <div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Date</label><br>
                                 <input type="date" class="form-control" placeholder="" id="date" name="date" value="<? echo $staffinfo['date'] ?>" readonly/>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                  <label>Vessel</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="vessel" name="vessel" value="<? echo $staffinfo['vessel'] ?>" readonly/>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Location</label><br>
                                 <input type="text" class="form-control" placeholder="" id="location" name="location" value="<? echo $staffinfo['location'] ?>" readonly/>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Department</label><br>
                                 <input type="radio" onclick="return false" id="department" name="department" <?php if($staffinfo['department']=="DECK") {echo"checked";}?> value="DECK" disabled readonly/>
								 <label for="department"> DECK</label><br>
								 <input type="radio" onclick="return false" id="department" name="department" <?php if($staffinfo['department']=="ENGINE") {echo"checked";}?> value="ENGINE" disabled readonly/>
								 <label for="department"> ENGINE</label><br>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>SSA Raised</label><br>
                                 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="LSA/ FFA ANNUAL SERVICING") {echo"checked";}?> value="LSA/ FFA ANNUAL SERVICING" disabled readonly/>
								 <label for="ssa_raised"> LSA/ FFA ANNUAL SERVICING</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="FLAG STATE INSPECTION") {echo"checked";}?> value="FLAG STATE INSPECTION" disabled readonly/>
								 <label for="ssa_raised"> FLAG STATE INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="EXT/ INT AUDIT") {echo"checked";}?> value="EXT/ INT AUDIT" disabled readonly/>
								 <label for="ssa_raised"> EXT/ INT AUDIT</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="VOYAGE REPAIR") {echo"checked";}?> value=" VOYAGE REPAIR" disabled readonly/>
								 <label for="ssa_raised"> VOYAGE REPAIR</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="CLASS SURVEY") {echo"checked";}?> value="CLASS SURVEY" disabled readonly/>
								 <label for="ssa_raised"> CLASS SURVEY</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="SAFETY INSPECTION") {echo"checked";}?> value="SAFETY INSPECTION"disabled readonly/>
								 <label for="ssa_raised"> SAFETY INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="VESSEL INSPECTION") {echo"checked";}?> value="VESSEL INSPECTION"disabled readonly/>
								 <label for="ssa_raised"> VESSEL INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="OTHERS") {echo"checked";}?> value="OTHERS" disabled readonly/>
								 <label for="ssa_raised"> OTHERS </label>
                                </div></div>
								
								
								<p>
								<div class="form-group" align="left">
                            <label><font color="blue">YY/NNN/VSL/SSA/X</font></label>
                            <br>
							<label><font color="blue">YY=Year, VSL=Vessel Abbreviation, NNN=Running No, SSA=Ship Shore Assistance, X=Department Deck (D) / Engine (E)</font></label>
							</br><br>
							
								<div class="form-group" align="left">
                                 <label>AA: Brief Description on the SSA Required</label><br>
                                 <input type="text" class="form-control" placeholder="" id="aa" name="aa" value="<? echo $staffinfo['aa'] ?>" readonly/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>BB: Maker/ Model No./ Serial No. (As Required)</label><br>
                                 <input type="text" class="form-control" placeholder="" id="bb" name="bb" value="<? echo $staffinfo['bb'] ?>" readonly/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>CC: Remedial Action Carried Out on Board For Repairs (As Required)</label><br>
                                 <input type="text" class="form-control" placeholder="" id="cc" name="cc" value="<? echo $staffinfo['cc'] ?>" readonly/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>DD: Nature of Assistance Required</label><br>
                                 <input type="text" class="form-control" placeholder="" id="dd" name="dd" value="<? echo $staffinfo['dd'] ?>" readonly/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>EE: Miscellaneous Information as Appropriate (Photo/ Sketch/ Drawing & etc)</label><br>
                                <?if($staffinfo['document_type'] == 'jpg' || $staffinfo['document_type'] == 'jpeg' || $staffinfo['document_type'] == 'png' || $staffinfo['document_type'] == 'gif') {
                                                echo '<img width="210" height="240" src="data:image/jpeg;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>'.$staffinfo['document_name'];}
                                         else if($staffinfo['document_type'] == 'pdf') {
                                                echo '<object width="210" height="240" data="data:application/pdf;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>'.$staffinfo['document_name'];}
                                            ?>
								<div>
								
								<hr>
								<div class="form-group"  align="left">
								<label>Status<font color="red">**</font>&nbsp;</label></br>
								<input type="radio" required="app_status" name="app_status" <?php if($staffinfo['app_status']=="0") {echo "checked";}?> value="0"> PENDING
								&nbsp &nbsp <input type="radio" name="app_status" <?php if($staffinfo['app_status']=="1") {echo "checked";}?> value="1"> APPROVE		
								</div>
								
                                <br><div class="form-group" align="left">
								 <label>Verifier Name</label><br>
                                 <input type="text" class="form-control" placeholder="" id="ver_name" name="ver_name" value="<? echo $staffinfo['ver_name'] ?>" readonly/>
                                </div>
								
                                <div class="form-group" align="left">
                                 <label>Verifier Designation</label><br>
                                 <input type="text" class="form-control" placeholder="" id="ver_design" name="ver_design" value="<? echo $staffinfo['ver_design'] ?>" readonly/>
                                </div>
								
                                <div class="form-group" align="left">
                                 <label>Approver Name<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="app_name" class="form-control" placeholder="" id="app_name" name="app_name" value="<? echo $_SESSION['SESS_NAME'] ?>" onkeyup="convertToUppercase(this)" readonly />
                                </div>
								
                                <div class="form-group" align="left">
                                 <label>Approver Designation<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="app_design" class="form-control" placeholder="" id="app_design" name="app_design" value="<? echo $staffinfo['app_design'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div></div>
                                
                             <br>
                                    <div align="center">
                          <button type="update" class="btn btn-primary">SUBMIT</button>
                       </div>    
                            </div>
         </form>
                       
<script>
	function convertToUppercase(el) {
					if(!el || !el.value) return;
					el.value = el.value.toUpperCase();
				}
    </script>
	
</body>

</html>