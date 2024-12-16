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
				$pic = getSebuthargaIfo($id)->fetch_assoc();
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
	
	<strong><h3 align="right">SEBUTHARGA</h3>
	<h5 align="right">No.SebutHarga: <? echo $pic['norujukan_sebut_harga'] ;?></h5></strong>
	<h5 align="right">Tarikh: <? echo $pic['tarikh_jana_sebut_harga'] ;?></h5>
	<h5 align="right">Sah Dalam Tempoh: <? echo $pic['tempoh_sah_sebut_harga'] ;?> hari</h5>
	
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
	<b>PERKARA  : SEBUTHARGA  <? echo strtoupper($pic['tajuk_sebut_harga']) ;?> </b><br><br>
	<table width="100%" class="table table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>No</th>
										<th>Keterangan</th>
										<th>Unit/Kuantiti</th>
										<th>Harga (RM)</th>
										<th>Jumlah (RM) </th>
									</tr>
								</thead>
								<tbody>
                                    <?
                                   
                                    $id_harga = $pic['id_sebut_harga'] ;                                                  
									$i= 1;
									$data = getItem($id_harga);
									while($row_data = $data->fetch_assoc()) {
									
								?>
									<tr>
									  <td><? echo $i ?></td>
									  <td><?php echo $row_data['keterangan_item']; ?></td>
									  <td><?php echo $row_data['kuantiti_item']; ?> </td>
									  <td><?php echo number_format($row_data['harga_item'],2); ?></td>
									  <td><?php echo number_format ($row_data['jumlah_harga_item'],2); ?></td>
									 </tr>
                                    <?php $i++; } ?>
									 <tr>
										<td colspan="3"> &nbsp </td>
										<td align="right"><b> Jumlah (RM)</b></td>
										<td><b><u><? echo number_format($pic['jumlah_sebut_harga'],2);?></u></b></td>
									</tr>
								</tbody>
	</table><br><br>
	Nota:<br> <? echo $pic['terma_sebut_harga'];?><br><br>
	</td></tr><br>
	<tr>
		<td colspan="2" valign="top"> 
		
		    Dikeluarkan Oleh:<br>
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory_sales'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name_sales'];?></b><br><? echo $com['authorized_position_sales'];?><br> <b><? echo $com['name'];?></b>
		</td>
		<td valign="top"> 
		
		 <? 
               $status_jawapan = $pic['status_penerimaan_sebut_harga'] ;
               // echo $status_jawapan;
                
            ?>
            <? if($status_jawapan==0) {?>
				
				 Pengesahan Penerimaan<br><br><br><br><br><br>
                <a href="../controller/pengesahan_sebutharga_exec.php?id=<? echo $id?>&status=<? echo 1?>&tarikh=<? echo $date->format('Y-m-d H:i:s');?>"<button type="submit" class="btn btn-primary" onclick="return Confirm()" >TERIMA</button></a>
            
            <? } 
                if($status_jawapan==1){
					echo "Diterima Oleh:<br><br><br><br><br><br>";
                    echo "Status Penerimaan: <b>TERIMA</b>";
                   
            ?><br>   
        
        Nama:<? echo $pic['nama_rujukan'] ;?><br>
        Tarikh:<? echo $pic['tarikh_penerimaan_sebut_harga']; ?>
	         <? } ?>         
            
            
 <br><br>Cetakan berkomputer. Tandatangan tidak diperlukan. 
	    </td>
	</tr>
	
   </table>
	
</body>

</html>