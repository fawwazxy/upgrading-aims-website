<?php

include ('../controller/auth.php');

require "../model/aims_lv_medicalapp_function.php";
require "../model/lookup.php";

?>

<?

date_default_timezone_set("Asia/Kuala_Lumpur");
$no_staff = $_SESSION['SESS_NO_STAFF'];
$staff_record_id = $_GET['staff_record_id'];
$app_status = $_GET['app_status'];
if (!isset($app_status) && $app_status == '') {
    $app_status = 'PENDING';
}
$sys = getSys(1)->fetch_assoc();

$id = $_GET['id'];
$staff_name=$_SESSION['SESS_NAME'];

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


    <script type="text/javascript">
        <!--
        function un_check(){
            for (var i = 0; i < document.frmactive.elements.length; i++) {
                var e = document.frmactive.elements[i];
                if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                    e.checked = document.frmactive.allbox.checked;
                }}}
        //-->
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

    <script language="JavaScript" type="text/javascript">
        function Kemaskini(){
            return confirm('Anda pasti untuk kemaskini maklumat permohonan cuti?');
        }

    </script>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk hantar permohonan cuti?');
        }

    </script>
    <!--style loading simbol-->
    <style>
        #loader {
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 12px solid #444444;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .center {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            z-index: 99999 ;
        }

        .popupCloseButton {
            background-color: #fff;
            border: 3px solid #999;
            border-radius: 50px;
            cursor: pointer;
            display: inline-block;
            font-family: arial;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: -5px;
            line-height: 20px;
            width: 30px;
            height: 30px;
            text-align: center;
        }
        .popupCloseButton:hover {
            background-color: #ccc;
        }
    </style>

</head>

