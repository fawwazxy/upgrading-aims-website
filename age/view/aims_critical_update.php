<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_critical_function.php";
	
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

            

        
						  
            <form method="post" action="../controller/aims_critical_update_exec.php"
            enctype="multipart/form-data"> 
			
			   <input type="hidden" class="form-control" id="id" name="id" value="<? echo $staff_info['id'] ?>" />
			   
                         
				<div class="form-group row" align="left">
					<div class="col-xs-4">
						<label>Part Name<font color="red">**</font>&nbsp;</label><br>
                        <input type="text" class="form-control" placeholder="" id="part_name" name="part_name" value="<? echo $staff_info['part_name'] ?>" />
					</div>

					<div class="col-xs-4">
						<label>minimum</label><br>
                        <input type="text" required="" class="form-control" placeholder="" id="minimum" name="minimum" value="<? echo $staff_info['minimum'] ?>" />
					</div>
					
					<div class="col-xs-4">
                     <label>Vessel<font color="red">**</font>&nbsp;</label><br>
                     <input type="text" required="" class="form-control" placeholder="" id="vessel" name="vessel" value="<? echo $staff_info['vessel'] ?>" readonly/>
                    </div>
					
				</div>	
				
				<div class="form-group row" align="left">
					<div class="col-xs-3">
						<label>balance</label><br>
                        <input type="text" required="" class="form-control" placeholder="" id="balance" name="balance" value="<? echo $staff_info['balance'] ?>" onkeyup="subtract()" />
					</div>

					<div class="col-xs-3">
						<label>used</label><br>
                        <input type="text" required class="form-control" placeholder="" id="used" name="used" value="<? echo $staff_info['used'] ?>" onkeyup="subtract()" />
					</div>
					
					<div class="col-xs-3">
                     <label>supply</label><br>
                     <input type="text" required class="form-control" placeholder="" id="supply" name="supply" value="<? echo $staff_info['supply'] ?>" onkeyup="subtract()"/>
                    </div>
					
					<div class="col-xs-3">
                     <label>ROB</label><br>
                     <input type="text" required class="form-control" placeholder="" id="rob" name="rob" value="<? echo $staff_info['rob'] ?>" value="subtract()" />
                    </div>
					
				</div>	
							
                             <div class="modal-footer">
                             <center> <button type="submit" class="btn btn-primary">Edit</button>
                            </center>    
                            </div>
         </form>
                       

    <!-- /#wrapper -->
  

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	
		
	function subtract(){
		
		var balance= document.getElementById('balance').value;
		var used = document.getElementById('used').value;
		var supply = document.getElementById('supply').value;
		var total=  ((balance-used) + (+supply));
		var totals = total;
		var rob = document.getElementById('rob');
		rob.value=totals;
	}
	
    </script>

</body>

</html>