<?php

	include ('../controller/auth.php');

	require "../model/support_function.php";

?>
<?      
            $id = $_GET['id'];

        
 ?>

</head>

<body>

					        	<? 
	                    
	                     
			                     $row=  getSupportUpdate($id)->fetch_assoc();
			                
			                ?>
					 
							<form method="post" enctype="multipart/form-data" action="../controller/update_aduan_exec.php?id=<?php echo $row['id']; ?>" >
					  
					   <h2>Kemaskini Maklumat</h2>
					        <input name="id" type="text" class="input-short" value="<? echo $_GET['id']; ?>" />

							
						
							<label><font color="red">Maklumat Wajib Diisi.</font></label><br>

								<label>Nama Projek/Sistem</label><br>
						         <? echo $row['nama_projek'];?>
						         <br><br>

						         <label>Aduan</label><br>
						         <? echo $row['aduan'];?>
						         <br><br>

								<label>Nama Pelanggan</label><br>
						         <? echo $row['nama_client'];?>
						         <br><br>

						         <label>Nombor Telefon</label><br>
						         <? echo $row['notel'];?>
						         <br><br>

						         <label>Gambar/Video Aduan</label><br>
						          <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['document'] ).'" type="video/mp4" style="width: 300px; height: 310px;"/>';?>
						         <br><br>

						
       								

       								<label>Tahap Keutamaan</label><br>
						            <select required class="form-control"  name="level_aduan" id="level_aduan"   value=" <? echo $row['level_aduan'];?>">

						          <option value="">-- Pilih --</option>
    								<? $level= getLevel();
   									 while ($listdata  = $level -> fetch_assoc()){ ?>
   								 <option value="<? echo $listdata['level'];?>"  <? echo ($listdata['level']==$row['level_aduan']?'selected':'');?>>   <? echo $listdata['level']?>-<? echo $listdata['keterangan']?></option>

											    <?
											    }       
											    ?>
											    </select>

		
						 <br>
					  			<br>
					  
					   			<button type="submit" class="btn btn-primary">Simpan</button>
					   			<input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                       
					    	</form>


</body>

</html>
