<?php

	//include ('../controller/auth.php');
	
	

	require "../model/niaga_function.php";

?>



<?php

$id = $_GET['id'];
function baki($no1,$no2){
    $result=no1-no2;
    return $result;
    
}
?>
<?
	date_default_timezone_set("Asia/Kuala_lumpur");
	$date = new DateTime();
?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
	
	<? require "../../resources/css/niaga.css";?>


<script language="javascript" type="text/javascript">


</script>

</head>

<body>
   <table width="100%" id="dataTables-example">
			 <? 		
				$pic = getInboisInfo($id)->fetch_assoc();
                $list = getBayaranInfo($id)->fetch_assoc();
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
		
	<strong><h3 align='right'>INBOIS</h3>
	<h5 align='right'>No. Inbois: <? echo $pic['norujukan_inbois'] ;?></h5></strong>
	<h5 align='right'>Tarikh: <? echo $tarikh_semasa; ?><? //echo $pic['tarikh_jana_inbois'] ;?></h5>
	<h5 align='right'>Oleh: <? echo $com['name'] ;?></h5>
    <h5 align='right'>Status: 
        <?
        if($pic['status_inbois']== 0 ){
            echo "<strong>BELUM DIJELASKAN</strong>";
        }
        else {
            echo "<strong>TELAH DIJELASKAN</strong>";
        }
        ?>
        </h5>
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
	<b>PERKARA  : INBOIS TUNTUTAN BAYARAN <? echo strtoupper($pic['tajuk_sebut_harga']) ;?> </b><br><br>
	<table width="100%" class="table table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>No</th>
										<th>Keterangan</th>
										<th>Unit/<br>Kuantiti</th>
										<th>Harga<br>(RM)</th>
										<th>Jumlah<br>(RM)</bo> </th>
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
									  <td><?php echo number_format($row_data['jumlah_harga_item'],2); ?></td>
									 </tr>
                                    <?php $i++; } ?>
									 <tr>
										<td colspan="3">&nbsp;</td>
										<td align="right" nowrap>Jumlah (RM):<br><br>Bayaran Terdahulu (RM):<br><br>Baki (RM):</td>
										<td nowrap>
										    <?
										        $jumlah_harga = $pic['jumlah_sebut_harga'];
										        $jumlah_dah_bayar = $list['jumlah_dah_bayar'];
										        $baki_bayaran = $jumlah_harga - $jumlah_dah_bayar;
										        
										    ?>
										    <? echo number_format($pic['jumlah_sebut_harga'],2);?><br><br>
										    <? echo number_format($list['jumlah_bayaran'],2) ;?><br><br>
										    <? //echo number_format(baki($row_data['jumlah_harga_item'],$list['jumlah_bayaran']))?>
										    <? echo number_format($baki_bayaran,2);?>
										</td>
									</tr>
								</tbody>
	</table><br>
	<strong>Keterangan Akaun Bank:</strong><br>
	Nama Bank: <b><? echo $com['bank_name'];?></b>&nbsp;&nbsp;&nbsp;Nama Akaun: <b><? echo $com['bank_account_name'];?></b>&nbsp;&nbsp;&nbsp;No. Akaun: <b><? echo $com['bank_account_no'];?></b>
	<br><br>
	Nota Kaki:<br> <? echo $pic['terma_sebut_harga'];?><br><br>
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
               $status_jawapan = $pic['status_penerimaan_inbois'] ;
               // echo $status_jawapan;
                
            ?>
            <? if($status_jawapan==0) {?>
				
				 Pengesahan Penerimaan<br><br><br><br><br><br>
                <a href="../controller/pengesahan_inbois_exec.php?id=<? echo $id?>&status=<? echo 1?>&tarikh=<? echo $date->format('Y-m-d H:i:s');?>"<button type="submit" class="btn btn-primary" onclick="return Confirm()" >TERIMA</button></a>
            
            <? } 
                if($status_jawapan==1){
					echo "Diterima Oleh:<br><br><br><br><br><br>";
                    //echo "Status Penerimaan: <b>TERIMA</b>";
                   
            ?><br>   
        
        Nama: <? echo $pic['nama_rujukan'] ;?><br>
        <!--Tarikh:--> <? //echo $tarikh_semasa; ?><? //echo $pic['tarikh_terima_inbois']; ?>
	         <? } ?>         
            
            
 <br><br>Cetakan berkomputer. Tandatangan tidak diperlukan. 
	    </td>
	</tr>
	
   </table>
	
</body>

</html>