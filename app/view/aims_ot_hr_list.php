<?php

include ('../controller/auth.php');
require "../model/lookup.php";

require "../model/aims_ot_function.php";

?>

<?


$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];
$department_code=$_GET['department_code'];
$sys = getSys(1)-> fetch_assoc();
$review_by = $_SESSION['SESS_NAME'];
$payment_status = $_GET['payment_status'];
$review_status = $_GET['review_status'];
if (!isset($review_status) && $review_status == '') {
    $review_status = 'PENDING';
}
if (!isset($payment_status) && $payment_status == '') {
    $payment_status = 'OPEN';
}
if(!isset($department_code)){
    $department_code = '0';
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

    <script language="JavaScript" type="text/javascript">
        function Kemaskini(){
            return confirm('Anda pasti untuk kemaskini maklumat permohonan claim?');
        }

    </script>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk hantar permohonan claim?');
        }

    </script>
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
                <h1 class="page-header">
                    Overtime Claim
                    <!--<a href="v02_aims_ot_hr_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>
        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-lg-4">

                <select  required class="form-control" name="department_code" id="department_code">
                    <option value="">-- Choose Company--</option>
                    <? echo getDropDown("department","code_department","description",$department_code);?>
                </select>

            </div></div>
        <br><br>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>List Overtime Claim</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_ot_hr_list.php?department_code=<? echo $department_code;?>&review_status=PENDING&payment_status=OPEN">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_ot_hr_list.php?department_code=<? echo $department_code;?>&review_status=REVIEWED&payment_status=OPEN">REVIEWED</a> &nbsp;|&nbsp;
                        <a href="aims_ot_hr_list.php?department_code=<? echo $department_code;?>&review_status=REJECTED&payment_status=OPEN">REJECTED</a> &nbsp;|&nbsp;
                        <a href="aims_ot_hr_list.php?department_code=<? echo $department_code;?>&review_status=REVIEWED&payment_status=CLOSED">CLOSED</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="text-align:center;" width="2%">No.</th>
                                <th style="text-align:center;" width="20%">Staff Info</th>
                                <th style="text-align:center;" width="20%">Month Claim</th>
                                <th style="text-align:center;" width="20%">HOD Status</th>
                                <th style="text-align:center;" width="20%">HR Status</th>
                                <th style="text-align:center;" width="20%">CEO/CHAIRMAN Status</th>
                                <th style="text-align:center;" width="20%">Payment Status</th>
                                <th style="text-align:center;" width="20%">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($review_status == 'PENDING' && $payment_status == 'OPEN') {
                                $pemohon= getOtHrNew($department_code,$_SESSION['SESS_DEPARTMENT_SUB']);
                            }
                            else if($review_status == 'REVIEWED' && $payment_status == 'OPEN') {
                                $pemohon= getOtHrReviewed($department_code,$_SESSION['SESS_DEPARTMENT_SUB']);
                            }
                            else if($review_status == 'REVIEWED' && $payment_status == 'CLOSED') {
                                $pemohon= getOtHrReviewedClosed($department_code,$_SESSION['SESS_DEPARTMENT_SUB']);
                            }
                            else {
                                $pemohon= getOtHrRejected($department_code,$_SESSION['SESS_DEPARTMENT_SUB']);
                            }

                            $i= 1;
                            while($ot = $pemohon->fetch_assoc()) {

                                $verify_date= new DateTime($ot['verify_date']);
                                $review_date= new DateTime($ot['review_date']);
                                $approved_date= new DateTime($ot['approved_date']);
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <b>Name:</b> <?echo $ot['name'];?><br>
                                        <b>IC No:</b> <?echo $ot['noic'];?><br>
                                        <b>Position:</b> <?echo $ot['position'];?><br>
                                        <b>Department:</b> <?echo $ot['department_sub'];?><br>
                                        <b>Company:</b> <?echo $ot['department_id'];?>
                                    </td>
                                    <td style="text-align:center;"><?echo $ot['month_claim'];?></td>

                                    <td style='text-align:center'>
                                        <?'<b>'.$ot['verify_status'].'</b>';
                                        if($ot['verify_status']==PENDING){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($ot['verify_status']==VERIFIED){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>
											<br><br>".$ot['verify_by']."<br>".$verify_date->format('Y-m-d').""; }
                                        else {
                                            echo"<span style='background-color:red;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REJECTED</span>";}
                                        ?>
                                    </td>

                                    <td style='text-align:center'>
                                        <?'<b>'.$ot['review_status'].'</b>';
                                        if($ot['review_status']==PENDING){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($ot['review_status']==REVIEWED){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REVIEWED</span>
											<br><br>".$ot['review_by']."<br>".$review_date->format('Y-m-d')."";}
                                        else {
                                            echo"<span style='background-color:red;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REJECTED</span>";}

                                        ?>
                                    </td>

                                    <td style='text-align:center'>
                                        <?'<b>'.$ot['approved_status'].'</b>';
                                        if($ot['approved_status']==PENDING){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($ot['approved_status']==APPROVED){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>
											<br><br>".$ot['approved_by']."<br>".$approved_date->format('Y-m-d')."";}
                                        else {
                                            echo"<span style='background-color:red;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                        ?>
                                    </td>

                                    <td style='text-align:center'>
                                        <?'<b>'.$ot['payment_status'].'</b>';
                                        if($ot['payment_status']==OPEN){
                                            echo"<span style='background-color:RED;padding:5px;border-radius:5px;font-weight:bold;color:white;'>OPEN</span>";}
                                        else {
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>CLOSED</span>";}

                                        ?>
                                    </td>

                                    <td>
                                        <a href="aims_ot_hr_update_form.php?id=<? echo $ot['id'];?>&month=<? echo $ot['month_claim'];?>&review_status=<? echo $ot['review_status'];?>&tahun=<? echo $ot['tahun'];?>" class="btn btn-warning" data-toggle="" data-id="">HR ACTION</a>

                                        <? if ($ot['review_status'] =='PENDING') {?>
                                            <a href="" onclick="return popitup('aims_ot_report.php?id=<? echo $ot['id'];?>&month=<? echo $ot['month_claim'];?>&tahun=<? echo $ot['tahun'];?>&review_status=<? echo $ot['review_status'];?>')"><button type="button" class="btn btn-info">FORM VIEW</button></a>
                                        <?}?>

                                        <? if ($ot['review_status']!='PENDING') {?>
                                            <a href="aims_ot_report.php?id=<? echo $ot['id'];?>&month=<? echo $ot['month_claim'];?>&tahun=<? echo $ot['tahun'];?>&review_status=<? echo $ot['review_status'];?>" class="btn btn-info" target="_blank" data-toggle="" data-id=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span>PRINT</a>
                                            <a href="../controller/aims_ot_hr_close_exec.php?id=<? echo $ot['id'];?>&month=<? echo $ot['month_claim'];?>&tahun=<? echo $ot['tahun'];?>&payment_status=CLOSED"><button class="btn btn-success">CLOSED</button></a>
                                        <?}?>
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
                            url:'aims_ot_hr_update.php',
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
                        url:'aims_ot_attachment.php',
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
        window.location.href="aims_ot_hr_list.php?department_code="+type+"&review_status=<? echo $review_status; ?>&payment_status=<? echo $payment_status; ?>";

    }

    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>

</body>

</html>



