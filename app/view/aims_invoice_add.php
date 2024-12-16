<?php

include ('../controller/auth.php');

require "../model/aims_billing_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$payment = $_GET['payment'];
$days = $_GET['days'];
$billing_info = getBillingById($id)->fetch_assoc();
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
                <h1 class="page-header">Add Invoice</h1>
                <div class="panel-heading" align="right">
                    <input class="btn btn-primary" type="button" value="Back" onclick="goBack()">
                    <a href="aims_senarai_invoice.php"><button type="button" class="btn btn-primary">See Invoice List</button></a>
                </div>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_invoice_exec.php">
                            <input id="billing_id" name="billing_id" type="hidden" value="<? echo $id?>"/>
                            <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>





                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Job No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="job_no" name="job_no" type="text" required value="<? echo $billing_info['job_no'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Total Invoice<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="total_invoice" name="total_invoice" type="text" required value="<? echo 'RM '.number_format($billing_info['total_invoice'],2,'.',','); ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <input class="form-control" id="unpaid" name="unpaid" type="hidden"  value="<? echo $billing_info['total_invoice']?>" style="text-transform:uppercase"/>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Date Received Bill<font color="red">&nbsp;*</font></label>
                                    <? $date_received = new DateTime ($billing_info['created_date']);  ?>
                                    <input class="form-control" id="date_received" name="date_received" type="date" required value="<? echo $date_received->format('Y-m-d'); ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"readonly/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Invoice No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="invoice_no" name="invoice_no" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Date Submit Invoice<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="date_submit" name="date_submit" type="date" required value="" style="text-transform:uppercase" onchange="setDueDate(event)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Submission By<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="submission" name="submission" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">SES No Received</label>
                                    <input class="form-control" id="ses_no_received" name="ses_no_received" type="text" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Term Of Payment<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="term_of_payment" name="term_of_payment" type="number" required value="<? echo $billing_info['term_of_payment'] ?>"  style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                                <br><br>
                                <b><span style="text-align:center;padding-left: -80px">Days</span></b>
                            </div>


                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Aging(Days)</label>
                                    <input class="form-control" id="aging" name="aging" type="text" value="" style="text-transform:uppercase" />
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Remarks</label>
                                    <input class="form-control" id="remarks" name="remarks" type="text" value="" style="text-transform:uppercase" value=""/>
                                </div>
                            </div>

                            <!--<div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Due Date<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="duedate" name="duedate" type="date" required style="text-transform:uppercase" value="setDueDate(event)"/>
                                </div>
                            </div>-->

                            <div align="center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
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

        function setDueDate(e){

            var period = document.getElementById('term_of_payment').value;
            var datesubmit = document.getElementById('date_submit').value;
            var duedate1 = new Date(datesubmit);
            var duedate2 = new Date(duedate1);

            duedate2.setDate(duedate2.getDate() + period);
            var duedate3 = duedate2
            //var duedate4 = new Date(duedate3)

            var duedate = document.getElementById('duedate');
            duedate.value = duedate3;





        }




    </script>

</body>

</html>