<?php

	//include ('../controller/auth.php');
	
	

	require "../model/perbelanjaan_functions.php";

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
				$pic = getBelanjaInfo($id)->fetch_assoc();
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
	
	<strong><h3 align="right">BAUCAR BAYARAN</h3>
	<h5 align="right">No.Rujukan: <? echo $pic['no_rujukan'] ;?></h5></strong>
	<h5 align="right">Tarikh: <? echo $pic['tarikh_bayaran_dibuat'] ;?></h5>
	
   </td>
   </tr>
    <tr>
	<td colspan="3"><br>
    Untuk Perhatian<br>
	<b><? 
					  echo $pic['penerima_baucar'] ;
					?></b>
					<br>
					<b>
					<? 
					 // echo $pic['agensi_rujukan'] ;
					?></b><br>
					<? 
					 // echo $pic['alamat_rujukan'] ;
					?>
	<br><br>				
	
	</td>
	</tr>
	 <tr>
	<td colspan="3">
	<b>PERKARA  : BAUCAR BAYARAN  <? echo strtoupper($pic['perbelanjaan_baucar']) ;?> </b><br><br>
	<table width="100%" class="table table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>No</th>
										<th>Keterangan</th>
										<th>Penerima Baucar</th>
										<th>Harga (RM)</th>
									</tr>
								</thead>
								<tbody>
                                    <?
                                   
                                    $amaun_bayaran = $pic['amaun_bayaran'] ;                                                  
									$i= 1;
									$data = getBaucarBayaran($id);
									while($row_data = $data->fetch_assoc()) {
									
								?>
									<tr>
									  <td><? echo $i ?></td>
									  <td>
									  	  PEMBAYARAN <?php echo $row_data['perbelanjaan']; ?><br>
									  	  KAEDAH BAYARAN : <?php echo $row_data['nama']; ?><br>
									  	  NOTA : <?php echo $row_data['catatan']; ?>

									  </td>
									  <td><?php echo $row_data['penerima_baucar']; ?> </td>
									  <td><?php echo number_format($row_data['total_baucar'],2); ?></td>
									 
									 </tr>
                                    <?php $i++; }?>
									 <tr>
										<td colspan="2"> &nbsp </td>
										<td align="right"><b> Jumlah (RM)</b></td>
										<td><b><u><? echo number_format($pic['amaun_bayaran'],2);?></u></b></td>
									</tr>
								</tbody>
	</table><br><br>
	<br>
	</td></tr><br>
	<tr>
		<td colspan="2" valign="top"> 
		
		    Dikeluarkan Oleh:<br>
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory_account'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name_account'];?></b><br><? echo $com['authorized_position_account'];?><br> <b><? echo $com['name'];?></b>
		</td>
		<td valign="top"> 
		
		 <? 
              $status_jawapan = $pic['status'] ;
               //echo $status_jawapan;
                
            ?>
            <? if($status_jawapan==0) {?>
				
				  Pengesahan Penerimaan<br><br><br><br><br><br>
                <a href="../controller/pengesahan_baucar_exec.php?id=<? echo $id?>&status=<? echo 1?>"<button type="submit" class="btn btn-primary" onclick="return Confirm()">TERIMA</button></a>

            <?} if ($status_jawapan==1){
            	    echo "Diterima Oleh:<br><br><br><br><br><br>";
                    echo "Status Penerimaan: <b>TERIMA</b>";
            ?>
           <br>   
        
        Nama:  <? echo $pic['penerima_baucar'] ;?><br>
        Tarikh:  <? echo $pic['tarikh_bayaran_dibuat']; ?>
	               
            <?}?>
            
 <br><br>Cetakan berkomputer. Tandatangan tidak diperlukan. 
	    </td>
	</tr>
	
   </table>
	
</body>

</html>