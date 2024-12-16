<?php

	//include ('../controller/auth.php');
	require "../model/pemohon_functions.php";

?>



<?php

$id = $_GET['pemohon_id'];
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
	    
		$tarikh_masa= getTarikhMasaIv($id)->fetch_assoc();
	    $com = getCompany()->fetch_assoc();
		$list = getPemohon($id)->fetch_assoc();
	 
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
	<td colspan=2>
	<b><br><br>
	<?
		 echo $list['name']."<br> (".$list['noic'].")" ;
	?> </b><br>
	<? 
		 echo $list['alamat_surat'] ;
	?>
   <td nowrap>				
	Ruj. Kami : <? echo $com['short_name'];?>/<? echo $list['role_id'] ?>/NOTSELECTED/<? echo $date_year?>/<? echo getRunningNo($id);?><br>
	Tarikh: <? echo date("d",strtotime($tarikh_masa['created_date']));?> <? echo getMonthString(date("n",strtotime($tarikh_masa['created_date'])));?> <? echo date("Y",strtotime($tarikh_masa['created_date']));?>
   </td>
   </tr>
   <table width="100%" id="dataTables-example">
	<br>				
	Assalamu'alaikum w.b.t,<br>Saudara/Saudari,
	</td>
	<td >
	&nbsp;<span></span><span></span><span></span><span></span>
	</td>
	<td align="left" >&nbsp;</td>
	</tr>
    <tr>
	<td colspan="3"><br>
	<u><b>SURAT MAKLUMAN PERMOHONAN TIDAK BERJAYA</b></u><br><br>
	Salam takzim serta doa kami dahulukan semoga saudara/i sekeluarga sentiasa sihat sejahtera disamping keluarga tersayang. Inshaa Allah.<br>
	Terima kasih kerana telah membuat permohonan perjawatan kepada kami. Namun begitu, dukacita dimaklumkan bahawa permohonan saudara/i tidak terpilih untuk disenaraipendek bagi proses selanjutnya.<br>
	<span></span>
	
	</td>
	</tr>
	 <tr>
	<td colspan="3">
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