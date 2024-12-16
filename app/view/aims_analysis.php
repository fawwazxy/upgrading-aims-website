<?php
require "../model/aims_analysis_function.php";
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
$year=$_GET['year'];

if(!isset($year)){
    $year=date('Y');

}

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
    .center {
        margin: auto;
        padding: 10px;
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
                <h1 class="page-header">Management Analysis</h1>
            </div>
        </div>

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" style="width:100%">
                <table align="left" border="0" width="100%">
                    <tr bgcolor="orange">
                        <td width="10%" align="right">
                        </td>
                        <td align="center" width="70%" colspan="3">
                            &nbsp;&nbsp;<strong><font size="5">REPORT SUMMARY</font></strong></br>
                            <div class="form-group col-lg-3" style="left:270px">
                                <select  required class="form-control" name="year" id="year">
                                    <option value="0">-- Choose Year--</option>
                                    <? echo getDropDownYear($year);?>
                                </select>
                            </div>
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
                            <th width="40%" colspan="4" rowspan="2" style="padding-top: 40px;">Total Billing Generated</th>
                            <th width="30%" colspan="3" style="padding-top: 40px;">Payment</th>
                            <th width="30%" rowspan="2" style="padding-top: 40px;">Total Amount (RM)</th>
                        </tr>

                        <?php
                        $sum = getTotalAmount($year);
                        ?>

                        <tr style = "background-color:orange">
                            <td colspan="2">Received</td>
                            <td>Pending</td>
                        </tr>

                        <tr style="height:10px">
                            <td colspan="4"><font size='7'><? echo getTotalBilling($year); ?></font></td>
                            <td colspan="2"><font size='7'><? echo getTotalReceivedPayment(1,$year);?></font></td>
                            <td rowspan="3"><font size='7' style="color:yellow; font-weight:bold"><? echo getTotalBillingSubmitted($year);?></font></td>
                            <td rowspan="3"><font size='7' style="color:blue; font-weight:bold"><?  echo number_format($sum,2,'.',',');?></font></td>
                        </tr>

                        <tr style = "background-color:orange">
                            <td>New</td>
                            <td>Submitted</td>
                            <td>Process By Finance</td>
                            <td>Closed</td>
                            <td>Timely</td>
                            <td>Overdue</td>
                        </tr>

                        <tr>
                            <td><font size='5'><? echo getTotalBillingByStatus(0,$year);?></font></td>
                            <td><font size='5'><? echo getTotalBillingByStatus(4,$year);?></font></td>
                            <td><font size='5'><? echo getTotalBillingByStatus(1,$year);?></font></td>
                            <td><font size='5'><? echo getTotalBillingByStatus(3,$year);?></font></td>
                            <td style="background-color:"><font size='5' style="color:green; font-weight:bold"><? echo getTotalTimely(1,$year);?></font>
                            <td style="background-color:"><font size='5' style="color:red; font-weight:bold"><? echo getTotalOverdue(2,$year);?></font>
                            </td>
                        </tr>
                    </table>



                    <!--
							
								
						
							<?php
                    $sum = getTotalAmount();
                    ?>
							
								<tr>
								   <td><font size='7'><? echo getTotalBilling($year); ?></font></td>
								   <td><font size='7'><? echo getTotalBillingByStatus(0,$year);?></font></td>
								   <td><font size='7'><? echo getTotalBillingByStatus(1,$year);?></font></td>
								   <td style="background-color:#FF6347"><font size='7'><? echo getTotalBillingSubmitted($year);?></font></td>
								   <td style="background-color:lightgreen"><font size='7'><? echo getTotalReceivedPayment(1,$year);?></font></td>
								   <td style="background-color:"><font size='7'><? echo getTotalTimely(1,$year);?></font></td>
								   <td style="background-color:"><font size='7'><? echo getTotalOverdue(2,$year);?></font></td>

								   
								   <td><font size="7"><?  echo number_format($sum,2,'.',',');?></font></td>
								</tr>

							
						</table> -->

                </div>
                <!-- /.col-lg-12 -->

                <div class="panel-heading" align="center">

                    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 10; padding-top:50px">
                        <div class="navbar-header" style="width:100%">
                            <table align="left" border="0" width="100%">
                                <tr bgcolor="orange">
                                    <td width="10%" align="right">
                                    </td>
                                    <td align="center" width="70%" rowspan="2">
                                        &nbsp;&nbsp;<strong><font size="5">INVOICE DETAILS</font></strong>
                                    </td>
                                    <td width="60%">
                                        <h1 align="right">
                                            <font color="black">

                                            </font>
                                        </h1>
                                        <h4 align="right">
                                            <font color="black">

                                            </font>
                                        </h4>
                                    </td>
                                    <td width="30%">&emsp;&emsp;</td>
                                </tr>
                            </table>
                        </div>
                    </nav>



                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead style = "background-color:darkorange">
                        <tr>
                            <th colspan="2" width="40%">Invoice</th>
                            <th colspan="4" width="60%">Payment</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr style = "background-color:orange;">
                            <th rowspan="2">Total Invoice</th>
                            <th rowspan="2">Total Amount (RM)</th>
                            <th colspan="2">Paid</th>
                            <th colspan="2" style="width:30%">Unpaid</th>
                            <!--	<th rowspan="2" style = "background-color:darkorange; font-size:24px"> Total Amount (RM)</th> -->
                        </tr>

                        <tr style="background-color:orange">
                            <th>Total</th>
                            <th>Amount (RM)</th>
                            <th>Total</th>
                            <th>Amount (RM)</th>
                        </tr>

                        <?php
                        $sum = getTotalAmountInvoice($year);
                        $sum_paid = getTotalPaid ($year);
                        $sum_unpaid = getTotalUnpaid($year);
                        ?>


                        <tr>
                            <td><font size='5' style="color:blue; font-weight:bold"><? echo getTotalInvoice($year); ?></font></td>
                            <td><font size='5'><? echo "<font color='blue' size='5' style='font-weight:bold'>".number_format($sum,2,'.',',')."</font>";?></font></td>

                            <td><font size='5' style="color:green; font-weight:bold" ><? echo getTotalPaidClient($paid,$year);?></font></td>

                            <td><a href="#myModal2" data-toggle="modal"><font size='5' style="color:green; font-weight:bold"><? echo number_format($sum_paid,2,'.',',');?></font></a></td>

                            <td><font size='5' style="color:red; font-weight:bold"><? echo getTotalUnpaidClient($unpaid,$year);?></font></td>

                            <td><a href="#myModal" data-toggle="modal"><font size='5' style="color:red; font-weight:bold"><? echo number_format($sum_unpaid,2,'.',',');?></font></a></td>

                        </tr>

                        </tbody>
                    </table>

                    <br><br><a class="btn btn-primary" onClick="popitup('aims_analysis_detail.php')" target="blank">SALES ANALYSIS MONTHLY / WEEKLY / DAILY</a>
                    <br><br><a class="btn btn-info" onClick="popitup('aims_analysis_report.php?year=<? echo $year?>')" target="blank">GENERATE REPORT <? echo $year ?></a>
                </div>

            </div>

            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">(UNPAID PAYMENT) Client Info</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_client_unpaid_info.php?year=<? echo $year?>',
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">(PAID PAYMENT) Client Info</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_client_paid_info.php?year=<? echo $year?>',
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

        $("#year").change(function(){
            var selected_year=$("#year").val();
            sendType(selected_year);
        });

        function sendType(selected_year){
            //console.log(obj);
            window.location.href = "aims_analysis.php?year="+selected_year;
        }

    </script>

</body>

</html>