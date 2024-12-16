<?php
require "../model/aims_medical_analysis_function.php";
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
        padding-bottom: 15px;   }
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
            <div class="navbar-header" style="width:100%">
                <table align="left" border="0" width="100%">
                    <tr bgcolor="yellow">
                        <td width="10%" align="right">
                        </td>
                        <td  align="center" width="70%" rowspan="2">
                            &nbsp;&nbsp;<strong><font size="5" color="brown">MEDICAL ANALYSIS MONTHLY / WEEKLY / DAILY</font></strong>
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
            <div class="col-lg-12">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <center><b>ANNUAL MEDICAL REPORT</b></center>
                    </div>
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                <?
                                    echo "<th width='30%'></th>";
                                    for ($i = 0; $i < 4; $i++)
                                    {
                                        
                                            $_bgcolor = "";
                                            if($i == 0) $_bgcolor = " bgcolor=\"yellow\"";
                                            echo "<th width='18%' ".$_bgcolor."><center>".($date_year-$i)."</center></th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                   <?
                                    echo "<td><font color='black' size='3'><strong>TOTAL AMOUNT</strong></font></td>";
                                    for ($i = 0; $i < 4; $i++)
                                    {
                                            $_bgcolor = "";
                                            $_fcolor = "blue";
                                            if($i == 0){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="blue";}
                                            echo "<td ".$_bgcolor."><font size='4' color='".$_fcolor."'><center><strong>".getAnalisaTotalJualanByYear(($date_year-$i))."</strong></center></font></td>";
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
            
        <div class="col-lg-12">
            <div class="col-lg-12">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <center><b>MONTHLY MEDICAL REPORT</b></center>
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
                                   echo "<th width='20%'><font color='black' size='3'><strong>TOTAL AMOUNT</strong></font></th>";
                                    
                                    

                                    for ($i = 0; $i < $arrlength; $i++)
                                    {
                                        $noofmonth = "";
                                        if(strlen($i+1)==1) {
                                            $noofmonth = $date_year.'0'.($i+1);
                                            $bulan = '0'.($i+1);
                                        }else{
                                            $noofmonth = $date_year.''.($i+1);
                                            $bulan = ($i+1);
                                        }
                                            $_fcolor = "blue";
                                            $_bgcolor = "";
                                            if(intval($i) == intval($date_month-1)){ $_bgcolor = " bgcolor=\"yellow\""; $_fcolor="blue";}
                                            echo "<td width='6.67%' ".$_bgcolor."><font size='4' color='".$_fcolor."'><center><strong>".getAnalisaTotalJualanByMonth($noofmonth)."</strong></center></font></td>";
                                    }
                                    ?>
                                </tr>
                                </tr>
                            </tbody>
                        </table>
                </div>


            <div class="panel panel-red">
                <div class="panel-heading">
                    <center><b>WEEKLY MEDICAL REPORT</b></center>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                        <?  
                            echo "<th width='40%'></td>";
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

                                
                                if($day == strtolower($rollover)){  
                                    //$weeks ++;
                                    $_first=$year."-".$month."-".$firstofweek;
                                    $firstofweek=$i;
                                    $_last=$year."-".$month."-".($i);
                                    $_bgcolor = "";
                                    if(isDateInRange($_first, $_last, $date)) $_bgcolor = " bgcolor=\"yellow\"";
                                    echo "<th width='100px'".$_bgcolor."><center>W".$weeks."</center></th>";
                                    $weeks ++;
                                    
                                }else if($total_days== $i){
                                    // $_bgcolor = " bgcolor=\"yellow\"";
                                    $_first=$year."-".$month."-".$firstofweek;
                                    $firstofweek=$i+1;
                                    $_last=$year."-".$month."-".($i);
                                    // echo "<th><center>W".$weeks."</center></th>";
                                    echo "<th width='100px'".$_bgcolor."><center>W".$weeks."</center></th>";
                                    $weeks ++;
                                }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            
                            
                            <?  
                            echo "<td><font color='black' size='3'><strong>TOTAL AMOUNT</strong></font></td>";
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
                                        $_fcolor="blue";}
                                    echo "<td ".$_bgcolor."><center><font size='4' color='".$_fcolor."'><strong>".
                                    getAnalisaTotalJualanByWeek($_first, $_last)
                                    ."</strong></font></center></td>";
                                    
                                    
                                }else if($total_days== $i){
                                    // $_bgcolor = " bgcolor=\"yellow\"";
                                    $_first=$year."-".$month."-".$firstofweek;
                                    $firstofweek=$i;
                                    $_last=$year."-".$month."-".($i);
                                    echo  "<td ".$_bgcolor."><center><font size='4' color='".$_fcolor."'><strong>".
                                    getAnalisaTotalJualanByWeek($_first, $_last)
                                    ."</strong></font></center></td>";
                                }
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="panel panel-red">
                <div class="panel-heading">
                    <center><b>DAILY MEDICAL REPORT</b></center>
                </div>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                 <th></th>
                                <th width="12%" <?php highlightDay(0); ?>><center>Sunday<br><?php echo date("d M Y",strtotime(getPastDate(0))); ?></center></th>
                                <th width="12%" <?php highlightDay(1); ?>><center>Monday<br><?php echo date("d M Y",strtotime(getPastDate(1))); ?></center></th>
                                <th width="12%" <?php highlightDay(2); ?>><center>Tuesday<br><?php echo date("d M Y",strtotime(getPastDate(2))); ?></center></th>
                                <th width="12%" <?php highlightDay(3); ?>><center>Wednesday<br><?php echo date("d M Y",strtotime(getPastDate(3))); ?></center></th>
                                <th width="12%" <?php highlightDay(4); ?>><center>Thursday<br><?php echo date("d M Y",strtotime(getPastDate(4))); ?></center></th>
                                <th width="12%" <?php highlightDay(5); ?>><center>Friday<br><?php echo date("d M Y",strtotime(getPastDate(5))); ?></center></th>
                                <th width="12%" <?php highlightDay(6); ?>><center>Saturday<br><?php echo date("d M Y",strtotime(getPastDate(6))); ?></center></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td width='18%'><font color='black' size='3'><strong>TOTAL AMOUNT</strong></font></td>
                                <td <?php highlightDay(0); ?>><strong><font color="blue" size="4"><center><?php echo getAnalisaTotalJualanByDay(getPastDate(0)); ?></center></font></strong></td>
                                <td <?php highlightDay(1); ?>><strong><font color="blue" size="4"><center><?php echo getAnalisaTotalJualanByDay(getPastDate(1)); ?></center></font></strong></td>
                                <td <?php highlightDay(2); ?>><strong><font color="blue" size="4"><center><?php echo getAnalisaTotalJualanByDay(getPastDate(2)); ?></center></font></strong></td>
                                <td <?php highlightDay(3); ?>><strong><font color="blue" size="4"><center><?php echo getAnalisaTotalJualanByDay(getPastDate(3)); ?></center></font></strong></td>
                                <td <?php highlightDay(4); ?>><strong><font color="blue" size="4"><center><?php echo getAnalisaTotalJualanByDay(getPastDate(4)); ?></center></font></strong></td>
                                <td <?php highlightDay(5); ?>><strong><font color="blue" size="4"><center><?php echo getAnalisaTotalJualanByDay(getPastDate(5)); ?></center></font></strong></td>
                                <td <?php highlightDay(6); ?>><strong><font color="blue" size="4"><center><?php echo getAnalisaTotalJualanByDay(getPastDate(6)); ?></center></font></strong></td>
                            </tr>
                        </tbody>

                    </table>
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

 <script>
    $(document).ready(function(){ 
        $('table tr').click(function(){ 
            window.open($(this).attr('href'),target="blank");
            return false; 
        }); 
    });

     $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
 </script>
</body>
</html>