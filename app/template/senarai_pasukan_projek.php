<?php

	include ('../controller/auth.php');
	
	require "../model/project_management_function.php";

	// require "../model/niaga_function.php";

?>



<?php

$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
	
	<? require "../../resources/css/project_management.css";?>
	<?
	date_default_timezone_set("Asia/Kuala_lumpur");
	$date = new DateTime();
?>
<style>
	hr{
	border-top: 3px double #000000;
    margin-top: 0;
}
</style>

<script language="javascript" type="text/javascript">


</script>

</head>

<body>
    <div class="grid-header">
			 <? 		
				$pic = getInfoProjek($id)->fetch_assoc();
				$com = getCompany()->fetch_assoc();
				
						
	?>
	<div class="item1">
	<? 
					echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"/>';
					 ?>
	
	</div>
	<div class="item2">
	
	<strong><h3 align='right'><? echo $com['name'];?></h3>
	<h4 align='right'><? echo $com['registration_no'];?></h4></strong><br>
	<h5 align='right'><? echo $com['address'];?></h5>
	<h6 align='right'>No. Telefon: <? echo $com['tel'];?> | Emel: <? echo $com['email'];?> | Website : <? echo $com['website'];?></h6>
   </div>
   
   </div>
    
	
	<div class="item5">
	<center><h2><b>SENARAI AHLI PASUKAN </b></h2></center><br><br>
	<center><h4><b>PROJEK :  <? echo $pic['tajuk_sebut_harga'] ;?> </b></h4></center><br>
	<center><h4><b>DISEDIAKAN UNTUK :  <? echo $pic['agensi_rujukan'] ;?> (<? echo $pic['nama_rujukan'] ;?>) </b></h4></center><br><br>
	<table width="80%" class="table table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										
										
										<th>Gambar</th>
										<th>Nama Penuh</th>
										<th>Peranan</th>
									</tr>
								</thead>
								<tbody>
                                    <?
                                   
                                    $id_harga = $pic['id_sebut_harga'] ;                                                  
									$i= 1;
									// $data = getItem($id_harga);

									$data = getSenaraiAhli($id);
									while($row_data = $data->fetch_assoc()) {
									
								?>
									<tr>
									  
									  <td width="15%"><center><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photo'] ).'" style="width: 70px; height: 75px;"/>';?></center></td>
									  <td><?php echo $row_data['name']; ?><br>No. K/P : <?php echo $row_data['noic']; ?><br>No. H/P : <?php echo $row_data['phone']; ?></td>
									  <td width="30%"><?php echo $row_data['nama_peranan']; ?></td>
                                    <?php $i++; } ?>
									 
								</tbody>
	</table><br><br>
	<!-- Nota:<br></bod> <? echo $pic['terma_sebut_harga'];?><br><br> -->
	</div></div><br>
	<div class="grid-footer">
		
		
	</div>
	
   
	
</body>

</html>