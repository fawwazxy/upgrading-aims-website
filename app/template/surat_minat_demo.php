<?php

	//include ('../controller/auth.php');
	
	

	require "../model/surat_function.php";

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
	
	<? require "../../resources/css/surat.css";?>


<script language="javascript" type="text/javascript">


</script>

</head>

<body>
   <table width="100%" id="dataTables-example">
			<? 		
				$pic = getLeadInformation($_GET['lead']);
				$list = getProdukInformation($_GET['produk']);
				$surat = getSuratInformation($_GET['surat']);
				$com = getCompany()->fetch_assoc();
				$tarikh = getTarikh($_GET['created_date'])->fetch_assoc();
						
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
    <tr>
	<td >
	
	
	<b><? 
					  echo $pic['pic_name'] ;
					?></b>
					<br>
					<? 
					  echo $pic['pic_position'] ;
					?>
					<br><b>
					<? 
					  echo $pic['lead_name'] ;
					?></b><br>
					<? 
					  echo $pic['lead_address'] ;
					?>
	<br><br>				
	Assalamu'alaikum w.b.t,<br>YBrs Tuan/Puan,
	</td>
	<td >
	&nbsp;<span></span><span></span><span></span><span></span>
	</td>
	<td align="left" >
	<br>				
	<span></span>Ruj. Kami : <? echo $com['short_name'];?>/<? echo $list['code'] ?>/<? echo $surat['code']?>/<? echo $pic['lead_shrtname']?>/<? echo $date_year?>/<? echo getRunningNo($pic['id']);?><br>
	   <span></span>Tarikh<span class="a"></span> : <? echo date("d",strtotime($tarikh['created_date']));?> <? echo getMonthString(date("n",strtotime($tarikh['created_date'])));?> <? echo date("Y",strtotime($tarikh['created_date']));?>
	</td>
	
	</tr>
    <tr><br>
	<td colspan="3"><br>
	<b>SURAT MINAT : CADANGAN MELAKSANAKAN SESI DEMO <? echo $list['produk']?> </b><br><br>
	Salam takzim serta doa kami dahulukan semoga YBrs Tuan/Puan, sekeluarga sentiasa sihat sejahtera disamping keluarga tersayang, Insha Allah.<br><br>
	Sukacita dimaklumkan syarikat <? echo $com['name'];?> bercadang untuk melaksanakan <b font style="text-transform: uppercase;">" Sesi Pembentangan dan demo <? echo $list['produk'] ?> "</b>.<br><br>
	2.<span></span><b><? echo $com['name'];?></b> adalah sebuah syarikat pembangun perisian bumiputera tempatan yang berpengkalan di Kota Bharu, Kelantan telahpun membangunkan sebuah perisian <? echo $list['produk'];?>.
	<? echo $list['desc']?></br></br>
	3.<span></span>Sehubungan dengan itu, Kami amat berbesar hati sekiranya diberi ruang dan peluang bagi perkara ini dan memohon sokongan
	serta kebenaran dari YBrs Tuan/Puan. Tarikh dan masa sesi temujanji ini adalah mengikut kesesuaian dan jadual pihak  Tuan/Puan.<br><br>
	Di atas sokongan dan kelulusan yang diberikan amatlah dihargai dan didahului dengan ucapan jutaan terima kasih.<br><br>Sekian.
	<br><br><b><? echo $com['tagline'];?></b><br><br><? echo $com['slogan'];?><br><br>
</td>
	</tr>
	 <tr>
	<td colspan="3" valign="top"> 
			Yang Benar,<br>
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory_sales'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name_sales'];?></b><br><? echo $com['authorized_position_sales'];?><br> <b><? echo $com['name'];?></b>
		</td>
		
	
	</tr>
	
   </table>
	
</body>

</html>