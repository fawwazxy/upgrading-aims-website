<?php
require "../model/aims_medical_analysis_function.php";
include ('../controller/auth.php');
require "../model/lookup.php";
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

    <? require "../global/header.php"; ?>

</head>

<?

$month=$_GET['date_created'];

if(!isset($month)){
    $month=$date_month;
}

?>

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
    td,th{
        text-align: center;
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
                <h1 class="page-header">Medical Analysis</h1>
            </div>
        </div>

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" style="width:100%">
                <table align="left" border="0" width="100%">
                    <tr bgcolor="orange">
                        <td width="10%" align="right">
                        </td>
                        <td align="center" width="70%" rowspan="2">
                            &nbsp;&nbsp;<strong><font size="5">MEDICAL REPORT SUMMARY</font></strong>
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

        <div class="form-group" align="right">
        </div>



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </div>
                    <!-- /.panel-heading -->


                    <table width="100%" class="table table-striped table-bordered table-hover">

                        <tr style = "background-color:darkorange">
                            <th width="40%" colspan="2" style="padding-top: 25px; font-size: 25px; text-align: center;">Total Medical</th>
                            <th width="60%" colspan="2" style="padding-top: 25px; font-size: 25px; text-align: center;">Total Amount(RM)</th>
                        </tr>

                        <?php
                        $sum = getTotalAmount($date_year);
                        ?>

                        <tr style="height:10px">
                            <td colspan="2"><font size='7'><? echo getTotalMedical($date_year); ?></font></td>
                            <td colspan="2"><font size='7' style="color:blue; font-weight:bold"><?  echo number_format($sum,2,'.',',');?></font></td>
                        </tr>

                        <tr style = "background-color:orange">
                            <td>Pending</td>
                            <td>Process</td>
                            <td>Pending(RM)</td>
                            <td>Process(RM)</td>
                        </tr>

                        <tr>
                            <td><font size='6' style="color:yellow; font-weight:bold"><? echo getTotalMedicalPending(PENDING,$date_year);?></font></td>
                            <td><font size='6' style="color:green; font-weight:bold"><? echo getTotalMedicalByStatus(VERIFIED,$date_year);?></font></td>
                            <td><font size='6' style="color:yellow; font-weight:bold"><? echo getTotalAmountPending(PENDING,$date_year);?></font></td>
                            <td><font size='6' style="color:green; font-weight:bold"><? echo getTotalAmountByStatus(VERIFIED,$date_year);?></font></td>
                        </tr>
                    </table>


                </div>


                <br><br><a class="btn btn-primary" onClick="popitup('aims_medical_analysis_details.php')" target="blank">ANALYSIS MONTHLY / WEEKLY / DAILY</a>

                <!--  </div> -->

            </div>

            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">(PENDING PAYMENT) Client Info</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_client_pending_info.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo3').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">(RECEIVED PAYMENT) Client Info</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_client_received_info.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo2').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });



    </script>

</body>

</html>