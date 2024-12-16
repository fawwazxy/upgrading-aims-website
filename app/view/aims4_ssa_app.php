<?php

include ('../controller/auth.php');

require "../model/aims_ssa_app_function.php";
require "../model/lookup.php";

$status = $_GET['status'];
if (!isset($status) && $status == '') {
    $status = '1';
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

<body>
<style>
    p{
        font-size: 120%;

    }
    td,th{
        text-align: center;
    }
</style>
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
                <h1 class="page-header">SHIP SHORE ASSISTANCE APPROVAL</h1>
            </div>

        </div>

        <?
        $flagScreen="tab_4";
        include ('../global/menu_aims_ssa_app.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">SSA Approvement &nbsp;&nbsp; <?if($status=='1'){echo '&nbsp;<strong><font color="orange">'.'Open'.'</font></strong>';}else{echo '&nbsp;<strong><font color="red">'.'Close'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="aims4_ssa_app.php?status=1">OPEN</a> &nbsp;|&nbsp;
                        <a href="aims4_ssa_app.php?status=0">CLOSE</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="50%">Information</th>
                                <th width="20%">Verification Status</th>
                                <th width="20%">Approval Status</th>
                                <th width="20%">Status </th>
                                <th width="20%">Action </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $staff = getSSAList4($status);
                            $i=1;
                            while($staffinfo = $staff->fetch_assoc()) {
                                $status_text = "";
                                if ($staffinfo['status'] == '1') {
                                    $status_text = "Close";
                                    $color = "danger";
                                }
                                else {
                                    $status_text = "Open";
                                    $color = "warning";
                                }
                                ?>

                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td style="text-align:left">
                                        <label class="control-label">SSA No. : <?echo $staffinfo['ssa_no'];?><br>
                                            <label class="control-label">Date : <?echo $staffinfo['date'];?><br>
                                                <label class="control-label">Vessel : <?echo $staffinfo['vessel'];?><br>
                                                    <label class="control-label">Location : <?echo $staffinfo['location'];?><br>
                                                        <label class="control-label">Department : <?echo $staffinfo['department'];?><br>
                                                            <label class="control-label">SSA Raised : <?echo $staffinfo['ssa_raised'];?><br>
                                                                <label class="control-label">SSA Required Description : <?echo $staffinfo['aa'];?><br>
                                                                    <label class="control-label">Model No. : <?echo $staffinfo['bb'];?><br>
                                                                        <label class="control-label">Remedial Action : <?echo $staffinfo['cc'];?><br>
                                                                            <label class="control-label">Assistance Required : <?echo $staffinfo['dd'];?><br>
                                                                                <label class="control-label">Added Info : <a href="#myModal2" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>"><? echo $staffinfo['document_name'];?></a><br></td>

                                    <td>
                                        <br>
                                        <?'<b>'.$staffinfo['ver_status'].'</b>';
                                        if($staffinfo['ver_status']==0){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else {
                                            echo"<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
                                            ;}'</b>'?><br><? echo $staffinfo['ver_on'] ?>
                                        <br>
                                        <br><label class="control-label">Name : </label>
                                        <?if($staffinfo['ver_name']!=''){ echo $staffinfo['ver_name'];}?>
                                        <br><label class="control-label">Designation : </label>
                                        <?if($staffinfo['ver_design']!=''){ echo $staffinfo['ver_design'];}?>
                                    </td>

                                    <td>
                                        <br>
                                        <?'<b>'.$staffinfo['app_status'].'</b>';
                                        if($staffinfo['app_status']==0){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else {
                                            echo"<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
                                            ;}'</b>'?><br><? echo $staffinfo['app_on'] ?>
                                        <br>
                                        <br><label class="control-label">Name : </label>
                                        <?if($staffinfo['app_name']!=''){ echo $staffinfo['app_name'];}?>
                                        <br><label class="control-label">Designation : </label>
                                        <?if($staffinfo['app_design']!=''){ echo $staffinfo['app_design'];}?>
                                    </td>

                                    <td
                                            href="#myModal1" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">
                                        <?if($staffinfo['status'] == '1')
                                        {
                                            echo '<b><font color="orange">'.'OPEN'.'</font></b>';
                                        }
                                        else {
                                            echo '<b><font color="red">'.'CLOSE'.'</font></b>';
                                        }
                                        ?>
                                    </td>


                                    <td>
                                        <br><a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<? echo $staffinfo['id'];?>">Action</a>
                                        <br><button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $telno; ?>&text=Assalamualaikum w.b.t. Boleh proceed untuk yang seterusnya. Boleh terus ke link <?echo $sys['sys_domain'].'/app/view/login.php';?>. Terima kasih')" >WhatsApp &nbsp <span class="fa fa-whatsapp"></button>
                                        <br><a onclick="closeApp(<?echo $staffinfo['id'] ;?>,<?echo $staffinfo['status'] ;?>)" >
                                            <button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
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
                <h4 class="modal-title" id="myModalLabel">Approval</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_ssa_app_update.php',
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
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'aims_ssa_pic.php',
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

    function closeApp(id,status){
        $.ajax({
            url: "../model/aims_ssa_app_function.php",
            type: "POST",
            data: {action:"closeApp",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='aims4_ssa_app.php?status=<?echo $status;?>';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

</script>

</body>

</html>