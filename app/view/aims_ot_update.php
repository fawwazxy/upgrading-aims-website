<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";	
	require "../model/aims_ot_function.php";

	$id = $_POST['id'];
	$otinfo = getOtById($id)->fetch_assoc();
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
        
            
            <form method="post" action="../controller/aims_otupdate_exec.php" enctype="multipart/form-data">  
			<input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $otinfo['id'] ?>" />
			
			
			      
                         
                            <label><font color="red">** Required</font></label>
                            <br>
                                <div class="form-group" align="left">
								
									<label>Claim For The Month Ended: <font color="red">**</font></label><br>
									<select required class="form-control" name="month_claim" id="month_claim">
													<option value="">-- Choose Month--</option>
													<? echo getDropDownMonthHuruf($otinfo['month_claim']);?>
									</select> 
								
							</div>
							
							<div class="form-group" align="left">
								
								
									<label>Position: <font color="red">**</font>&nbsp;</label><br>
									<input type="text" required class="form-control" placeholder="" id="position" name="position" value="<? echo $otinfo['position'] ?>" onkeyup="convertToUppercase(this)"/>
								
                            </div>
		
                            <div class="form-group" align="left">
								
								
									<label>Date: <font color="red">**</font>&nbsp;</label><br>
									<input type="date" required="" class="form-control" placeholder="" id="date_ot" name="date_ot" onchange="showDate(this.value)" value="<? echo $otinfo['date_ot'] ?>" />
								
							</div>
							
							<div class="form-group" align="left">
								
                                  <label>Day:<font color="red">**</font>&nbsp;</label><br>
                                  <input type="text" required class="form-control" placeholder="" id="day_ot" name="day_ot" value="<? echo $otinfo['day_ot'] ?>" />
								
                            </div>
							
							<div class="form-group" align="left">
								
								
									<label>Start: <font color="red">**</font>&nbsp;</label><br>
									<input type="time" required="" class="form-control" placeholder="" id="start_ot" name="start_ot" value="<? echo $otinfo['start_ot'] ?>" />
								
							</div>
							<div class="form-group" align="left">
								
                                  <label>End:<font color="red">**</font>&nbsp;</label><br>
                                  <input type="time" required class="form-control" placeholder="" id="end_ot" name="end_ot" value="<? echo $otinfo['end_ot'] ?>" />
								
                            </div>
								
								
							<div class="form-group" align="left">
								
                                  <label>Working Period: <font color="red">**</font>&nbsp;</label><br>
								  <input type="text" required class="form-control" placeholder="0H 00M" id="working_hours" name="working_hours" value="<? echo $otinfo['working_hours'] ?>" onkeyup="convertToUppercase(this)">
                                
							</div>
							
							<div class="form-group" align="left">
								
                                  <label>Types of Claim: <font color="red">**</font>&nbsp;</label><br>
								  <input type="text" required class="form-control" placeholder="" id="type_claim" name="type_claim" value="<? echo $otinfo['type_claim'] ?>" onkeyup="convertToUppercase(this)">
                                
							</div>

                            <div class="form-group" align="left">
								
                                  <label>Work Description: <font color="red">**</font>&nbsp;</label><br>
								  <input type="text" required class="form-control" placeholder="" id="description_ot" name="description_ot" value="<? echo $otinfo['description_ot'] ?>" onkeyup="convertToUppercase(this)">
                                
							</div>
								
								<hr>
                       <div align="center">
                          <button type="update" class="btn btn-primary">UPDATE</button>
                       </div>    
                            
         </form>
</div>
                       
<script>
	function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
	
	function showDate(getdate) {
    			var selectedDate = new Date(getdate);
    			var dateformat = getdate.split('-')
    			var displaydate = document.getElementById('day_ot')
    			var days = ["SUNDAY", "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY"];
    
    			
    				displaydate.value = days[selectedDate.getDay()];
    			
    		}
	
	
    </script>
</body>

</html>