<?php

    include ('../controller/auth.php');

    require "../model/aims_inout_function.php";
	
	$id = $_GET['id'];
	$aims_inout_info = getaims_inoutbyId($id)->fetch_assoc();
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


           
            <form method="post" action="../controller/update_aims_inout_exec.php"
            enctype="multipart/form-data">   
           
            <input type="hidden" name="id" value="<?echo $aims_inout_info['id']; ?>" />  
			
                         <div class="form-group" align="left">
                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                            <br>
                       
								 
								
                                <div class="form-group" align="left">
                                 <label>Date In/Out<font color="red">**</font>&nbsp;</label><br>
                                 <input type="date" required="" class="form-control" placeholder="" id="date_mohon" name="date_mohon" value="<?echo $aims_inout_info['date_mohon']; ?>" />
                                </div>

                                
                            
                                <div class="form-group" align="left">
                                  <label>Description<font color="red">**</font>&nbsp;</label><br>
                                   <input type="text" required="" class="form-control" placeholder="" id="description" name="description"  value="<?echo $aims_inout_info['description']; ?>" />
                                </div>

                                 <div class="form-group" align="left">
                                  <label>Time Out<font color="red">**</font>&nbsp;</label><br>
                                  <input type="time" required="" class="form-control" placeholder="" id="time_out" name="time_out"  value="<?echo $aims_inout_info['time_out']; ?>" />
                                </div>
                                
                                <div class="form-group" align="left">
                                  <label>Time In<font color="red">**</font>&nbsp;</label><br>
                                  <input type="time" required="" class="form-control" placeholder="" id="time_in" name="time_in"  value="<?echo $aims_inout_info['time_in']; ?>" />
                                </div>
								
								
                               
                             <div class="modal-footer">
                                    <div align="left">
                          <button type="submit" class="btn btn-primary">submit</button>
                       </div>    
                            </div><br>
         </form>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    </script>

</body>

</html>