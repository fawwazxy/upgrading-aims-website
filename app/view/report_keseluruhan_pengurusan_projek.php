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
	?>
<center>
<br><br><br><br><br><br>
<? echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"style="width: 150px; height: 170px;"/>';?><br><br><br><br>
<h2>LAPORAN KESELURUHAN PERKEMBANGAN PROJEK</h2><br>
<h3>Projek : <? echo $agency['tajuk_sebut_harga']; ?></h3><br>
<h5>Tarikh Janaan Laporan: <? echo date('d/m/Y'); ?></h5><br>
<br><br><br><br><br><br><br><br><br>
<h4>Laporan Disediakan Untuk
<br><? echo $agency['agensi_rujukan']; ?></h4>
<h4>Laporan Disediakan Oleh
<br><? echo $sys['sys_owner']; ?></h4><br><br><br><br><br>
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
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Keterangan Projek<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Fasa Kerja (Jangkaan vs Sebenar)<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Analisa Perkembangan Kerja (Fasa & Bulan)<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Carta Gantt<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5. Senarai Log Kerja<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6. Pasukan Projek<br>
   
    
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
    <h1>2. Fasa Kerja (Jangkaan vs Sebenar)</h1>

<br><!-- 
<table style="width:100%"> -->
	 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                                            

                                <thead>
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Fasa Kerja</th>
                                        <th>Tarikh Mula</th>
                                        <th>Tarikh Akhir</th>
                                        <th>Bil. Hari</th>
                                       
                                        
                                    </tr>
                                </thead>
                                <tbody>
                            
                                <?
                                    $i= 1;
                                    $data = getJadual2($id);
                                    while($row_data = $data->fetch_assoc()) {
                                    $color = "white";  
                                    $bil_hari_sebenar = 0;

                                    $date1=date_create($row_data['mula']);
                                    $date2=date_create($row_data['akhir']);
                                    $diff_jangka=date_diff($date1,$date2);
                                    $bil_hari_jangka=(($diff_jangka->format("%R%a")) + 1);


                                    $date_ms=date_create($row_data['mula_sebenar']);
                                    $date_as=date_create($row_data['akhir_sebenar']);
                                    //$diff_sebenar=date_diff($row_data['mula'],$row_data['mula']);
                                    if(!IS_NULL($row_data['mula_sebenar']) && !IS_NULL($row_data['akhir_sebenar'])){
                                        $diff_sebenar=date_diff($date_ms,$date_as); 
                                        $bil_hari_sebenar=(($diff_sebenar->format("%R%a")) + 1);
                                        if($bil_hari_sebenar > $bil_hari_jangka){
                                            $color = "red"; 
                                        }else if($bil_hari_sebenar == $bil_hari_jangka){
                                            $color = "lightblue"; 
                                        }else if($bil_hari_sebenar < $bil_hari_jangka){
                                            $color = "lightgreen"; 
                                        }else{
                                            $color = "white"; 
                                        }
                                    }else{
                                         $color = "white"; 
                                    }

                                    
                  
                                ?>
                                    <tr class="odd gradeX">
                                        <td width="5%" valign="top"><?php echo $i; ?></td>
                                        <td width="45%" valign="top"><?php echo $row_data['fasa']; ?></td>
                                        <td><b>
                                            <div style="background-color:yellow">Jangkaan : <?php echo $row_data['mula']; ?></div>
                                            <div style="background-color:<?echo $color?>">Sebenar : <?php echo $row_data['mula_sebenar']; ?></div></b>
                                        </td>
                                        <td><b>
                                            <div style="background-color:yellow">Jangkaan : <?php echo $row_data['akhir']; ?></div>
                                            <div style="background-color:<?echo $color?>">Sebenar : <?php echo $row_data['akhir_sebenar']; ?></div></b>    
                                        </td>
                                        <td><b>
                                            <div style="background-color:yellow">Jangkaan : <?php
                                            
                                            echo $bil_hari_jangka." hari";

                                            //date_sub($date,date_interval_create_from_date_string("1 years"));

                                            ?></div>
                                            <div style="background-color:<?echo $color?>">Sebenar : <? 
                                            echo $bil_hari_sebenar." hari";  ?></div></b>
                                        </td>
                                        
                                        
                                        
                                    </tr>
                                <? $i++; } ?>
                                
                                
                            
                                </tbody>

                                
                            </table>

</center>

<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>

<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6><? echo $agency['agensi_rujukan']; ?> | <? echo $agency['tajuk_sebut_harga']; ?></h6>
</div>
<br><br>
<center>
    <h1>3. Analisa Perkembangan Kerja (Fasa & Bulan)</h1>

