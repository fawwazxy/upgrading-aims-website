<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";	
	require "../model/aims_ssa_function.php";

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

    <div id="wrapper">

        <!-- Navigation -->
        
            
            <form method="post" action="../controller/aims_ssa_update_exec.php"
            enctype="multipart/form-data">  
			<input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $staffinfo['id'] ?>" />
			
			      
                         <div class="form-group" align="left">
                            <label><font color="red">** Required</font></label>
                            <br>
							<br>
							
		
							<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>SSA. No<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="ssa_no" class="form-control" placeholder="" id="ssa_no" name="ssa_no" value="<? echo $staffinfo['ssa_no'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div></div>
								
                                <div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Date</label><br>
                                 <input type="date" class="form-control" placeholder="" id="date" name="date" value="<? echo $staffinfo['date'] ?>" />
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Vessel<font color="red">**</font>&nbsp;</label><br>
								 <input type="text" class="form-control"  id="vessel" name="vessel" value="<? echo $staffinfo['vessel'] ?>" readonly />
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Location</label><br>
                                 <input type="text" class="form-control" placeholder="" id="location" name="location" value="<? echo $staffinfo['location'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Department</label><br>
                                 <input type="radio" id="department" name="department" <?php if($staffinfo['department']=="DECK") {echo"checked";}?> value="DECK">
								 <label for="department"> DECK</label><br>
								 <input type="radio" id="department" name="department" <?php if($staffinfo['department']=="ENGINE") {echo"checked";}?> value="ENGINE">
								 <label for="department"> ENGINE</label><br>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>SSA Raised</label><br>
                                 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="LSA/ FFA ANNUAL SERVICING") {echo"checked";}?> value="LSA/ FFA ANNUAL SERVICING">
								 <label for="ssa_raised"> LSA/ FFA ANNUAL SERVICING</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="FLAG STATE INSPECTION") {echo"checked";}?> value="FLAG STATE INSPECTION">
								 <label for="ssa_raised"> FLAG STATE INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="EXT/ INT AUDIT") {echo"checked";}?> value="EXT/ INT AUDIT">
								 <label for="ssa_raised"> EXT/ INT AUDIT</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="VOYAGE REPAIR") {echo"checked";}?> value=" VOYAGE REPAIR">
								 <label for="ssa_raised"> VOYAGE REPAIR</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="CLASS SURVEY") {echo"checked";}?> value="CLASS SURVEY">
								 <label for="ssa_raised"> CLASS SURVEY</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="SAFETY INSPECTION") {echo"checked";}?> value="SAFETY INSPECTION">
								 <label for="ssa_raised"> SAFETY INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="VESSEL INSPECTION") {echo"checked";}?> value="VESSEL INSPECTION">
								 <label for="ssa_raised"> VESSEL INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" <?php if($staffinfo['ssa_raised']=="OTHERS") {echo"checked";}?> value="OTHERS">
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
                                 <input type="text" class="form-control" placeholder="" id="aa" name="aa" value="<? echo $staffinfo['aa'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>BB: Maker/ Model No./ Serial No. (As Required)</label><br>
                                 <input type="text" class="form-control" placeholder="" id="bb" name="bb" value="<? echo $staffinfo['bb'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>CC: Remedial Action Carried Out on Board For Repairs (As Required)</label><br>
                                 <input type="text" class="form-control" placeholder="" id="cc" name="cc" value="<? echo $staffinfo['cc'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>DD: Nature of Assistance Required</label><br>
                                 <input type="text" class="form-control" placeholder="" id="dd" name="dd" value="<? echo $staffinfo['dd'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>Remark</label><br>
                                 <input type="text" class="form-control" placeholder="" id="remark" name="remark" value="<? echo $staffinfo['remark'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-8">
								<label>EE: Miscellaneous Information as Appropriate (Photo/ Sketch/ Drawing & etc)
								<br><font color="red"><i>(Only pdf/jpeg/jpg/png/gif format file are allowed)</i></font></label>
								<br><?if($staffinfo['document_type'] == 'jpg' || $staffinfo['document_type'] == 'jpeg' || $staffinfo['document_type'] == 'png' || $staffinfo['document_type'] == 'gif') {
                                                echo '<img width="210" height="240" src="data:image/jpeg;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>'.$staffinfo['document_name'];}
                                         else if($staffinfo['document_type'] == 'pdf') {
                                                echo '<object width="210" height="240" data="data:application/pdf;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>'.$staffinfo['document_name'];}
                                            ?>
								<br><input type="hidden" name="MAX_FILE_SIZE" value="2000000">
								<br><input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
								</div>
								</div>
								
								<hr>
								<br>
                                    <div align="center">
                          <button type="update" class="btn btn-primary">UPDATE</button>
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