<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_function.php";

?>

<?
$id = $_GET['id'];
$claim_id = $_GET['claim_id'];
$status = $_GET['hr_review_status'];
$tahun = $_GET['tahun'];
$month = $_GET['month'];
$staff = getStaffOT($claim_id)->fetch_assoc();
$staffss = gethrname($claim_id,$tahun)->fetch_assoc();
$total = getTotal_claim($claim_id,$tahun)->fetch_assoc();
$finance = getfinanceAction($claim_id,$tahun)->fetch_assoc();
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


    <script>
        function myFunction() {
            if(document.getElementById('myRadio1').checked == true) {
                return confirm('Are you sure you already check?');
            }
        }
    </script>

</head>

<style>
    .alert {
        padding: 10px;
        background-color: #f44336;
        color: white;
    }

    .closebtn {
        margin-left: 30px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
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
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <br><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group row" align="left">
                    <div class="col-xs-8">
                        <button class="btn btn-primary" onclick="window.location.href='aims_otherclaim_financelist.php?department_id=<? echo $staff['company_claim'];?>&finance_status=<?echo $finance['finance_status'];?>'">Back</button>
                    </div>
                    <div class="col-xs-4">
                        <form method="POST" action="../controller/aims_claim_finance_exec.php" >
                            <table width="20%" class="table table-bordered table-hover">
                                <tr>
                                    <input type="hidden" width="30%" name="staff_record_id" id="staff_record_id" value="<? echo $id;?>" >
                                    <input type="hidden" class="form-control" id="claim_id" name="claim_id" value="<? echo $claim_id; ?>" />
                                    <input type="hidden" class="form-control" name="month_claim" id="month_claim" value="<? echo $month;?>">
                                    <input type="hidden" class="form-control" name="status" id="status" value="<? echo $status;?>">
                                    <input type="hidden" class="form-control" name="tahun" id="tahun" value="<? echo $tahun;?>">
                                    <input type="hidden" class="form-control" name="company" id="company" value="<? echo $company;?>">
                                    <td colspan="2"><b>Finance Use</b></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;padding-top:1.5%"><b>Advance</b></td>
                                    <td> RM  &emsp;<input type="text" name="advance" id="advance" size="15%" value="<? echo $finance['advance'];?>"/></td>

                                </tr>
                                <tr>
                                    <td style="text-align:center;padding-top:1.5%"><b>Less : Expenditure</b></td>
                                    <td> RM  &emsp;<input type="text" name="total_monthclaim" id="total_monthclaim"size="15%" value="<? echo $total['total_expenses'];?>" value="<? echo $finance['total_monthclaim'];?>" readonly /></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;padding-top:1.5%"><b>Refund</b></td>
                                    <td> RM  &emsp;<input type="text" name="refund" id="refund" size="15%"  value="<? echo $finance['refund'];?>" /></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;padding-top:1.5%"><b>Outstanding</b></td>
                                    <td> RM  &emsp;<input type="text" name="outstanding" id="outstanding" size="15%" value="<? echo $finance['outstanding'];?>" /></td>
                                </tr>

                                <tr>
                                    <td style="background-color:white;width:20%">REVIEWED BY : <br>
                                        STATUS :
                                        <input type="hidden" name="name_fin" id="name_fin" value="<? echo $_SESSION['SESS_NAME'];?>" /></td>
                                    <td colspan="2" style="text-align:center;background-color:white;width:40%"><?if($finance['finance_reviewby'] != '') {
                                            echo $finance['finance_reviewby'];}
                                        else {  echo $_SESSION['SESS_NAME']; }?>
                                        <br>
                                        <input type="radio" id="myRadio1" name="finance_status" <?php if($finance['finance_status']=="PENDING") {echo "checked";}?> value="PENDING">UNCHECK &nbsp;&nbsp;
                                        <input type="radio" id="myRadio" name="finance_status" <?php if($finance['finance_status']=="CHECK") {echo "checked";}?> value="CHECK">CHECKED &nbsp;&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" onclick="myFunction()" class="btn btn-block btn-success">Save</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="col-lg-12">
            <table style="width: 100%">
                <tr>
                    <td><label>NAME : </label> <? echo $staff['name'];?></td>
                    <td><label>CLAIM FOR THE MONTH ENDED : </label> <? echo $month;?></td>
                </tr>
                <tr>
                    <td><label>IC : </label> <? echo $staff['noic'];?></td>
                    <td><label>JOB NO. : </label> <? echo $staff['job_no'];?></td>
                </tr>
                <tr>
                    <td><label>DEPARTMENT : </label> <? echo $staff['department_sub'];?></td>
                    <td><label>COMPANY CLAIM : </label> <? echo $staff['company_claim'];?></label></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
                        <thead>
                        <tr>
                            <th rowspan="2">Date</th>
                            <th colspan="2">Date Time</th>
                            <th rowspan="2">Details Description</th>
                            <th rowspan="2">Milage (KM*RM)</th>
                            <th rowspan="2">Hotel/Lodging Allowance (RM)</th>
                            <th rowspan="2">Daily Allowance (RM)</th>
                            <th rowspan="2">Others Claim</th>
                            <th rowspan="2">HR Remark</th>
                            <th rowspan="2">Attachment</th>
                        </tr>

                        <tr>
                            <td>Departure</td>
                            <td style= "border-right: inset;">Arrival</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $i= 1;
                        $list_education = getStaffForms($claim_id,$status,$tahun);
                        while($row_data_education = $list_education->fetch_assoc()) {
                            ?>
                            <tr class="odd gradeX">

                                <td><?php echo $row_data_education['date_purchase']; ?></td>
                                <td><?php echo $row_data_education['time_departure']; ?></td>
                                <td><?php echo $row_data_education['time_arrival']; ?></td>
                                <td><?php echo $row_data_education['description']; ?></td>
                                <td><?php echo $row_data_education['milage']; ?></td>
                                <td><?php echo $row_data_education['hotel_allowance']; ?></td>
                                <td><?php echo $row_data_education['daily_allowance']; ?></td>
                                <td><?php echo $row_data_education['total_claim']; ?></td>
                                <td><?php echo $row_data_education['remark']; ?></td>
                                <td><? if ($row_data_education['document_name'] != '') {?>
                                        <a href="" onclick="return popitup('aims_claim_attachFinance.php?id=<? echo $row_data_education['id'];?>')"><button type="button" class="btn btn-warning">Attachment</button></a>
                                        <!--<a href="#myModal2" data-toggle="modal" data-id="<? echo $row_data_education['id'];?>"><button class="btn btn-warning" type="button">Attachment</button></a>-->
                                    <?}?></td>

                            </tr>
                        <?}?>
                        <tr>
                            <td colspan="4"></td>
                            <td>RM <?php echo $total['total_milage']; ?></td>
                            <td>RM <?php echo $total['total_hotel']; ?></td>
                            <td>RM <?php echo $total['total_daily']; ?></td>
                            <td>RM <?php echo $total['total']; ?></td>
                            <td colspan="5">Total Expenses : RM <?php echo $total['total_expenses']; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <? include ('../global/footer.php'); ?>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">FINANCE SECTION</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var staff_record_id = $(e.relatedTarget).data('id');
                        var month  = $(e.relatedTarget).data('month ');
                        var total = $(e.relatedTarget).data('total');
                        var tahun = $(e.relatedTarget).data('tahun');
                        var advance = $("#advance").val();
                        var total_monthclaim = $("#total_monthclaim").val();
                        var refund = $("#refund").val();
                        var outstanding = $("#outstanding").val();
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_claim_finance_update.php',
                            data:{id:staff_record_id,month :month ,total:total,tahun:tahun,advance:advance,total_monthclaim:total_monthclaim,refund:refund,outstanding:outstanding},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-body" id="demo2">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'aims_claim_attachFinance.php',
                        data:{id:rowid},
                        success:function(html){
                            $('#demo2').html(html);
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel4">HR IMAGES UPDATE</h4>
            </div>
            <div class="modal-body" id="demo4">
                <script type="text/javascript">
                    $('#myModal4').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        var staff_record_id = $(e.relatedTarget).data('stf_id');
                        var month = $(e.relatedTarget).data('month');
                        var status = $(e.relatedTarget).data('status');
                        var tahun = $(e.relatedTarget).data('tahun');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_otherclaim_foto.php',
                            data:{id:rowid,stf_id:staff_record_id,month:month,status:status,tahun:tahun},
                            success:function(html){
                                $('#demo4').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function popitup(url) {
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>
</body>
</html>