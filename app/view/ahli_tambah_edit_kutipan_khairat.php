<?php

	include ('../controller/auth.php');

	require "../model/ahli_functions.php";
	require "../model/lookup.php";

?>

<?
          
		 $id = $_POST['id'];
		 $status = $_POST['status'];
		 $nokp = $_POST['nokp'];
		 $nama = $_POST['nama'];
		 $created_by=$_POST['created_by'];
		 $tahun = $_POST['tahun'];

		 $jum_khairat=getJumlahKhairat()->fetch_object()->jumlah_kutipan;

        
 ?>

                     
                      <form method="post" action="../controller/ahli_khairat_exec.php" >     
                         <div class="form-group" align="left">
                              
                              <? 
                              ?>
							 
                             
							<label><font color="red">** Maklumat Wajib Diisi **</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $id; ?>">
							 <input type="hidden" name="nokp_ahli" value="<?php echo $nokp; ?>">
							 <input type="hidden" name="action" value="addEditKhairat">
							 <input type="hidden" name="status" value="<?php echo $status; ?>">
							  <input type="hidden" name="created_by" value="<?php echo $created_by; ?>">
							   <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
								<div class="form-group"  align="left">
								  <label>Nama</label>
								  <input class="form-control" placeholder=" "  name="nama" value="<? echo $nama;?>" readonly>
								</div>
		                        <div class="form-group"  align="left">
								  <label>Jumlah (RM)</label>
								  <input type="number" step="any" class="form-control" placeholder=" "  name="jum_khairat" value="<? echo $jum_khairat;?>" readonly>
								</div>
								
		                        <div class="form-group"  align="left">
								  <label>Tarikh&nbsp;<font color="red"></font></label>
								  <input class="form-control" type="date" placeholder=" "  name="tarikh" value="<? echo $data['tarikh'] ?>" >
								</div> 			
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                             </div>
         
         </form>
                      