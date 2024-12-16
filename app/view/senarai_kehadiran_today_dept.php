<?php

	//include ('../controller/auth.php');
	require_once("../../util/qrcode.php");

	require "../model/kehadiran_functions.php";
         
	$dateSelection=$_GET['dt'];
	$com = getCompanyDetails(1)->fetch_assoc();
	
	$tab_dept=$_GET['tab_dept'];
        
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


<script language="JavaScript" type="text/javascript">
function Confirm(){
    return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
}

function Confirm2(){
    return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
}


</script>
<script language="javascript" type="text/javascript">
setInterval(function () {
    
	 location.reload();
	 
    
}, 20000);

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

<body id="refresh">
	<div class="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<table align="left" border="0" width="100%">
					<tr bgcolor="yellow">
					    <td width="10%" align="right">
                            <? 
                        echo '<img src="data:image/png;base64,'.base64_encode( $sys['logo'] ).'" style="height:100px" />';
                        ?>
                        </td>
						<td  align="left" width="50%" rowspan="2">
							&nbsp;&nbsp;<? echo '<h3><b>'.$com['name'].'</b></h3>';?><? echo '<h5><b>No. Pendaftaran: '.$com['registration_no'].'</b></h5>';?><? echo '<h5><b>'.$com['address'].'</b></h5>';?>
						</td>
						<td width="60%">
							<h1 align="right">
								<font color="blue">
									<div id="MyClockDisplay" class="clock"><? echo date('h:i:s A')?></div>
								</font>
							</h1>
							<h4 align="right">
								<font color="blue">
									<span id="timeRunningDate"><? echo date('D M d Y, H:i:s ')?></span>
								</font>
							</h4>
						</td>
						<td width="30%">&emsp;&emsp;</td>
					</tr>
				</table>
			</div>
		</nav>
		
		<!-- Table Sasaran Jualan -->
		
			<div id='cssmenu'>
			<ul>

			<?
				$j= 1;
				$description ="";
				$data_dept = getDepartmentByStaff();
				while($data = $data_dept->fetch_assoc()) {
					if (!isset($tab_dept)){
						$tab_dept = $data['department_id'];
					}
					if ($tab_dept==$data['department_id']){
						$description =$data['description'];
					}
			?>		
			<li class="<? echo ($tab_dept==$data['department_id']?'active':'') ?>">
			<a href="senarai_kehadiran_today_dept.php?tab_dept=<?echo $data['department_id']?>"><?echo $data['description'];?></a></li>
			<?}?>
			</ul>
			</div>
			<br>
			
			<div class="col-xs-6 col-md-8">
    		<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>SENARAI KEHADIRAN HARI INI</b></center>
				</div>
				<table width="100%" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th width="3%">#</th>
							<th width="10%"><center>Gambar</center></th>
							<th width="35%"><center>Nama</center></th>
							<th width="10%"><center>Masuk</center></th>
							<th width="17%"><center>Keluar</center></th>
							<th width="10%"><center>Status</center></th>
							<th width="35%"><center>Catatan</center></th>
						</tr>
					</thead>
					<tbody>
						<?
							$i= 1;
							$data_staff = getLogStaffByDepartment($tab_dept);
							while($row_data_staff = $data_staff->fetch_assoc()) {
							    $data_cuti = getCutiStaff($row_data_staff['no_staff'])->fetch_object();  
								$status = '';
								if ($row_data_staff['status_kehadiran_flag'] == 'AWAL') {
						        $status = '<font color="BLUE"><b>'.$row_data_staff['status_kehadiran_flag'].'</b></font>';
						        } else { 
						        $status = '<font color="RED"><b>'.$row_data_staff['status_kehadiran_flag'].'</b></font>';
						        }
								$catatan = $row_data_staff['catatan'];
								$flag_color = "";
								if($data_cuti->tarikh_mula != ''){
									$status = "BERCUTI";
									$catatan = "Dari ".date('d/m/Y',strtotime($data_cuti->tarikh_mula))." Hingga ".date('d/m/Y',strtotime($data_cuti->tarikh_akhir));
									$flag_color = 'style="background: yellow;"';
								}
								$remark_masuk_txt = $row_data_staff['remark_masuk'];
								if($row_data_staff['remark_masuk'] == 'LUAR KAWASAN'){
								    $remark_masuk_txt = '<font color="red">'.$row_data_staff['remark_masuk'].'</font>';
								}
								$remark_keluar_txt = $row_data_staff['remark_keluar'];
								if($row_data_staff['remark_keluar'] == 'LUAR KAWASAN'){
								    $remark_keluar_txt = '<font color="red">'.$row_data_staff['remark_keluar'].'</font>';
								}
							
						?>
						<tr <?echo $flag_color;?>>
							<td><?php echo $i; ?></td>
							<td><center><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data_staff['photo'] ).'" style="width: 50px; height: 60px;"/>';?></center></td>
							<td><b><?php echo $row_data_staff['name']; ?><br>No. ID: <?php echo $row_data_staff['no_staff']; ?></b></td>
							<td><center>
							    <b><?php echo $row_data_staff['masa_masuk']; ?></b><br>
							    <?php if( $remark_masuk_txt=="LUAR KAWASAN"){?>
											  <strong><font color="red">
										    <?php echo $remark_masuk_txt; ?></font></strong>
											<? } else {?>
											<strong><font color="blue">
											<?php echo $remark_masuk_txt; ?></font></strong>
											<?}?>
							    </center>
							</td>
							<td><center>
							    <b><?php echo $row_data_staff['masa_keluar']; ?></b><br>
							    <?php if( $remark_keluar_txt=="LUAR KAWASAN"){?>
											  <strong><font color="red">
										    <?php echo $remark_keluar_txt; ?></font></strong>
											<? } else {?>
											<strong><font color="blue">
											<?php echo $remark_keluar_txt; ?></font></strong>
											<?}?>
							    </center>
							</td>
							<td><center><?php echo $status; ?></center></td>
							<td><center><b><?php echo $catatan; ?></b></center></td>
						</tr>
						<? $i++;}?>
					</tbody>
				</table>
			</div>
			</div>
			<div class="col-xs-6 col-md-4">
				<div class="short-div" style="background-color:green">
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Scan QR-Code Untuk Log Kehadiran</b></center>
						</div>
						<br>
						<center><? 
						$qr = new QRCode();
						$qr = QRCode::getMinimumQRCode($sys['sys_domain'], QR_ERROR_CORRECT_LEVEL_L);
						$qr->printHTML("12px");?>
							
						</center>
						<br>
					</div>
				</div>
				<div class="short-div" style="background-color:green">
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Renungan Bersama</b></center>
						</div>
						<center>
						<strong>
						    <h3>"Demi masa. Sungguh manusia dalam kerugian, kecuali orang-orang yang beriman dan mengerjakan kebajikan serta saling menasihati untuk kebenaran dan saling menasihati untuk kesabaran."
						</strong><br> 
      				        ( Surah al-‘Asr, ayat 1 hingga 3)</h3>
							
						</center>
						<br>
					</div>
				</div>
				
			</div>
			
			<!-- /.panel -->
		</div>

		
		
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
</body>

</html>
