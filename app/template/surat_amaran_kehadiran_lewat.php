<?php

	//include ('../controller/auth.php');
	require "../model/kehadiran_functions.php";

?>



<?php

$nokp = $_GET['nokp_staff'];
$no_staff = $_GET['no_staff'];
$amaran = strtoupper($_GET['amaran']);
$lewat = $_GET['lewat'];
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
<style type="text/css">
@media print {
  #html-content-holder {
    display: none;
  }
  #btn-Preview-Image {
    display: none;
  }
} 
table { page-break-inside:auto }
tr { page-break-inside:avoid; page-break-after:auto }

</style>
</head>

<body>
	<input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>

   <table width="100%" id="dataTables-example">
			  <?
	    
		//$tarikh_masa= getTarikhMasaIv($id)->fetch_assoc();
	    $com = getCompany()->fetch_assoc();
		$list = getStafInfo($nokp,$no_staff)->fetch_assoc();
	 
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
		 echo $list['role'] ;
	?><br>
	<? 
		 echo $list['alamat_surat'] ;
	?>
   <td nowrap>				
	Ruj. Kami : <? echo $com['short_name'];?>/<? echo $list['role_id'] ?>/WARNING/<? echo $date_year;?>/<? echo $amaran;?><br>
	Tarikh: <? echo date("d");?> <? echo getMonthString(date("n"));?> <? echo date("Y");?>
   </td>
   </tr>
   <table width="100%" id="dataTables-example">
	<br>				
	Assalamu'alaikum w.b.t,<br>Kepada yang berkenaan,
	</td>
	<td >
	&nbsp;<span></span><span></span><span></span><span></span>
	</td>
	<td align="left" >&nbsp;</td>
	</tr>
    <tr>
	<td colspan="3"><br>
	<u><b>SURAT AMARAN <?echo $amaran;?> LEWAT DATANG KERJA</b></u><br><br>
	Kami ingin memaklumkan Cik. <? echo $list['name'];?> bahawa anda telah kerap kali datang lewat ke tempat kerja. Sepanjang anda bekerja, anda telah pun lewat untuk log kehadiran sebanyak <b><? echo $lewat;?></b> kali.<br><br>
	Ini adalah rekod kedatangan anda :<br>
	<ol>
			<?
				$i= 1;
				$data = getMaklumatLewat($nokp,$no_staff);
				while($row_data = $data->fetch_assoc()) {
					echo "<li>".$row_data['tarikh']." - masa masuk :".$row_data['masa_masuk']." (Lewat selama ".$row_data['masa_lewat']." )</li>";
		}?>
	</ol>
	Kami dengan ini ingin memastikan semua pekerja <? echo $com['name']; ?> akur dengan etika kerja yang telah ditetapkan dengan serius. Letakkan keutamaan anda untuk hadir tepat pada waktunya ke tempat kerja.<br><br>
	Syarikat memandang serius berkenaan hal ini, oleh itu anda diminta untuk memastikan hal yang demikian tidak berulang lagi atau hukuman yang lebih keras akan dikenakan kepada anda.<br><br>
	<strong><p align="justify">"Demi masa. Sungguh manusia dalam kerugian, kecuali orang-orang yang beriman dan mengerjakan kebajikan serta saling menasihati untuk kebenaran dan saling menasihati untuk kesabaran."</p></strong>
	( Surah al-‘Asr, ayat 1 hingga 3)

	<span></span>
	
	</td>
	</tr>
	 <tr>
	<td colspan="3">
	<br><br><b><? echo $com['tagline'];?></b><br><br><? echo $com['slogan'];?><br>	
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name'];?></b><br><? echo $com['authorized_position'];?><br> <b><? echo $com['name'];?></b>

	    </td>
	</tr>
	
   </table>
	
</body>

</html>