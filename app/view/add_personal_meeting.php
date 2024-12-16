
				<div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">

                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
						<form method="post" action="../controller/meeting_add_exec.php?id=<? echo $id;?>" enctype="multipart/form-data">    
                         <div class="form-group" align="left">
							<br>
							<div class="form-group" align="left">
							
							<div class="form-group" align="left">
                                  <label>Tajuk Perjumpaan <font color="red">**</font>&nbsp;</label>
                                  <input type="text" class="form-control" placeholder=" " id="title" name="title" required autocomplete="">
                                </div>
							
					<div class="form-group">
					<label for="color" class="col-sm-2 control-label">Warna</label>
					  <select name="color" class="form-control" id="color">
						  <option value="">Pilih</option>
						  <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
						  <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
						  <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
						  <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
						  <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
						  <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
						  <option style="color:#000;" value="#000">&#9724; Black</option>
						  
						</select>
					</div>
								<label>Butir-Butir Temujanji<font color="red">**</font>&nbsp;</label>
                                 <!--<input type = "textarea rows="4" cols="50" class="form-control" placeholder=" "id="jenama" name="description" required autocomplete="" > -->
								  <br>
								  
								  <textarea id="summernote" name="description" rows="10"></textarea>
                                </div>
                             
                                <div class="form-group" align="left">
                                  <label>Tarikh & Masa Mula <font color="red">**</font>&nbsp;</label>
                                  <input type="datetime-local" class="form-control" placeholder=" " id="start" name="start" required autocomplete="" value = "2018-11-11T08:00">
                                </div>

                                <div class="form-group" align="left">
                                  <label>Tarikh & Masa Tamat<font color="red">**</font>&nbsp;</label>
                                  <input type="datetime-local" class="form-control" placeholder=" " id="end" name="end" required autocomplete="" value = "2018-11-11T16:00">
                                </div>
								
								 <div class="form-group" align="left">
                                  <label>Individu Terlibat<font color="red">**</font>&nbsp;</label>
								<?php
												$result = getStaffInfo(); 
                                                ?>
                                                <?php
                                                //display dept code
                                                while($row = mysqli_fetch_assoc($result)){
                                                ?>
												<br>		
                                                 <input type = "checkbox" name = "id_staff[]" value = "<?php echo $row["id"] ?>"><?php echo $row["name"];?>
																		 
                                                <?php
                                                }
                                                ?>
								</select>
                                </div>							
							<div class="form-group" align="left">
                                  <label>Status <font color="red">**</font>&nbsp;</label>
                                  <select name = "status" class = "form-control">
										<option value = "BARU">BARU</option>
								  </select>
                            </div>
							
								
							<div class="form-group" align="left">
                                  <label>Jenis Acara <font color="red">**</font>&nbsp;</label>
                                  <select name = "event_type" class = "form-control">
										<option value = "PERLANCARAN PRODUK">PERLANCARAN PRODUK"</option>
										<option value = "DEMO SISTEM">DEMO SISTEM</option>
										<option value = "UNDANGAN CCERAMAH">UNDANGAN CCERAMAH</option>
										<option value = "TEMUJANJI">TEMUJANJI</option>
								  </select>
                               </div>
								
                            </div>
							
							<div class="form-group" align="left">
                                <label>Disediakan oleh <font color="red">**</font>&nbsp;</label>
                                <input type = "text" name = "prepared_by" class = "form-control" value = "<? echo ($_SESSION['SESS_NAME']); ?>" readonly>
                            </div>
                  
                             <div class="modal-footer">
                                <button class="btn btn-primary">Simpan</button>
                                   <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                             </div>
         
         </form>
                            </div></div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
			
<script type="text/javascript">
$(document).ready(function() {
	$('#summernote').summernote({
		height: "300px",
		styleWithSpan: false
	});
});
function postForm() {
	$('textarea[name="description"]').html($('#summernote').code());
}
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  </script>