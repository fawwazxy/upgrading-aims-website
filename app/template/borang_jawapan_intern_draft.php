<?php

	//include ('../controller/auth.php');
	require "../model/pemohon_functions.php";

?>



<?php
$id = $_GET['id'];
$noic = $_GET['noic'];

 
   



function bulan($date1, $date2)
{
    $first = DateTime::createFromFormat('m/d/Y', $date1);
    $second = DateTime::createFromFormat('m/d/Y', $date2);
    if($date1 > $date2) return bulan($date2, $date1);
    $week = floor($first->diff($second)->days/7);
	$bulan = ceil($week/4);
	return $bulan;
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
    <? require "../../resources/css/surat.css";?>
<script language="javascript" type="text/javascript">


</script>
<style type="text/css">
@media print {
    #printbtn {
        display :  none;
    }
}
</style>

</head>

<body>
   <table width="100%" id="dataTables-example">
			  <? 
		$list = getPemohonKelulusan($id)->fetch_assoc();
		$com = getCompany()->fetch_assoc();
		
		$dt1 = date("m/d/Y",strtotime($list['tarikh_start']));
		$dt2 =  date("m/d/Y",strtotime($list['tarikh_tamat']));
		
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
    Ruj. Kami : <? echo $com['short_name'];?>/<? echo $list['peranan'];?>/OFFER/<? echo $date_year?>/<? echo getRunningNo($id);?><br>
	Tarikh<span class="a"></span> : <? echo date("d",strtotime($list['tarikh_jawapan']));?> <? echo getMonthString(date("n",strtotime($list['tarikh_jawapan'])));?> <? echo date("Y",strtotime($list['tarikh_jawapan']));?>
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
	<u><b>BORANG JAWAPAN TAWARAN PENEMPATAN PELAJAR LATIHAN INDUSTRI</b></u><br><br>
	Dengan hormatnya, perkara di atas adalah dirujuk dan surat tuan/puan bernombor rujukan <b><? echo $list['no_rujukan'];?></b> bertarikh <b><? echo $list['tarikh_rujukan'];?></b> adalah berkaitan.<br><br>
	2. Adalah dengan ini, kami <b>BERSETUJU</b> untuk menerima pelajar berikut:-<br><br>
</td>
</tr>
</table>
<table>
<tr>
	<td valign="top" nowrap>Nama Pelajar</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<? echo $list['name']?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>No. Kad Pengenalan</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<? echo $list['noic']?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>No. Matrik</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<? echo $list['nomatrik']?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>Program</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<? echo $list['program']?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>Jangkamasa/Tempoh</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<? echo $list['tempoh']?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>Alamat Penempatan<br>(jika setuju terima)</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;<? echo $com['address'];?></b></td>
</tr>
<tr>
	<td valign="top" nowrap>Penyelia Industri</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;Akan dimaklumkan semasa tarikh lapor diri</b></td>
</tr>
<tr>
	<td valign="top" nowrap>Elaun Latihan</td>
	<td valign="top">&nbsp; :</td>
	<td valign="top"><b>&nbsp;TIADA</b></td>
</tr>
</table>
<br><br>
<table width="100%" id="dataTables-example">
	 <tr>
	<td valign="top" colspan="2" nowrap> 
		Sekian, Terima Kasih.
		<br><br><b><? echo $com['tagline'];?></b><br><br><? echo $com['slogan'];?><br>	
			<? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
			<? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory_hr'] ).'"/>'; ?> <br><br><br><br><br>
			<b><? echo $com['authorized_name_hr'];?></b><br><? echo $com['authorized_position_hr'];?><br> <b><? echo $com['name'];?></b>
		</td>
	<td width="150px">&nbsp;&nbsp;</td>
	<td  valign="top" > 
		<u><b>PENGAKUAN DAN PENERIMAAN OLEH PELAJAR</b></u><br><br>

            Saya <b><?  echo $list['name'] ;?></b> Nombor Kad Pengenalan <b><?  echo $list['noic'] ;?></b> menerima tawaran penempatan latihan industri di organisasi/ syarikat tuan/puan dan akan
            mematuhi segala peraturan organisasi/ syarikat dan universiti. Dengan penerimaan tawaran
            penempatan ini, saya tidak akan membuat permohonan lain dimana-mana organisasi/
            syarikat.<br><br>
            
            <? 
               $status_jawapan = $list['status_jawapan'] ;
               // echo $status_jawapan;
                
            ?>
            <? if($status_jawapan==0) {?>
                <a href="../controller/pengesahan_intern_exec.php?id=<? echo $id?>&status=<? echo 1?>&tarikh=<? echo $date->format('Y-m-d H:i:s');?>" id ="printbtn" ><button type="submit" class="btn btn-primary" onclick="return Confirm()">Saya Menerima Tawaran Ini</button></a>
            
            <? } 
                if($status_jawapan==1){
                    echo "Status Penerimaan: <b>TERIMA</b>";
                   
            ?><br>                            
Tandatangan: <?  echo $list['name'] ;?> (<?  echo $list['noic'] ;?>)<br>
Tarikh Penerimaan Tawaran: <?  echo $list['tarikh_jawapan'] ;?><br><br>
              
           <? } ?>         
            
            
 <br>Surat ini adalah cetakan berkomputer. Tandatangan tidak diperlukan. 
		</td>
		
	</tr>
	
   </table>
	
</body>

</html>