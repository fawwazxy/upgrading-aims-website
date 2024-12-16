<?  
     
	  date_sub($date,date_interval_create_from_date_string("1 days"));
	  $date6 = date_format($date,"D d-F-Y");
      $date1 = date_format($date,"d-m-Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 days"));
      $date7 = date_format($date,"D d-F-Y");
	  $date2 = date_format($date,"d-m-Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 days"));
      $date8 = date_format($date,"D d-F-Y");
	  $date3 = date_format($date,"d-m-Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 days"));
     $date9 = date_format($date,"D d-F-Y");
	 $date4 = date_format($date,"d-m-Y");
	  
	  
	 
	  

?>


<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flag=='tb_1'?'active':'') ?>"><a href="senarai_kehadiran.php?dt=<? echo $current_date;?>&flg=<? echo tb_1 ;?>&cawangan_kod=<?  echo $cawangan_kod;?>&jabatan_kod=<?  echo $jabatan_kod;?>"><? echo $crt_dt;?></a></li>
		<li class="<? echo ($flag=='tb_2'?'active':'') ?>"><a href="senarai_kehadiran.php?dt=<? echo $date1;?>&flg=<? echo tb_2 ;?>&cawangan_kod=<?  echo $cawangan_kod;?>&jabatan_kod=<?  echo $jabatan_kod;?>"><? echo $date6; ?></a></li>
		<li class="<? echo ($flag=='tb_3'?'active':'') ?>"><a href="senarai_kehadiran.php?dt=<? echo $date2;?>&flg=<? echo tb_3 ;?>&cawangan_kod=<?  echo $cawangan_kod;?>&jabatan_kod=<?  echo $jabatan_kod;?>"><? echo $date7; ?></a></li>
		<li class="<? echo ($flag=='tb_4'?'active':'') ?>"><a href="senarai_kehadiran.php?dt=<? echo $date3;?>&flg=<? echo tb_4 ;?>&cawangan_kod=<?  echo $cawangan_kod;?>&jabatan_kod=<?  echo $jabatan_kod;?>"><? echo $date8; ?></a></li>
		<li class="<? echo ($flag=='tb_5'?'active':'') ?>"><a href="senarai_kehadiran.php?dt=<? echo $date4;?>&flg=<? echo tb_5 ;?>&cawangan_kod=<?  echo $cawangan_kod;?>&jabatan_kod=<?  echo $jabatan_kod;?>"><? echo $date9; ?></a></li>
		
		
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
				
				
<? if($flag=='tb_1'){ ?>
<div class="panel-heading" align="right">
				
<button class="btn btn-primary" onClick="popitup('senarai_kehadiran_today.php','Paparan Kehadiran')">Pemantauan</button></a>
<button class="btn btn-primary" onClick="popitup('pemantauan_kehadiran_semasa_keseluruhan.php','Paparan Kehadiran')">Pemantauan Mengikut Jabatan</button></a>
<button class="btn btn-primary" onClick="popitup('pemantauan_kehadiran_semasa_keseluruhan_lokasi.php','Paparan Kehadiran')">Pemantauan Mengikut Lokasi</button></a>

</div>
<?}?>
</div>