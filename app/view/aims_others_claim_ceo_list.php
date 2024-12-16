<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_function.php";
require "../model/lookup.php";

?>

<?
$no_staff = $_SESSION['SESS_NO_STAFF'];
$department = $_SESSION['SESS_DEPARTMENT'];
$verified_name = $_SESSION['SESS_NAME'];
$approve_status = $_GET['approve_status'];
if (!isset($approve_status) && $approve_status == '') {
    $approve_status = 'PENDING';
}
$claim_id = $_GET['claim_id'];
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


    <script language="javascript" type="text/javascript">
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=890');
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>

    <script type="text/javascript">

        function un_check(){
            for (var i = 0; i < document.frmactive.elements.length; i++) {
                var e = document.frmactive.elements[i];
                if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                    e.checked = document.frmactive.allbox.checked;
                }}}

    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#select_all').on('click',function(){
                if(this.checked){
                    $('.checkbox').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('.checkbox').each(function(){
                        this.checked = false;
                    });
                }
            });

            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#select_all').prop('checked',true);
                }else{
                    $('#select_all').prop('checked',false);
                }
            });


        });
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
        <!--<?include '../global/menu_keselamatan.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Claim</h1>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Claim List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_others_claim_ceo_list.php?approve_status=PENDING">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_others_claim_ceo_list.php?approve_status=APPROVED">APPROVE</a> &nbsp;|&nbsp;
                        <a href="aims_others_claim_ceo_list.php?approve_status=DISAPPROVE">DISAPPROVE</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">


                        <input type="checkbox" id="select_all"/><font size='4'> Select All</font>

                        <? $data=getCheckboxUpdateOtCeo($claim_id,$_SESSION['SESS_NAME'])?>
                        <form name="frmactive" method="post" action="">
                            <table border="0">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="APPROVED" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="DISAPPROVE" />
                                    </td>
                            </table><br>

                            <input name="id" type="hidden" class="input-short" value="<? echo $claim_id;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="text-align:center;" width="5%">No.</th>
                                    <th style="text-align:center;" width="20%">Staff Info</th>
                                    <th style="text-align:center;" width="20%">Month Claim</th>
                                    <th style="text-align:center;" width="20%">HOD Verified</th>
                                    <th style="text-align:center;" width="20%">HR Review</th>
                                    <th style="text-align:center;" width="20%">CEO/CHAIRMAN Approval</th>
                                    <th style="text-align:center;" width="10%">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                if($approve_status == 'PENDING') {
                                    $pemohon= getTravelApprovenew($_SESSION['SESS_NO_STAFF']);
                                }
                                else if($approve_status == 'APPROVED') {
                                    $pemohon= getTravelApprove($_SESSION['SESS_NO_STAFF']);
                                }
                                else {
                                    $pemohon= getTravelDisapprove($_SESSION['SESS_NO_STAFF']);
                                }
                                $i= 1;
                                while($staffinfo = $pemohon->fetch_assoc()) {

                                    $hod_review_date= new DateTime($staffinfo['hod_review_date']);
                                    $hr_review_date= new DateTime($staffinfo['hr_review_date']);
                                    $approve_date= new DateTime($staffinfo['approve_date']);
                                    $b = ceoBatch($staffinfo['approve_status'],$staffinfo['claim_id'])->fetch_assoc();
                                    ?>
                                    <tr>
                                        <td><?echo $i++; ?><br>

                                            <align="center">
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $b['claim_id'];?>" >
                                        </td>
                                        <td>
                                            NAME:<?echo $staffinfo['name'];?><br>
                                            IC:<?echo $staffinfo['noic'];?><br>
                                            DEPARTMENT:<?echo $staffinfo['department_sub'];?><br>
                                            COMPANY:<?echo $staffinfo['department_id'];?>
                                        </td>
                                        <td style="text-align:center;"><?echo $staffinfo['month_claim'];?></td>
                                        <td style="text-align:center;">
                                            <? //'<b>'.$staffinfo['hod_review_status'].'</b>';
                                            if($staffinfo['hod_review_status']=='PENDING'){
                                                echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                            else if($staffinfo['hod_review_status']=='VERIFIED'){
                                                echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>";}
                                            else {
                                                echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISVERIFIED</span>";}

                                            ?><br><br>
                                            <?echo $staffinfo['hod_review_by'];?>

                                            <br><br>
                                            <?echo $staffinfo['hod_review_date'];?>
                                        </td>
                                        <td style="text-align:center;">
                                            <? //'<b>'.$staffinfo['hr_review_status'].'</b>';
                                            if($staffinfo['hr_review_status']=='PENDING'){
                                                echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                            else if($staffinfo['hr_review_status']=='REVIEW'){
                                                echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REVIEWED</span>";}
                                            else {
                                                echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                            ?><br><br>
                                            <?echo $staffinfo['hr_review_by'];?>

                                            <br><br>
                                            <?echo $staffinfo['hr_review_date'];?>
                                        </td>
                                        <td style="text-align:center;">
                                            <? //'<b>'.$staffinfo['approve_status'].'</b>';
                                            if($staffinfo['approve_status']=='PENDING'){
                                                echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                            else if($staffinfo['approve_status']=='APPROVED'){
                                                echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>";}
                                            else {
                                                echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                            ?><br><br>
                                            <?echo $staffinfo['approve_by'];?>

                                            <br><br>
                                            <?echo $staffinfo['approve_date'];?>
                                        </td>
                                        <td>
                                            <a href="" onclick="return popitup('aims_others_claim_report.php?id=<? echo $staffinfo['id'];?>&claim_id=<? echo $staffinfo['claim_id'];?>&month=<? echo $staffinfo['month_claim'];?>&tahun=<? echo $staffinfo['tahun'];?>&hr_review_status=REVIEW&company_claim=<? echo $staffinfo['company_claim'];?>')"><button type="button" class="btn btn-info">CLAIM INFO</button></a>
                                            <a href="#myModal1" class="btn btn-success" data-toggle="modal" data-id ="<? echo $staffinfo['id'];?>" data-claim_id ="<? echo $staffinfo['claim_id'];?>">APPROVE</a>
                                            <a href="" onclick="return popitup('aims_oth_all_images.php?id=<? echo $staffinfo['id'];?>&month=<? echo $staffinfo['month_claim'];?>&tahun=<? echo $staffinfo['tahun'];?>&hr_review_status=REVIEW')"><button type="button" class="btn btn-info">ATTACHMENT</button></a>
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
                <h4 class="modal-title" id="myModalLabel">CEO/CHAIRMAN SECTION</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var staff_record_id = $(e.relatedTarget).data('id');
                        var claim_id = $(e.relatedTarget).data('claim_id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_others_claim_ceo_update.php',
                            data:{id:staff_record_id,claim_id:claim_id},
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
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    var month = $(e.relatedTarget).data('month');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'GET',
                        url:'aims_oth_all_images.php',
                        data:{id:rowid,month:month},
                        success:function(html){
                            $('#demo1').html(html);
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
    // Delete row on delete button click

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

</script>

</body>

</html>



