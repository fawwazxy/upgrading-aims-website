<?php

	//include ('../controller/auth.php');
	require "../model/pemohon_functions.php";

?>



<?php
$id = $_GET['id'];
$noic = $_GET['noic'];

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
	

<script language="JavaScript" type="text/javascript">
function Confirm(){
    return confirm('Anda pasti ingin menerima tawaran ini?');
}

</script>
</head>

<body>
   <table width="100%" id="dataTables-example">
			  <? 
		$list = getPemohonKelulusan($id)->fetch_assoc();
		$com = getCompany()->fetch_assoc();
		
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
		 echo $list['name']." (".$list['noic'].")" ;
	?> </b><br>
	<? 
		 echo $list['alamat_surat'] ;
	?>
	<td nowrap>
    Ruj. Kami : <? echo $com['short_name'];?>/STAFF/OFFER/<? echo $list['peranan'];?>/<? echo $date_year?>/<? echo getRunningNo($id);?><br>
	Tarikh<span class="a"></span> : <? echo date("d");?> <? echo getMonthString(date("n"));?> <? echo date("Y");?>
	</td>
   </tr>
   <table width="100%" id="dataTables-example">
	<br>
	<tr>
	<td >Assalamu'alaikum w.b.t.<br>Saudara/Saudari,<br><br></td>
	<td align="left" >&nbsp;</td>
	</tr>
	</table>
	<table width="100%" id="dataTables-example">
    <tr>
	<td colspan="3">
	<u><b>SURAT TAWARAN PERJAWATAN </b></u><br><br>
	Merujuk perkara di atas, dengan sukacitanya syarikat <b><? echo $com['name'];?></b> ingin menawarkan jawatan sebagai <b><? echo $list['jawatan']?></b>  kepada saudara/i. Tarikh mula bekerja adalah pada <b><? echo date("d",strtotime($list['tarikh_mula']));?> <? echo getMonthString(date("n",strtotime($list['tarikh_mula'])));?> <? echo date("Y",strtotime($list['tarikh_mula']));?>.</b><br><br>
	Kami percaya bahawa pengetahuan, kemahiran dan pengalaman saudara/i akan menjadi antara aset kami yang paling berharga dan kehadiran saudara/i ke dalam organisasi ini amat dialu-alukan. <br><br>
	Terma serta syarat-syarat tawaran adalah seperti yang termaktub di bawah:<br><br>
	<b>1. Tempoh bekerja</b><br><br>
	Tempoh bekerja adalah <b>KONTRAK</b> , saudara/i akan melalui tempoh percubaan (probation) selama <b>3 BULAN</b> pertama dan <b>3 BULAN</b> kedua sebelum diserap masuk sebagai pekerja tetap di syarikat kami.<br><br><br>
	<b>2. Gaji dan elaun</b><br><br>
    Gaji yang ditawarkan adalah sebanyak <b>RM <? echo $list['gaji_dipersetujui']?> </b> . Sebarang kenaikan atau perubahan gaji jika perlu, akan dibincangkan bersama dengan pihak pengurusan selepas tamat tempoh percubaan.<br><br><br>
	<b>3. Potongan KWSP dan SOCSO</b><br><br>
	Potongan KWSP dan SOCSO akan dilakukan SELEPAS TAMAT TEMPOH PERCUBAAN iaitu selepas 6 BULAN tempoh perkhidmatan.<br><br><br>
	<b>4. Cuti tahunan</b><br><br>
	Tiada cuti tahunan sepanjang tempoh percubaan namun sekiranya saudara/i ingin memohon cuti, saudara/i hendaklah mengemukakan <b>borang permohonan cuti yang telah disediakan oleh pihak pengurusan 
	(cuti yang dipohon mestilah mendapat kelulusan oleh pihak pengurusan)</b> dan permohonan mestilah dibuat <b>2 HARI lebih awal</b> dan gaji akan ditolak selama mana cuti yang diambil. 
	Cuti yang dihadkan adalah <b>3 HARI SAHAJA DALAM TEMPOH SEBULAN</b>. Dan sekiranya cuti sakit, saudara/i hendaklah <b>mengemukakan sijil sakit (MC)</b> yang dikeluarkan oleh hospital atau klinik yang dilawati.<br><br><br>
     <b>5. Hari dan waktu bekerja</b><br>
	<table>
