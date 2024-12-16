<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";
	
	require "../model/aims_ssr_function.php";

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
	<style>
.warning {
  background-color: #ffffcc;
  border-left: 6px solid #ffeb3b;
}
</style>
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
                <h1 class="page-header">SHIP STORES REQUISITION</h1>
            </div>
         </div>  
         
			<div class="panel-heading" align="right">
				   <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->
			</div>

                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Staff
                        </div>
                        <!-- /.panel-heading -->
            <div class="panel-body">
                          
						  
            <form method="post" action="../controller/aims_ssr_exec.php"
            enctype="multipart/form-data"> 
			
			    <div class="col-sm-4">
                        <div class="form-group" align="left">
                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                            <br>
                                 <div class="form-group" align="left">
                                 <label>SSR No<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="ssr_no" name="ssr_no" value="" />
                                </div>
                               

                                <div class="form-group" align="left">
                                 <label>SSR Date<font color="red">**</font>&nbsp;</label><br>
                                 <input type="date" required="" class="form-control" placeholder="" id="ssr_date" name="ssr_date" value="" />
                                </div> 
                        </div>
				</div><!-- /.panel-body -->
					
					
				<div class="col-sm-4">
                        <div class="form-group" align="left">
                            <br>
                                <div class="form-group" align="left">
                                 <label>Location<font color="red">**</font>&nbsp;</label><br>
                                 <input type="text" required="" class="form-control" placeholder="" id="location" name="location" style="text-transform:uppercase" value="" />
                                </div>
								<br>
								
								   
                        <div class="form-group" align="left">
                                 <label>Department</label><br>
 
								  <input type="radio" id="department" name="department" value="DECK"/>
								  <label for="department"> Deck</label><br>
								  
								  <input type="radio" id="department" name="department" value="ENGINE"/>
								  <label for="department"> Engine</label><br>

                        </div>	

                        </div>
				</div><!-- /.panel-body -->
					  
				<div class="col-sm-4">
                        <div class="form-group" align="left">
                            <br>
                                <div class="form-group" align="left">
                                 <label>Vessel</label><br>
                                 <select class="form-control" required="" name="vessel" id="vessel">
								  <option value="AA1">AA1</option>
								  <option value="AA2">AA2</option>
								  <option value="AA3">AA3</option>
								  <option value="AA4">AA4</option>
								  <option value="AA5">AA5</option>
								</select>
                                </div>
						</div>
								
                               <br>
						
						<div class="form-group" align="left">
                                 <label>Item</label><br>
								 
                                 <input type="radio" id="item" name="item" value="deckstores"/>
								  <label for="item"> Deck Stores</label><br>
								  
								  <input type="radio" id="item" name="item" value="enginestore"/>
								  <label for="item"> Engine Store</label><br>
								  
								  <input type="radio" id="item" name="item" value="sparepart"/>
								  <label for="item"> Spare Part</label><br>
                                
							</div>
                </div>
				
                    
                        <!-- /.panel-heading -->
                        <div class="panel-body">

						<br><br>
							<div class="form-group row" align="left">
                            <div class="col-xs-8">
                            <label>Attachment&nbsp;<font color="red"><i>(Hanya fail format pdf/jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                            <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                            </div>
                            </div>
							
								<div class="col-sm-12">
								<br>
								<div class="form-group" align="left">
                                <label>REMINDER</label>
								
								  <p>1. ALL COLUMN SHOULD BE DULY FILLED, OTHERWISE THIS REQUISITION WILL BE REJECTED</p>
								  <p>2. N/A SHOULD BE INDICATED WHERE ITEM(S) IS/ARE NOT APPLICABLE</p>
								  <p>3. DECK STORES AND ENGINE STORES SHOULD BE REQUSTED UNDER SAME REQUISITION. THE STORE FALLS UNDER DIFFERENT CODE INDEX FOR EAH CATEGORY TO BE REQUESTED SEPARATELY I.E CLOTH & 
										LINEN PRODUCTS, TABLEWARE & GALLEY UTENSILS & ETC.</p>
								  <p>4. FOR ITEM WITHOUT IMPA CODE, USER IS ADVISABLE TO INDICATE A CLEAR SPECIFICATION OF ITEM REQUESTED I.E. DIMENSION, LENGHT, MATERIAL, DRAWING/SKETCH/PHOTO AND ETC. </p>
								  <p>5. FOR SPAREPART, USER IS ADVISABLE TO PROVIDE RELEVANT INFORMATION I.E. EQUIPMENT/MACHINERY'S NAME, MAKER, MODEL, SERIAL NO., DRAWING/SKECTH/PHOTO AND ETC.</p>
								  <p>6. POINT 4 & 5 TO BE INDICATED UNDER COLUMN "REMARKS"</p>
								  
								 
								</div>

                            </div>
							<div class="modal-footer">
							 <table class="table table-striped" id ="buttontab">
							<tbody>
							  <tr>
								<td  colspan="12" align="center">
									<button type="submit" class="btn btn-default" id="addStaff" name="addStaff">Submit</button>
									<a href="../view/aims_list_ssr.php?id=<?echo $staff_info['id'];?>" ><button type="button" class="btn btn-default" >View Lists</button></a>
								</td>
							  </tr>
							</tbody>
						  </table>
                        </div><br>
                        </div>	
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



    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    	<script>
				function convertToUppercase(el) {
					if(!el || !el.value) return;
					el.value = el.value.toUpperCase();
				}
			</script>

</body>

</html>