<?php

include ('../controller/auth.php');

require "../model/aims_billing_function.php";
require "../model/lookup.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_year = date(Y);
$current_date = $date_year;

//date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$status_billing = $_GET['status_billing'];
$status = $_GET['status_billing'];
$client_name=$_GET['client_name'];
$no_staff = $_SESSION['SESS_NO_STAFF'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$month=$_GET['month'];
$year=$_GET['year'];

if(!isset($year)){
    $year=date('Y');

}

if (!isset($client_name) && $client_name == '') {
    $client_name = '0';
}
if (!isset($status_billing) && $status_billing == '') {
    $status_billing = '0';
}

if(!isset($month)){
    $month=date('m');

}
$sys = getSys(1)->fetch_assoc();
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" >

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

        <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
            <tr style="background-color:orange">
                <th width="25%">Total Billing Generate <? echo $current_year;?></th>
                <th width="15%">New</th>
                <th width="20%">Submitted</th>
                <th width="20%">Processed by Finance</th>
                <th width="25%">Closed</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><font size='6'><? echo getTotalBilling($year); ?></font></td>
                <td><a href="#myModal4" data-toggle="modal"><font size='6' color="yellow"><b><? echo getTotalBillingByStatus(0,$year);?></b></td>
                <td><a href="#myModal7" data-toggle="modal"><font size='6' color="Green"><b><? echo getTotalBillingByStatus(4,$year);?></b></td>
                <td><a href="#myModal2" data-toggle="modal"><font size='6' color="Orange"><b><? echo getTotalBillingByStatus(1,$year);?></b></td>
                <td><a href="#myModal6" data-toggle="modal"><font size='6' color="#FD7808"><b><? echo getTotalBillingByStatus(3,$year);?></b></td>
            </tr>
            </tbody>


        </table>

        <?
        $flagScreen="tab_1";
        include ('../global/menu_commercial.php');
        ?>


        <br>

        <div class="form-group" align="right">
        </div>
        <div class="form-group col-lg-2" >
            <select  required class="form-control" name="year" id="year">
                <option value="0">-- Choose Year--</option>
                <? echo getDropDownYear($year);?>
            </select>
        </div>

        <div class="col-lg-3">

            <!--BUAT TABLE MONTH-->
            <select  required class="form-control" name="month" id="month" value="<?echo $month?>">
                <option value="0">-- Choose Month--</option>
                <? echo getDropDownMonthInvoice($month);?>
            </select>
        </div>

        <div class="col-lg-4">
            <select  required class="form-control" name="client_name" id="client_name">
                <option value="0">-- Pilih Client--</option>
                <? echo getDropDownClient($client_name);?>
            </select>
        </div>



        <div class="form-group" align="right">
        </div>

        <div class="form-group" align="right">
            <a href="aims_billing_add.php"><button type="button" class="btn btn-primary">Add New</button></a>
            <a href="aims_billing_track_sales.php?year=<? echo $year?>"><button type="button" class="btn btn-primary">Track Sales</button></a>
            <a href="aims_billing_print.php">
                <button type="button" class="btn btn-primary">Print</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Billing List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_billing_list.php?year=<? echo $year;?>&month=<? echo $month;?>&client_name=<? echo $client_name;?>&status_billing=0">New</a>&nbsp;|&nbsp;
                        <a href="aims_billing_list.php?year=<? echo $year;?>&month=<? echo $month;?>&client_name=<? echo $client_name;?>&status_billing=4">Submitted</a>&nbsp;|&nbsp;
                        <a href="aims_billing_list.php?year=<? echo $year;?>&month=<? echo $month;?>&client_name=<? echo $client_name;?>&status_billing=1">Processed</a>&nbsp;|&nbsp;
                        <a href="aims_billing_list.php?year=<? echo $year;?>&month=<? echo $month;?>&client_name=<? echo $client_name;?>&status_billing=3">Closed</a>&nbsp;&nbsp;

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" align="right">


                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Client</th>
                                        <th>Company</th>
                                        <th>Job No</th>
                                        <!--	<th>Job Description</th> -->
                                        <th>Date Prepared</th>
                                        <th>TIN No</th>
                                        <!--	<th>SST</th>   -->
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Created Date</th>

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?
                                    if($status_billing == '0') {
                                        $billing = getBillingList($year,$month,$client_name,$department_sub);
                                    }
                                    else if($status_billing == '4') {
                                        $billing = getBillingListSubmitted($year,$month,$client_name,$department_sub);
                                    }
                                    else if($status_billing == '1') {
                                        $billing = getBillingListProcessed($year,$month,$client_name,$department_sub);
                                    }
                                    else {
                                        $billing = getBillingListClosed($year,$month,$client_name,$department_sub);
                                    }

                                    $i=1;
                                    while($list_billing = $billing->fetch_assoc()) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $list_billing['client_name']; ?></td>
                                        <td><?php echo $list_billing['company_name']; ?></td>
                                        <td><?php echo $list_billing['job_no']; ?></td>
                                        <td><?php echo $list_billing['date_prepared']; ?></td>
                                        <!--	<td><?php echo $list_billing['job_description']; ?></td>  -->
                                        <td><?php echo $list_billing['tin_no']; ?></td>
                                        <!--    <td><?php echo $list_billing['sst']; ?></td>  -->
                                        <td><?php echo 'RM'.number_format($list_billing['total_invoice'],2,'.',','); ?></td>

                                        <td style="text-align:center"><?php $list_billing['status_billing'];
                                            if($list_billing['status_billing'] == 0){
                                                echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>NEW</span>";
                                            }
                                            else if($list_billing['status_billing'] == 4) {
                                                echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>SUBMITTED</span>";
                                            }
                                            else if($list_billing['status_billing'] == 1) {
                                                echo "<span style='background-color:Orange; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PROCESSED</span>";
                                            }
                                            else if($list_billing['status_billing'] == 2) {
                                                echo "<span style='background-color:Orange; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>DELETED</span>";
                                            }
                                            else if($list_billing['status_billing'] == 3) {
                                                echo "<span style='background-color:#FD7808; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>CLOSED</span>";
                                            }
                                            ?> </td>

                                        <td><?php echo $list_billing['created_date']; ?></td>
                                        <!--	<td><?php echo $list_billing['updated_date']; ?></td>  -->
                                        <!--    <td><?php echo $list_billing['updated_by']; ?></td>  -->



                                        <td>

                                            <?	'<b>'.$list_billing['status_billing'].'</b>';
                                            if($list_billing['status_billing']==4){ ?>
                                                <a href="#myModal5" data-toggle="modal" data-id="<? echo $list_billing['id'];?>"><button type="button" class="btn btn-info">Show Info</button></a>
                                                <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_billing['id'];?>"><button type="button" class="btn btn-primary">Update</button></a>
                                                <a href="../controller/aims_billing_delete_exec.php?id=<? echo $list_billing['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                                <?
                                            }else if($list_billing['status_billing']==0){ ?>

                                                <a href="../controller/aims_billing_submit_exec.php?id=<? echo $list_billing['id'];?>"><button class="btn btn-success" type="button" onclick="return confirm('Are you sure you want to submit?');">Submit</button></a>
                                                <a href="#myModal" data-toggle="modal" data-id="<? echo $list_billing['id'];?>"><button type="button" class="btn btn-info">Show Info</button></a>
                                                <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_billing['id'];?>"><button type="button" class="btn btn-primary">Update</button></a>
                                                <a href="../controller/aims_billing_delete_exec.php?id=<? echo $list_billing['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                                <?
                                            }else	{ ?>

                                                <a href="#myModal" data-toggle="modal" data-id="<? echo $list_billing['id'];?>"><button type="button" class="btn btn-info">Show Info</button></a>
                                                <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_billing['id'];?>"><button type="button" class="btn btn-primary">Update</button></a>
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

            </div>

        </div>
        <? include ('../global/footer.php'); ?>
    </div>

</div>
<!-- /#wrapper -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Billing Info</h4>
            </div>
            <div class="modal-body" id="demo3">
                <script type="text/javascript">
                    $('#myModal').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_billing_info_new.php',
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

<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Billing Info</h4>
            </div>
            <div class="modal-body" id="demo5">
                <script type="text/javascript">
                    $('#myModal5').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_billing_info.php',
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Billing Update</h4>
            </div>
            <div class="modal-body" id="demo4">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo4').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_billing_update_modal.php',
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

<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel4">(NEW BILLING) Client Info</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal4').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_billing_new_info.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo1').html(html);
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

<div class="modal fade" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel7">(SUBMITTED BILLING) Client Info</h4>
            </div>
            <div class="modal-body" id="demo7">
                <script type="text/javascript">
                    $('#myModal7').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_billing_submitted_info.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo7').html(html);
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

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">(PROCESSED BILLING) Client Info</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_billing_processed_info.php',
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
                <h4 class="modal-title" id="myModalLabel6">(CLOSED BILLING) Client Info</h4>
            </div>
            <div class="modal-body" id="demo6">
                <script type="text/javascript">
                    $('#myModal6').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_billing_closed_info.php',
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });


    });


    $("#year,#month,#client_name").change(function(){
        var selected_year=$("#year").val();
        var selected_month=$("#month").val();
        var selected_client=$('#client_name').val();
        sendType(selected_year,selected_month,selected_client);
    });

    function sendType(selected_year,selected_month,selected_client){
        //console.log(obj);
        window.location.href = "aims_billing_list.php?year="+selected_year+"&month="+selected_month+"&status_billing=<?echo $status_billing;?>&client_name="+selected_client;
    }
</script>

</body>

</html>