<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>
<?
$id = $_GET['id'];
?>

<?

if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
{
    activePemohon($id,2);

}

if(isset($_GET['act']) && $_GET['act'] == "active" && !empty($_GET['id']))
{
    activePemohon($id,1);

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
                <h1 class="page-header">Senarai Maklumat Pemohon Untuk Pelantikan</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">


            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pemohon
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pemohon</th>
                                <th>No Telefon</th>
                                <th>Kumpulan Peranan</th>
                                <th>Peranan</th>
                                <th>Gaji Dipersetujui</th>
                                <th>Status</th>
                                <th>Status Jawapan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_pemohon = getPemohon();
                            while($row_data_pemohon = $data_pemohon->fetch_assoc()) {
                                $id=$row_data_pemohon['id'];
                                $noic=$row_data_pemohon['noic'];
                                $staffhpno=$row_data_pemohon['phone'];
                                $status_jawapan=$row_data_pemohon['status_jawapan'];
                                $peranan=$row_data_pemohon['role_id'];
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>


                                    <td>
                                        <a href="" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $row_data_pemohon['pemohon_id']; ?>')"><?php echo strtoupper($row_data_pemohon['name']); ?></a>

                                    </td>
                                    <td><?php echo $row_data_pemohon['phone']; ?></td>
                                    <td><?php echo $row_data_pemohon['role_group_name']; ?></td>
                                    <td><?php echo $row_data_pemohon['role_id']; ?></td>
                                    <td><?php echo $row_data_pemohon['gaji_dipersetujui']; ?></td>
                                    <td><strong><font color="blue"><?php echo $row_data_pemohon['desc']; ?></font></strong>
                                    </td>
                                    <td>
                                        <? if($status_jawapan==0 && $peranan != 'INTERN' && $row_data_pemohon['code'] == 'TERIMA') {
                                            echo "<strong><font color=red>BELUM TERIMA</font></strong><br>";

                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $staffhpno; ?>&text=Assalamualaikum w.b.t. Sila klik link di bawah untuk mengesahkan Surat Tawaran anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/surat_offer_perjawatan_draft.php?id%3d<? echo $id; ?>%26noic%3d<? echo $noic; ?>')" >WhatsApp Surat Setuju Terima </button>
                                            <?
                                        }
                                        else if($status_jawapan==1 && $peranan != 'INTERN' && $row_data_pemohon['code'] == 'TERIMA' ) {
                                            echo "<strong><font color=blue>TERIMA</font></strong><br>";
                                            ?>
                                            <button class="btn btn-warning" onclick="return popitup('../template/surat_offer_perjawatan_draft.php?id=<? echo $id; ?>&noic=<? echo $noic; ?>')" >Surat Setuju Terima </button>
                                            <?
                                        }
                                        else if($status_jawapan==1 && $peranan = 'INTERN' && $row_data_pemohon['code'] == 'TERIMA') {
                                            echo "<strong><font color=blue>TERIMA</font></strong><br>";
                                            ?>
                                            <button class="btn btn-warning" onclick="return popitup('../template/surat_offer_intern_draft.php?id=<? echo $id; ?>&noic=<? echo $noic; ?>')" >Surat Setuju Terima </button>
                                        <? }

                                        else if($status_jawapan==0 && $peranan = 'INTERN' && $row_data_pemohon['code'] == 'TERIMA' ) {
                                            echo "<strong><font color=red>BELUM TERIMA</font></strong><br>";

                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $staffhpno; ?>&text=Assalamualaikum w.b.t. Sila klik link di bawah untuk mengesahkan Surat Tawaran anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/surat_offer_intern_draft.php?id%3d<? echo $id; ?>%26noic%3d<? echo $noic; ?>')" >WhatsApp Surat Setuju Terima </button>
                                        <? }?>
                                        <br>
                                        <?php echo $row_data_pemohon['tarikh_jawapan']; ?>
                                    </td>

                                    <td>

                                        <?
                                        if ($row_data_pemohon['code'] == 'TERIMA' && $status_jawapan==1){ ?>

                                            <a href="../controller/new_staff_exec.php?id=<? echo $row_data_pemohon['pemohon_id'];?>&shortcode=<? echo $shortcode;?>"><button class="btn btn-info" type="button" >Pilih Sebagai Staf</button></a>
                                            <a onclick="batalPenerimaan('<? echo $row_data_pemohon['pemohon_id'];?>','<? echo $row_data_pemohon['id'];?>')">
                                                <button class="btn btn-danger" type="button">Batal</button></a>

                                            <?
                                        }
                                        else {
                                            ?>
                                            <a onclick="batalPenerimaan('<? echo $row_data_pemohon['pemohon_id'];?>','<? echo $row_data_pemohon['id'];?>')">
                                                <button class="btn btn-danger" type="button">Batal</button></a>
                                            <?
                                        }

                                        ?>


                                        </strong>

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
</script>

</body>

</html>