<tr>
	<td>Hari bekerja</td>
	<td>&nbsp; :</td>
	<td>&nbsp; Ahad – Khamis</td>
</tr>
<tr>
	<td>&nbsp; </td>
	<td>&nbsp; :</td>
	<td>&nbsp; Sabtu (minggu ke-2 dan minggu ke-4)</td>
</tr>
<tr>
	<td>Waktu bekerja		</td>
	<td>&nbsp; :</td>
	<td>&nbsp; 9 pagi – 6 petang</td>
</tr>
	<td>Waktu rehat		    </td>
	<td>&nbsp; :</td>
	<td>&nbsp; 1 petang – 2 petang</td>
</tr>
<tr>
	<td>Cuti			    </td>
	<td>&nbsp; :</td>
	<td>&nbsp; Jumaat & Sabtu (minggu ke-1 dan minggu-3)</td>
</tr>
</table>
<p style="page-break-after: always;">&nbsp;</p>
<br><br>
	<b>6. Tugas dan tanggungjawab</b><br><br>
	Tugas dan tanggungjawab saudara/i adalah seperti yang dibincangkan bersama pihak pengurusan. Sebarang perubahan dan tambahan tugas akan dibincangkan dari semasa ke semasa. 
	Kami yakin saudara/i mampu menggalas tugas yang diberikan. Walau bagaimanapun, jika saudara/i menghadapi sebarang kesulitan, saudara/i dialu-alukan untuk merujuk kepada pihak
	pengurusan dan memaklumkan kepada ketua unit masing-masing .<br><br><br>
	<b>7. Penamatan Kerja</b><br><br>
    Sepanjang tempoh perkhidmatan ini, kedua-dua pihak boleh menamatkan perkhidmatan melalui pemberian <b>NOTIS 2 MINGGU LEBIH AWAL</b>. Denda <b>RM1,000</b> akan dikenakan ke atas saudara/i jika saudara/i gagal mengemukakan notis tersebut dan denda juga akan 
	dikenakan ke atas pihak pengurusan sebanyak <b>RM1,000</b> jika pihak pengurusan gagal mengemukakan notis penamatan kerja terhadap saudara/i dalam tempoh tersebut.<br><br><br>
	<b>8. Khas</b><br><br>
	Sekiranya didapati prestasi saudara/i tidak baik ataupun ditangkap mencuri atau merompak atau dituduh dan dihukum kerana dadah atau telah dinilai sebagai <b>‘incompetent’</b> oleh pihak pengurusan, pihak pengurusan berhak memberhentikan saudara/i tanpa sebarang notis atau pembayaran gaji atau elaun dalam tempoh percubaan..<br><br>
	</td></tr>
	</table>
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
		<u><b>PENGAKUAN DAN PENERIMAAN</b></u><br><br>

            Saya <b><?  echo $list['name'] ;?></b> nombor kad pengenalan <b><?  echo $list['noic'] ;?></b> dengan ini menerima dan bersetuju dengan terma dan syarat yang termaktub dalam perjanjian ini.<br><br><br><br>
            
            <? 
               $status_jawapan = $list['status_jawapan'] ;
               // echo $status_jawapan;
                
            ?>
            <? if($status_jawapan==0) {?>
                <a href="../controller/pengesahan_tawaran_exec.php?id=<? echo $id?>&status=<? echo 1?>&tarikh=<? echo $date->format('Y-m-d H:i:s');?>"<button type="submit" class="btn btn-primary" onclick="return Confirm()" >Saya Menerima Tawaran Ini</button></a>
            
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