<?
    //require "../global/header.php";
require('../../lib/gantti.php'); 
	require "../model/project_management_function.php";
	//require"../controller/auth.php";
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$sys_id = $_GET['sys_id'];
	//$agency_id = $_GET['agency_id'];
	//$vs_id = $_GET['vs_id'];
	$sys = getSys($sys_id)->fetch_assoc();
	$com = getCompany()->fetch_assoc();
	$id = $_GET['id'];
    $no_staff = $_GET['no_staff'];
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/<? echo $sys['logo_filename']; ?>" />
		<title><? echo $sys['sys_name']; ?> :: <? echo $sys['sys_tagline']; ?></title>
		<style>
			#map_wrapper {
				height: 500px;
			}

			#map_canvas {
				width: 100%;
				height: 100%;
			}
		</style>
		<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;    
}
table { page-break-inside:auto }
tr { page-break-inside:avoid; page-break-after:auto }
@media print {
tr {
    -webkit-print-color-adjust: exact; 
}}
</style>
	</head>
	<body>
		
		
	<? /* Start Frontpage Cover */ ?>
	<?
	//$agency = getAgensi($id) -> fetch_assoc();
	//$vs = getVotingSessionDetails($sys_id,$agency_id,$vs_id) -> fetch_assoc();
	$agency = getInfoProjek($id)->fetch_assoc();
    $nama = getNamaBukuLog($id,$no_staff)->fetch_assoc();

	?>
<center>
<br><br><br><br><br><br>
<?echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"style="width: 150px; height: 170px;"/>';?><br><br><br><br>
<h2>BUKU LOG KERJA INDIVIDU</h2><br>
<h3>Projek : <? echo $agency['tajuk_sebut_harga']; ?></h3><br>
<h5>Tarikh Janaan Buku Log: <? echo date('d/m/Y'); ?></h5><br>
<br><br><br><br><br>
<h4>Laporan Disediakan Untuk
<br><? echo $sys['sys_owner']; ?></h4>
<h4>Laporan Disediakan Oleh
<br><? echo $nama['name'];?>&nbsp;(<? echo $nama['noic'];?>)</h4><br><br><br><br><br>
<?include '../global/footer_report.php'?>
</center>

<? /* End Frontpage Cover */ ?>
<p style="page-break-after:always;"></p>

<!-- .............................................................................................................................. -->

<? /* Start TOC */ ?>
<div align="right">
    <h6><? echo $agency['agensi_rujukan']; ?> | <? echo $agency['tajuk_sebut_harga']; ?></h6>
</div>
<br><br>
<center>
    <h1>Isi Kandungan</h1>
</center>
<br>
<div align="left">
<left>
<h2>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Keterangan<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Senarai Log Kerja<br>
   
    
</h2>
</left>

<? /* End TOC */ ?>
<p style="page-break-after:always;"></p>

<? /* Start TOC */ ?>
<div align="right">
    <h6><? echo $agency['agensi_rujukan']; ?> | <? echo $agency['tajuk_sebut_harga']; ?></h6>
</div>
<br><br>
<center>
    <h1>1. Keterangan Projek</h1><br><br><br>
</center>
<br>
<div align="left">
<left>

                        
                     <table width="100%" class="table" id="dataTables-example">
                       

                        <? 
                    $log = getProjekDetailsById($id) -> fetch_assoc();
                ?>
                      
                        <tr>
                            <td><b>Projek</b></td><td><?php echo $log['tajuk_sebut_harga'] ?></td> 
                        </tr>
                        <tr>
                            <td><b>Ketua Pasukan Projek</b></td><td><?php echo $log['nama_ketua_projek'] ?></td> 
                        </tr>
                            <tr>
                            <td><b>Pelanggan</b></td><td><?php echo $log['agensi_rujukan'] ?></td> 
                        </tr>
                            <tr>
                            <td><b>Pegawai Rujukan Agensi</b></td><td><?php echo $log['nama_rujukan'] ?></td>
                        </tr>
                            <tr>
                            <td><b>Pegawai Rujukan Dalaman </b></td><td><?php echo $log['nama_pegawai_dalaman'] ?></td>
                        </tr>
                            <tr>
                            <td><b>Jangka Masa Kerja</b></td><td><?php echo $log['tarikh_mula'] ?> hingga <?php echo $log['tarikh_akhir'] ?>&nbsp;&nbsp;(<?php echo $log['jumlah_hari'] ?> hari)</td>
                        </tr>
                        
                        </table>
                     
                     
                    
</left>
</div>

<? /* End TOC */ ?>
<p style="page-break-after:always;"></p>


<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6><? echo $agency['agensi_rujukan']; ?> | <? echo $agency['tajuk_sebut_harga']; ?></h6>
</div>
<br><br>
<center>
    <h1>2. Senarai Log Kerja</h1>

<br><!-- 
<table style="width:100%"> -->
	 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                                            

                                <thead>
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Tarikh</th>
                                        <th>Perkembangan</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                            
                                <?
                                    $i= 1;
                                    $data = getPerkembanganProjekIndividu($id,$no_staff);
                                    while($row_data = $data->fetch_assoc()) {
                                        
                  
                                ?>
                                    <tr class="odd gradeX">
                                        
                                        <td width="1%" valign="top"><?php echo $i++;?></td>
                                        <td width="15%" valign="top"><?php echo $row_data['created_date']?></td>
                                        <td valign="top" valign="top"><?php echo $row_data['perkembangan']; ?></td>
                                        
                                        
                                    </tr>
                                <?  } ?>
                                
                                
                            
                                </tbody>

                                
                            </table>

</center>

<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>



		
	</body>
</html>