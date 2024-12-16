<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";	
	require "../model/aims_ot_function.php";

	$id = $_POST['id'];
	$otpinfo = getOtPermissionById($id)->fetch_assoc();
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
        
            
            <form method="post" action="../controller/aims_otpupdate_exec.php"
            enctype="multipart/form-data">  
			<input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $otpinfo['id'] ?>" />
			
			      
                         
                            <label><font color="red">** Required</font></label>
                            <br>
                                <div class="form-group" align="left">
                                 <label>To<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required class="form-control" placeholder="" id="hod_name" name="hod_name" value="<? echo $otpinfo['hod_name'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>
								
                                
                                <div class="form-group" align="left">
                                 <label>Date<font color="red">**</font>&nbsp;</label><br>
                                 <input type="date" class="form-control" placeholder="" id="otp_date" name="otp_date" value="<? echo $otpinfo['otp_date'] ?>" />
                                </div>
								
								
                                <div class="form-group" align="left">
                                 <label>Description<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" class="form-control" placeholder="" id="otp_description" name="otp_description" value="<? echo $otpinfo['otp_description'] ?>" onkeyup="convertToUppercase(this)"/>
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
    </script>
</body>

</html>