<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_lv_medical_function.php";
	
	$id = $_POST['id'];
	$staffinfo = getStaffById($id)->fetch_assoc();
	
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

            

        
						  
            <form method="post" action="../controller/aims_lv_medical_update_exec.php"
            enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $staffinfo['id'] ?>" />
                         
						 
				
	                            
								
								 <div class="form-group row" align="left">
								<div class="col-xs-8">
								<label>Attachment&nbsp;<font color="red"><i>(Only pdf/jpeg/jpg/png/gif format file are allowed)</i></font></label>
								<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
								<input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
								</div>
								</div>
								
								
								<br><br>
								
							
								<div class="form-group row" align="center">
								<table border="1" cellspacing="3" cellpadding="5" >
								<tr>
								<th style="text-align:center;">DATE</th>
								<th style="text-align:center;">DESCRIPTION</th>
								<th style="text-align:center;">TOTAL</th></tr>
								
								<tr><td><input style="padding:30px;" type="date" size="20" name="mec_date"  value="<? echo $staffinfo['mec_date'] ?>"></td>
								<td><input style="padding:30px;" type="text" size="40" name="description" value="<? echo $staffinfo['description'] ?>"></td>
								<td><input style="padding:30px;" type="text" size="20" name="total" value="<? echo $staffinfo['total'] ?>"></td></tr>
								
								</table></div>
					  
                            <br> 
							
                             <div class="modal-footer">
                             <div align="center">
							<br><br> <br>  <button type="submit" class="btn btn-primary">Update</button>
                            </div>    
                            </div><br>
         </form>
                       

    <!-- /#wrapper -->
  

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	
	
	
    </script>

</body>

</html>