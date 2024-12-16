<?php

    include ('../controller/auth.php');

    require "../model/aims_inout_function.php";
	
	$staff_record_id = $_GET['staff_record_id'];
	
	$no_staff = $_GET['no_staff'];
	$staff = getStaffInformation($_SESSION['SESS_NO_STAFF']) -> fetch_assoc();
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


           
            <form method="post" action="../controller/aims_inout_exec.php"
            enctype="multipart/form-data">   
            <input type="hidden" name="action" value="login_edit" />    
            <input type="hidden" name="no_staff" value="<?echo $staff['no_staff']; ?>" />      
                         <div class="form-group" align="left">
                            <label><font color="red">** IN/OUT PERMISSION FORM.</font></label>
                            <br>
							
							 <table width="100%">
                                <tr>
                                    <th width="14%"></th>
                                    <th width="2%"></th>
                                    <th></th>
                                </tr>
                       
                                <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />      
                                <input name="id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" /> 
                                <input type="hidden" class="input-short" id="staff_record_id" name="staff_record_id" value="<?echo $staff['staff_record_id']?>" />

							</table>
							
								
								 
                                
								
								
								 <div class="form-group" align="left">
                                  <label>Date<font color="red">**</font>&nbsp;</label><br>
                                  <input type="date" required="" class="form-control" placeholder="" id="date_mohon" name="date_mohon" value="" />
                                </div>
								
								 <div class="form-group" align="left">
                                  <label>Description<font color="red">**</font>&nbsp;</label><br>
                                  <input type="text" required="" class="form-control" placeholder="" id="description" name="description" value="" />
                                </div>
								
								 
								 <div class="form-group" align="left">
                                  <label>Time Out<font color="red">**</font>&nbsp;</label><br>
                                  <input type="time" class="form-control" placeholder="" id="time_out" name="time_out" required value="" value="myFunction()" />
								  <input class="form-control" id="month_mohon" name="month_mohon" type="hidden" required value="" value="myFun()"/>
                                </div>
                                
                                <div class="form-group" align="left">
                                  <label>Time in<font color="red">**</font>&nbsp;</label><br>
                                  <input type="time" required="" class="form-control" placeholder="" id="time_in" name="time_in" value="" onkeyup="myFunction()" />
                                </div>
								
								
								 
						
								
                             <div class="modal-footer">
                                    <div align="left">
                          <button type="submit" class="btn btn-primary">Submit</button>
                       </div>    
                            </div><br>
         </form>
                        

    <!-- /#wrapper -->


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
/*function myFunction() {
  var d = document.getElementById('time_out').value;
  var t = (d * 1) + 2; 
  var dr = document.getElementById('time_in');
  dr.value = t;
} */

function myFun() {
 
  var d = new Date();
  var n = d.getMonth() + 1;
  var mn = document.getElementById('month_mohon');
  mn.value = n;

  
}
</script>

</body>

</html>