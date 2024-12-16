<?php

    include ('../controller/auth.php');

    require "../model/aims_inout_function.php";
	
	$id = $_GET['id'];
	$aims_inout_id = getaims_verified_approvebyId($id)->fetch_assoc();
	$no_staff = $_GET['no_staff'];
	$staff = getStaffInformation($_SESSION['SESS_NO_STAFF']) -> fetch_assoc();
?>


            <form method="post" action="../controller/aims_verified_approve_exec.php"
            enctype="multipart/form-data">   
            <input type="hidden" name="action" value="login_edit" />    
            <input type="hidden" name="no_staff" value="<?echo $staff['no_staff']; ?>" />      
                         <div class="form-group" align="left">
                            <label><font color="red">**  VERFIED / APPROVE.</font></label>
                            <br>
							
							 <table width="100%">
                                <tr>
                                    <th width="14%"></th>
                                    <th width="2%"></th>
                                    <th></th>
                                </tr>
                       
                                     
                                <input name="id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" /> 
                                <input type="hidden" name="aims_inout_id" value="<?php echo $aims_inout_id['aims_inout_id']; ?>">
							</table>
							
								<div class="form-group" align="left">
                                  <label>approve<font color="red">**</font>&nbsp;&nbsp;&nbsp;</label><br>
								  <label><input type="radio" required=""  id="approve" name="approve" value="APPROVE" />	APPROVE</label> &nbsp;&nbsp;&nbsp;
								  <label><input type="radio" required=""  id="approve" name="approve" value="DISAPPROVE" />	NOT APPROVE</label> &nbsp;&nbsp;&nbsp;
                                </div>
								
								<div class="form-group" align="left">
                                  <label>approve_name<font color="red">**</font>&nbsp;</label><br>
                                  <input type="text" required="" class="form-control" placeholder="" id="approve_name" name="approve_name" value="<?echo $_SESSION['SESS_NAME'];?>" readonly />
								  <input type="hidden" required="" class="form-control" placeholder="" id="approve_by" name="approve_by" value="<?echo $_SESSION['SESS_NO_STAFF'];?>"  />
                                </div>
								
								<div class="form-group" align="left">
                                  <label>Reason</label><br>
                                  <input type="text" class="form-control" placeholder="" id="reason" name="reason" value="" />
                                </div>
								
                             <div class="modal-footer">
                                    <div align="left">
                          <button type="submit" class="btn btn-primary">Submit</button>
                       </div>    
                            </div><br>
         </form>
                        </div>
                        <!-- /.panel-body -->
                    

    <!-- /#wrapper -->


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    </script>

</body>

</html>