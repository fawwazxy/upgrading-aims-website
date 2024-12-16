<?php

	include ('../controller/auth.php');

	require "../model/kehadiran_functions.php";


function getMonthString($num)
    {

          
      switch($num)
      {
        case 1:
          $month="Januari";
          break;
        case 2:
          $month="Februari";
          break;
        case 3:
          $month="Mac";
          break;
        case 4:
          $month="AprilL";
          break;
        case 5:
          $month="Mei";
          break;
        case 6:
          $month="Jun";
          break;
        case 7:
          $month="Julai";
          break;
        case 8:
          $month="Ogos";
          break;
        case 9:
          $month="September";
          break;
        case 10:
          $month="Oktober";
          break;
        case 11:
          $month="November";
          break;
        case 12:
          $month="Disember";
          break;
        default:
          $month="Invalid month";
      }
      return $month;
    }
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
    <script src="../../js/highcharts/highcharts.js"></script>
    <script src="../../js/highcharts/modules/exporting.js"></script>
    <script src="../../js/highcharts/modules/export-data.js"></script>
    <script src="../../js/highcharts/modules/data.js"></script>
    <script src="../../js/jquery.highchartTable.js"></script>


<script language="JavaScript" type="text/javascript">
function Confirm(){
    return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
}

function Confirm2(){
    return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
}


</script>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	/*newwindow=window.open(url,'name','height=842,width=595');*/
	newwindow=window.open(url,'name','height=595,width=842');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>

</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <!-- /.navbar-header -->
			<? include ('../global/menu_top.php'); ?>

            <!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--li>
							<center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
						</li-->

						<? include ('../global/menu_left.php'); ?>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        
        <div id="page-wrapper">
	
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Analis Semasa Kehadiran</h1>
				</br>
			</div>
			
		</div>
		
                <div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            Analisa Semasa Kehadiran
                        </div>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table class="highchart" data-graph-container-before="1" data-graph-type="pie" style="display:none" data-graph-datalabels-enabled="1">
                            <caption>Status Kehadiran Bulan <? echo getMonthString(date('m'));?></caption>
                                <thead>
                                    <tr>
                                        <th >Status</th>
                                        <th >Bil</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $bil_staf_awal=getBilKehadiranByStaff("AWAL",$_SESSION['SESS_NOKP']);
                                    $bil_staf_tepat=getBilKehadiranByStaff("TEPAT",$_SESSION['SESS_NOKP']);
                                    $bil_staf_lewat=getBilKehadiranByStaff("LEWAT",$_SESSION['SESS_NOKP']);
                                   
                                        ?>
                                         <tr>
                                             <td>Awal</td>
                                             <td data-graph-item-color="#00ff00" data-graph-name="Awal"><? echo $bil_staf_awal;?></td>
                                        </tr>
                                         <tr>
                                             <td>Tepat</td>
                                             <td data-graph-item-color="#0000ff" data-graph-name="Tepat"><? echo $bil_staf_tepat;?></td>
                                        </tr>
                                         <tr>
                                             <td>Lewat</td>
                                             <td data-graph-item-color="#ff0000" data-graph-name="Lewat"><? echo $bil_staf_lewat ;?></td>
                                        </tr>
                                    </tbody>
                            </table>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Analisa Jam Bekerja Tahun <? echo date('Y');?>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table style="display: none;" class="highchart" data-graph-container-before="1" data-graph-type="column" border="1" data-graph-datalabels-enabled="1">
                            <caption>Analisa Jam Bekerja Tahun <? echo date('Y');?></caption>
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Sasaran</th>
                                        <th>Sebenar</th>
                                        <th>Baki</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    
                                    $bulan = getBulanBekerjaStaf($_SESSION['SESS_NOKP']);
                                    while($row_bln = $bulan->fetch_assoc()) {
                                    $sasaran = workdays($row_bln['bulan'],date('Y'))*8;
                                    $sebenar = getTotalJamBekerjaStaf($row_bln['bulan'],$_SESSION['SESS_NOKP']);
                                    $beza = $sasaran-$sebenar;
                                        ?>
                                         <tr>
                                             <td><? echo getMonthString($row_bln['bulan']);?></td>
                                             <td data-graph-item-color="#0000ff"><? echo $sasaran;?></td>
                                             <td data-graph-item-color="#33FFFF"><? echo $sebenar;?></td>
                                             <td data-graph-item-color="#ff0000"><? echo $beza;?></td>
                                        </tr>
                                        
                                <? } ?>
                                </tbody>
                            </table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <div class="footer-section">
            <div class="copy-section">
                <!--<div class="container">-->
                    <center>
                        <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
                        Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
                    </center>
                <!--</div>-->
            </div>
        </div>

<script>
    $(document).ready(function() {
  $('table.highchart').highchartTable();
});
</script>
</body>
</html>

