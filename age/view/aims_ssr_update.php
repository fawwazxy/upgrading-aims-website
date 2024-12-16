<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_ssr_function.php";
	
	$id = $_POST['id'];
	$staff_info = getStaffById($id)->fetch_assoc();
	
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

            

        
						  
            <form method="post" action="../controller/aims_ssr_update_exec.php"
            enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $staff_info['id'] ?>" />
                         
						 <div class="col-sm-4">
                         <div class="form-group" align="left">
                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                            <br>
                                 <div class="form-group" align="left">
                                 <label>SSR No<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="ssr_no" name="ssr_no" value="<? echo $staff_info['ssr_no'] ?>" />
                                </div>
                               

                                <div class="form-group" align="left">
                                 <label>SSR Date<font color="red">**</font>&nbsp;</label><br>
                                 <input type="date" required="" class="form-control" placeholder="" id="ssr_date" name="ssr_date" value="<? echo $staff_info['ssr_date'] ?>" />
                                </div>
								 
                      </div>
</div><!-- /.panel-body -->
					  
				<div class="col-sm-4">
                         <div class="form-group" align="left">
                            <br>
                                <div class="form-group" align="left">
                                 <label>Vessel<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="vessel" name="vessel" value="<? echo $staff_info['vessel'] ?>" readonly/>
                                </div>
								
                               <br>
							   
                                <div class="form-group" align="left">
                                 <label>Department</label><br>
 
								  <input type="radio" id="department" name="department" <?php if ($staff_info['department']  == 'DECK') echo 'checked="checked"'; ?> value="DECK" />
								  <label for="department"> Deck</label><br>
								  
								  <input type="radio" id="department" name="department" <?php if ($staff_info['department']  == 'ENGINE') echo 'checked="checked"'; ?> value="ENGINE" />
								  <label for="Department"> Engine</label><br>

                                </div> 
                      </div>
					  </div><!-- /.panel-body -->
					  
				<div class="col-sm-4">
                         <div class="form-group" align="left">
                            
                            <br>
                                <div class="form-group" align="left">
                                 <label>Location<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="location" name="location" style="text-transform:uppercase" value="<? echo $staff_info['location'] ?>" />
                                </div>
								
								<br>
								
							<div class="form-group" align="left">
                                 <label>Item</label><br>
								 
                                 <input type="radio" id="item" name="item" <?php if ($staff_info['item']  == 'DECKSTORES') echo 'checked="checked"'; ?> value="DECKSTORES" />
								  <label for="item"> Deck Stores</label><br>
								  
								  <input type="radio" id="item" name="item" <?php if ($staff_info['item']  == 'ENGINESTORE') echo 'checked="checked"'; ?> value="ENGINESTORE" />
								  <label for="item"> Engine Store</label><br>
								  
								  <input type="radio" id="item" name="item" <?php if ($staff_info['item']  == 'SPAREPART') echo 'checked="checked"'; ?> value="SPAREPART" />
								  <label for="item"> Spare Part</label><br>
                                
								</div>	

                      </div>
					  </div><!-- /.panel-body -->
					  <br><br>
					  <div class="form-group row" align="left">
                            <div class="col-xs-8">
                            <label>Lampiran&nbsp;<font color="red"><i>(Hanya fail format pdf/jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
							<?if($staff_info['document'] != ''){
                                echo $staff_info['document_name'];
                                }?>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                            <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                            </div>
                            </div>
					  
                            <br> 
                             <div class="modal-footer">
                                    <div align="left">
                          <button type="submit" class="btn btn-primary">SAVE</button>
                       </div>    
                            </div><br>
         </form>
                       
</div>
    <!-- /#wrapper -->
  

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    </script>

</body>

</html>