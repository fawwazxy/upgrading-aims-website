<?php

	//include ('../controller/auth.php');
	
	require "../model/pemohon_functions.php";

?>



<?php
    $id = $_GET['no_staff'];
    $no_staff = $_GET['no_staff'];
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_month = date(m);
	$date_months = date(mm);
	$date_year = date(Y);
	$date_day = date(d);
	$time_hour = date(H);
	$time_min = date(i);
	$time_sec = date(s);
    
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
    <? require "../../resources/css/surat.css";?>
<script language="javascript" type="text/javascript">


</script>

</head>

<body>
   <table width="100%" id="dataTables-example">
		<? 
		$list = getStaffInfo($no_staff);
		$com = getCompany()->fetch_assoc();
		$info= getStaffRecord($id);
	
        $nostaff = $list['no_staff'];
		$recordservice_start = getRecStart($nostaff) -> fetch_assoc();
		$recordservice_end = getRecEnd($nostaff) -> fetch_assoc();
		$enddate = $recordservice_end['tarikh_akhir'];
		$endyear =  $recordservice_end['tahun_berhenti'];
		
		
		?>
		<tr>
	<td width="150px" valign="bottom">
	<? 
					echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"/>';
					 ?>
	
	</td>
	<td colspan="2">
	
	<strong><h3 align="right"><? echo $com['name'];?></h3>
	<h4 align="right"><? echo $com['registration_no'];?></h4></strong>
	<h5 align="right"><? echo $com['address'];?></h5>
	<h6 align="right">No. Telefon: <? echo $com['tel'];?> | Emel: <? echo $com['email'];?> | Website : <? echo $com['website'];?></h6>
   </td>
   </tr>
   </table>
   <table width="100%" id="dataTables-example">
    <tr>
	<td colspan=2 width="60%">
	<b><br><br><br>
	Kepada yang berkenaan, 
	</b><br>
	</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
    <td nowrap>			
	Ruj. Kami : <? echo $com['short_name'];?>/RESIGNED/VERIFY/<? echo $endyear?>/<?  echo $list['noic'] ;?><br>
	Tarikh<span class="a"></span> : <? echo date("d");?> <? echo getMonthString(date("n"));?> <? echo date("Y");?>
	</td>
   </tr>
   <table width="100%" id="dataTables-example">
	<br>
	<tr>
	<td>Assalamu'alaikum w.b.t.<br><br>Tuan/Puan,<br><br></td>
	<td align="left" >&nbsp;</td>
	</tr>
	</table>
	<table width="100%" id="dataTables-example">
    <table>
    <tr>
	<td colspan="3">
	<u><b>SURAT KETERANGAN BERHENTI BEKERJA</b></u><br><br>
	Adalah yang bertanda tangan seperti di bawah ini menerangkan bahawasanya;<br><br>
</td>
</tr>
</tr>
<tr>
	<td valign="top" nowrap>Nama</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<?  echo $list['name'] ;?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>No. Kad Pengenalan</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<?  echo $list['noic'] ;?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>Alamat</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<?  echo $list['alamat_tetap'] ;?></b></td>
</tr>
<tr>
	<td colspan="3">
	<br>Adalah benar bahawa penama seperti yang dinyatakan di atas adalah merupakan kakitangan kami yang telah bekerja mulai tanggal <b>
	<? echo $recordservice_start['tarikh_mula'];?></b> hingga tanggal <b><? echo $recordservice_end['tarikh_akhir'];?></b> di <b><? echo $com['name'];?></b>.<br><br> 
	Penama ini telah menamatkan perkhidmatan dan berhenti bekerja selepas pada tempoh yang telah dinyatakan tersebut.
</td>
</tr>
<tr>
	<td colspan="3">
	<br>Demikian surat keterangan ini agar dapat dipergunakan sebagaimana mestinya.
</td>
</tr>
</table>
<br>
<table width="100%" id="dataTables-example">
	 <tr>
	<td colspan="3"><br>
	Sekian, Terima Kasih.
	<br><br><b><? echo $com['tagline'];?></b><br><br><? echo $com['slogan'];?><br>	
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name'];?></b><br><? echo $com['authorized_position'];?><br> <b><? echo $com['name'];?></b>
	    </td>
	</tr>
	
   </table>
	
</body>

</html>