<?php

	//include ('../controller/auth.php');
	
	require "../model/pemohon_functions.php";

?>



<?php
    $id = $_GET['no_staff'];
    $no_staff = $_GET['no_staff'];
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
	Ruj. Kami : <? echo $com['short_name'];?>/<? echo $info['peranan'];?>/COMPLETION/<? echo $date_year?>/<?  echo $list['noic'] ;?><br>
	Tarikh<span class="a"></span> : <? echo date("d",strtotime($info['tarikh_akhir']));?> <? echo getMonthString(date("n",strtotime($info['tarikh_akhir'])));?> <? echo date("Y",strtotime($info['tarikh_akhir']));?>
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
    <tr>
	<td colspan="3">
	<u><b>SURAT PENGESAHAN TAMAT LATIHAN INDUSTRI</b></u><br><br>
	Dengan ini disahkan bahawa <b><?  echo $list['name'] ;?> (<?  echo $list['noic'] ;?>)</b> telah tamat menjalani <b>Sesi Latihan Industri</b> dengan jayanya di <b><? echo $com['name'];?></b>
	sebagai <?  echo $info['myjawatan'] ;?> bermula pada tarikh <b><? echo date("d",strtotime($info['tarikh_mula']));?> <? echo getMonthString(date("n",strtotime($info['tarikh_mula'])));?> <? echo date("Y",strtotime($info['tarikh_mula']));?></b> hingga <b><? echo date("d",strtotime($info['tarikh_akhir']));?> <? echo getMonthString(date("n",strtotime($info['tarikh_akhir'])));?> <? echo date("Y",strtotime($info['tarikh_akhir']));?></b>.<br><br>
	Disepanjang tempoh menjalani sesi latihan industri ini, <?  echo $list['name'] ;?> telah berjaya melaksanakan tugasan yang telah diberikan dan menunjukkan komitmen yang cemerlang sebagai pelatih industri.<br><br>
	Secara keseluruhan, <b><?  echo $list['name'] ;?></b> telah memenuhi kriteria sebagai pelatih industri sepanjang tempoh latihan bersama <b><? echo $com['name'];?></b>.
					
	
	</td>
	</tr>
	 <tr>
	<td colspan="3"><br>
	Sekian, Terima Kasih.
	<br><br><b><? echo $com['tagline'];?></b><br><br><? echo $com['slogan'];?><br>	
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory_hr'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name_hr'];?></b><br><? echo $com['authorized_position_hr'];?><br> <b><? echo $com['name'];?></b>
	    </td>
	</tr>
	
   </table>
	
</body>

</html>