<br><!-- 
<table style="width:100%"> -->
	 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                                            

                                <thead>
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Fasa Kerja</th>
                                        <?
                                            
                                            $datamonth = getBulanAnalisa($id);
                                            while($row_datam = $datamonth->fetch_assoc()) {
                                        ?>
                                        <th><?echo $row_datam['month'];?> - <?echo $row_datam['year'];?></th>
                                        <?}?>
                                        
                                       
                                        
                                    </tr>
                                </thead>
                                <tbody>
                            
                                <?
                                    $i= 1;
                                    $data = getJadual2($id);
                                    while($row_data = $data->fetch_assoc()) {
                                        
                  
                                ?>
                                    <tr class="odd gradeX">
                                        <td width="5%" valign="top"><?php echo $i; ?></td>
                                        <td width="20%" valign="top"><?php echo $row_data['fasa']; ?></td>
                                        <?
                                            
                                            $datamonth = getBulanAnalisa($id);
                                            while($row_datam = $datamonth->fetch_assoc()) {
                                        ?>
                                        <td valign="top"><?echo getCountPerkembanganKerja($id,$row_data['id'],$row_datam['yearmonth'])?></td>
                                        <?}?>
                                        
                                        
                                        
                                        
                                    </tr>
                                <? $i++; } ?>
                                
                                
                            
                                </tbody>

                                
                            </table>

</center>

<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>
<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6><? echo $agency['agensi_rujukan']; ?> | <? echo $agency['tajuk_sebut_harga']; ?></h6>
</div>
<br><br>
<left>
    <h1 align="center">4. Carta Gantt</h1>

<br>
<?
date_default_timezone_set('Asia/Kuala_Lumpur');
  $date_month = date(m);
  $date_year = date(Y);
  $date_day = date(d);
  $time_hour = date(H);
  $time_min = date(i);
  $time_sec = date(s);

    


$data = array();
$id = $_GET['id'];

$row_data=getGanttChart($id);
while ($row = $row_data->fetch_assoc()){

$data[] = array(
  'label' => $row['fasa'],
  'start' => $row['mula'], 
  'end'   => $row['akhir'],

  //'class' =>'urgent'


);

}




$gantti = new Gantti($data, array(
  'title'      => 'Fasa',
  'cellwidth'  => 25,
  'cellheight' => 50,
  'today'      => true
));

?>


 

  <!-- <link rel="stylesheet" href="../../resources/css/gantt_chart_screen.css" /> -->
  <link rel="stylesheet" href="../../resources/css/gantt_chart.css" />

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->





            <?php echo $gantti ?>
          

 


<br><br>

	 

</left>

<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>


<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6><? echo $agency['agensi_rujukan']; ?> | <? echo $agency['tajuk_sebut_harga']; ?></h6>
</div>
<br><br>
<center>
    <h1>5. Senarai Log Kerja</h1>

<br><!-- 
<table style="width:100%"> -->
	 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                                            

                                <thead>
                                    <tr>
                                        
                                        <th>Bil.</th>
                                        <th>Tarikh</th>
                                        <th>Log Kerja</th>
                                        <th>Tugasan Oleh</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                            
                                <?
                                    $i= 1;
                                    $data = getPerkembanganProjek($id);
                                    while($row_data = $data->fetch_assoc()) {
                                        
                  
                                ?>
                                    <tr class="odd gradeX">
                                        
                                        <td width="1%" valign="top"><?php echo $i++;?></td>
                                        <td width="15%" valign="top"><?php echo $row_data['created_date']?></td>
                                        
                                        <td valign="top">
                                        <?php echo $row_data['perkembangan']; ?></a></td>
                                        <td width="15%" valign="top"><?php echo $row_data['name']?></td>
                                        
                                    </tr>
                                <?  } ?>
                                
                                
                            
                                </tbody>

                                
                            </table>

</center>

<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>

<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6><? echo $agency['agensi_rujukan']; ?> | <? echo $agency['tajuk_sebut_harga']; ?></h6>
</div>
<br><br>
<center>
    <h1>6. Senarai Pasukan Projek</h1>

<br><!-- 
<table style="width:100%"> -->
	 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                                            

                               <thead>
									<tr>
										
										
										<th>Gambar</th>
										<th>Nama Penuh</th>
										<th>Peranan</th>
									</tr>
								</thead>
								<tbody>
                                    <?
                                   
                                    $id_harga = $pic['id_sebut_harga'] ;                                                  
									$i= 1;
									// $data = getItem($id_harga);

									$data = getSenaraiAhli($id);
									while($row_data = $data->fetch_assoc()) {
									
								?>
									<tr>
									  
									  <td width="15%"><center><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photo'] ).'" style="width: 70px; height: 75px;"/>';?></center></td>
									  <td><?php echo $row_data['name']; ?><br>No. K/P : <?php echo $row_data['noic']; ?><br>No. H/P : <?php echo $row_data['phone']; ?></td>
									  <td width="30%"><?php echo $row_data['nama_peranan']; ?></td>
                                    <?php $i++; } ?>
									 
								</tbody>

                                
                            </table>

</center>

<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>

		
	</body>
</html>