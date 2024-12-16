<?php

include ('../controller/auth.php');

require "../model/cuti_function.php";


?>
<?
date_default_timezone_set("Asia/Kuala_Lumpur");
$no_staff = $_SESSION['SESS_NO_STAFF'];
$rule_cuti = $_GET['rule_cuti'];
$sys = getSys(1)->fetch_assoc();
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
            if (baki_cuti_pohon==0) {
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

                <h1 class="page-header">Maklumat Peribadi</h1>

            </div>
            <div class="panel-heading">

                <?
                $staff = getStaffInformation($no_staff,$jenis_cuti) -> fetch_assoc();
                ?>

                <table width="100%">
                    <tr>
                        <th width="13%"></th>
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

                    <tr>
                        <td><label>Jawatan</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['role']?></td>
                    </tr>

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
                    <?$cuti = getCutiInformation($staff['rule_cuti'],date('Y'),$staff['staff_record_id']);
                    while ($list_cuti = $cuti->fetch_assoc()) {?>

                        <tr>
                            <td><label><font color="blue"><?echo $list_cuti['desc'];?></font></label></td>
                        </tr>

                        <tr>
                            <td><i><label>Jumlah Keseluruhan</label></i></td>
                            <td><label>:</label></td>
                            <td><?php echo $list_cuti['total_cuti'];?>&nbsp;Hari</td>
                        </tr>

                        <tr>
                            <td><i><label>Baki Semasa</label></i></td>
                            <td><label>:</label></td>
                            <td><?php echo $list_cuti['baki_cuti'];?>&nbsp;Hari</td>
                        </tr>

                        <tr>
                            <td><i><label>Baki Permohonan</label></i></td>
                            <td><label>:</label></td>
                            <td><?php echo $list_cuti['baki_cuti_pohon'];?>&nbsp;Hari</td>
                        </tr>
                    <?}?>

                </table>
            </div>



            <div class="panel-heading" align="right">
                <div align="right">
                    <a href="permohonan_cuti_tahunan.php?no_staff=<? echo $no_staff;?>&staff_record_id=<?echo $staff['staff_record_id']?>"><button class="btn btn-primary" type="button">Borang Permohonan Cuti</button></a>
                    <!-- <a href="permohonan_cuti_tahunan.php?no_staff=<? echo $no_staff;?>"><button class="btn btn-primary" onclick="Alert()" type="button">Borang Permohonan Cuti</button></a> -->
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Senarai Permohonan Cuti</label>&nbsp;&nbsp;&nbsp;
                        <a href="maklumat_cuti.php?tahun=currentyear">Tahun Ini</a> &nbsp;|&nbsp;
                        <a href="maklumat_cuti.php?tahun=previousyear">Tahun Sebelum</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="20%">Alamat & No. Telefon</th><!--
                                        <th width="10%">No. Telefon</th>  -->
                                <th width="20%">Maklumat Cuti</th>
                                <!-- <th>Jenis Cuti</th>
                                <th>Jum. Cuti</th> -->
                                <th width="15%">Status & Catatan</th>
                                <th width="13%">Alasan/Sebab</th>
                                <th width="10%">Tindakan</th>
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
                                    <td><?php echo $row_maklumat_cuti['alamat_cuti']; ?>
                                        <br><?php echo $row_maklumat_cuti['telepon']; ?></td>
                                    <td><label class="control-label">Tarikh Mula :</label> <? echo '<b><font color="blue">'.date('d/m/Y',strtotime($row_maklumat_cuti['tarikh_mula'])).'</font></b>';?>
                                        <br><label class="control-label">Tarikh Akhir :</label> <? echo '<b><font color="brown">'.date('d/m/Y',strtotime($row_maklumat_cuti['tarikh_akhir'])).'</font></b>';?>
                                        <br><label class="control-label">Jenis Cuti :</label> <?php echo $row_maklumat_cuti['nama_cuti']; ?>
                                        <br><label class="control-label">Jum. Cuti :</label> <?php echo $row_maklumat_cuti['jumlah_cuti']; ?></td>
                                    <td>
                                        <?
                                        if($tahun == 'previousyear') {
                                            if($row_maklumat_cuti['approvement'] == 'SD' ) {
                                                echo '<b><font color="red">'.'OVERDUE'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'LULUS'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'TIDAK LULUS'.'</font></b>';}
                                            else {
                                                echo '<b><font color="orange">'.'BELUM DIHANTAR'.'</font></b>';}
                                        }
                                        else {
                                            if($row_maklumat_cuti['approvement'] == 'SD' ) {
                                                echo '<b><font color="blue">'.'BAHARU'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'LULUS'.'</font></b>';}
                                            else if($row_maklumat_cuti['approvement'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'TIDAK LULUS'.'</font></b>';}
                                            else {
                                                echo '<b><font color="orange">'.'BELUM DIHANTAR'.'</font></b>';}
                                        }
                                        ?>
                                        <br><?php echo $row_maklumat_cuti['catatan'];?>
                                    </td>

                                    <td><?php echo $row_maklumat_cuti['sebab'];?><br>
                                        <?if($row_maklumat_cuti['document_type'] == 'jpg' || $row_maklumat_cuti['document_type'] == 'jpeg' || $row_maklumat_cuti['document_type'] == 'png' || $row_maklumat_cuti['document_type'] == 'gif') {
                                            echo '<img width="200" height="100" src="data:image/jpeg;base64,'.base64_encode( $row_maklumat_cuti['document'] ).'"/><br>';}
                                        else if($row_maklumat_cuti['document_type'] == 'pdf') {
                                            echo '<object width="200" height="100" data="data:application/pdf;base64,'.base64_encode( $row_maklumat_cuti['document'] ).'"/><br>'.'" type="application/pdf"></object>';}
                                        ?>

                                    </td>
                                    <td>
                                        <?if($row_maklumat_cuti['document'] != '') {?>
                                        <a href="#myModal2" data-toggle="modal" data-id="<? echo $row_maklumat_cuti['id'];?>"><button class="btn btn-info" type="button">Papar Lampiran</button></a><?}?>
                                        <?
                                        if ($row_maklumat_cuti['approvement'] == 'BD' && $tahun == 'currentyear') { ?>
                                            <a href="kemaskini_borang_permohonan.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&staff_record_id=<? echo $row_maklumat_cuti['staff_record_id'];?>&no_staff=<? echo $no_staff;?>"><button class="btn btn-primary" type="button" onclick="return Kemaskini()" >Kemaskini</button></a>
                                            <br><a href="../controller/hantar_button_exec.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>"><button class="btn btn-success" type="button" onclick="return Confirm()" >Hantar</button></a>
                                        <?}
                                        else if ($row_maklumat_cuti['approvement'] == 'BD' && $tahun == 'previousyear') {?>
                                            <a href="../controller/hantar_button_exec.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>"><button class="btn btn-success" type="button" onclick="return Confirm()" >Hantar</button></a>
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



</body>

</html>
