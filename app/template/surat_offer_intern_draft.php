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
	<td colspan=2>
	<b><br><br>
	<?
		 echo $list['name']."<br>(".$list['noic'].")" ;
	?> </b><br>
	<? 
		 echo $list['alamat_surat'] ;
	?>
    <td nowrap>
    Ruj. Kami : <? echo $com['short_name'];?>/<? echo $list['peranan'];?>/OFFER/<? echo $date_year?>/<? echo getRunningNo($id);?><br>
	Tarikh<span class="a"></span> : <? echo date("d",strtotime($list['tarikh_jawapan']));?> <? echo getMonthString(date("n",strtotime($list['tarikh_jawapan'])));?> <? echo date("Y",strtotime($list['tarikh_jawapan']));?>
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
	<u><b>SURAT TAWARAN PENGAMBILAN PELAJAR LATIHAN INDUSTRI</b></u><br><br>
	Merujuk perkara di atas, dengan sukacitanya syarikat <b><? echo $com['name'];?></b> ingin menawarkan posisi sebagai <b>PELAJAR LATIHAN INDUSTRI</b>  kepada saudara/i. Tarikh mula menjalani latihan industri anda adalah pada    
	<? echo date("d",strtotime($list['tarikh_start']));?> <? echo getMonthString(date("n",strtotime($list['tarikh_start'])));?> <? echo date("Y",strtotime($list['tarikh_start']));?> hingga <? echo date("d",strtotime($list['tarikh_tamat']));?> <? echo getMonthString(date("n",strtotime($list['tarikh_tamat'])));?> <? echo date("Y",strtotime($list['tarikh_tamat']));?>.
Kami percaya bahawa pengetahuan, kemahiran dan pengalaman saudara/i semasa belajar akan menjadi antara aset kami yang paling berharga dan kehadiran saudara/i ke dalam organisasi ini amat dialu-alukan. 
<b>Terma</b> serta <b>syarat-syarat</b> tawaran adalah seperti yang termaktub di bawah:<br><br>
<b>1. Tempoh bekerja</b><br>
Tempoh menjalani latihan industri adalah selama <b><? echo bulan($dt1,$dt2);?> BULAN</b> , seperti yang telah ditetapkan oleh pihak universiti.<br><br>
<b>2. Gaji dan elaun</b><br>
Tiada gaji dan elaun yang ditawarkan . <br><br>
<b>3. Cuti tahunan</b><br>
Tiada cuti tahunan sepanjang tempoh menjalani latihan industri. Namun sekiranya saudara/i ingin memohon cuti, saudara/i hendaklah mengemukakan <b>borang permohonan cuti yang telah disediakan oleh pihak 
pengurusan (cuti yang dipohon mestilah mendapat kelulusan oleh pihak pengurusan)</b> dan permohonan mestilah dibuat <b>7 HARI LEBIH AWAL</b>. Dan sekiranya cuti sakit, saudara/i hendaklah <b>mengemukakan sijil 
sakit (MC)</b> yang dikeluarkan oleh hospital atau klinik yang dilawati dan surat tersebut mestilah diserahkan kepada pihak pengurusan untuk perekodan cuti .<br><br>
<b>4. Hari dan waktu bekerja</b>
</td>
</tr>
</table>
<table>
<tr>
	<td>Hari bekerja</td>
	<td>&nbsp :</td>
	<td>&nbsp Ahad – Khamis</td>
</tr>
<tr>
	<td>&nbsp </td>
	<td>&nbsp :</td>
	<td>&nbsp Sabtu (minggu ke-2 dan minggu ke-4)</td>
</tr>
<tr>
	<td>Waktu bekerja		</td>
	<td>&nbsp :</td>
	<td>&nbsp 9 pagi – 6 petang</td>
</tr>
	<td>Waktu rehat		    </td>
	<td>&nbsp :</td>
	<td>&nbsp 1 petang – 2 petang</td>
</tr>
<tr>
	<td>Cuti			    </td>
	<td>&nbsp :</td>
	<td>&nbsp Jumaat & Sabtu (minggu ke-1 dan minggu-3)</td>
</tr>
</table>
<br>
<b>5. Etika Pakaian dan Penampilan Semasa Bekerja</b><br>
Pihak pengurusan telah sebulat suara bersetuju untuk menetapkan etika kod pemakaian seperti berikut :<br>
<table>
<tr>
	<td>Lelaki</td>
	<td>:</td>
	<td>&nbsp Memakai baju kemeja lengan panjang/pendek  , baju t-shirt berkolar , berseluar slack</td>
</tr>
<tr>
	<td>Wanita</td>
	<td>:</td>
	<td>&nbsp Memakai baju kurung /kemeja lengan panjang/blouse wanita/seluar slack/skirt labuh</td>
</tr>
<tr>
	<td>&nbsp </td>
	<td>&nbsp</td>
	<td>&nbsp (Wanita yang beragama Islam diwajibkan memakai stoking/sarung kaki)</td>
	
   		                            
 </tr>
</table>
<br>
<b>6. Tugas dan tanggungjawab</b><br>
Tugas dan tanggungjawab saudara/i adalah seperti yang dibincangkan bersama pihak pengurusan. Sebarang perubahan dan tambahan tugas akan dibincangkan dari semasa ke semasa. 
Kami yakin saudara/i mampu menggalas tugas yang diberikan. Walau bagaimanapun, jika saudara/i menghadapi sebarang kesulitan, saudara/i dialu-alukan untuk merujuk kepada pihak
 pengurusan dan memaklumkan kepada ketua unit masing-masing .<br><br>
 
<p style="page-break-after: always;">&nbsp;</p>

<b>7. Khas </b><br>
Sekiranya didapati prestasi saudara/i tidak baik ataupun ditangkap mencuri atau merompak atau dituduh dan dihukum kerana dadah atau telah dinilai sebagai 
<b>‘incompetent’</b> oleh pihak pengurusan, pihak pengurusan berhak memberhentikan saudara/i untuk meneruskan latihan industri di syarikat kami.<br><br>
</td>
	</tr>
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

            Saya <b><?  echo $list['name'] ;?></b> nombor kad pengenalan <b><?  echo $list['noic'] ;?></b> dengan ini menerima dan bersetuju dengan terma dan syarat yang termaktub dalam perjanjian ini.<br><br>
            
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