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
$month=$_GET['month'];
$client_name=$_GET['client_name'];
$payment_status = $_GET['payment_status'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$list_invoice = getInvoiceList($year,$client_name,$month,$department_sub)->fetch_assoc();
$year=$_GET['year'];

if(!isset($year)){
    $year=date('Y');

}

if(!isset($month)){
    $month=date('m');

}

if (!isset($client_name) && $client_name == '') {
    $client_name = '0';
}

if (!isset($payment_status) && $payment_status == '') {
    $payment_status = '0';
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
                <h1 class="page-header">Invoice List</h1>
            </div>
        </div>

        <table width="100%" class="table table-striped table-bordered table-hover">
            <thead style="background-color:orange">
            <tr>
                <th width="25%">Total Invoice</th>
                <th width="25%">Pending</th>
                <th width="25%">Received Payment</th>
                <th width="20%">Closed Invoice</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><font size='6'><? echo getTotalInvoice($year); ?></font></td>
                <td><a href="#myModal4" data-toggle="modal"><font size='6' color="yellow"><b><? echo getTotalInvoiceSubmitted($year);?></b></a></td>
                <td><a href="#myModal2" data-toggle="modal"><font size='6' color="green"><b><? echo getTotalReceivedPayment(1,$year);?></b></a></td>
                <td><a href="#myModal6" data-toggle="modal"><font size='6' color="orange"><b><? echo getTotalClosedPayment(2,$year);?></b></a></td>
            </tr>
            </tbody>
        </table>

        <div class="form-group" align="right">
        </div>

        <div class="form-group col-lg-2" >
            <select  required class="form-control" name="year" id="year">
                <option value="0">-- Choose Year--</option>
                <? echo getDropDownYear($year);?>
            </select>
        </div>

        <div class="col-lg-4">

            <!--BUAT TABLE MONTH-->
            <select  required class="form-control" name="month" id="month" value="<?echo $month?>">
                <option value="0">-- Choose Month--</option>
                <? echo getDropDownMonthInvoice($month);?>
            </select>
        </div>

        <div class="col-lg-4">
            <select  required class="form-control" name="client_name" id="client_name" value="<?echo $client_name?>">
                <option value="0">-- Pilih Client--</option>
                <? echo getDropDownClient($client_name);?>
            </select>
        </div>
        <div class="form-group" align="right">
            <a href="aims_invoice_print.php">
                <button type="button" class="btn btn-primary">Print</button></a>
        </div>



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Invoice List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_senarai_invoice.php?year=<? echo $year;?>&month=<? echo $month;?>&client_name=<? echo $client_name;?>&payment_status=0">Pending</a>&nbsp;|&nbsp;
                        <a href="aims_senarai_invoice.php?year=<? echo $year;?>&month=<? echo $month;?>&client_name=<? echo $client_name;?>&payment_status=1">Received</a>&nbsp;|&nbsp;
                        <a href="aims_senarai_invoice.php?year=<? echo $year;?>&month=<? echo $month;?>&client_name=<? echo $client_name;?>&payment_status=2">Closed</a>&nbsp;&nbsp;

                    </div>


                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Detail</th>
                                <th>Invoice No</th>
                                <th>Date Submit Invoice</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Date Received Payment</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?


                            if($payment_status == '0') {
                                $invoice = getInvoiceList($year,$client_name,$month,$department_sub);
                            }
                            else if ($payment_status == '1'){
                                $invoice = getInvoiceListReceived($year,$client_name,$month,$department_sub);
                            }
                            else {
                                $invoice = getInvoiceListClosed($year,$client_name,$month,$department_sub);
                            }

                            $i=1;
                            while($list_invoice = $invoice->fetch_assoc()) {

                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i++; ?></td>
                                <td><b>Job No: </b></br><?php echo $list_invoice['job_no']; ?></br>
                                    <b>Client: </b></br><?php echo $list_invoice['client_name']; ?></br>
                                    <b>Date Received: </b></br><?php echo $list_invoice['date_received']; ?>
                                </td>
                                <td><?php echo $list_invoice['invoice_no']; ?></td>
                                <td><?php echo $list_invoice['date_submit']; ?></td>
                                <td><b>Total Amount: </b></br><?php echo 'RM'.number_format($list_invoice['total_invoice'],2,'.',','); ?></br>
                                    <b>Total Paid: </b></br><?php echo 'RM'.number_format($list_invoice['paid'],2,'.',','); ?></br>
                                    <b>Total Unpaid: </b></br><?php echo 'RM'.number_format($list_invoice['unpaid'],2,'.',','); ?>
                                </td>


                                <td style="text-align:center"><?php $list_invoice['payment_status'];
                                    if($list_invoice['payment_status'] == 0){
                                        echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";
                                    }
                                    else if ($list_invoice['payment_status'] == 1){
                                        echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>RECEIVED</span>"; }
                                    else {
                                        echo "<span style='background-color:#FD7808; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>CLOSED</span>"; }?>
                                </td>

                                <td><?php echo $list_invoice['date_received_payment']; ?></td>

                                <td style="text-align:center"><?php $list_invoice['status'];
                                    '<b>' .$list_invoice['term_of_payment'];

                                    date_default_timezone_set("Asia/Kuala_Lumpur");
                                    $period = $list_invoice['term_of_payment'];

                                    $myDateTime3 = DateTime::createFromFormat('Y-m-d', $list_invoice['date_submit']);
                                    $datesubmit = $myDateTime3->format('Y-m-d');

                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $list_invoice['date_received_payment']);
                                    $date = $myDateTime->format('Y-m-d');

                                    $duedate1 = date("Y-m-d", strtotime($datesubmit.' + '.$list_invoice['term_of_payment'].' days'));

                                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $duedate1);
                                    $duedate = $myDateTime2->format('Y-m-d');

                                    if($list_invoice['term_of_payment'] >= 2){
                                        if($list_invoice['date_received_payment'] == '0000-00-00'){
                                            echo "<span style='background-color:YELLOW; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span><br/>";
                                        }
                                        else if($date <= $duedate){
                                            echo "<span style='background-color:GREEN; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>TIMELY</span><br/>";
                                        }
                                        else if($date > $duedate){
                                            echo "<span style='background-color:RED; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>OVERDUE</span><br/>";
                                        }
                                    }
                                    else if($list_invoice['term_of_payment'] == 1){
                                        if($list_invoice['date_received_payment'] == '0000-00-00'){
                                            echo "<span style='background-color:YELLOW; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span><br/>";
                                        }
                                        else if($date <= $duedate){
                                            echo "<span style='background-color:GREEN; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>TIMELY</span><br/>";
                                        }
                                        else if($date > $duedate){
                                            echo "<span style='background-color:RED; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>OVERDUE</span><br/>";
                                        }
                                    }


                                    echo "<label id='duedate' name='duedate' style='padding:10px'>Due Date: ".$list_invoice['duedate']."</label></b>";

                                    if($list_invoice['payment_status'] == 0){
                                        if($current_date > $duedate){ ?>
                                            <span style='background-color:RED; padding:4px; border-radius: 5px; font-weight: bold; color:white;'>OVERDUE</span><br/>
                                        <?	}}


                                    ?>
                                </td>


                                <td><?php echo $list_invoice['remarks']; ?></td>
                                <td><?php echo $list_invoice['created_date']; ?></td>


                                <td>

                                    <?	'<b>'.$ot['payment_status'].'</b>';
                                    if($list_invoice['payment_status']==0){ ?>
                                        <a href="#myModal" data-toggle="modal" data-id="<? echo $list_invoice['id'];?>"><button type="button" class="btn btn-info">Show Info</button></a>
                                        <a href="aims_invoice_update.php?id=<? echo $list_invoice['id']; ?>" class="btn btn-primary">Update</a>
                                        <a href="../controller/aims_invoice_delete_exec.php?id=<? echo $list_invoice['id']; ?>&billing_id=<?php echo $list_invoice['billing_id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                        <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_invoice['id'];?>"><button type="button" class="btn btn-warning">Payment Status</button></a>
                                        <?
                                    }else if($list_invoice['payment_status']==1){	?>
                                        <a href="#myModal" data-toggle="modal" data-id="<? echo $list_invoice['id'];?>"><button type="button" class="btn btn-info">Show Info</button></a>
                                        <a href="aims_invoice_update.php?id=<? echo $list_invoice['id']; ?>" class="btn btn-primary">Update</a>
                                        <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_invoice['id'];?>"><button type="button" class="btn btn-warning">Payment Status</button></a>
                                        <a href="../controller/aims_invoice_closed_exec.php?billing_id=<? echo $list_invoice['billing_id']; ?>&invoice_no=<?php echo $list_invoice['invoice_no']; ?>"><button class="btn btn-success" type="button" onclick="return confirm('Are you sure you want to close?');">Closed</button></a>

                                        <?
                                    }else	{ ?>

                                        <a href="#myModal" data-toggle="modal" data-id="<? echo $list_invoice['id'];?>"><button type="button" class="btn btn-info">Show Info</button></a>
                                        <a href="aims_invoice_update.php?id=<? echo $list_invoice['id']; ?>" class="btn btn-primary">Update</a>
                                    <?	}
                                    } ?>

                                </td>
                            </tr>


                            </tbody>

                        </table>
                    </div>
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

    <div class="modal fade modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Invoice Info</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_invoice_info.php',
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


    <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel4">(PENDING PAYMENT) Client Info</h4>
                </div>
                <div class="modal-body" id="demo4">
                    <script type="text/javascript">
                        $('#myModal4').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_client_pending_info.php?year=<? echo $year?>',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo4').html(html);
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
                    <h4 class="modal-title" id="myModalLabel">(RECEIVED PAYMENT) Client Info</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_client_received_info.php?year=<? echo $year?>',
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

    <div class="modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabe6">(CLOSED PAYMENT) Client Info</h4>
                </div>
                <div class="modal-body" id="demo6">
                    <script type="text/javascript">
                        $('#myModal6').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo6').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_client_closed_info.php?year=<? echo $year?>',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo6').html(html);
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

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Payment Status</h4>
                </div>
                <div class="modal-body" id="demo5">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo5').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_payment_invoice_modal.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo5').html(html);
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

        $("#year,#month,#client_name").change(function(){
            var selected_year=$('#year').val();
            var selected_month=$("#month").val();
            var selected_client=$('#client_name').val();
            sendType(selected_year,selected_month,selected_client);
        });

        function sendType(selected_year,selected_month,selected_client){
            //console.log(obj);
            window.location.href = "aims_senarai_invoice.php?year="+selected_year+"&month="+selected_month+"&payment_status=<?echo $payment_status;?>&client_name="+selected_client;
        }

    </script>

</body>

</html>