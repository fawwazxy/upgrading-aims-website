<?php
require "../model/library_functions.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;

//date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));

function highlightDay($day_no) {
	if ($day_no==date("w")) {
		echo 'bgcolor="yellow"';
	}
}


function getPastDate($count) {
	if ($count>=date("w")) {
		$count=date("w")-$count;
		$date = strtotime("-".$count." day", strtotime(date('d M Y')));
		return date('Y-m-d', $date);
		//echo date('d', $date);
	}
	else
	{
		$count=date("w")-$count;
		$date = strtotime("-".$count." day", strtotime(date('d M Y')));
		return date('Y-m-d', $date);
	}
}

function getWeekCount() {
	if ($count<=date("w")) {
		$count=date("w")-$count;
		$date = strtotime("-".$count." day", strtotime(date('d M Y')));
		echo date('d M Y', $date);
	}
}
function getLastWeekPreviousMonth(){
	$date= new DateTime();
	$date->modify("last day of previous month");
    return $date->format("W");
	
}
function getThisWeek(){
	$date= new DateTime();
	$week_no=date("W");
	return $week_no - getLastWeekPreviousMonth();
}
function isDateInRange($startDate, $endDate, $userDate)
{
	$startT = strtotime($startDate);
	$endT = strtotime($endDate);
	$userT = strtotime($userDate);
	return (($userT >= $startT) && ($userT <= $endT));
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
    <?php require "../global/header.php"; ?>    
<script src="../../js/jquery/moment.js"></script>
<style type="text/css">
	td.a{
		padding-bottom: 15px;	}
	#menu {
		background: hsla(1,0%,100%,.9);
		position: absolute;
		top: 50;
		right: 0;
		left: 0;
		min-height: 100%;
		padding-top: 10px;
	}
	td.red{
		color: red;
	}
	td.green{
		color: green;
	}
	td.blue{
		color: blue;
	}
	td.orange{
		color: orange;
	}
	td.brown{
		color: brown;
	}
</style>

<script language="javascript" type="text/javascript">
// setInterval(function () {
    
//   location.reload();
     
    
// }, 30000);
setInterval(function () {
     var date = new Date();
    $('#timeRunningDate').html(moment().format('ddd MMM D YYYY, HH:mm:ss '));
       
    showTime();
}, 1000);

function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerHTML = time;
    document.getElementById("MyClockDisplay").textContent = time;
    //$('#timeRunningDate').html(time);
    
    

    //setTimeout(showTime, 1000);
    
}


</script>

