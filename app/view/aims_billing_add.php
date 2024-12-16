<?php

include ('../controller/auth.php');

require "../model/aims_billing_function.php";
require "../model/lookup.php";

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
<style type="text/css">
    input.unit{
        width: 100px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 6px 6px 6px 6px;
    }

    input.mycheck{

        display: inline-block;
        margin-left: 250px;
    }

    /* On mouse-over, add a grey background color */
    .mycheck:hover{
        background-color: black;
    }

    input{
        text-transform: uppercase;
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
                <h1 class="page-header">Billing List</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_billing_exec.php">
                            <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>



                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Client Name<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="client_id" id="client_id">
                                        <option value="">-- Choose Client Name --</option>
                                        <? echo getDropDownClient("");?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Company Name<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="company_id" id="company_id">
                                        <option value="">-- Choose Company Name --</option>
                                        <? echo getDropDownCompany("");?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Job No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="job_no" name="job_no" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Job Description<font color="red">&nbsp;*</font></label>
                                    <textarea class="form-control" id="job_description" name="job_description" type="text" rows="5" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"></textarea>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">TIN No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="tin_no" name="tin_no" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Amount to Invoice (RM)<font color="red">&nbsp;*</font></label>
                                    <input class="form-control auto-number" id="amount_to_invoice" name="amount_to_invoice" type="text" required value="" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">SST<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="sst" id="sst" onchange="multi()">
                                        <option value="">-- SST --</option>
                                        <option value="0.06">0.06</option>
                                        <option value="0.00">0.00</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row" align="left">

                                <div class="col-xs-4">
                                    <label class="control-label">Amount Credit Note (RM)</label>
                                    <input class="form-control auto-number" id="amount_credit_note" name="amount_credit_note" type="text" value="" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Amount Debit Note (RM)</label>
                                    <input class="form-control auto-number" id="amount_debit_note" name="amount_debit_note" type="text" value="" style="text-transform:uppercase"  onkeyup="multi()"/>
                                </div>
                            </div>


                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Total Invoice (RM)<font color="red">&nbsp;*</font></label>
                                    <input class="form-control auto-number" id="total_invoice" name="total_invoice" type="text" readonly required value="" style="text-transform:uppercase" value="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Date Prepared<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="date_prepared" name="date_prepared" type="date" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Vessel</label>
                                    <input class="form-control" id="vessel" name="vessel" type="text" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Term Of Payment <font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="term_of_payment" name="term_of_payment" type="number" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                                <br><br>
                                <b><span style="text-align:center;padding-left: -80px">Days</span></b>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Date Movement<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="date_movement" name="date_movement" type="text" placeholder="dd/mm/yyyy-dd/mm/yyyy" required value="" style="text-transform:uppercase" />
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">PO No</label>
                                    <input class="form-control" id="po_no" name="po_no" type="text" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">DO No</label>
                                    <input class="form-control" id="do_no" name="do_no" type="text" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div align="center">
                                <button type="submit" class="btn btn-success" id="submit-btn">Save</button>
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


        function multi() {

            var amount_to_invoice = document.getElementById('amount_to_invoice').value;
            var sst = document.getElementById('sst').value;
            var amount_credit_note = document.getElementById('amount_credit_note').value;
            var amount_debit_note = document.getElementById('amount_debit_note').value;

            var b = (amount_to_invoice * sst);
            var total_inv = (((amount_to_invoice * 1) + b)-amount_credit_note).toFixed(2);
            var total_invo = ((+total_inv) + (+amount_debit_note));
            var total= total_invo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var total_invoice = document.getElementById('total_invoice');
            total_invoice.value = total;

        }


    </script>

</body>

</html>