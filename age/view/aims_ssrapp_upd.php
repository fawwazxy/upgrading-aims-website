<?php

include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_ssrapproved_function.php";
	
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
<style type="text/css">
    input.unit{
        width: 100px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 6px 6px 6px 6px;
    }
</style>
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

                        <? include ('../../app/global/menu_left.php'); ?>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Info Agensi</h2>
                </div>
            </div>
             
            <div class="row">
                <div class="col-lg-12">

                    <form method="post" action="../controller/aims_ssrapproved_update_exec.php" enctype="multipart/form-data">
                        <div>
                            <input type="hidden" name="action" value="agensiEdit" />
                          <input type="hidden" class="form-control" id="id" name="id" value="<? echo $staff_info['id'] ?>" />
                        </div>

                        <br><div class="form-group" align="right">
                            <a href="agromart_admin_agensi_senarai.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
                        </div>

                        <div class="panel panel-default">
                        <div class="panel-heading">
                        <label class="control-label" for="date">Kemaskini Info Agensi</label>
                        </div>
                    
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="form-group"  align="left">
								<label>Status:</label></br>
								<input type="radio" name="approved_status" <?php if($staff_info['approved_status']=="0") {echo "checked";}?> value="0"> PENDING
								<input type="radio" name="approved_status" <?php if($staff_info['approved_status']=="1") {echo "checked";}?> value="1"> APPROVED
								
                                </div>
                            <div class="form-group row" align="left">
                            <div class="col-xs-5">
                                 <label>SSR No<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="ssr_no" name="ssr_no" value="<? echo $staff_info['ssr_no'] ?>" readonly/>
                                </div>
								</div>
                            <div class="col-xs-5">
                             <label>SSR Date<font color="red">**</font>&nbsp;</label><br>
                                 <input type="date" required="" class="form-control" placeholder="" id="ssr_date" name="ssr_date" value="<? echo $staff_info['ssr_date'] ?>" readonly/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                            <div class="col-xs-5">
                            <label>Vessel<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="vessel" name="vessel" value="<? echo $staff_info['vessel'] ?>" readonly/>
                                </div>
                            <div class="col-xs-5">
                           <label>Department</label><br>
 
								  <input type="checkbox" id="department" name="department" value="deck<? echo $staff_info['department'] ?>" disabled readonly/>
								  <label for="department"> Deck</label><br>
								  
								  <input type="checkbox" id="Department" name="Department" value="engine<? echo $staff_info['department'] ?>" disabled readonly/>
								  <label for="Department"> Engine</label><br>
</div>
                            </div>

                            <div class="form-group row" align="left">
                            <div class="col-xs-5">
                             <label>Location<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="location" name="location" value="<? echo $staff_info['location'] ?>" readonly/>
                                </div>
                            <div class="col-xs-5">
                             <label>Item</label><br>
								 
                                 <input type="checkbox"  id="item" name="item" value="deckstores<? echo $staff_info['item'] ?>" disabled readonly/>
								  <label for="item"> Deck Stores</label><br>
								  
								  <input type="checkbox"  id="item" name="item" value="enginestore<? echo $staff_info['item'] ?>" disabled readonly/>
								  <label for="item"> Engine Store</label><br>
								  
								  <input type="checkbox" id="item" name="item" value="sparepart<? echo $staff_info['item'] ?>" disabled readonly/>
								  <label for="item"> Spare Part</label><br></div>
                            </div>

                           <div class="form-group row" align="left">
                            
                            <div class="col-xs-5">
                           <label>Department</label><br>
 
								  <input type="checkbox" id="department" name="department" value="deck<? echo $staff_info['department'] ?>" disabled readonly/>
								  <label for="department"> Deck</label><br>
								  
								  <input type="checkbox" id="Department" name="Department" value="engine<? echo $staff_info['department'] ?>" disabled readonly/>
								  <label for="Department"> Engine</label><br>
</div>
                          

                            

                        </div>
                        </div>
                    </div>
                    <div class="form-group" align="center">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

        

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

         function getCurrentAge(){
            var noic = document.getElementById("nokp").value;
            var noic_year = noic.slice(0,2);
            var age = "19" + noic_year;
            var today = new Date();
            var current_year = today.getFullYear();

            document.getElementById("umur").value = current_year - age;
            document.getElementById("umur").focus;    
        }

    </script>

</body>

</html>