</head>
<body id="refresh">

    

    <div class="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <table align="left" border="0" width="100%">
                    <tr bgcolor="yellow">
                        <td width="10%" align="right">
                        </td>
                        <td  align="center" width="70%" rowspan="2">
                            &nbsp;&nbsp;<strong><font size="5">ANALISA SEMASA KESELURUHAN</font></strong>
                        </td>
                        <td width="60%">
                            <h1 align="right">
                                <font color="black">
                                    <div id="MyClockDisplay" class="clock"><? echo date('h:i:s A')?></div>
                                </font>
                            </h1>
                            <h4 align="right">
                                <font color="black">
                                    <span id="timeRunningDate"><? echo date('D M d Y, H:i:s ')?></span>
                                </font>
                            </h4>
                        </td>
                        <td width="30%">&emsp;&emsp;</td>
                    </tr>
                </table>
            </div>
        </nav>
        <br>
        <div class="col-lg-12">
        	<div class="col-lg-8">
	        	<div class="panel panel-red">
	                <!-- /.panel-heading -->
	                <div class="panel-heading">
	                    <center><b>Analisa Semasa Pinjaman Bahan Bacaan</b></center>
	                </div>
	                    <table class="table table-striped table-bordered table-hover">
	                        <thead>
	                            <tr>
	                                <th width="18%" bgcolor="yellow">Kategori</th>
	                                <th bgcolor="yellow"><center>Jum. Dipinjam</center></th>
	                                <th bgcolor="yellow"><center>Jum. Tamat Tempoh</center></th>
	                                <th bgcolor="yellow"><center>Buku dlm Library</center></th>
	                                <th bgcolor="yellow"><center>Jum. Keseluruhan</center></th>
	                                <th bgcolor="yellow"><center>Peratusan Pinjaman (%)</center></th>
	                                <th bgcolor="yellow"><center>Jum. Lewat Hantar</center></th>
	                            </tr>
	                        </thead>
							<? $analisa_kategori = getKategoriList(); 
								$all_pinjam = 0;
								$all_expired = 0;
								$all_available = 0;
								$all_keseluruhan = 0;
								$all_percent = 0;
								$all_lewat = 0;
                                while($list_kategori = $analisa_kategori->fetch_assoc()) {

                                	$analisa_nilai = getAnalisaKategoriLibrary($list_kategori['id_jenis']); 
									$i=1;
									$noofmonth = $date_year.$date_month;
	                                while($list_nilai = $analisa_nilai->fetch_assoc()){
							?>
	                       	<tbody>
								
									<tr href="library_analisa_kategori.php?id=<?echo $list_kategori['id_jenis']?>">
										<td>
												<h4><strong><?echo $list_kategori['jenis'] ;?></strong></h4>
											
										</td>
										<td class="green"><h4><center><strong>
											<?
												$pinjaman =getAnalisaPinjamanByMonth($list_nilai['id_jenis'])->fetch_assoc();
												if($pinjaman['bilangan_pinjam']!=0){
													echo $jum_pinjam = $pinjaman['bilangan_pinjam'] ;
													$all_pinjam = $all_pinjam+$jum_pinjam;
												}else{
													echo '0';
												}
											?></strong></center></h4>
											
										</td>
										<td class="red"><h4><center><strong>
											
											<?
												$lewat_hantar =getAnalisaLewatLibrary($list_kategori['id_jenis'],0,'CURRENT_DATE',$noofmonth)->fetch_assoc();
												echo $jum_expired = $lewat_hantar['bilangan_pinjam'];
												$all_expired = $all_expired+$jum_expired;
											?>
												</strong></center></h4>
											
										</td>
										<td class="brown"><h4><center><strong>
											<?
												$baki_ada = $list_nilai['bilangan_kategori']-$pinjaman['bilangan_pinjam'];
												echo $jum_baki = $baki_ada;
												$all_available = $all_available+$jum_baki;
											?>
										</strong></center></h4></td>
										<td class="blue"><h4><center><strong>
										
											<?
												if($list_nilai['bilangan_kategori']!=''){
													echo $jum_all = $list_nilai['bilangan_kategori'];
													$all_keseluruhan = $all_keseluruhan+$jum_all;
												}else{
													echo '0';
												}
											?>
												</strong></center></h4>
											
										</td>
										<td class="orange"><h4><center><strong>
											
											<?
												if($pinjaman['bilangan_pinjam'] != 0 && $list_nilai['bilangan_kategori']!=0){
													$peratusan_pinjam = ($pinjaman['bilangan_pinjam']/$list_nilai['bilangan_kategori'])*100;
													
													//echo $jum_pinjam = $pinjaman['bilangan_pinjam'] ;
													

												}else{
													$peratusan_pinjam = 0;
												}
												echo number_format($peratusan_pinjam,0) ;
												$jum_percent = $peratusan_pinjam;
												$all_percent = $all_percent+$jum_percent;
											?>
												</strong></center></h4>
										</td>
										<td><h4><center><strong><font color="red">
											<?
												$lewat_hantar =getAnalisaLewatLibrary($list_kategori['id_jenis'],1,"epin.tarikh_hantar",$noofmonth)->fetch_assoc();
													$lewat_hantar['bilangan_pinjam'];
												//echo $jum_pinjam = $pinjaman['bilangan_pinjam'] ;
													
											?>
											<a href="#myModal2" style="color:red" data-toggle="modal" data-id="<? echo $list_kategori['id_jenis'];?>"><?echo $jum_lewat = $lewat_hantar['bilangan_pinjam'];
																	$all_lewat = $all_lewat+$jum_lewat;?></a>
											</font></strong></center></h4>
										</td>
										
									</tr>
	                           <?}}?>
	                           	<tr>
										<td>
												<h4><strong>Jumlah Keseluruhan</strong></h4>
											
										</td>
										<td class="green"><h4><center><strong>
											<?
												echo $all_pinjam;
											?></strong></center></h4>
											
										</td>
										<td class="red"><h4><center><strong>
											
											<?
												echo $all_expired;
											?>
												</strong></center></h4>
											
										</td>
										<td class="brown"><h4><center><strong>
											<?
												echo $all_available;
											?>
										</strong></center></h4></td>
										<td class="blue"><h4><center><strong>
										
											<?
												echo $all_keseluruhan;
											?>
												</strong></center></h4>
											
										</td>
										<td class="orange"><h4><center><strong>
											
											<?
												$all_percent = ($all_pinjam / $all_keseluruhan)*100;
												echo number_format($all_percent,0) ;
											?>
												</strong></center></h4>
										</td>
										<td><h4><center><strong><font color="red">
											<?
												echo $all_lewat;
											?>
											</font></strong></center></h4>
										</td>
										
									</tr>     
	                        </tbody>
	                        
	                    </table>
	                
	                <!-- /.panel-body -->
	            </div>
	        </div>
	        <div class="col-lg-4">
				<div class="panel panel-red">
				<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Mingguan Pinjaman Bahan Bacaan (<? echo date("F"); ?>)</b></center>
					</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
							<?  
								echo "<th width='27%'></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = date('n'); // Month ID, 1 through to 12.
								$year = date('Y'); // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 1;
								$firstofweek = 1;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									// if($day == strtolower($rollover)){  
										// $weeks ++;
										// $_first=$year."-".$month."-".$firstofweek;
										// $firstofweek=$i+1;
										// $_last=$year."-".$month."-".($i);
										
										// if(isDateInRange($_first, $_last, $date) ){
										// echo "<th bgcolor=\"yellow\"><center>M".$weeks."</center></th>";
										// }else{
										// echo "<th><center>M".$weeks."</center></th>";
										// }
										
									// }
									if($day == strtolower($rollover)){  
										//$weeks ++;
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_bgcolor = "";
										if(isDateInRange($_first, $_last, $date)) $_bgcolor = " bgcolor=\"yellow\"";
										echo "<th width='100px'".$_bgcolor."><center>M".$weeks."</center></th>";
										$weeks ++;
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i+1;
										$_last=$year."-".$month."-".($i);
										echo "<th><center>M".$weeks."</center></th>";
										$weeks ++;
									}
								}
								?>
							</tr>
						</thead>
						<tbody>
							<tr>
							    
								
								<?  
								echo "<td><font color='black'><h4><strong>Jum. Pinjaman</strong></h4></font></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = date('n'); // Month ID, 1 through to 12.
								$year = date('Y'); // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 1;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
								
										//$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";

										if(isDateInRange($_first, $_last, $date)){
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="green";}
										echo "<td ".$_bgcolor."><center><font color='".$_fcolor."'><h4><strong>".
										getAnalisaPinjamWeek($_first, $_last)
										."</strong></h4></font></center></td>";
										
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										echo "<td width=\"14.6%\"><center>".getAnalisaPinjamWeek($_first, $_last)."</center></td>";
									}
								}
								?>
							</tr>
							<tr>
							    
								
								<?  
								echo "<td><font color='black'><h4><strong>Jum. Hantar Lewat</strong></h4></font></td>";
								$d = new DateTime('first day of this month');
								$d->format('Y-m-d');
								$l = new DateTime('last day of this month');
								$l->format('Y-m-d');
								$type = CAL_GREGORIAN;
								$month = date('n'); // Month ID, 1 through to 12.
								$year = date('Y'); // Year in 4 digit 2009 format.
								$total_days = cal_days_in_month($type, $month, $year);
								
								
								$date = date('Y-m-d');
								//firstday sunday
								$rollover = "saturday";
								$cut = substr($date, 0, 8);
								$daylen = 86400;

								$timestamp = strtotime($date);
								$first = strtotime($cut."00");
								$elapsed = ($timestamp - $first) / $daylen;

								$weeks = 1;
								$firstofweek = 0;
								//echo "<td width=\"20%\"><center>".$d->format('Y-m-d')."</center></td>";

								for ($i = 1; $i <= $total_days; $i++)
								{
									$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
									$daytimestamp = strtotime($dayfind);

									$day = strtolower(date("l", $daytimestamp));

									if($day == strtolower($rollover)){  
								
										//$weeks ++;
										$_first=$year."-".$month."-".($firstofweek+1);
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										$_fcolor = "blue";
										$_bgcolor = "";
										if(isDateInRange($_first, $_last, $date)) {
											$_bgcolor = " bgcolor=\"yellow\"";
											$_fcolor="red";}
										echo "<td ".$_bgcolor."><center><font color='".$_fcolor."'><h4><strong>".
										getAnalisaLewatByWeek($_first, $_last)
										."</strong></h4></font></center></td>";
										
										
									}else if($total_days== $i){
										$_first=$year."-".$month."-".$firstofweek;
										$firstofweek=$i;
										$_last=$year."-".$month."-".($i);
										echo "<td width=\"18%\"><center>".getAnalisaLewatByWeek($_first, $_last)."</center></td>";
									}
								}
								?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
	        
        </div>

	    <div class="col-lg-12">
	    	<div class="col-lg-7">
		        <div class="panel panel-red">
					<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Bulanan Pinjaman Bahan Bacaan</b></center>
					</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
								<?  
									echo "<td></td>";
									$months = array("Jan", "Feb", "Mac","Apr","Mei","Jun","Jul","Ogos","Sep","Okt","Nov","Dis");
									$arrlength = count($months);
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										
											$_bgcolor = "";
											if(intval($i) == intval($date_month-1)) $_bgcolor = " bgcolor=\"yellow\"";
											echo "<th ".$_bgcolor."><center>".$months[$i]."</center></th>";
									}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
								   <?  
								   echo "<th width='20%'><font color='black'><h4><strong>Jum. Pinjaman</strong></h4></font></th>";
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										$noofmonth = "";
										if(strlen($i)==1) {
											$noofmonth = $date_year.'0'.($i+1);
										}else{
											$noofmonth = $date_year.''.($i+1);
										}
											$_fcolor = "blue";
											$_bgcolor = "";
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="green";}
											echo "<td width='6.67%' ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getAnalisaPinjamMonth($noofmonth)."</strong></h4></center></font></td>";
									}
									?>
								</tr>
								<tr>
								   <?  
								   echo "<th width='20%'><font color='black'><h4><strong>Jum. Lewat Hantar</strong></h4></font></th>";
									
									for ($i = 0; $i < $arrlength; $i++)
									{
										$noofmonth = "";
										if(strlen($i)==1) {
											$noofmonth = $date_year.'0'.($i+1);
										}else{
											$noofmonth = $date_year.''.($i+1);
										}
											$_fcolor = "blue";
											$_bgcolor = "";
											if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="red";}
											echo "<td width='6.67%' ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getAnalisaLewatByMonth($noofmonth)."</strong></h4></center></font></td>";
									}
									?>
								</tr>
							</tbody>
						</table>
					
					<!-- /.panel-body -->
				</div>
			</div>
	        <div class="col-lg-5">
		        <div class="panel panel-red">
					<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>Analisa Tahunan Pinjaman Bahan Bacaan</b></center>
					</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									
								<?
									echo "<th width='40%'></th>";
									for ($i = 0; $i < 4; $i++)
									{
										
											$_bgcolor = "";
											if($i == 0) $_bgcolor = " bgcolor=\"yellow\"";
											echo "<th width='15%' ".$_bgcolor."><center>".($date_year-$i)."</center></th>";
									}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
								   <?
									echo "<td><font color='black'><h4><strong>Jum. Pinjaman</strong></h4></font></td>";
									for ($i = 0; $i < 4; $i++)
									{
											$_bgcolor = "";
											$_fcolor = "blue";
											if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="red";}
											echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getAnalisaPinjamYear(($date_year-$i))."</h4></strong></center></font></td>";
									}
									?>
								</tr>
								<tr>
								   <?
									echo "<td><font color='black'><h4><strong>Jum. Peminjam Berdaftar</strong></h4></font></td>";
									for ($i = 0; $i < 4; $i++)
									{
											$_bgcolor = "";
											$_fcolor = "blue";
											if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="red";}
											echo "<td ".$_bgcolor."><font color='".$_fcolor."'><h4><center><strong>".getAnalisaPeminjamYear(($date_year-$i))."</h4></strong></center></font></td>";
									}
									?>
								</tr>
							</tbody>
						</table>
					
					<!-- /.panel-body -->
				</div>
			</div>
	    </div>

        <br>
        <div class="footer-section">
            <div class="copy-section">
                <!--<div class="container">-->
                    <center>
                        <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
                        Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a></p>
                    </center>
                <!--</div>-->
            </div>
        </div>
    </div>

 <script>
 	$(document).ready(function(){ 
 		$('table tr').click(function(){ 
 			window.open($(this).attr('href'),target="blank");
 			return false; 
 		}); 
 	});
 </script>
</body>
</html>