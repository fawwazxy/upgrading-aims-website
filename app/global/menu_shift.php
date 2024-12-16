
<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flag=='tb_1'?'active':'') ?>"><a href="konfigurasi_shift_mengikut_staf.php">Mengikut Staf</a></li>
		<li class="<? echo ($flag=='tb_2'?'active':'') ?>"><a href="konfigurasi_shift_mengikut_bahagian.php">Mengikut Bahagian</a></li>
		
		
	</ul>
</div><br>
<div class="col-lg-12">
	<?   if($_SESSION['SESS_ROLE']=="ADMIN" || $_SESSION['SESS_ROLE']=="SUPERADMIN"){

		$disable="";
    }else{

    		$disable="disabled";
    	}?>
<div class="col-lg-3">
				
							<select  required class="form-control" name="cawangan_kod" id="cawangan_kod">
									<option value="0">-- Pilih Cawangan--</option>
									<? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan_kod);?>
									</select>
				</div>
				
				
				<div class="col-lg-3">
				
							<select  required class="form-control" name="jabatan_kod" id="jabatan_kod">
									<option value="0">-- Pilih Jabatan--</option>
									<? echo getDropDown("department","code_department","description",$jabatan_kod);?>
									</select>
				</div>
				
</div>