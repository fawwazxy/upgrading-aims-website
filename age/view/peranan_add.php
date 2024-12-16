<?php

	include ('../controller/auth.php');

	require "../model/pemohon_functions.php";

?>

<?
  $id = $_GET['id'];
  $no_staff = $_GET['no_staff'];
  $role = $_GET["role"];
  $xrole = $_GET["xrole"];
 
  
?>


<?
    
	
	
    if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
    {
      activePeranan($id,0); 
    
    }

    if(isset($_GET['act']) && $_GET['act'] == "active" && !empty($_GET['id']))
    {
    activePeranan($id,1);   
    
    }

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
	
	

<script language="javascript" type="text/javascript">
function updateId(curr_update_id){
	document.getElementById('curr_update_id').value = curr_update_id;
}


function Confirm(){
    return confirm('Adakah Anda Pasti untuk NYAH-AKTIFKAN ?');
}

function Confirm2(){
    return confirm('Adakah Anda Pasti untuk AKTIFKAN semula?');
}



</script>

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
		
          <? 
                        $flagScreen="tab_4";
                        include ('../global/menu_keselamatan.php'); 
                    ?>
			
					
		
		<div class="panel-heading" align="right">
		<button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>
		
		</div>
		
		
		
	
	
                <div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">
                        <div class="panel-heading">
                          Senarai Peranan
                        </div>
						<input type="hidden" id="curr_update_id" value="0">
                        <!-- /.panel-heading -->
				
                    <? 
                        
					
											         
						$log_peranan_edit = getPerananEdit($id)-> fetch_assoc();
						
                    
                    ?>

			 		 <!-- Modal -->
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Peranan</h4>
                    </div>
                
                <div class="modal-body">
                
               	<form method="post" action="../controller/peranan_update_exec.php?id=<? echo $list['id'];?>" >
					  

                    <input name="id" type="text" class="input-short" value="<? echo $id;?>" /> 
						
					<label><font color="red">Maklumat Wajib Diisi.</font></label>
					<br>
					
					<div class="form-group" align="left">
                   
						 <div class="form-group" align="left">
                         <label>Kod<font color="red">**</font>&nbsp;</label>
                         <input type="text" class="form-control" name="code" value="<? echo $log_peranan_edit['code']; ?>"/><br>
                         </div>
						 
						 <div class="form-group" align="left">
                         <label>Peranan<font color="red">**</font>&nbsp;</label>
                         <input type="text" class="form-control" name="role" value="<? echo $log_peranan_edit['role']; ?>"/><br>
                         </div>
						
						
						<div class="form-group" align="left">
								<label>Pilih Kumpulan Peranan<font color="red">**</font>&nbsp;</label>
								<select id="disabledSelect" class="form-control" name="role_group_id" value="<? echo $log_peranan_edit['role_group_name']; ?>">
								  <option value="">-- Pilih --</option>
													  
								 <? $role_group = getRoleGroup();
								 while ($list_group  = $role_group-> fetch_assoc()){ ?>
								 <option value="<? echo $list_group['id'];?>" <?echo($list_group['id']==$log_peranan_edit['role_group_name']?'selected':'');?>><? echo $list_group['role_group_name'];?> </option>
															
									<?
										}       
									?>
								</select>
						</div> 
						
					
					  
					   <button type="submit" class="btn btn-primary">Simpan</button>
					   <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                       
					    </form>
                </div><!--modal-body-->
				</div>
        
                </div>
        <!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
						
						 <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Peranan</h4>
                    </div>
                
                <div class="modal-body">
                
                <form method="post" action="../controller/peranan_add_exec.php" >
         
                         <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
						 <input type="hidden" name="company_id"  value="<? echo $_SESSION['SESS_COM']; ?>">

					     <div>
					   
                         <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>						 
                           </div>
						   
						   
						<div class="form-group" align="left">
							<label>Kod</label>
							<input class="form-control"  name="code" id="code"  required autocomplete="off" style="text-transform:uppercase" />
							</div>
						   
						  <div class="form-group" align="left">
							<label>Peranan</label>
							<input class="form-control"   name="role" id="role"  required autocomplete="off"  style="text-transform:uppercase" />
							</div>
							
							
							<div class="form-group" align="left">
								<label>Pilih Kumpulan Peranan<font color="red">**</font>&nbsp;</label>
								<select class="form-control" name="role_group_id">
								  <option value="">-- Pilih --</option>
													  
								 <? $role_group = getRoleGroup();
								 while ($list_group  = $role_group-> fetch_assoc()){ ?>
								 <option value="<? echo $list_group['id'];?>"> <? echo $list_group['role_group_name'];?> </option>
															
									<?
										}       
									?>
								</select>
						</div> 

						   
                    	    
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                        </div>
						
					
                         
                </form>
                </div><!--modal-body-->
        
                </div>
        <!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
						
						
                        <div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Kod</th>
										<th>Kumpulan Peranan</th>
										<th>Peranan</th>
										<th>Status</th>
										<th>Tindakan</th>
									</tr>
								</thead>
								<tbody>
							    <?
								    $x=1;
									$log_Peranan = getPeranan() ;
									while($list = $log_Peranan->fetch_assoc()) {
								?>
								
								<tr class="odd gradeX">
								    
										<td><?php echo $list['code']; ?></td>
										<td><?php echo $list['role_group_name']; ?></td>
										<td><?php echo $list['role']; ?></td>
									
									
								       
										 <td>
                                         
                                            <?
                                            if($list['status'] == 1)
                                            {
                                                
												 echo'<strong><font color=blue>AKTIF</font></strong>';
											
                                            }
                                            else
                                            {
                                              	echo '<strong><font color=red>TIDAK AKTIF</font></strong>';
                                            }
                                        ?></td>
                                        <td><?
                                              if ($list['status'] == 0) { ?>

                                            <a href="peranan_add.php?act=active&id=<? echo $list['id'];?>&no_staff=<? echo $no_staff;?>"><button type="button" class="btn btn-success">AKTIFKAN</button>
                                             <?     
                                                    }
                                                    else {
                                                ?>

                                            <a href="peranan_update.php?id=<? echo $list['id'];?>"><button class="btn btn-info" type="button"  data-toggle="modal"  data-target="#myModal1">Kemaskini</button></a>
                                             <a href="peranan_add.php?act=delete&id=<? echo $list['id']; ?>&no_staff=<? echo $no_staff;?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" >NYAH-AKTIF</button>

                                             <? 
                                                    }

                                                ?></td>
									</tr>
									
                                             <? 
											 
											   $x++;  
                                                    }

                                                ?>
								
								</tbody>

							</table>

                        </div>

                        <!-- /.panel-body -->
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
	   $(document).ready(function() {
  $('#dataTables-example').DataTable({
    responsive: true
  });
  
  
  	<?
		$duplic = $_GET["duplic"];
		if($duplic=='1'){
		
		echo "$('#myModal').modal('toggle')"; 
		//echo "document.getElementsByName('role').value = '".$xrole."';";
		}
		?>
  
  });
 </script>

</body>

</html>