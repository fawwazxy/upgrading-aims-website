<?php

include ('../controller/auth.php');


require "../model/aims_ssa_function.php";
require "../model/lookup.php";
$staffinfo=$_POST['id'];
?>
 
<form method="post" action="../controller/aims_ssa_exec.php"
            enctype="multipart/form-data">  
			      
                         <div class="form-group" align="left">
                            <label><font color="red">** Required</font></label>
                            <br>
							<br>
							<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>SSA. No<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="ssa_no" class="form-control" placeholder="" id="ssa_no" name="ssa_no" value="" onkeyup="convertToUppercase(this)"/>
                                </div></div>
								
                                <div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Date</label><br>
                                 <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="date" name="date" value="" />
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Vessel<font color="red">**</font>&nbsp;</label><br>
                                 <select class="form-control" id="vessel" name="vessel" required="vessel">
								 <option value="0">-- Choose --</option>
								 <option value="AA1">AA1</option>
								 <option value="AA2">AA2</option>
								 <option value="AA3">AA3</option>
								 <option value="AA4">AA4</option>
								 <option value="AA5">AA5</option>
								 </select>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Location</label><br>
                                 <input type="text" class="form-control" placeholder="" id="location" name="location" value="" onkeyup="convertToUppercase(this)"/>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>Department</label><br>
                                 <input type="radio" id="department" name="department" value="DECK">
								 <label for="department"> DECK</label><br>
								 <input type="radio" id="department" name="department" value="ENGINE">
								 <label for="department"> ENGINE</label><br>
                                </div></div>
								
								<div class="col-sm-6">
                                <div class="form-group" align="left">
                                 <label>SSA Raised</label><br>
                                 <input type="radio" id="ssa_raised" name="ssa_raised" value="LSA/ FFA ANNUAL SERVICING">
								 <label for="ssa_raised"> LSA/ FFA ANNUAL SERVICING</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" value="FLAG STATE INSPECTION">
								 <label for="ssa_raised"> FLAG STATE INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" value="EXT/ INT AUDIT">
								 <label for="ssa_raised"> EXT/ INT AUDIT</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" value=" VOYAGE REPAIR">
								 <label for="ssa_raised"> VOYAGE REPAIR</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" value="CLASS SURVEY">
								 <label for="ssa_raised"> CLASS SURVEY</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" value="SAFETY INSPECTION">
								 <label for="ssa_raised"> SAFETY INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" value="VESSEL INSPECTION">
								 <label for="ssa_raised"> VESSEL INSPECTION</label><br>
								 <input type="radio" id="ssa_raised" name="ssa_raised" value="OTHERS">
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
                                 <input type="text" class="form-control" placeholder="" id="aa" name="aa" value="" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>BB: Maker/ Model No./ Serial No. (As Required)</label><br>
                                 <input type="text" class="form-control" placeholder="" id="bb" name="bb" value="" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>CC: Remedial Action Carried Out on Board For Repairs (As Required)</label><br>
                                 <input type="text" class="form-control" placeholder="" id="cc" name="cc" value="" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>DD: Nature of Assistance Required</label><br>
                                 <input type="text" class="form-control" placeholder="" id="dd" name="dd" value="" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group" align="left">
                                 <label>Remark</label><br>
                                 <input type="text" class="form-control" placeholder="" id="remark" name="remark" value="" onkeyup="convertToUppercase(this)"/>
                                </div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-8">
								<label>EE: Miscellaneous Information as Appropriate (Photo/ Sketch/ Drawing & etc)
								<br><font color="red"><i>(Only pdf/jpeg/jpg/png/gif format file are allowed)</i></font></label>
								<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
								<input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
								</div>
								</div>
								</div>
								
								<hr>
								<div align="center">
								<button type="reset" class="btn btn-primary">RESET</button>
								<button type="submit" class="btn btn-success">SUBMIT</button>
						</div>
						
			</form>
<script>
	function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>