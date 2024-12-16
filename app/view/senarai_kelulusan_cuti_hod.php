<?php
include ('../controller/auth.php');
require "../model/cuti_function.php";

$code = $_GET['code'];
$approvement = ($_GET['approvement']) ?: 'IN PROGRESS';
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Leave Approvement <a href="../view/v02_aims_leave_approval.php" class="btn btn-sm btn-primary">Switch to version 2</a></h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_lv_migration_message.php"; ?>
        </div>
        <div class="form-group" align="right">
            <!-- <a class="view" href="analisa_permohonan_cuti.php" target="blank"><button type="button" class="btn btn-primary">Analisa Keseluruhan Permohonan Cuti</button></a>
            <a class="view" href="analisa_permohonan_cuti_bulanan.php" target="blank"><button type="button" class="btn btn-primary">Analisa Permohonan Cuti Mengikut Bulan</button></a> -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="panel panel-red">
                    <div class="panel-heading" align="center">
                    <label class="control-label" for="date">Analisa Permohonan Cuti</label>
                    </div> -->
                <!-- /.panel-heading -->
                <!-- <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th bgcolor="#D6DBDF" width="25%" onClick="location.href='senarai_kelulusan_cuti.php?approvement=SD';"><center>Baharu</center></th>
                                        <th bgcolor="#D6DBDF" width="25%" onClick="location.href='senarai_kelulusan_cuti.php?approvement=APPROVE';"><center>Lulus</center></th>
                                        <th bgcolor="#D6DBDF" width="25%" onClick="location.href='senarai_kelulusan_cuti.php?approvement=DISAPPROVE';"><center>Tidak Lulus</center></th>
                                        <th bgcolor="#D6DBDF" width="25%" onClick="location.href='senarai_kelulusan_cuti.php?approvement=OVERDUE';"><center>Overdue</center></th>
                                    </tr>
                                </thead>
                                <?
                // $count_cuti_baharu = getCountCutiBaharu($_SESSION['SESS_NO_STAFF']);
                // $count_cuti_lulus_baharu = getCountCutiLulusBaharu($_SESSION['SESS_NO_STAFF']);
                // $count_cuti_lulus_lama = getCountCutiLulusLama($_SESSION['SESS_NO_STAFF']);
                // $count_cuti_tidak_lulus_baharu = getCountCutiTidakLulusBaharu($_SESSION['SESS_NO_STAFF']);
                // $count_cuti_tidak_lulus_lama = getCountCutiTidakLulusLama($_SESSION['SESS_NO_STAFF']);
                // $count_cuti_overdue = getCountCutiOverdue($_SESSION['SESS_NO_STAFF']);
                ?>
                                <tbody>
                                    <tr>
                                        <td align="center" bgcolor="#FDFEFE" onClick="location.href='senarai_kelulusan_cuti.php?approvement=SD';">
                                            <strong><font color="blue" size="6"><?//echo $count_cuti_baharu;?></font></strong>
                                        </td>

                                        <td align="center" bgcolor="#FDFEFE" onClick="location.href='senarai_kelulusan_cuti.php?approvement=APPROVE';">
                                            <strong><font color="green" size="6"><?//echo $count_cuti_lulus_baharu;?></font></strong>
                                        </td>
                                       
                                        <td align="center" bgcolor="#FDFEFE" onClick="location.href='senarai_kelulusan_cuti.php?approvement=DISAPPROVE';">
                                            <strong><font color="red" size="6"><?//echo $count_cuti_tidak_lulus_baharu;?></font></strong>
                                        </td>

                                        <td align="center" bgcolor="#FDFEFE" onClick="location.href='senarai_kelulusan_cuti.php?approvement=OVERDUE';">
                                            <strong><font color="orange" size="6"><?//echo $count_cuti_overdue;?></font></strong>
                                        </td>
                                    </tr> 

                                </tbody>
                            </table>
                    </div> -->

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Senarai Permohonan Cuti</label>&nbsp;&nbsp;&nbsp;
                        <a href="senarai_kelulusan_cuti_hod.php?approvement=IN PROGRESS">Baharu</a> &nbsp;|&nbsp;
                        <a href="senarai_kelulusan_cuti_hod.php?approvement=APPROVE">Lulus</a> &nbsp;|&nbsp;
                        <a href="senarai_kelulusan_cuti_hod.php?approvement=DISAPPROVE">Tidak Lulus</a> &nbsp;|&nbsp;
                        <a href="senarai_kelulusan_cuti_ceo.php?">Cuti Special</a> &nbsp;|&nbsp;

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th width="5%">Bil.</th>
                                <th width="15%">Maklumat Staf</th>
                                <th width="15%">Maklumat Cuti</th>
                                <th width="10%">Alasan/Sebab</th>
                                <th width="13%">Status & Lampiran</th>
                                <th width="13%">Remark</th>
                                <th width="10%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($approvement == 'IN PROGRESS') {
                                $pemohon= getSenaraiPemohonCutiBaharu1($_SESSION['SESS_NO_STAFF'],$_SESSION['SESS_DEPARTMENT_SUB']);
                            }
                            else if($approvement == 'APPROVE') {
                                $pemohon= getSenaraiPemohonCutiLulusSemua1($_SESSION['SESS_NO_STAFF'],$_SESSION['SESS_DEPARTMENT_SUB']);
                            }
                            else {
                                $pemohon= getSenaraiPemohonCutiTidakLulusSemua1($_SESSION['SESS_NO_STAFF'],$_SESSION['SESS_DEPARTMENT_SUB']);
                            }


                            $i= 1;
                            while($row_pemohon = $pemohon->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <a href="#myModal1" data-toggle="modal" data-id="<? echo $row_pemohon['id'];?>"><?php echo $row_pemohon['nama_pekerja']; ?></a>
                                        <br><b>&nbsp;<?php echo $row_pemohon['noic']; ?></b>
                                        <br><b>&nbsp;<?php echo $row_pemohon['dept_code']; ?><?php //echo $row_pemohon['approval']; ?></b>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalAkses<?php echo $i; ?>" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title"><b>Maklumat Permohonan Cuti</b></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table width="100%">
                                                            <tr>
                                                                <th width="30%"></th>
                                                                <th width="3%"></th>
                                                                <th></th>
                                                            </tr>
                                                            <tr>
                                                                <td><label>Nama</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['nama_pekerja']?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>No. Kad Pengenalan</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['noic']?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>No. Telefon</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['phone'] ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>Email</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['email']?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>Jawatan</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['role']?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>Bahagian</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['dept_code']?></td>
                                                            </tr>


                                                            <tr>
                                                                <td><label>Jumlah Keseluruhan Cuti</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['total_cuti']?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>Baki Cuti Semasa</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['baki_cuti'];?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>Baki Cuti Permohonan</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?php echo $row_pemohon['baki_cuti_pohon'];?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label>Status</label></td>
                                                                <td><label>:</label></td>
                                                                <td><?
                                                                    if($approvement == 'PENDING') {
                                                                        echo '<b><font color="blue">'.'NEW'.'</font></b>';}
                                                                    else if($approvement == 'APPROVE') {
                                                                        echo '<b><font color="green">'.'APPROVE'.'</font></b>';}
                                                                    else {
                                                                        echo '<b><font color="red">'.'DISAPPROVE   '.'</font></b>';}

                                                                    ?>
                                                                </td>
                                                            </tr>




                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $row_pemohon['id'];?>"><label class="control-label">Tarikh Mohon :</label> <?php echo date('d/m/Y',strtotime($row_pemohon['date_fill']));?>
                                        <br><label class="control-label">Tarikh Awal :</label> <? echo '<b><font color="blue">'.date('d/m/Y',strtotime($row_pemohon['date_lv_from'])).'</font></b>';?>
                                        <br><label class="control-label">Tarikh Akhir :</label> <? echo '<b><font color="brown">'.date('d/m/Y',strtotime($row_pemohon['date_lv_to'])).'</font></b>';?>
                                        <br><label class="control-label">Bilangan Cuti :</label> <?php echo $row_pemohon['total_lv_req']; ?>
                                        <br><label class="control-label">Sokongan :</label> <?php echo $row_pemohon['support_by']; ?>
                                        <? echo ($approvement!='IN PROGRESS') ? '<br><label class="control-label">Nama Pelulus :</label>'.$row_pemohon['pelulus'] : ''; ?></td>
                                    <!-- <td><?//php echo $row_pemohon['baki_cuti']; ?></td> -->
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $row_pemohon['id'];?>"><?php echo $row_pemohon['reason_leave']; ?></td>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $row_pemohon['id'];?>">
                                        <?
                                        if($approvement == 'IN PROGRESS') {
                                            echo '<b><font color="blue">'.'BAHARU'.'</font></b>';}
                                        else if($approvement == 'APPROVE') {
                                            echo '<b><font color="green">'.'LULUS'.'</font></b>';}
                                        else {
                                            echo '<b><font color="red">'.'TIDAK LULUS'.'</font></b>';}
                                        ?>
                                    </td>
                                    <td><?php echo $row_pemohon['remark'];?></td>
                                    <td>
                                        <a href="#myModal1" data-toggle="modal" data-id="<? echo $row_pemohon['id'];?>"><button class="btn btn-info" type="button">Papar Maklumat</button></a>
                                        <?if($row_pemohon['document'] != '' || $row_pemohon['document_name'] != '') {?>
                                        <a href="#myModal2" data-toggle="modal" data-id="<? echo $row_pemohon['id'];?>"><button class="btn btn-warning" type="button">Papar Lampiran</button></a><?}?>
                                        <?
                                        if ($row_pemohon['approvement'] == 'IN PROGRESS') { ?>
                                            <a href="lulus_cuti.php?staff_holiday_id=<? echo $row_pemohon['id'];?>&no_staff=<? echo $row_pemohon['no_staff'];?>&staff_record_id=<? echo $row_pemohon['staff_record_id'];?>"><button class="btn btn-success" type="button" >Luluskan</button></a>
                                        <?}
                                        else if ($row_pemohon['approvement'] == 'DISAPPROVE') { ?>
                                            <a href="lulus_cuti2.php?staff_holiday_id=<? echo $row_pemohon['id'];?>&no_staff=<? echo $row_pemohon['no_staff'];?>&staff_record_id=<? echo $row_pemohon['staff_record_id'];?>"><button class="btn btn-success" type="button" >Luluskan</button></a>

                                        <?}?>
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal1').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'maklumat_cuti_papar.php',
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
<script language="JavaScript" type="text/javascript">
    function checkDelete(){
        return confirm('Adakah anda pasti untuk padam Peranan ini?');
    }


</script>

</body>

</html>
