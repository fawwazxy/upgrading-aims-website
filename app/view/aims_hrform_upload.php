<?php
	include ('../controller/auth.php');
    require "../model/aims_hr_function.php";
	
	$created_by = $_SESSION['SESS_NAME'];
	
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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <!-- /.navbar-header -->
			<? include ('../global/menu_top.php'); ?>

            <!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--li>
							<center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
						</li-->

						<? include ('../global/menu_left.php'); ?>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		 
		
        <div id="page-wrapper">
		
		
		
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">HR FORM</h1>
            </div>
			
		</div>
         
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
						<br>
				
                        <div class="panel-body">
                          <div class="col-sm-12">
						 
        <form method="post" action="../controller/aims_hrform_add_exec.php" enctype="multipart/form-data"> 
		<input type="hidden" id="created_by" name="created_by" value="<? echo $created_by; ?>" />
		
							
							<div class="form-group row" align="left">
								<div class="col-xs-6">
									<label> Company Name <font color="red">**</font></label><br>
									<select required class="form-control" name="company_name" id="company_name">
													<option value="">Choose Company</option>
													<? echo getDropDownDepartment("");?>
									</select> 
								</div>
							</div>
							
							<div class="form-group row" align="left">
							
								<div class="col-xs-6">
                                  <label>Form Name<font color="red">**</font>&nbsp;</label><br>
                                  <input type="text" required class="form-control" placeholder="" id="form_name" name="form_name" value="" />
								</div>

                            </div>
							
							<div class="form-group row" align="left">
								<div class="col-xs-8">
									<label>Upload&nbsp;<font color="red"><i>(Only pdf/jpeg/jpg/png/gif format file are allowed)</i></font></label>
									<input type="hidden" name="MAX_FILE_SIZE">
									<input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
								</div>
                            </div>
							
                          <button href="aims_hrform_list.php?" type="submit" class="btn btn-primary">Submit</button>

                                    </div>    
                             </div><br>
         </form>
                        </div>
                        <!-- /.panel-body -->
                             </div>
                        </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                    </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
                </div>

                </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    
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
	
	<? 
		$duplic = $_GET["duplic"];
	    if($duplic=='1'){
    
   		 echo "$('#myModal').modal('toggle')";
   		 //echo "document.getHrFormById('role').value = '".$xrole."';";
   		 }
    ?>
  
	</script>



</body>

</html>