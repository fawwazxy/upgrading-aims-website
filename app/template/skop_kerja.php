<?php

	//include ('../controller/auth.php');
	require "../model/lkp_function.php";

?>



<?php

//$id = $_GET['id'];
echo $id = $_GET['com_id'];
$skopid = $_GET['skopid'];
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
	    
		
	    $com = getCompany($id)->fetch_assoc();
		$list = getPrintSkopKerja($skopid)->fetch_assoc();
	 
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
	<b><br><br><br>
	Kepada yang berkenaan, 
	</b><br>
	     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<td nowrap align="right">				
	Ruj. Kami : <? echo $com['short_name'];?>/<? echo $list['role'] ?>/JOBSCOPE/<? echo $date_year?><br>
	Tarikh: <? echo date("d",strtotime($list['created_date']));?> <? echo getMonthString(date("n",strtotime($list['created_date'])));?> <? echo date("Y",strtotime($list['created_date']));?>
   </td>
   </tr>
   <table width="100%" id="dataTables-example">
	<br>				
	Assalamu'alaikum w.b.t,<br><br>Saudara/Saudari,
	</td>
	<td >
	&nbsp;<span></span><span></span><span></span><span></span>
	</td>
	<td align="left" >&nbsp;</td>
	</tr>
    <tr>
	<td colspan="3"><br>
	<u><b>SKOP KERJA DAN TUGASAN - <? echo $list['role'] ;?></b></u><br><br>
	Skop Kerja dan Tugasan yang perlu dilaksanakan oleh saudara/i di sepanjang tempoh berada di <b><? echo $com['name'];?></b> adalah seperti berikut:<br><br><br>
	<span></span>
		<table width="100%">
			<tr>
				<td><? echo $list['keterangan'] ?></td>
			</tr>
		</table>
	
	<br><br><br>
	</td>
	</tr>
	 <tr>
	<td colspan="3">
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