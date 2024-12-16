<?php

include ('../controller/auth.php');


require "../model/library_functions.php";
$id=$_POST['id'];
$data_tempahan=getTempahanInfo($id)->fetch_assoc();
?>

 
 
 <form method="post" action="../controller/library_tempahan_exec.php">
						
						   <input id="action" name="action" type="hidden" value="addEditTempahan"/>
						   <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_ID'];?>"/>
						    <input id="id_tempahan" name="id_tempahan" type="hidden" value="<?echo $id?>"/>
						    <input id="status" name="status" type="hidden" value="<?echo $data_tempahan['status']?>"/>
                            <div class="form-group"> 
								<label class="control-label">No. Kad Pengenalan<font color="red"></font></label>
								<input class="form-control" id="nokp" name="nokp" type="text" required  value="<?echo $data_tempahan['nokp']?>" disabled/>
							</div> 
							<div class="form-group"> 
								<label class="control-label">Nama<font color="red"></font></label>
								<input class="form-control" id="nama" name="nama" type="text" required  value="<?echo $data_tempahan['nama']?>" disabled />
							</div>
							<div class="form-group"> 
								<label class="control-label">No. Telefon<font color="red"></font></label>
								<input class="form-control" id="notel" name="notel" type="text" required  value="<?echo $data_tempahan['notel']?>" disabled />
							</div>
							<div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                    <label>Status Tempahan<font color="red"> ** </font>&nbsp;(Sila klik untuk kemaskini)</label><br>
                                    <input type="radio" value="0" checked="" name="status_urgent" id="tidak_urgent" <?echo $data_tempahan['status_urgent'] == '0'?'checked':''?> />
                                    <label>Tidak Segera</label>&nbsp; &nbsp; &nbsp;
                                    <input type="radio" value="1" name="status_urgent" id="urgent" <?echo $data_tempahan['status_urgent'] == '1'?'checked':''?> />
                                    <label>Segera</label>
                                    </div>
                                    </div>
							<div class="form-group"> 
								<label class="control-label">Tarikh Anggaran Tempahan<font color="red"> **</font></label>
								<input class="form-control" id="anggaran_tarikh_tempah" name="anggaran_tarikh_tempah" type="date"required  value="<?echo $data_tempahan['anggaran_tarikh_tempah']?>"/>
							</div>
							<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-warning">Tetapan Semula</button>
							</div>
									
					
                         
                </form>
<script>

</script>