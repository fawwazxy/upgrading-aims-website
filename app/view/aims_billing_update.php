


<?php

include ('../controller/auth.php');

require "../model/aims_billing_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
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
                <h1 class="page-header">Billing List</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">

                        <form method="post" action="../controller/aims_billing_update_exec.php">
                            <input id="id" name="id" type="hidden" value="<? echo $id?>"/>

                            <input id="updated_by" name="updated_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>





                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Client Name<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="client_id" id="client_id">
                                        <option value="">-- Choose Client Name --</option>
                                        <? echo getDropDownClient($billing_info['client_id'])?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Company Name<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="company_id" id="company_id">
                                        <option value="">-- Choose Company Name --</option>
                                        <? echo getDropDownCompany($billing_info['company_id']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Job No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="job_no" name="job_no" type="text" required value="<? echo $billing_info['job_no'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Job Description<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="job_description" name="job_description" type="text" required value="<? echo $billing_info['job_description'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">TIN No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="tin_no" name="tin_no" type="text" required value="<? echo $billing_info['tin_no'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Amount to Invoice (RM)<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="amount_to_invoice" name="amount_to_invoice" type="text" required value="<? echo $billing_info['amount_to_invoice'] ?>" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">SST<font color="red">&nbsp;</font></label>
                                    <input class="form-control" id="sst" name="sst" type="text" required value="<? echo $billing_info['sst'] ?>" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Amount Credit Note<font color="red">&nbsp;</font></label>
                                    <input class="form-control" id="amount_credit_note" name="amount_credit_note" type="text" required value="<? echo $billing_info['amount_credit_note'] ?>" style="text-transform:uppercase" onkeyup="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Total Amount (RM)<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="total_invoice" name="total_invoice" type="text" required value="<? echo $billing_info['total_invoice'] ?>" style="text-transform:uppercase" value="multi()"/>
                                </div>
                            </div>

                            <div align="center">
                                <button type="submit" class="btn btn-success">Edit</button>
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


        function multi() {

            var amount_to_invoice = document.getElementById('amount_to_invoice').value;
            var sst = document.getElementById('sst').value;
            var b = (amount_to_invoice * sst);
            var total_amount = ((amount_to_invoice * 1) + b).toFixed(2);
            var total= total_amount.toString().replace(/\B(?=(\d{4})+(?!\d))/g, ",");
            var total_amount = document.getElementById('total_amount');
            total_amount.value = total;


        }



    </script>

</body>

</html>