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

<head>

    <meta charset="utf-8">
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
	
	<strong><h3 align='right'>PESANAN PENGHANTARAN</h3>
	<h5 align='right'>No. Pesanan Penghantaran: <? echo  str_replace("INB","DO",$pic['norujukan_inbois']);?></h5></strong>
	<h5 align='right'>Tarikh: <? echo $pic['tarikh_jana_inbois'] ;?></h5>
	<h5 align='right'>Oleh: <? echo $com['name'] ;?></h5>
   
   </td>
   </tr>
    <tr>
	<td colspan="3"><br>
     Dihantar Kepada<br>
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
	<b>PERKARA  : PESANAN PENGHANTARAN  <? echo strtoupper( $pic['tajuk_sebut_harga'] ) ;?> </b><br><br>
	<table width="100%" class="table table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>No</th>
										<th>Keterangan</th>
										<th>Unit/Kuantiti</th>
									
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
									  
									 </tr>
                                    <?php $i++; } ?>
								
								</tbody>
	</table>
	</td>
	<tr>
		<td colspan="3" valign="top"> 
		
		    Dikeluarkan Oleh:<br>
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name'];?></b><br><? echo $com['authorized_position'];?><br> <b><? echo $com['name'];?></b>
		</td>
		
	</tr>
	
   </table>
	
</body>

</html>