<?php

	include ('../controller/auth.php');

	require "../model/ahli_functions.php";
	require "../model/lookup.php";

?>
<?
         
		 $id = $_POST['id'];
		 $tahun = $_POST['tahun'];
		 $created_by = $_POST['created_by'];
		

		 $jum_khairat=getJumlahKhairat()->fetch_object()->jumlah_biaya;
		 $data = getSenaraiBiayaKhairatById($id)->fetch_assoc();

        
 ?>

                     
                      <form method="post" action="../controller/ahli_khairat_exec.php" >     
                         <div class="form-group" align="left">
                              
                              <? 
                               if($id!=0){
                               	$jum_khairat=$data['jum_khairat'];

                               }
                              ?>
							 
                             
							<label><font color="red">** Maklumat Wajib Diisi **</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $id; ?>">
							 <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
							 <input type="hidden" name="created_by" value="<?php echo $created_by; ?>">
							 <input type="hidden" name="action" value="addEditBiayaKhairat">
								<div class="form-group"  align="left">
								  <label>Nama / No. Kad Pengenalan&nbsp;<font color="red">**</font></label>
								  <input class="form-control" id="nama" name="nama" value="<? echo $data['label'] ?>" onfocus="javascript:$(this).autocomplete('search','');" required>
                                    <input type="hidden" name="nokp_ahli" id="nokp_ahli" value="<? echo $data['nokp_ahli'];?>" /> 
								</div>
		                        <div class="form-group"  align="left">
								  <label>Jumlah (RM)&nbsp;<font color="red">**</font></label>
								  <input type="number" step="any" class="form-control" placeholder=" "  name="jum_khairat" value="<? echo $jum_khairat;?>" required>
								</div>
								
		                        <div class="form-group"  align="left">
								  <label>Tarikh&nbsp;<font color="red">**</font></label>
								  <input class="form-control" type="date" placeholder=" "  name="tarikh" value="<? echo $data['tarikh'] ?>" >
								</div> 

								<div class="form-group" align="left">
		                         <label>Nota<font color="red"></font>&nbsp;</label>
		                         <textarea class="form-control" name="nota" rows="5"><? echo $data['nota_biaya'];?></textarea>
		                        </div>			
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                             </div>
         
         </form>


   <script>
    $( function() {
         $( "#nama" ).autocomplete({
          source: function( request, response ) {
           // Fetch data
           console.log(request.term);
           $.ajax({
            url: "../model/ahli_functions.php",
            type: 'post',
            dataType: "json",
            data: {action:"searchAhli",search: request.term},
            success: function(data) {
             response(data );
             console.log(data);
            }
           });
          },
           minLength: 0,
                          open: function() {

                          },
          select: function (event, ui) {
           // Set selection
           $('#nama').val(ui.item.label); // display the selected text
           $('#nokp_ahli').val(ui.item.value); // save selected id to input
           return false;
          }
         });
       });
    </script>
                      