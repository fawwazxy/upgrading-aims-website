


<?php

include ('../controller/auth.php');

require "../model/aims_invoice_functions.php";
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
$id = $_GET['id'];
$term_of_payment = $_GET['term_of_payment'];
$invoice_info = getInvoiceById($id)->fetch_assoc();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <? require "../global/header.php"; ?>

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
                <h1 class="page-header">Edit Invoice</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">

                        <form method="post" action="../controller/aims_invoice_update_exec.php" enctype="multipart/form-data">
                            <input id="id" name="id" type="hidden" value="<? echo $id?>"/>

                            <input id="updated_by" name="updated_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>


                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Date Received Bill<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="date_received" name="date_received" type="date" required value="<? echo $invoice_info['date_received'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"readonly/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Invoice No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="invoice_no" name="invoice_no" type="text" required value="<? echo $invoice_info['invoice_no'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Total invoice<font color="red">&nbsp;*</font></label>
                                    <input class="form-control auto-number" id="total_invoice" name="total_invoice" type="text" required value="<? echo $invoice_info['total_invoice']; ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" readonly/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Total Paid<font color="red"></font></label>
                                    <input class="form-control auto-number" id="paid" name="paid" type="text" value="<? echo $invoice_info['paid'];?>" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Total Unpaid<font color="red"></font></label>
                                    <input class="form-control auto-number" id="unpaid" name="unpaid" type="text" value="<?echo $invoice_info['unpaid'];?>" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Date Submit Invoice<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="date_submit" name="date_submit" type="date" onchange="calcDate()" required value="<? echo $invoice_info['date_submit'] ?>" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Submission By<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="submission" name="submission" type="text" required value="<? echo $invoice_info['submission'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Ses No Received</label>
                                    <input class="form-control" id="ses_no_received" name="ses_no_received" type="text"  value="<? echo $invoice_info['ses_no_received'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Term Of Payment<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="term_of_payment" name="term_of_payment" type="number" value="<? echo $invoice_info['term_of_payment'] ?>" style="text-transform:uppercase" onkeyup="multi()" onchange="calcDate()"/>
                                </div>
                                <br><br>
                                <b><span style="text-align:center;padding-left: -80px">Days</span></b>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Remarks</label>
                                    <input class="form-control" id="remarks" name="remarks" type="text" value="<? echo $invoice_info['remarks'] ?>" style="text-transform:uppercase"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Aging (Days)</label>
                                    <input class="form-control" id="aging" name="aging" type="text"  value="<?
                                    if ($invoice_info['aging'] != 0) echo $invoice_info['aging'] ;
                                    ?>"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Status<font color="red">&nbsp;*</font></label>


                                    <?php $invoice_info['status'];
                                    "<b>" .$invoice_info['term_of_payment'];

                                    date_default_timezone_set("Asia/Kuala_Lumpur");
                                    $period = $invoice_info['term_of_payment'];

                                    $myDateTime3 = DateTime::createFromFormat('Y-m-d', $invoice_info['date_submit']);
                                    $datesubmit = $myDateTime3->format('Y-m-d');

                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $invoice_info['date_received_payment']);
                                    $date = $myDateTime->format('Y-m-d');

                                    $duedate1 = date("Y-m-d", strtotime($datesubmit.' + '.$invoice_info['term_of_payment'].' days'));

                                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $duedate1);
                                    $duedate = $myDateTime2->format('Y-m-d');

                                    if($invoice_info['term_of_payment'] >= 2){
                                        if($invoice_info['date_received_payment'] == '0000-00-00'){
                                            echo "<input type='hidden' id='status' name='status' value='0'/><span style='background-color:YELLOW; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";
                                        }
                                        else if($date <= $duedate){
                                            echo "<input type='hidden' id='status' name='status' value='1'/><span style='background-color:GREEN; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>TIMELY</span>";
                                        }
                                        else if($date > $duedate){
                                            echo "<input type='hidden' id='status' name='status' value='2'/><span style='background-color:RED; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>OVERDUE</span>";
                                        }
                                    }

                                    else if($invoice_info['term_of_payment'] == 1){
                                        if($invoice_info['date_received_payment'] == '0000-00-00'){
                                            echo "<input type='hidden' id='status' name='status' value='0'/><span style='background-color:YELLOW; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";
                                        }
                                        else if($date <= $duedate){
                                            echo "<input type='hidden' id='status' name='status' value='1'/><span style='background-color:GREEN; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>TIMELY</span>";
                                        }
                                    } "</label>
					
					
					</b>"?></label>
                                    <label style="padding:10px">Due Date: </label>
                                    <input type="date" id="duedate" class="form-control col-md-6" name="duedate" readonly value="<? echo $duedate; ?>" value="multi()"/>
                                </div>
                            </div>

                            <div align="center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <input class="btn btn-primary" type="button" value="Back" onclick="goBack()">
                            </div>
                        </form>
                    </div>
                    <script>
                        function convertToUppercase(el) {
                            if(!el || !el.value) return;
                            el.value = el.value.toUpperCase();
                        }
                    </script>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        function calcDate(){
            var term = $('#term_of_payment').val();
            var date = new Date($('#date_submit').val());
            date.setDate(date.getDate() + parseInt(term));
            var y = (date.getFullYear()).toString();
            var m = (date.getMonth()+1).toString();
            var d = (date.getDate()).toString();
            if (d.length < 2) d = '0'+d;
            if (m.length < 2) m = '0'+m;
            var duedate = y+"-"+m+"-"+d;

            $('#duedate').val(duedate);
        }

        function multi() {

            var total_invoice = document.getElementById('total_invoice').value;
            var paid = document.getElementById('paid').value;
            var total_un = (total_invoice-paid).toFixed(2);
            var total= total_un.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var unpaid = document.getElementById('unpaid');
            unpaid.value = total;


        }

    </script>

</body>

</html>