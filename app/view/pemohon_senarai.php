<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?
$no_staff = $_GET['no_staff'];
$com_id = $_GET['company_id'];
//$statact = $_GET['statact'];
$tahun = $_GET['tahun'];

if ($tahun != NULL) {
    $statact = "DLMPOHON";
}
else {
    $statact = $_GET['statact'];
}

?>

<?
if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
{
    deletePemohon($id);
}
?>

<?
if(isset($_GET['act']) && $_GET['act'] == "inactive" && !empty($_GET['id']))
{
    update_PemohonActivity(0,$id);
}

if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
{
    deletePemohon($id);
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
        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
        }
    </script>

    <script language="javascript" type="text/javascript">


    </script>

    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }

        // -->
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

                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <?

        if ($statact=='DLMPOHON') {
            $flagScreen="tab_1";
        }
        elseif ($statact=='IV') {
            $flagScreen="tab_2";
        }
        elseif ($statact=='TERIMA') {
            $flagScreen="tab_3";
        }
        elseif ($statact=='STAFF') {
            $flagScreen="tab_4";
        }
        else {
            $flagScreen="tab_5";
        }
        include ('../global/menu_pemohonlist.php');
        ?>
        <div class="row">
            <!--<div class="col-lg-12">
                <h1 class="page-header">Permohonan Perjawatan</h1>
            </div>-->


            <div class="panel-heading" align="right">

                <a href="permohonan_baru.php?&com_id=<?echo($_SESSION['SESS_COM']);?>">
                    <button class="btn btn-primary">Tambah Permohonan Baru</button></a>

            </div></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Permohonan
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarikh (Mohon, Mula & Tamat)</th>
                                <th>Peranan</th>
                                <th>Nama Pemohon</th>
                                <th>Alamat Tetap</th>
                                <th>Status</th>
                                <th>Status Jawapan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_pemohon = getLogPemohon($statact);
                            while($list = $log_pemohon->fetch_assoc()) {

                                $id=$list['id'];
                                $noic=$list['noic'];
                                $staffhpno=$list['phone'];
                                $status_jawapan=$list['status_jawapan'];
                                $peranan=$list['role_id'];
                                $kelulusanid=$list['kelulusanid'];

                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td nowrap><b>Permohonan dibuat:</b><br>
                                        <?php echo $list['created_date']; ?><br><br>
                                        <b>Tempoh:</b><br>
                                        <? echo date('d/m/Y',strtotime($list['tarikh_mula']));?> - <? echo date('d/m/Y',strtotime($list['tarikh_tamat']));?>
                                    </td>
                                    <td><?php echo $list['peranan']; ?></td>
                                    <td nowrap><b><?php echo $list['name']; ?></b><br><?php echo $list['noic']; ?></td>
                                    <td><?php echo $list['alamat_tetap']; ?></td>
                                    <td><font color=blue><strong><?php echo $list['desc'];?></strong></font></td>
                                    <td nowrap>
                                        <!--<button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $list['phone']; ?>')" >WhatsApp</button><br>-->

                                        <? if($list['statusmohon'] == '') {


                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $list['phone']; ?>')" >WhatsApp</button><br>
                                            <?
                                        }
                                        else if($list['statusmohon'] == 'TDKTERIMA') {


                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $list['phone']; ?>')" >WhatsApp</button><br>
                                            <?
                                        }
                                        else if($status_jawapan==0 && $peranan != 'INTERN' && $list['statusmohon'] == 'DLMPOHON') {
                                            echo "<strong><font color=red>BELUM TERIMA</font></strong><br>";

                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $staffhpno; ?>&text=Assalamualaikum w.b.t. Sila klik link di bawah untuk mengesahkan Surat Tawaran anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/surat_offer_perjawatan_draft.php?id%3d<? echo $kelulusanid; ?>%26noic%3d<? echo $noic; ?>')" >WhatsApp Surat Setuju Terima </button>
                                            <?
                                        }
                                        else if($status_jawapan==1 && $peranan != 'INTERN' && $list['statusmohon'] == 'TERIMA' ) {
                                            echo "<strong><font color=blue>TERIMA</font></strong><br>";
                                            ?>


                                            <?
                                        }
                                        else if($status_jawapan==1 && $peranan = 'INTERN' && $list['statusmohon'] == 'TERIMA') {
                                            echo "<strong><font color=blue>TERIMA</font></strong><br>";
                                            ?>
                                            <button class="btn btn-warning" onclick="return popitup('../template/surat_offer_intern_draft.php?id=<? echo$kelulusanid; ?>&noic=<? echo $noic; ?>')" >Surat Setuju Terima </button>
                                        <? }

                                        else if($status_jawapan==0 && $peranan = 'INTERN' && $list['statusmohon'] == 'TERIMA' ) {
                                            echo "<strong><font color=red>BELUM TERIMA</font></strong><br>";

                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $staffhpno; ?>&text=Assalamualaikum w.b.t. Sila klik link di bawah untuk mengesahkan Surat Tawaran anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/surat_offer_intern_draft.php?id%3d<? echo $kelulusanid; ?>%26noic%3d<? echo $noic; ?>')" >WhatsApp Surat Setuju Terima </button>
                                        <? }

                                        else if($status_jawapan==0 && $list['statusmohon'] == 'IV' ) {
                                            echo "<strong><font color=red>BELUM TERIMA</font></strong><br>";

                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $staffhpno; ?>&text=Assalamualaikum w.b.t. Sila klik link di bawah untuk melihat Surat Panggilan Temuduga anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/surat_panggilan_temuduga.php?pemohon_id%3d<? echo $id; ?>')" >WhatsApp Surat Temuduga </button>
                                        <? }

                                        else if($list['statusmohon'] == 'TDKTERIMA' ) {
                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $list['phone']; ?>')" >WhatsApp</button><br>
                                        <? }

                                        else if($list['statusmohon'] == 'STAFF' ) {
                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $list['phone']; ?>')" >WhatsApp</button><br>
                                        <? }?>

                                        <br>
                                        <?php

                                        if ($list['statusmohon'] != 'TDKTERIMA' && $list['statusmohon'] != 'STAFF') {
                                            echo $list['tarikh_jawapan'];
                                        }
                                        ?>





                                    </td>
                                    <td>

                                        <?
                                        if ($list['status_pemohon'] == 'DLMPOHON') { ?>

                                            <a href="pemohon_update.php?pemohon_id=<? echo $list['id']; ?>&act=update"><button type="button" class="btn btn-info">Kemaskini</button></a>
                                            <a href="hr_add_interview.php?pemohon_id=<? echo $list['id']; ?>&no_staff=<? echo $no_staff; ?>"><button type="button" class="btn btn-warning">Tetapkan Jadual</button></a>
                                            <a href="" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $list['id']; ?>')"><button type="button" class="btn btn-info">Papar Permohonan</button> </a>
                                            <a onclick="batalPenerimaan('<? echo $list['id'];?>','<? echo $list['kelulusanid'];?>')">
                                                <button class="btn btn-danger" type="button">Ditolak</button></a>
                                            <a onclick="removePemohonData('<? echo $list['id'];?>','<? echo $list['kelulusanid'];?>')">
                                                <button class="btn btn-danger" type="button">Padam</button></a>
                                            <?
                                        }
                                        else if  ($list['status_pemohon'] == 'IV') {  ?>

                                            <a href="" onclick="return popitup('../template/surat_panggilan_temuduga.php?pemohon_id=<? echo $list['id'];?>')" ><button type="button" class="btn btn-warning">Surat Temuduga</button></a>
                                            <a href="pemohon_update.php?pemohon_id=<? echo $list['id']; ?>&act=update"><button type="button" class="btn btn-info">Papar Permohonan</button></a>

                                        <?		}
                                        else if  ($list['status_pemohon'] == 'TERIMA' && $list['role_id'] != 'INTERN') {  ?>

                                            <a href="" onclick="return popitup('../template/surat_panggilan_temuduga.php?pemohon_id=<? echo $list['id'];?>')" ><button type="button" class="btn btn-warning">Surat Temuduga</button></a>
                                            <a href="" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $list['id']; ?>')"><button type="button" class="btn btn-info">Papar Permohonan</button> </a>

                                        <?	}
                                        else if  ($list['status_pemohon'] == 'TERIMA' && $list['role_id'] == 'INTERN' ) {  ?>

                                            <a href="" onclick="return popitup('../template/surat_panggilan_temuduga.php?pemohon_id=<? echo $list['id'];?>')" ><button type="button" class="btn btn-warning">Surat Temuduga</button></a>
                                            <a href="" onclick="return popitup('../template/surat_offer_intern_draft.php?id=<? echo $kelulusanid; ?>&noic=<? echo $noic; ?>')" ><button type="button" class="btn btn-warning">Surat Setuju Terima</button></a>
                                            <? if ($status_jawapan==1) {?>
                                                <a href="" onclick="return popitup('../template/borang_jawapan_intern_draft.php?id=<? echo $kelulusanid; ?>&noic=<? echo $noic; ?>')" ><button type="button" class="btn btn-warning">Borang Jawapan</button></a>
                                            <? }?>
                                            <a href="" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $list['id']; ?>')"><button type="button" class="btn btn-info">Papar Permohonan</button></a>


                                        <?	}
                                        else if  ($list['status_pemohon'] == 'STAFF' && $list['role_id'] != 'INTERN') {  ?>

                                            <a href="" onclick="return popitup('../template/surat_panggilan_temuduga.php?pemohon_id=<? echo $list['id'];?>')" ><button type="button" class="btn btn-warning">Surat Temuduga</button></a>
                                            <a href="" onclick="return popitup('../template/surat_offer_perjawatan_draft.php?id=<? echo $kelulusanid; ?>&noic=<? echo $noic; ?>')" ><button type="button" class="btn btn-warning">Surat Setuju Terima</button></a>
                                            <a href="" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $list['id']; ?>')"><button type="button" class="btn btn-info">Papar Permohonan</button></a>

                                        <?	}
                                        else if  ($list['status_pemohon'] == 'STAFF' && $list['role_id'] = 'INTERN') {  ?>

                                            <a href="" onclick="return popitup('../template/surat_panggilan_temuduga.php?pemohon_id=<? echo $list['id'];?>')" ><button type="button" class="btn btn-warning">Surat Temuduga</button></a>
                                            <a href="" onclick="return popitup('../template/surat_offer_intern_draft.php?id=<? echo $kelulusanid; ?>&noic=<? echo $noic; ?>')" ><button type="button" class="btn btn-warning">Surat Setuju Terima</button></a>
                                            <a href="" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $list['id']; ?>')"><button type="button" class="btn btn-info">Papar Permohonan</button></a>

                                        <?	}
                                        else if  ($list['status_pemohon'] == 'TDKTERIMA') {  ?>

                                        <a href="" onclick="return popitup('../template/surat_makluman_tidak_terpilih.php?pemohon_id=<? echo $list['id'];?>')" ><button type="button" class="btn btn-warning">Surat Tidak Terpilih</button>
                                            <a href="" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $list['id']; ?>')"><button type="button" class="btn btn-info">Papar Permohonan</button></a>
                                            <?
                                            }
                                            ?>

                                    </td>
                                </tr>

                                <?php $i++; } ?>

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
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function batalPenerimaan(pemohon_id,pmohon_lulus_id){
        $.ajax({
            url: "../model/staff_function.php",
            type: "POST",
            data: {action:"statusKelulusanUpdate",pemohon_id:pemohon_id,pmohon_lulus_id:pmohon_lulus_id},
            success: function (response) {
                $.confirm({
                    title: 'Notifikasi',
                    content: response,
                    buttons: {
                        OK: function () {
                            location.reload(true);
                        }
                    }
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }


        });
    }

    function removePemohonData(pemohon_id,pmohon_lulus_id){
        $.ajax({
            url: "../model/staff_function.php",
            type: "POST",
            data: {action:"removePemohonData",pemohon_id:pemohon_id,pmohon_lulus_id:pmohon_lulus_id},
            success: function (response) {
                $.confirm({
                    title: 'Notifikasi',
                    content: response,
                    buttons: {
                        OK: function () {
                            location.reload(true);
                        }
                    }
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }


        });
    }
</script>

</body>

</html>