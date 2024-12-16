<?php
include ('../controller/auth.php');
require "../model/aims_lv_medical_function.php";
require "../model/lookup.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$no_staff = $_SESSION['SESS_NO_STAFF'];
$staff_record_id = $_GET['staff_record_id'];
$medical_id = $_GET['medical_id'];
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
    <script type="text/javascript">
        function Kemaskini(){
            return confirm('You are sure to update the medical claim application?');
        }
        function Confirm(){
            return confirm('Are you are sure to CANCEL the medical claim application?');
        }
    </script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <!--<?include '../global/menu_keselamatan.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Medical List <a href="../view/v02_aims_medical_list.php" class="btn btn-sm btn-primary">Switch to version 2</a></h1>
            </div>
        </div>
        <div class="panel-heading">
            <? $staff = getStaffInformation($no_staff) -> fetch_assoc(); ?>
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

                <!--    <tr>
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

            <?
            $staff_record_id = $staff['id'];
            $balanceClaim = getBalanceInfo($staff_record_id) -> fetch_assoc();
            ?>

            <table width="100%">
                <tr>
                    <th width="14%"></th>
                    <th width="2%"></th>
                    <th></th>
                </tr>
                <?
                if ($_SESSION['SESS_ROLE'] == FOUNDER){
                    echo ("<b>BALANCE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&#8734;</b>");
                }
                else {
                    ?>
                    <tr>

                        <td><label>BALANCE CLAIM</label></td>
                        <td><label>:</label></td>
                        <td><b>&nbsp;RM<?php echo $balanceClaim['baki_claim']?></b></td>
                    </tr>
                <?}?>
            </table>
        </div>
        <div class="panel-heading" align="right">
            <div align="right">
                <a href="aims_lv_medical_form.php?no_staff=<? echo $no_staff;?>&staff_record_id=<?echo $staff['id']?>"><button class="btn btn-primary" type="button">Medical Claim Form</button></a>
                <!-- <a href="permohonan_cuti_tahunan.php?no_staff=<? echo $no_staff;?>"><button class="btn btn-primary" onclick="Alert()" type="button">Borang Permohonan Cuti</button></a> -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Medical List</label>&nbsp;&nbsp;&nbsp;
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="text-align:center;" width="5%">No.</th>

                                <th style="text-align:center;">Medical Date</th>
                                <th style="text-align:center;">Description</th>
                                <!-- <th style="text-align:center;">Total Claim(RM)</th> -->
                                <th style="text-align:center;">Attachment</th>
                                <th style="text-align:center;">Total Balance(RM)</th>
                                <th style="text-align:center;">Remarks</th>
                                <!-- <th style="text-align:center;">Verified Date</th> -->
                                <th style="text-align:center;">HR Verify</th>
                                <th style="text-align:center;">CFO Status</th>
                                <th style="text-align:center;">CEO Status</th>
                                <th >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $staff = liststaff1($no_staff);
                            $i=1;
                            while($staffinfo = $staff->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>

                                    <td><?echo $staffinfo['mec_date'];?> </td>
                                    <td><?echo $staffinfo['description'];?> </td>


                                    <td>
                                        <? 	$filename = $staffinfo['document_name'];
                                        $filepath = '../../medicalphoto/'.$staffinfo['document_name'];

                                        if($staffinfo['document_name'] != ''){
                                            if($staffinfo['document_type'] == 'jpg' || $staffinfo['document_type'] == 'jpeg' || $staffinfo['document_type'] == 'png' || $staffinfo['document_type'] == 'gif') {
                                                // echo '<img width="200" height="100" src="data:image/jpeg;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>';
                                                echo '<img width="200" height="100" src="'.$filepath.'" />';

                                            }
                                            else if($staffinfo['document_type'] == 'pdf') {
                                                //  echo '<object width="200" height="100" data="data:application/pdf;base64,'.base64_encode( $staffinfo['document'] ).'"/><br>'.'" type="application/pdf"></object>';
                                                echo '<iframe width="200" height="100" src="'.$filepath.'" type="application/pdf"></iframe>';

                                            }
                                        }   else{ ?>
                                            <center><b><font color="red">NO ATTACHMENT<br>[MAX SIZE: 2MB]</font></b></center>
                                        <?}?>

                                    </td>
                                    <td>
                                        <label class="control-label">Medical Claim : RM<?echo $staffinfo['baki_claim'];?><br>
                                            <label class="control-label">Total Claim : RM<?echo $staffinfo['total_claim'];?> <br>
                                                <!--<label class="control-label">Balance : RM<?echo $staffinfo['jumlah_claim'];?> -->
                                    </td>
                                    <td>
                                        <?echo $staffinfo['remarks'];?>
                                    </td>

                                    <td>


                                        <?'<b>'.$staffinfo['ver_status'].'</b>';
                                        if($staffinfo['ver_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if ($staffinfo['ver_status']=='DISAPPROVED'){
                                            echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
                                            ;}
                                        else {
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>"
                                            ;}
                                        '</b>'?>
                                        <br><br>
                                        <?echo $staffinfo ['ver_name'];?>
                                        <br><br>
                                        <?'<b>'.$staffinfo['ver_date'].'</b>';
                                        if($staffinfo['ver_status'] == 'VERIFIED'){
                                            echo $staffinfo['ver_date'];}?>
                                    </td>

                                    <td>
                                        <?'<b>'.$staffinfo['appcfo_status'].'</b>';
                                        if($staffinfo['appcfo_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($staffinfo['appcfo_status']=='APPROVED'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
                                            ;}
                                        else {
                                            echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
                                            ;}'</b>'?>
                                        <br><br>
                                        <?echo $staffinfo['appcfo_name'];?>
                                        <br><br>
                                        <?'<b>'.$staffinfo['appcfo_date'].'</b>';
                                        if($staffinfo['appcfo_status'] == 'APPROVED'){
                                            echo $staffinfo['appcfo_date'];}?>
                                    </td>
                                    <td>
                                        <?'<b>'.$staffinfo['app_status'].'</b>';
                                        if($staffinfo['app_status']=='PENDING'){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($staffinfo['app_status']=='APPROVED'){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
                                            ;}
                                        else {
                                            echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
                                            ;}'</b>'?>
                                        <br><br>
                                        <?echo $staffinfo['app_name'];?>
                                        <br><br>
                                        <?'<b>'.$staffinfo['app_date'].'</b>';
                                        if($staffinfo['app_status'] == 'APPROVED'){
                                            echo $staffinfo['app_date'];}?>
                                    </td>

                                    <td>
                                        <!-- <a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $staffinfo['medical_id'];?>">Update</a> -->


                                        <? if($staffinfo['document_name'] != ''){ ?>
                                            <a href="" onclick="return popitup('aims_medicalclaim_attachment.php?id=<? echo $staffinfo['medical_id'];?>')"><button class="btn btn-info" type="button">Show Attachment</button></a>
                                            <!--    <a href="#myModal2" class="btn btn-info" data-toggle="modal" data-id="<? echo $staffinfo['medical_id'];?>">Show Attachment</a> -->
                                        <? }
                                        if ($staffinfo['ver_status'] == 'PENDING')
                                        { ?>

                                            <a href="../controller/aims_lv_medical_delete_exec.php?medical_id=<? echo $staffinfo['medical_id'];?>&no_staff=<? echo $no_staff;?>&staff_record_id=<? echo $staffinfo['staff_record_id'];?>&total_claim=<? echo $staffinfo['total_claim'];?>
                                            "><button class="btn btn-danger" type="button" onclick="return Confirm()" >DELETE</button></a>
                                        <?}


                                        ?>

                                        <!-- <a href="../controller/aims_lv_medical_delete_exec.php?id=<? echo $staffinfo['id']; ?>"><button type="button" class="btn btn-danger" onclick="return confirm ('Do you want to delete?')">Delete</button></a> -->
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
                            url:'aims_lv_medical_update.php',
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

    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }

</script>

</body>

</html>