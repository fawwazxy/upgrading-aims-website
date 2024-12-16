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
	.tbl{
		padding-right: 10px;
		padding-left: 20px;
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
                            &nbsp;&nbsp;<strong><font size="5">ANALISA SEMASA TEMPAHAN</font></strong>
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
	        	<div class="panel panel-red">
	                <div class="panel-heading">
	                    <center><b>Analisa Tempahan Bahan Bacaan Untuk Dipinjam</b></center>
	                </div>
	                <br>
	                <div class="tbl">
                    <table class="table table-bordered" id="dataTables-example">
                        <thead bgcolor="yellow">
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="40%">Tajuk</th>
                                <th width="50">Kategori</th>
                                <th width="12%">Jum. Tempahan</th>
                                <th width="12%">Jum. Tersedia</th>
                            </tr>
                        </thead>
						<? $analisa_tempahan = getAnalisaTempahanByTajuk();                                                           
							$i=1;
                            while($list_tempahan = $analisa_tempahan->fetch_assoc()) {

                            	$bil_masih_ada=$list_tempahan['bil_naskah_hardcopy']- getBilDokumenDipinjam($list_tempahan['id_library']);
						?>
                       	<tbody>
							<tr href="library_analisa_available.php?id=<?echo $list_tempahan['id_library']?>">
								<td><b><?echo $i++?></b></td>
								<td><b><font size="4" color="purple"><?echo $list_tempahan['nama'];?></font></b></td>
								<td><b><font size="4" color="brown"><?echo $list_tempahan['jenis'];?></font></b></td>
								<td><b><font size="5" color="green"><center><?echo $list_tempahan['bil_tempahan'];?></center></font></b></td>
								<td><b><font color="black" size="5"><center>
								<? 
									if($bil_masih_ada <= 0){
										echo '0';
									}else{
										echo $bil_masih_ada;
									}
								?>
								</center></font></b></td>
							</tr>
                                   
                        </tbody>
                        <?}?>
                    </table>
                    <br>
                </div>  
	          </div>
	    
	    <div class="col-lg-8">
		<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>Analisa Tempahan Bahan Bacaan Mengikut Kategori</b></center>
				</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
							
								<th bgcolor="yellow" width="7%">Bil.</center></th>
								<th bgcolor="yellow" width="70%">Kategori</center></th>
								<th bgcolor="yellow" width="10%"><center>Jum. Tempahan</center></th>
								
							</tr>
						</thead>
						<tbody>
							
							   <?
                        		$analisa_tempahan_kategori = getAnalisaTempahanByKategori();
                        		$i=1;
                        		while($kategori = $analisa_tempahan_kategori->fetch_assoc()) {
                            	?>
                            	<tr>
                                    <td><b><?echo $i++;?></b></td>
                                    <td><b><font size="4" color="brown"><?echo $kategori['jenis'];?></font></b></td>
                                    <td><b><font size="5" color="green"><center><?echo $kategori['bil_tempahan'];?></center></font></b></td>
                            	</tr>
                                <?}?>
						</tbody>
					</table>
		</div>
		</div>
	    </div>
	    
	    <br><br><br>
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
 	$(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            paging: false,
            info: false,
            searching: true
        });

 		$('table tr').click(function(){ 
 			window.open($(this).attr('href'),target="blank");
 			return false; 
 		}); 

 	});

 </script>
</body>
</html>