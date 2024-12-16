<? 
	require "../model/kehadiran_functions.php";
	require "../model/lookup.php";
?>


	
	<? $log=$_POST['log'];?>

<?
	date_default_timezone_set("Asia/Kuala_lumpur");
	$date = new DateTime();
?>



                    
                   
				<?	if($log=="masuk") {?>
						
					 
                        <form role="form" action="../controller/masuk_exec.php" method="POST">
                            <fieldset>
                                <div class="form-group" align="left">
			                    <label class="control-label" for="date">Lokasi<font color="red">**</font>&nbsp;</label>
			                    <select required class="form-control" id="id_lkp_lokasi" name="id_lkp_lokasi" value="">
			                    <option value="">-- Pilih --</option>
			                    <?echo getLookupTable("lkp_location","id","name");?>
			                    </select>
			                    </div>
			                    <div class="form-group" align="left">
			                    <label class="control-label" for="date">Cawangan<font color="red">**</font>&nbsp;</label>
			                    <select required class="form-control" id="id_lkp_cawangan" name="id_lkp_cawangan" value="">
			                    <option value="">-- Pilih --</option>
			                    <?echo getLookupTable("lkp_cawangan","cawangan_kod","nama");?>
			                    </select>
			                    </div>
			                    
                                <div class="form-group">
								    <input name="action" type="hidden" value="masuk"/>
								    <label class="control-label" for="date">No. Kad Pengenalan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder="NO K/P" name="nokp_staff" type="text" required=""/>
                                </div>
                                
                                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Masuk"/>
                            </fieldset>
                        </form>
				<?}
					else {?>
					
					<form role="form" action="../controller/masuk_exec.php" method="POST">
                            <fieldset>
                                <div class="form-group" align="left">
			                    <label class="control-label" for="date">Lokasi<font color="red">**</font>&nbsp;</label>
			                    <select required class="form-control" id="id_lkp_lokasi" name="id_lkp_lokasi" value="">
			                    <option value="">-- Pilih --</option>
			                    <?echo getLookupTable("lkp_location","id","name");?>
			                    </select>
			                    </div>
			                    </div>
			                    <div class="form-group" align="left">
			                    <label class="control-label" for="date">Cawangan<font color="red">**</font>&nbsp;</label>
			                    <select required class="form-control" id="id_lkp_cawangan" name="id_lkp_cawangan" value="">
			                    <option value="">-- Pilih --</option>
			                    <?echo getLookupTable("lkp_cawangan","cawangan_kod","nama");?>
			                    </select>
			                    </div>
			                    
                                <div class="form-group">
								<input name="action" type="hidden" value="keluar"/>
								<label class="control-label" for="date">No. Kad Pengenalan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder="NO K/P" name="nokp_staff" type="text" required=""/>
                                </div>
                                
                                <input type="submit" class="btn btn-lg btn-primary btn-block" value="keluar"/>
                            </fieldset>
                        </form>
					<?}?>
					
				  