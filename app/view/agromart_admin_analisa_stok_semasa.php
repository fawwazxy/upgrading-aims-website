<?php
require "../model/agromart_functions.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_year=date("Y");
$current_month=date("m");

$year = $_GET['year'];
$year_selected = $current_year;
if(!empty($_GET['year'])) {
    $year_selected=$year;
}

$month = $_GET['month'];
$month_selected = $current_month;
if(!empty($_GET['month'])) {
    $month_selected=$month;
}

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

<script language="javascript" type="text/javascript">
setInterval(function () {
    
   location.reload();
     
    
 }, 30000);
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
                            &nbsp;&nbsp;<strong><font size="5" color="brown">ANALISA STOK SEMASA</font></strong>
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
        </div>
            <div class="col-lg-4">
                <label class="control-label" for="date">Pilihan Tahun</label>
                    <select required class="form-control" id="year" name="year" value="" onchange="reloadMonthAnalisa()">
                        <?echo getDropDownTahunStok($year);?>
                    </select>
            </div>
            <div class="col-lg-4">
                <label class="control-label" for="date">Pilihan Bulan</label>
                    <select required class="form-control" id="month" name="month" value="" onchange="reloadMonthAnalisa()">
                    <option value="01" <?echo ("01"==$month_selected?'selected':'')?>>Januari</option>
                    <option value="02" <?echo ("02"==$month_selected?'selected':'')?>>Februari</option>
                    <option value="03" <?echo ("03"==$month_selected?'selected':'')?>>Mac</option>
                    <option value="04" <?echo ("04"==$month_selected?'selected':'')?>>April</option>
                    <option value="05" <?echo ("05"==$month_selected?'selected':'')?>>Mei</option>
                    <option value="06" <?echo ("06"==$month_selected?'selected':'')?>>Jun</option>
                    <option value="07" <?echo ("07"==$month_selected?'selected':'')?>>Julai</option>
                    <option value="08" <?echo ("08"==$month_selected?'selected':'')?>>Ogos</option>
                    <option value="09" <?echo ("09"==$month_selected?'selected':'')?>>September</option>
                    <option value="10" <?echo ("10"==$month_selected?'selected':'')?>>Oktober</option>
                    <option value="11" <?echo ("11"==$month_selected?'selected':'')?>>November</option>
                    <option value="12" <?echo ("12"==$month_selected?'selected':'')?>>Disember</option>
                    </select><br>
          </div>
           
        <!-- Table Sasaran Jualan -->
        <div class="col-lg-12">
                <?
                    $jumlah_keseluruhan_stok = getCountAnalisaStokSemasa($month_selected,$current_year);
                ?>
            <b><font color="brown" size="5">JUMLAH STOK SEMASA : <?echo $jumlah_keseluruhan_stok;?></font></b>
            <br><br>
            <div class="panel panel-red">
                <div class="panel-heading">
                   <center><b>Analisa Stok Semasa (<?echo $month_selected?>)</b></center>
                </div>
                <div style="padding-left: 15px;padding-right: 15px;padding-top: 15px;">
                <table width="100%" class="table  table-bordered" id="dataTables-example">
                    <thead>
                        <tr>
                        <th width="7%">Bil.</th>
                        <th width="25%">Info Pembekal</th>
                        <th width="20%">Info Item</th>
                        <th width="15%">Meter Minimum</th>
                        <th width="15%">Jumlah Stok Semasa</th>
                        <th width="15%">Shortage / Surplus</th>
                        </tr>
                            
                    </thead>
                    <tbody>
                        <? 
                            $analisa_stok = getAnalisaStokSemasa($month_selected,$year_selected); 
                            $i=1;
                            while($list_analisa_stok = $analisa_stok->fetch_assoc()) {
                                $jumlah_baki_stok = $list_analisa_stok['jumlah_baki_stok'];
                                if($jumlah_baki_stok < 0){
                                    $font = 'color="blue" size="4"';
                                    $jumlah_baki = (0 - $jumlah_baki_stok);
                                }else{
                                    $font = 'color="red" size="4"';
                                    $jumlah_baki = $jumlah_baki_stok;
                                }
                        ?>
                        <tr>
                        <td><?echo $i++;?></td>
                        <td><b><?echo $list_analisa_stok['nama_pembekal'];?></b><br><?echo $list_analisa_stok['nokp'];?></td>
                        <td><b><?echo $list_analisa_stok['barcode'];?> - </b><?echo $list_analisa_stok['nama'];?></td>
                        <td><strong><font color="brown" size="4"><?echo $list_analisa_stok['meter'];?></font></strong></td>
                        <td><strong><font color="purple" size="4"><?echo $list_analisa_stok['kuantiti'];?></font></strong></td>
                        <td><strong><font <? echo $font;?>><?echo $jumlah_baki;?></font></strong></td>
                        </tr>
                           <?}?>
                    </tbody>
                </table>
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
        </div> 
        </div> 
        
    </div>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        });

        function reloadMonthAnalisa(){
            var year = $("#year").val();
            var month = $("#month").val();
            location.href = "agromart_admin_analisa_stok_semasa.php?year="+year+"&month="+month;
        }
   
    </script>
</body>
</html>