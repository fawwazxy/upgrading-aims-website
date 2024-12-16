<?

    require "../model/aims_access_function.php";
	
?>        
		
		<form method="post" action="../controller/aims_add_access_exec.php" >     
                         <div class="form-group" align="left">
                             
							<br>
							    <input type="hidden" name="id" value="<?echo $staff_info['id']; ?>"/>
								
						<div class="form-group row" align="left">
							<div class="col-xs-8">
								   <label>PIC<font color="red">**</font>&nbsp;</label>
								 <input class="form-control" list="pic1" id="no_staff" name="no_staff" value="<? echo $no_staff['car_pic'];?>"/>
								<datalist  id="pic1">
								<option value="">-- Choose Name --</option>
								<? echo getdropdownstaff($car_info['car_pic'])?>
								</datalist>
							</div>
						</div>

                            <div class="form-group row" align="left">
								<div class="col-xs-8">
									<div style="float:left" style="margin-left:1%">
										<p><label class="control-label">Vehicle Access :</label>&nbsp;&nbsp;&nbsp;</p>
										<p><input type="radio" id="vehicle_access" name="vehicle_access" value="1"> PIC &nbsp;&nbsp;
											<input type="radio" name="vehicle_access" value="2"> Admin</p>
								</div>
								</div>
							</div>
							
							<div class="form-group row" align="left">
				<div class="col-xs-8">
					<div style="float:left" style="margin-left:1%">
						<p><label class="control-label">Gl Access: </label>&nbsp;&nbsp;&nbsp;</p>
						<p><input type="radio" name="gl_access" id="gl_access" value="1"> Admin&nbsp;&nbsp;
							<input type="radio" name="gl_access" value="0"> NO</p>
						</div>
					</div>	

				</div>
								
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                   <button type="reset" class="btn btn-info">Tetapan Semula</button>
                             </div>
         
         </form>
		 