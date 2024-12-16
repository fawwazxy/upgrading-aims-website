<?

    require "../model/aims_access_function.php";
	
	$id = $_POST['id'];
	$no_staff = getDataAccessbyId($id)->fetch_assoc();
?>        
		
		<form method="post" action="../controller/aims_update_access_exec.php" >     
                        <div class="form-group" align="left">
                             
							<br>
							    <input type="hidden" name="id" value="<?echo $no_staff['id']; ?>"/>
								
						<div class="form-group row" align="left">
							<div class="col-xs-8">
								   <label>PIC<font color="red">**</font>&nbsp;</label>
								 <input class="form-control" list="pic1" id="no_staff" name="no_staff" readonly="" value="<? echo $no_staff['no_staff'];?>"/>
							</div>
						</div>

                            <div class="form-group row" align="left">
								<div class="col-xs-8">
									<div style="float:left" style="margin-left:1%">
										<p><label class="control-label">Vehicle Access :</label>&nbsp;&nbsp;&nbsp;</p>
										<p><input type="radio" id="vehicle_access" name="vehicle_access" value="1"
										 <? if($no_staff['vehicle_access'] == 1) echo "checked"?>> PIC &nbsp;&nbsp;
											<input type="radio" name="vehicle_access" value="2"
											<? if($no_staff['vehicle_access'] == 2) echo "checked"?>> Admin &nbsp;&nbsp;
											<input type="radio" id="vehicle_access" name="vehicle_access" value="3"
										 <? if($no_staff['vehicle_access'] == 3) echo "checked"?>> NO</p>
								</div>
								</div>
							</div>
							
							<div class="form-group row" align="left">
								<div class="col-xs-8">
									<div style="float:left" style="margin-left:1%">
										<p><label class="control-label">Gl Access: </label>&nbsp;&nbsp;&nbsp;</p>
										<p><input type="radio" name="gl_access" id="gl_access" value="1" 
											<? if($no_staff['gl_access'] == 1) echo "checked"?>> Admin&nbsp;&nbsp;
											<input type="radio" name="gl_access" value="0" 
											<? if($no_staff['gl_access'] == 0) echo "checked"?>> No</p>
								</div>
							</div>	
								
						</div>
								
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Save</button>
                             </div>
         
         </form>
		 