<body>
<!--loading symbol-->
<div id="loader" class="center"></div>

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
                <h1 class="page-header">Medical List
                    <a href="v02_aims_medical_ceo_list.php" class="btn btn-primary">Switch to version 2</a></h1>
            </div>

        </div>

        <div class="panel-heading">

            <?
            $staff = getStaffInformation($no_staff) -> fetch_assoc();
            ?>
            <table width="100%">
                <tr>
                    <th width="14%"></th>
                    <th width="2%"></th>
                    <th></th>
                </tr>
                <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                <tr>
                    <td><label>NAME</label></td>
                    <td><label>:</label></td>
                    <td><?php echo $staff['staff_name']?></td>
                </tr>

                <tr>
                    <td><label>IC NUMBER</label></td>
                    <td><label>:</label></td>
                    <td><?php echo $staff['noic']?></td>
                </tr>

                <!--     <tr>
                                    <td><label>POSITION</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $staff['role_id']?></td>
                                </tr> -->

                <tr>
                    <td><label>DEPARTMENT</label></td>
                    <td><label>:</label></td>
                    <td><?php echo $staff['department_sub'] ?></td>
                </tr>

                <tr>
                    <td><label>COMPANY</label></td>
                    <td><label>:</label></td>
                    <td><?php echo $staff['company_name']?></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <br><br><br><br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Medical List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_lv_medicalapp_list.php?app_status=PENDING">New</a> &nbsp;|&nbsp;
                        <a href="aims_lv_medicalapp_list.php?app_status=APPROVED">Approved</a> &nbsp;|&nbsp;
                        <a href="aims_lv_medicalapp_list.php?app_status=DISAPPROVED">Disapproved</a> &nbsp;|&nbsp;
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <input type="checkbox" id="select_all" /><font size='4'> Select All</font></li>

                        <? $data=getCheckboxUpdateMedicalCeo($id,$_SESSION['SESS_NAME'])?>
                        <form name="frmactive" method="post" action="">
                            <table border="0">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="Approve" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="Disapprove" />
                                    </td>
                            </table><br>

                            <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>

                                    <th style="text-align:center;" width="5%">No.</th>
                                    <th style="text-align:center;" width="10%">Staff Info</th>
                                    <th style="text-align:center;" width="50%">Info</th>

                                    <th style="text-align:center;" width="15%">Attachment</th>
                                    <th style="text-align:center;" width="40%">Total Balance</th>
                                    <th style="text-align:center;" width="40%">Remarks</th>

                                    <th style="text-align:center;" width="10%">Approved Date</th>

                                    <th style="text-align:center;" width="20%">Status</th>
                                    <th style="text-align:center;" width="40%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?

                                if($app_status == 'PENDING')
                                {
                                    $staff= getSenaraiMedicalBaru($_SESSION['SESS_NO_STAFF']);
                                }
                                else if ($app_status == 'APPROVED')
                                {
                                    $staff= getSenaraiMedicalLulus($_SESSION['SESS_NO_STAFF']);
                                }
                                else {
                                    $staff= getSenaraiMedicalTidakLulus($_SESSION['SESS_NO_STAFF']);
                                }

                                $i=1;
                                while($staffinfo = $staff->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?>
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<? echo $staffinfo['id'];?>">
                                        </td>

                                        <td><?echo $staffinfo['name'];?>  <br>
                                            <?echo $staffinfo['noic'];?>  <br>
                                            <?echo $staffinfo['department_sub'];?>  <br>
                                            <?echo $staffinfo['department_id'];?>  <br>
                                            <?echo $staffinfo['company_name'];?></td>

                                        <td>
                                            <label class="control-label">Date:</label><br> <?echo $staffinfo['mec_date'];?><br>
                                            <label class="control-label">Description:</label> <?echo $staffinfo['description'];?> <br>
                                            <?$created_date= new DateTime($staffinfo['created_date']);?>
                                            <label class="control-label">Date Applied:</label><br> <?echo $created_date->format('Y-m-d');?>
                                        </td>

                                        <td>

                                            <? if($staffinfo['document_name'] != ''){ ?>
                                                <a href="" onclick="return popitup('aims_medicalclaim_attachment.php?id=<? echo $staffinfo['id'];?>')"><button class="btn btn-info" type="button">Show Attachment</button></a>
                                                <!--	<a href="#myModal2" class="btn btn-info" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">Show Attachment</a> -->
                                            <?} else { ?>
                                                <b><font color="red">NO ATTACHMENT</font></b>
                                            <? } ?>

                                        </td>

                                        <td>
                                            <label class="control-label">Total Medical : <?echo $staffinfo['baki_claim'];?><br>
                                                <label class="control-label">Total Claim :<?echo $staffinfo['total_claim'];?> <br>
                                                    <!--<label class="control-label">Balance:<?echo $staffinfo['jumlah_claim'];?> -->
                                        </td>
                                        <td><?echo $staffinfo['remarks'];?></td>
                                        <td><?'<b>'.$staffinfo['app_date'].'</b>';
                                            if($staffinfo['app_status'] == 'APPROVED'){
                                                echo $staffinfo['app_date'];}?> </td>



                                        <td>
                                            <?'<b>'.$staffinfo['app_status'].'</b>';
                                            if($staffinfo['app_status']=='PENDING'){
                                                echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                            else if($staffinfo['app_status']=='APPROVED'){
                                                echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>";}
                                            else{
                                                echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
                                                ;}'</b>'?>
                                            <br><br>
                                            <?echo $staffinfo['app_name'];?>

                                        </td>
                                        <td>
                                            <a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">APPROVE</a>
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

        <? include ('../global/footer.php'); ?>
        <!-- /.row -->
        <!-- /.container-fluid -->
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
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_lv_medicalapp_update.php',
                            data:{id:rowid},
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

        <div class="modal-header"> <!--<div class="popupCloseButton"> </div>-->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><font color="black"><b>&#10006;</b></font></button>
        </div>
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'aims_lv_medicalpic.php',
                        data:{id:rowid},
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
<!--loading simbol-->
<script>
    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector(
                "body").style.visibility = "hidden";
            document.querySelector(
                "#loader").style.visibility = "visible";
        } else {
            document.querySelector(
                "#loader").style.display = "none";
            document.querySelector(
                "body").style.visibility = "visible";
        }
    };

    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>

</body>

</html>



