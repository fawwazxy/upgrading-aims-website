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
        
            
            <form method="post" action="../controller/aims_otpremark_exec.php"
            enctype="multipart/form-data">  
			<input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $otpinfo['id'] ?>" />
	
                                <div class="form-group" align="left">
                                 <label>Remark<font color="red">**</font>&nbsp;</label><br>
                                 <textarea class="form-control" id="otp_remark" name="otp_remark" type="text" value="" rows="5" value="" onkeyup="convertToUppercase(this)"> </textarea>
                                 </div>
								
								<hr>
                       <div align="center">
                          <button type="update" class="btn btn-primary">Add</button>
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