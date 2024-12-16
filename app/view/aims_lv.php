<?php

include ('../controller/auth.php');

require "../model/cuti_function.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];

$start_maintenance = strtotime('2022-12-10 14:00:00');
$end_maintenance = strtotime('2022-12-10 16:00:00');
if (time() > $start_maintenance && time() < $end_maintenance){
    echo "<script>
            alert('Modul cuti sedang diselenggara sehingga jam 04.00pm.')
            window.history.back();
            </script>";
    exit();
}

$sys = getSys(1)->fetch_assoc();
$cutiAL = getCutiInformationAL($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$cutiMC = getCutiInformationMC($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$cutitotalAL = gettotalcutidiambilAL($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$cutitotalMC = gettotalcutidiambilMC($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$totalcutiLP = gettotalcutidiambilLP($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$totalcutiCL = gettotalcutidiambilCL($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$totalcutiURL = gettotalcutidiambilURL($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$totalcutiHL = gettotalcutidiambilHL($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$tahun = $_GET['tahun'];
if ($tahun == date('Y') || $tahun == '') {
    $tahun = 'currentyear';
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

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
    <script>
        function Alert() {
            var baki_cuti_pohon=document.getElementById("baki_cuti_pohon");
            if (baki_cuti_pohon==0.0) {
                alert("Maaf, baki cuti permohonan anda sudah habis");
            }
        }
    </script>

    <script>
        function Alert() {
            var baki_cuti_pohon=document.getElementById("baki_cuti_pohon1");
            if (baki_cuti_pohon==0.0) {
                alert("Maaf, baki cuti permohonan anda sudah habis");
            }
        }
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>

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

                <h1 class="page-header">Maklumat Peribadi <a href="../view/v02_aims_leave_list.php" class="btn btn-sm btn-primary">Switch to version 2</a></h1>

                <div class="row">
                    <? include "v02_aims_lv_migration_message.php"; ?>
                </div>
            </div>
            <div class="panel-heading">

                <?
                $staff = getStaffInformation($no_staff,$jenis_cuti) -> fetch_assoc();
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
                        <td><label>Nama</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['staff_name']?></td>
                    </tr>

                    <tr>
                        <td><label>No. Kad Pengenalan</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['noic']?></td>
                    </tr>

                    <tr>
                        <td><label>No. Staf</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['no_staff']?></td>
                    </tr>

                    <tr>
                        <td><label>No. Telefon</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['phone'] ?></td>
                    </tr>

                    <tr>
                        <td><label>Email</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['email']?></td>
                    </tr>

                    <!--  <tr>
                                    <td><label>Jawatan</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $staff['role']?></td>
                                </tr> -->

                    <tr>
                        <td><label>Bahagian</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['department_name']?>
                        </td>
                    </tr>

                    <tr>
                        <td><label>Alamat</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['alamat_surat']?></td>
                    </tr>

                    <tr>
                        <td><label><font color="blue">Maklumat Cuti Tahunan</font></label></td>
                    </tr>

                    <tr>
                        <td><i><label>Jumlah Keseluruhan</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $cutiAL['total_cuti'];?>&nbsp;Hari</td>
                    </tr>

                    <tr>
                        <td><i><label>Baki Semasa</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $cutiAL['baki_cuti'];?>&nbsp;Hari</td>
                    </tr>

                    <tr>
                        <td><i><label>Jumlah Cuti Diambil</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $cutitotalAL['totalal'];?>&nbsp;Hari</td>
                        <input id="baki_cuti_pohon" type="hidden" class="input-short" value="<?php echo $cutiAL['baki_cuti_pohon'];?>" onclick="alert()"/>
                    </tr>

                    <tr>
                        <td><label><font color="blue">Maklumat Cuti Sakit</font></label></td>
                    </tr>

                    <tr>
                        <td><i><label>Jumlah Keseluruhan</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $cutiMC['total_cuti'];?>&nbsp;Hari</td>
                    </tr>

                    <tr>
                        <td><i><label>Baki Semasa</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $cutiMC['baki_cuti'];?>&nbsp;Hari</td>
                    </tr>

                    <tr>
                        <td><i><label>Jumlah MC Diambil</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $cutitotalMC['totalmc'];?>&nbsp;Hari
                            <input id="baki_cuti_pohon1" type="hidden" class="input-short" value="<?php echo $cutiMC['baki_cuti_pohon'];?>" onclick="alert()" /> </td>
                    </tr>

                    <tr>
                        <td><label><font color="blue">Maklumat Cuti Lain-lain</font></label></td>
                    </tr>

                    <tr>
                        <td><i><label>Jumlah Cuti Tanpa Gaji</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $totalcutiLP['totallp'];?>&nbsp;Hari</td>

                    </tr>

                    <tr>
                        <td><i><label>Jumlah Cuti Ehsan</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $totalcutiCL['totalcl'];?>&nbsp;Hari</td>

                    </tr>

                    <tr>
                        <td><i><label>Jumlah Cuti Tanpa Rekod</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $totalcutiURL['totalurl'];?>&nbsp;Hari</td>

                    </tr>

                    <tr>
                        <td><i><label>Jumlah Cuti Hospital</label></i></td>
                        <td><label>:</label></td>
                        <td><?php echo $totalcutiHL['totalhl'];?>&nbsp;Hari</td>

                    </tr>

                </table>
            </div>



            <div class="panel-heading" align="right">
                <div align="right">
                    <a href="aims_lv_form.php?no_staff=<? echo $no_staff;?>&staff_record_id=<?echo $staff['staff_record_id']?>"><button class="btn btn-primary" type="button">Request Leave Form</button></a>
                    <a href="aims_lv_special_form.php?no_staff=<? echo $no_staff;?>&staff_record_id=<?echo $staff['staff_record_id']?>"><button class="btn btn-primary" type="button">Special Leave Form</button></a>
                    <!-- <a href="permohonan_cuti_tahunan.php?no_staff=<? echo $no_staff;?>"><button class="btn btn-primary" onclick="Alert()" type="button">Borang Permohonan Cuti</button></a> -->
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Senarai Permohonan Cuti</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_lv.php?tahun=currentyear">Tahun Ini</a> ||
                        <a href="aims_lv.php?tahun=previousyear">Tahun Sebelum</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">No.</th>
                                <th width="20%">Date & Type Request</th><!--
                                        <th width="10%">No. Telefon</th>  -->
                                <th width="20%">Leave Info</th>
                                <!-- <th>Jenis Cuti</th>
                                <th>Jum. Cuti</th> -->
                                <th width="15%">Support</th>
                                <th width="15%">Approval</th>
                                <th width="13%">Reason</th>
                                <th width="13%">Remark</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($tahun == 'previousyear') {
                                $maklumat_cuti = getCutiStaffByPrevYear($_SESSION['SESS_NO_STAFF']);
                            }
                            else {
                                $maklumat_cuti = getCutiStaffByCurYear($_SESSION['SESS_NO_STAFF']);
                            }

                            $i= 1;
                            while($row_maklumat_cuti = $maklumat_cuti->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_maklumat_cuti['date_fill']; ?>
                                        <br><?php echo $row_maklumat_cuti['dic_leave']; ?>
                                    </td>
                                    <td><label class="control-label">Date Start :</label> <? echo '<b><font color="blue">'.date('d/m/Y',strtotime($row_maklumat_cuti['date_lv_from'])).'</font></b>';?>
                                        <br><label class="control-label">Date Last :</label> <? echo '<b><font color="brown">'.date('d/m/Y',strtotime($row_maklumat_cuti['date_lv_to'])).'</font></b>';?>
                                        <br><label class="control-label">Day Leave :</label> <?php echo $row_maklumat_cuti['day_lv_from']; ?>- <?php echo $row_maklumat_cuti['day_lv_to']; ?>
                                        <br><label class="control-label">Type Leave :</label> <?php if($row_maklumat_cuti['type_leave'] == 'AL' ) {
                                            echo '<b>'.'Annual leave'.'</b>';}
                                        else if($row_maklumat_cuti['type_leave'] == 'MC') {
                                            echo '<b>'.'Medical leave'.'</b>';}
                                        else if($row_maklumat_cuti['type_leave'] == 'LP') {
                                            echo '<b>'.'Leave Without Pay'.'</b>';}
                                        else if($row_maklumat_cuti['type_leave'] == 'CL') {
                                            echo '<b>'.'Compassionate Leave'.'</b>';}
                                        else if($row_maklumat_cuti['type_leave'] == 'HL') {
                                            echo '<b>'.'Hospitalization Leave'.'</b>';}
                                        else if($row_maklumat_cuti['type_leave'] == 'RP') {
                                            echo '<b>'.'Replacement Leave'.'</b>';}
                                        else {
                                            echo '<b>'.'Leave Without Record'.'</font></b>'; }?>
                                        <br><label class="control-label">Total Leave :</label> <?php echo $row_maklumat_cuti['total_lv_req']; ?></td>
                                    <td>
                                        <?
                                        if($tahun == 'previousyear') {
                                            if($row_maklumat_cuti['support'] == 'IN PROGRESS' ) {
                                                echo '<b><font color="orange">'.'SUDAH DIHANTAR'.'</font></b>';}
                                            else if($row_maklumat_cuti['support'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'APPROVE'.'</font></b>';}
                                            else if($row_maklumat_cuti['support'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'DISAPPROVE'.'</font></b>';}
                                        }
                                        else {
                                            if($row_maklumat_cuti['support'] == 'PENDING' ) {
                                                echo '<b><font color="blue">'.'BAHARU'.'</font></b>';}
                                            else if($row_maklumat_cuti['support'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'LULUS'.'</font></b>';}
                                            else if($row_maklumat_cuti['support'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'TIDAK LULUS'.'</font></b>';}
                                            else if($row_maklumat_cuti['support'] == 'TIADA') {
                                                echo '<b><font color="brown">'.'TIADA SOKONGAN'.'</font></b>';}
                                            else {
                                                echo '<b><font color="orange">'.'SUDAH DIHANTAR'.'</font></b>';}
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?
                                        if($tahun == 'previousyear') {
                                            if($row_maklumat_cuti['approvement'] == 'IN PROGRESS' ) {
                                                echo '<b><font color="orange">'.'SUDAH DIHANTAR'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'APPROVE'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'DISAPPROVE'.'</font></b>';}
                                            else {
                                                echo '<b><font color="orange">'.'BELUM DIHANTAR'.'</font></b>';}
                                        }
                                        else {
                                            if($row_maklumat_cuti['approvement'] == 'PENDING' ) {
                                                echo '<b><font color="blue">'.'BAHARU'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'LULUS'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'TIDAK LULUS'.'</font></b>';}
                                            else {
                                                echo '<b><font color="orange">'.'SUDAH DIHANTAR'.'</font></b>';}
                                        }
                                        ?>

                                    </td>

                                    <td><?php echo $row_maklumat_cuti['reason_leave'];?><br></td>

                                    <td><?php echo $row_maklumat_cuti['remark'];?><br></td>

                                    <td>
                                        <?if($row_maklumat_cuti['document'] != '') {?>
                                        <a href="#myModal2" data-toggle="modal" data-id="<? echo $row_maklumat_cuti['id'];?>"><button class="btn btn-info" type="button">Papar Lampiran</button></a><?}?>
                                        <?
                                        if ($row_maklumat_cuti['approvement'] == 'PENDING' && $tahun == 'currentyear') { ?>

                                            <br><a href="../controller/deletebuttoncuti.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>&staff_record_id=<? echo $row_maklumat_cuti['staff_record_id'];?>&total_lv_req=<? echo $row_maklumat_cuti['total_lv_req'];?>
												&type_leave=<? echo $row_maklumat_cuti['type_leave'];?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" >DELETE</button></a>
                                        <?}
                                        else if ($row_maklumat_cuti['approvement'] == 'IN PROGRESS' && $tahun == 'previousyear') {?>
                                            <a href="../controller/deletebuttoncuti.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>
												&type_leave=<? echo $row_maklumat_cuti['type_leave'];?>&staff_record_id=<? echo $row_maklumat_cuti['staff_record_id'];?>&total_lv_req=<? echo $row_maklumat_cuti['total_lv_req'];?>
												"><button class="btn btn-danger" type="button" onclick="return Confirm()" >DELETE</button></a>
                                        <?}
                                        else if ($row_maklumat_cuti['approvement'] == 'IN PROGRESS' && $tahun == 'currentyear') { ?>

                                            <br><a href="../controller/deletebuttoncuti.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>
												&type_leave=<? echo $row_maklumat_cuti['type_leave'];?>&staff_record_id=<? echo $row_maklumat_cuti['staff_record_id'];?>&total_lv_req=<? echo $row_maklumat_cuti['total_lv_req'];?>
												"><button class="btn btn-danger" type="button" onclick="return Confirm()" >DELETE</button></a>
                                        <?}

                                        else if ($row_maklumat_cuti['approvement'] == 'APPROVE' && $row_maklumat_cuti['type_leave'] != 'AL' && $row_maklumat_cuti['type_leave'] != 'MC') { ?>

                                            <br><a href="../controller/deletebuttoncuti.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>
												&type_leave=<? echo $row_maklumat_cuti['type_leave'];?>&staff_record_id=<? echo $row_maklumat_cuti['staff_record_id'];?>&total_lv_req=<? echo $row_maklumat_cuti['total_lv_req'];?>
												"><button class="btn btn-danger" type="button" onclick="return Confirm()" >DELETE</button></a>
                                        <?}

                                        else if ($row_maklumat_cuti['approvement'] == 'DISAPPROVE' && $row_maklumat_cuti['type_leave'] != 'AL' && $row_maklumat_cuti['type_leave'] != 'MC') { ?>

                                            <br><a href="../controller/deletebuttoncuti.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>
												&type_leave=<? echo $row_maklumat_cuti['type_leave'];?>&staff_record_id=<? echo $row_maklumat_cuti['staff_record_id'];?>&total_lv_req=<? echo $row_maklumat_cuti['total_lv_req'];?>
												"><button class="btn btn-danger" type="button" onclick="return Confirm()" >DELETE</button></a>
                                        <?}

                                        else if ($row_maklumat_cuti['approvement'] == 'APPROVE' && date('Y-m-d') <= $row_maklumat_cuti['monthss']) { ?>

                                            <br><a href="../controller/deleterequest_exec.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>
												&type_leave=<? echo $row_maklumat_cuti['type_leave'];?>&staff_record_id=<? echo $row_maklumat_cuti['staff_record_id'];?>&total_lv_req=<? echo $row_maklumat_cuti['total_lv_req'];?>
												"><button class="btn btn-danger" type="button" onclick="return Confirm()" >DELETE</button></a>
                                        <?}

                                        ?>
                                    </td>


                                </tr>
                                <?php $i++; } ?>
                            </tbody>

                        </table><center>
                            <!-- Button trigger modal -->


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
<!-- /#wrapper -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-header"> <!--<div class="popupCloseButton"> </div>-->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><font color="black"><b>&#10006;</b></font></button>
        </div>
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal1').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'lampiran_papar.php',
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

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-header"> <!--<div class="popupCloseButton"> </div>-->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><font color="black"><b>&#10006;</b></font></button>
        </div>
        <div class="modal-body" id="demo2">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'lampiran_papar.php',
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
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>



</body>

</html>
