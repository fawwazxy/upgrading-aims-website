<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_critical_function.php";

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
                <h1 class="page-header">MONTHLY CRITICAL SPAREPARTS ROB</h1>
            </div>
         </div>  
         
            <div class="panel-heading" align="right">
               <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->
        
        </div>

                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          MONTHLY CRITICAL SPAREPARTS ROB INFO
                        </div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                          
						  
            <form method="post" action="../controller/aims_critical_exec.php"
            enctype="multipart/form-data"> 

				
				
				           
				<div class="form-group row" align="left">
					<div class="col-xs-4">
						<label>Part Name<font color="red">**</font>&nbsp;</label><br>
                        <input type="text" class="form-control" placeholder="" id="part_name" name="part_name" value="" />
					</div>

					<div class="col-xs-4">
						<label>minimum</label><br>
                        <input type="text" required="" class="form-control" placeholder="" id="minimum" name="minimum" value="" />
					</div>
					
					<div class="col-xs-4">
                     <label>Vessel<font color="red">**</font>&nbsp;</label><br>
                     <input type="text" required="" class="form-control" placeholder="" id="vessel" name="vessel" value=""/>
                    </div>
					
				</div>	
				
				<div class="form-group row" align="left">
					<div class="col-xs-3">
						<label>balance</label><br>
                        <input type="text" required="" class="form-control" placeholder="" id="balance" name="balance" value="" onkeyup="subtract()" />
					</div>

					<div class="col-xs-3">
						<label>used</label><br>
                        <input type="text" required class="form-control" placeholder="" id="used" name="used" value="" onkeyup="subtract()" />
					</div>
					
					<div class="col-xs-3">
                     <label>supply</label><br>
                     <input type="text" required class="form-control" placeholder="" id="supply" name="supply" value="" onkeyup="subtract()"/>
                    </div>
					
					<div class="col-xs-3">
                     <label>ROB</label><br>
                     <input type="text" required class="form-control" placeholder="" id="rob" name="rob" value="" value="subtract()" />
                    </div>
					
				</div>	

						<div class="modal-footer">
                            <div align="right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
						  <a href="../view/aims_critical_list.php?id=<?echo $staff_info['id'];?>" ><button type="button" class="btn btn-primary" >View Lists</button></a>
                       </div>    
                            </div>
							<br>
         </form>
                        </div>
                        
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

    </div>

    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>

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