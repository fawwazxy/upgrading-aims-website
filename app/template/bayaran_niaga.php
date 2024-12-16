<?php

	//include ('../controller/auth.php');
	
	

	require "../model/niaga_function.php";

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
	
	<? require "../../resources/css/niaga.css";?>
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
   <table width="100%" id="dataTables-example">
			  <? 		
				$pic = getBayaranInfoResit($id)->fetch_assoc();
				$com = getCompany()->fetch_assoc();
				
						
	?>
	<tr>
	<td width="150px" valign="bottom">
	<? 
					echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"/>';
					 ?>
	
	</td>
	<td>
	
	<strong><h3 align="left"><? echo $com['name'];?></h3>
	<h4 align="left"><? echo $com['registration_no'];?></h4></strong>
	<h5 align="left"><? echo $com['address'];?></h5>
	<h6 align="left">No. Telefon: <? echo $com['tel'];?> | Emel: <? echo $com['email'];?> | Website : <? echo $com['website'];?></h6>
   </td>
   <td valign="top">
		
	
	<strong><h3 align='right'>RESIT BAYARAN</h3>
	<h5 align='right'>No. Resit: <? echo $pic['norujukan_bayaran'] ;?></h5></strong>
	<h5 align='right'>Tarikh: <? echo $tarikh_semasa; ?><? //echo $pic['tarikh_jana_bayaran'] ;?></h5>
    
   </td>
   </tr>
    <tr>
	<td colspan="3"><br>
    Untuk Perhatian<br>
	<b><? 
					  echo $pic['nama_rujukan'] ;
					?></b>
					<br>
					<b>
					<? 
					  echo $pic['agensi_rujukan'] ;
					?></b><br>
					<? 
					  echo $pic['alamat_rujukan'] ;
					?>
	<br><br>				
	
	</td>
	</tr>
	 <tr>
	<td colspan="3">
	<b>PERKARA  : RESIT BAYARAN  <? echo strtoupper( $pic['tajuk_sebut_harga']) ;?> </b><br><br>
	<table width="100%" class="table table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Tarikh Bayaran</th>
										<th>No. Inbois</th>
										<th>Keterangan</th>
										<th>Jumlah (RM)</th>
									</tr>
								</thead>
								<tbody>
                                    <?
                                   
                                    $id_harga = $pic['id_sebut_harga'] ;                                                  
									$i= 1;
									$data = getItem($id_harga);
                                    $data1=getBayaranInfoResit($id)->fetch_assoc();
                                                                                        
									
									
								?>
                                                                                        
									<tr>
									  
									  <td nowrap><?php echo $data1['tarikh_bayaran']; ?></td>
									  <td><?php echo $data1['norujukan_inbois']; ?> </td>
									  <td><? while($row_data = $data->fetch_assoc()) {?>
                                            <?php echo $row_data['keterangan_item']; ?> x <?echo $row_data['kuantiti_item'];?> unit x <?php echo $row_data['harga_item']; ?><br><?}?></td>
									  <td><?php echo number_format($pic['jumlah_sebut_harga'],2); ?></td>
									 </tr>
                                     <tr>
                                         
										<td colspan="3" align="right"><b>Bayaran Terdahulu (RM):</b></td>
										
										<td> <b><? echo number_format(getBayaranTerdahulu($pic['id_inbois'],$id),2);?></b> </td>
									</tr>
									<tr>
                                         
										<td colspan="3" align="right"><b> Jumlah Yang Dibayar (RM):</b></td>
										
										<td> <b><? echo number_format($pic['jumlah_bayaran'],2);?></b> </td>
									</tr>
									<tr>
                                        <?
                                            $jumlah_harga = $pic['jumlah_sebut_harga'];
										    $jumlah_dah_bayar = getBayaranTerdahulu($pic['id_inbois'],$id);
										    $bayaran_semasa = $pic['jumlah_bayaran'];
										    $baki_bayaran = $jumlah_harga - ($jumlah_dah_bayar + $bayaran_semasa);
                                        
                                        ?> 
										<td colspan="3" align="right"><b> Baki Bayaran (RM):</b></td>
										
										<td> <b><u><? echo number_format($baki_bayaran,2);;?></u></b> </td>
									</tr>
                                    
								</tbody>
	</table>
	</td>
	<tr>
		<td colspan="2" valign="top"> 
		
		    Dikeluarkan Oleh:<br>
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory_account'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name_account'];?></b><br><? echo $com['authorized_position_account'];?><br> <b><? echo $com['name'];?></b><br>
		</td>
		
	</tr>
	
   </table>
	
</body>

</html>