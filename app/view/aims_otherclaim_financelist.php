<?php
include "../controller/auth.php";
require "../model/aims_others_claim_function.php";
require "../model/lookup.php";

$no_staff = $_SESSION['SESS_NO_STAFF'];
$claim_id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];
$department_code=$_GET['department_id'];
$sys = getSys(1)-> fetch_assoc();
$verified_name = $_SESSION['SESS_NAME'];
$finance_status = $_GET['finance_status'];
$finance_payment_status = $_GET['finance_payment_status'];
if (!isset($finance_status) && $finance_status == '') {
    $finance_status = 'PENDING';
}
if (!isset($finance_payment_status) && $finance_payment_status == '') {
    $finance_payment_status = 'OPEN';
}
if(!isset($department_code)){
    $department_code = $_SESSION['SESS_DEPARTMENT'];
}
$open = 'OPEN';
$closed = 'CLOSED';
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
        <!--<?include '../global/menu_keselamatan.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Claim</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">

                <select  required class="form-control" name="department_code" id="department_code">
                    <option value="">-- Choose Company--</option>
                    <? echo getDropDown("department","code_department","description",$department_code);?>
                </select>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Claim List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_otherclaim_financelist.php?department_id=<? echo $department_code;?>&finance_status=PENDING">UNCHECK</a> &nbsp;|&nbsp;
                        <a href="aims_otherclaim_financelist.php?department_id=<? echo $department_code;?>&finance_status=CHECK">CHECK</a> &nbsp;|&nbsp;
                        <a href="aims_otherclaim_financelist.php?department_id=<? echo $department_code;?>&finance_status=CHECK&finance_payment_status=CLOSED">CLOSED</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $claim_id;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="text-align:center;" width="5%">No.</th>
                                <th style="text-align:center;" width="20%">Staff Info</th>
                                <th style="text-align:center;" width="15%">Month Claim</th>
                                <th style="text-align:center;" width="20%"> Finance Action Status</th>
                                <th style="text-align:center;" width="20%"> Finance Payment Status</th>
                                <th style="text-align:center;" width="20%">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($finance_status == 'PENDING' && $finance_payment_status == 'OPEN') {
                                $pemohon= getTravelVerifiednewfinance($department_code,$_SESSION['SESS_DEPARTMENT_SUB']);
                            }
                            else if($finance_status == 'CHECK' && $finance_payment_status == 'OPEN') {
                                $pemohon= getTravelVerifiedApprovefinance($department_code);
                            }
                            else if($finance_status == 'CHECK' && $finance_payment_status == 'CLOSED') {
                                $pemohon= getTravelfinanceClosed($department_code);
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
                                        <?
                                        if($staffinfo['finance_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>UNCHECK</span>";}
                                        else if($staffinfo['finance_status']=='CHECK'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>CHECKED</span>";}
                                        ?><br><br>
                                        <?echo $staffinfo['finance_reviewby'];?>
                                        <br><br>
                                        <?echo $staffinfo['finance_review_date'];?>
                                    </td>
                                    <td style='text-align:center'>
                                        <?
                                        if($staffinfo['finance_payment_status']=='OPEN'){
                                            echo"<span style='background-color:red;padding:5px;border-radius:5px;font-weight:bold;color:white;'>OPEN</span>";}
                                        else if($staffinfo['finance_payment_status']=='CLOSED'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>CLOSED</span>";}
                                        ?><br><br>
                                        <?echo $staffinfo['date_payment_status'];?>
                                    </td>
                                    <td>
                                        <a href="aims_claim_financeuse.php?id=<? echo $staffinfo['id'];?>&claim_id=<? echo $staffinfo['claim_id'];?>&month=<? echo $staffinfo['month_claim'];?>&hr_review_status=<? echo $staffinfo['hr_review_status'];?>&tahun=<? echo $staffinfo['tahun'];?>&company_claim=<? echo $staffinfo['company_claim'];?>" class="btn btn-warning" data-toggle="" data-id="">FINANCE ACTION</a>
                                        <br>
                                        <? if($staffinfo['finance_payment_status']=='OPEN'){?>
                                            <a href="../controller/aims_claim_finance_close_exec.php?id=<? echo $staffinfo['claim_id'];?>&finance_payment_status=<? echo $closed; ?>&finance_status=<?echo $staffinfo['finance_status'];?>&department_id=<? echo $staffinfo['company_claim'];?>"><button class="btn btn-danger">CLOSED</button></a>
                                        <?}?>
                                        <? if($staffinfo['finance_payment_status']=='CLOSED'){?>
                                            <a href="../controller/aims_claim_finance_close_exec.php?id=<? echo $staffinfo['claim_id'];?>&finance_payment_status=<? echo $open; ?>&finance_status=<?echo $staffinfo['finance_status'];?>&department_id=<? echo $staffinfo['company_claim'];?>"><button class="btn btn-success">OPEN</button></a>
                                        <?}?>
                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
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
                        url:'aims_others_claim_attachment.php',
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
        window.location.href="aims_otherclaim_financelist.php?department_id="+type;

    }
</script>
</body>
</html>



