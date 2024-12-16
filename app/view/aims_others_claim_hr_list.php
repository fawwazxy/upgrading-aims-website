<?php
include ('../controller/auth.php');
require "../model/aims_others_claim_function.php";
require "../model/lookup.php";

$claim_id = $_SESSION['SESS_ID'];
$no_staff = $_SESSION['SESS_NO_STAFF'];
$verified_name = $_SESSION['SESS_NAME'];
$department = $_SESSION['SESS_DEPARTMENT'];
$sys = getSys(1)-> fetch_assoc();

$department_code= ($_GET['department_id']) ?: "";
$payment_status = ($_GET['payment_status']) ?: 'OPEN';
$hr_review_status = ($_GET['hr_review_status']) ?: 'PENDING';
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Claim</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">

                <select required class="form-control" name="department_code" id="department_code">
                    <option value="">-- Choose Company--</option>
                    <? echo getDropDownCompany($department_code);?>
                </select>

            </div></div>
        <br><br>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Claim List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_others_claim_hr_list.php?department_id=<? echo $department_code;?>&hr_review_status=PENDING">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_others_claim_hr_list.php?department_id=<? echo $department_code;?>&hr_review_status=REVIEW">VERIFIED</a> &nbsp;|&nbsp;
                        <a href="aims_others_claim_hr_list.php?department_id=<? echo $department_code;?>&hr_review_status=DISAPPROVE">DISAPPROVE</a> &nbsp;|&nbsp;
                        <a href="aims_others_claim_hr_list.php?department_id=<? echo $department_code;?>&hr_review_status=REVIEW&payment_status=CLOSED">CLOSED</a>

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $claim_id;?>" />
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="text-align:center;" width="5%">No.</th>
                                <th style="text-align:center;" width="20%">Staff Info</th>
                                <th style="text-align:center;" width="20%">Month Claim</th>
                                <th style="text-align:center;" width="20%"> HOD Status</th>
                                <th style="text-align:center;" width="20%"> Finance Action Status</th>
                                <th style="text-align:center;" width="20%">HR Status</th>
                                <th style="text-align:center;" width="20%">CEO/CHAIRMAN Status</th>
                                <th style="text-align:center;" width="20%">Payment Status</th>
                                <th style="text-align:center;" width="20%">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($hr_review_status == 'PENDING' && $payment_status == 'OPEN') {
                                $pemohon= getTravelVerifiednew($department_code,$_SESSION['SESS_DEPARTMENT_SUB']);
                            }
                            else if($hr_review_status == 'REVIEW' && $payment_status == 'OPEN') {
                                $pemohon= getTravelVerifiedApprove($department_code);
                            }
                            else if($hr_review_status == 'REVIEW' && $payment_status == 'CLOSED'){
                                $pemohon= getClaimHrClosed($department_code);
                            }
                            else{
                                $pemohon= getTravelVerifiedDisapprove($department_code);
                            }


                            $i= 1;
                            while($staffinfo = $pemohon->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        NAME:<?echo $staffinfo['name'];?> <br>
                                        IC:<?echo $staffinfo['noic'];?>  <br>
                                        DEPARTMENT:<?echo $staffinfo['department_sub'];?><br>
                                        COMPANY:<?echo $staffinfo['department_id'];?><br></td>
                                    <td style="text-align:center;"><?echo $staffinfo['month_claim'];?></td>
                                    <td style='text-align:center'>
                                        <?'<b>'.$staffinfo['hod_review_status'].'</b>';
                                        if($staffinfo['hod_review_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($staffinfo['hod_review_status']=='VERIFIED'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>";}

                                        else {
                                            echo"<span style='background-color:red;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISVERIFIED</span>";}
                                        ?><br><br>
                                        <?echo $staffinfo['hod_review_by'];?>
                                        <br><br>
                                        <?echo $staffinfo['hod_review_date'];?>
                                    </td>
                                    <td><? //'<b>'.$staffinfo['finance_status'].'</b>';
                                        if($staffinfo['finance_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>UNCHECK</span>";}
                                        else if($staffinfo['finance_status']=='CHECK'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>CHECKED</span>";}
                                        ?><br><br>
                                        <?echo $staffinfo['finance_reviewby'];?>
                                        <br><br>
                                        <?echo $staffinfo['finance_review_date'];?></td>
                                    <td style='text-align:center'>
                                        <? //'<b>'.$staffinfo['hr_review_status'].'</b>';
                                        if($staffinfo['hr_review_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($staffinfo['hr_review_status']=='REVIEW'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REVIEW</span>";}
                                        else {
                                            echo"<span style='background-color:red;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                        ?><br><br>
                                        <?echo $staffinfo['hr_review_by'];?>
                                        <br><br>
                                        <?echo $staffinfo['hr_review_date'];?>
                                    </td>
                                    <td style='text-align:center'>
                                        <? //'<b>'.$staffinfo['approve_status'].'</b>';
                                        if($staffinfo['approve_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($staffinfo['approve_status']=='APPROVED'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>";}
                                        else {
                                            echo"<span style='background-color:red;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                        ?><br><br>
                                        <?echo $staffinfo['approve_by'];?>
                                        <br><br>
                                        <?echo $staffinfo['approve_date'];?>
                                    </td>

                                    <td style='text-align:center'>
                                        <? //'<b>'.$staffinfo['payment_status'].'</b>';
                                        if($staffinfo['payment_status']=='OPEN'){
                                            echo"<span style='background-color:RED;padding:5px;border-radius:5px;font-weight:bold;color:white;'>OPEN</span>";}
                                        else {
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>CLOSED</span>";}?>
                                    </td>

                                    <td>
                                        <a href="aims_others_claim_hr_update_form.php?id=<? echo $staffinfo['id'];?>&hr_review_status=<? echo $staffinfo['hr_review_status'];?>&tahun=<? echo $staffinfo['tahun'];?>&month=<? echo $staffinfo['month_claim'];?>&claim_id=<? echo $staffinfo['claim_id'];?>" class="btn btn-warning" data-toggle="" data-id="">HR ACTION</a>
                                        <? if ($staffinfo['hr_review_status']!='PENDING') {?>
                                            <a href="aims_others_claim_report.php?id=<? echo $staffinfo['id'];?>&tahun=<? echo $staffinfo['tahun'];?>&hr_review_status=<? echo $staffinfo['hr_review_status'];?>&claim_id=<? echo $staffinfo['claim_id'];?>" class="btn btn-success" data-toggle="" data-id=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> PRINT</a>
                                            <a href="../controller/aims_claim_hr_close_exec.php?id=<? echo $staffinfo['claim_id'];?>&month=<? echo $staffinfo['month_claim'];?>&payment_status=CLOSED"><button class="btn btn-success">CLOSED</button></a>
                                        <?}?>
                                        <?/* if ($staffinfo['document_name'] != '') {*/?>
                                        <a href="#myModal2" data-toggle="modal" data-id="<? echo $staffinfo['claim_id'];?>"><button class="btn btn-warning" type="button">Attachment</button></a>
                                        <?/*}*/?>
                                    </td>



                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->


</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        var month = $(e.relatedTarget).data('month');
                        var status = $(e.relatedTarget).data('status');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_others_claim_hr_update.php',
                            data:{id:rowid,month:month,status:status},
                            success:function(html){
                                $('#demo').html(html);
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
    <div class="modal-dialog">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo2">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'aims_others_claim_update_attachment.php',
                        data:{id:rowid},
                        success:function(html){
                            $('#demo2').html(html);
                        }
                    });
                });
            </script>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->


<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#department_code").change(function(){
            var selected_cawangan=$(this).val();
            sendType(selected_cawangan);
        });

    });
    function sendType(type)
    {
        window.location.href="aims_others_claim_hr_list.php?department_id="+type;

    }
</script>

</body>

</html>



