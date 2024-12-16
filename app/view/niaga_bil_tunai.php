<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>
<?
$id_bil_tunai=$_GET['id_bil_tunai'];
//$lead = $_GET['lead'];
$shortcode = $_GET['shortcode'];

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
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


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
        <?
        $flagScreen="tab_7";
        include ('../global/menu_niaga.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bil Tunai</h1>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Bil Tunai</button>

            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Bil Tunai
                    </div>

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Bil Tunai</h4>
                                </div>

                                <div class="modal-body">

                                    <?

                                    $data = getCompanySC();
                                    while($row_data = $data->fetch_assoc()){

                                    ?>

                                    <form method="post" action="../controller/bil_tunai_add_pelanggan_exec.php" >

                                        <input name="shortcode" type="hidden" class="input-short" value="<?php echo $row_data['shortcode']; ?>" /> <?}?>
                                        <input class="form-control" id="tajuk_bil_tunai" name="tajuk_bil_tunai" value="JUALAN TUNAI" type="hidden" >


                                        <div class="form-group" align="left">
                                            <label>Pelanggan<font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="agensi_rujukan" value="">
                                                <option value="">-- Pilih --</option>
                                                <option value="0">TUNAI</option>

                                                <?
                                                $lead= getLead();
                                                while ($list  = $lead -> fetch_assoc()){

                                                    ?>
                                                    <option value="<? echo $list['id'];?>"><? echo $list['lead_name'];?>: <? echo $list['pic_name'];?></option>

                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="form-group" align="left">
                                            <label>Kategori Produk/Perkhidmatan<font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="id_produk" value="">
                                                <option value="0">-- Pilih --</option>

                                                <?
                                                $product= getProduct();
                                                while ($list  = $product -> fetch_assoc()){

                                                    ?>
                                                    <option value="<? echo $list['id'];?>"><b><? echo $list['code'];?></b> - <? echo $list['produk'];?></option>

                                                <?}?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Pegawai Jualan<font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="pegawai_dalaman" value="">
                                                <option value="0">-- Pilih --</option>

                                                <?
                                                $pegawai= getPegawai();
                                                while ($list  = $pegawai -> fetch_assoc()){
                                                    ?>
                                                    <option value="<? echo $list['no_staff'];?>"><b><? echo $list['no_staff'];?></b> - <? echo $list['name'];?></option>

                                                <?}?>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button></a>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>
                                </div>
                                </form>
                            </div><!--modal-body-->

                        </div>
                        <!-- /.modal-content -->
                        <!-- /.modal-dialog -->
                    </div><!-- /.modal -->





                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Bil Tunai</th>
                                <th>Perkara</th>
                                <th>Pelanggan</th>
                                <th>Jumlah (RM)</th>
                                <th>Status</th>
                                <th>Status Penerimaan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getBiltunai();
                            while($row_data = $data->fetch_assoc()) {
                                $notel_rujukan=$row_data['notel_rujukan'];
                                $id_bil_tunai=$row_data['id_bil_tunai'];


                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_bil_tunai']; ?></td>
                                    <td>
                                        <?php echo $row_data['tajuk_bil_tunai']; ?><br><br>
                                        Kategori: <b><?php echo $row_data['code']; ?></b><br><br>
                                    </td>
                                    <td>
                                        <?php echo $row_data['agensi_rujukan']; ?><br><br
                                        >Untuk perhatian: <?php echo $row_data['nama_rujukan']; ?><br><br>
                                        Jualan Tunai oleh: <b><?php echo $row_data['nostaff_pegawai_dalaman']; ?>&nbsp;<?php echo $row_data['pegawai_dalaman']; ?></b><br><br>
                                    </td>
                                    <td><?php echo number_format($row_data['jumlah_bil_tunai'],2); ?></td>
                                    <td>
                                        <?php
                                        $status_bil_tunai = $row_data['status_bil_tunai'];
                                        if ($status_bil_tunai == 0 ) {
                                            echo "<font color=red><strong>AKTIF</strong></font>";
                                            ?>
                                            <?
                                        }else{
                                            echo "<font color=blue><strong>SELESAI</strong></font><br>";}
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($row_data['status_penerimaan_bil_tunai'] == 0 && $row_data['jumlah_bil_tunai'] > 0) {
                                            echo "<font color=red><strong>BELUM TERIMA</strong></font>";
                                            ?>

                                            <br>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $notel_rujukan; ?>&text=Assalamualaikum. Sila klik link di bawah untuk mengesahkan dokumen Bil Tunai anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/biltunai.php?id%3d<? echo $id_bil_tunai; ?>')" >WhatsApp Bil Tunai </button>

                                            <?
                                        }else {
                                            if ($row_data['status_penerimaan_bil_tunai'] == 1) {
                                                echo "<font color=blue><strong>TERIMA</strong></font><br>";
                                            } else {
                                                echo "<font color=blue><strong>BELUM DIHANTAR</strong></font><br>";
                                            }

                                        }

                                        ?>

                                    </td>

                                    <td>




                                        <?php
                                        if ($row_data['status_bil_tunai']== 0 && $row_data['status_penerimaan_bil_tunai'] == 1) {



                                            ?>
                                            <a href="bil_tunai_edit_pelanggan.php?id_bil_tunai=<? echo $row_data['id_bil_tunai'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a><br>
                                            <a href="bil_tunai_add_item.php?id_bil_tunai=<? echo $row_data['id_bil_tunai'];?>"><button class="btn btn-primary" type="button" >Tambah Item</button></a><br>


                                            <?
                                        }
                                        ?>

                                        <?php
                                        if ($row_data['status_penerimaan_bil_tunai'] == 0  ) {

                                            ?>
                                            <a href="bil_tunai_edit_pelanggan.php?id_bil_tunai=<? echo $row_data['id_bil_tunai'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a><br>
                                            <a href="bil_tunai_add_item.php?id_bil_tunai=<? echo $row_data['id_bil_tunai'];?>"><button class="btn btn-primary" type="button" >Tambah Item</button></a><br>

                                            <?
                                        }
                                        ?>

                                        <?
                                        if ($row_data['jumlah_bil_tunai'] > 0) {

                                            ?>
                                            <a href="" onclick="return popitup('../template/biltunai.php?id=<? echo $row_data['id_bil_tunai'];?>')"><button class="btn btn-info" type="button" >Cetak Bil Tunai</button></a><br>
                                            <?
                                        }
                                        ?>
                                        <?php

                                        /*$log=getPesananBelian($row_data['id_sebut_harga'])->fetch_assoc();
                                        if(isset($log['id_pesanan_belian']))
                                        {


                                         } else{*/

                                        ?>



                                        <? //} ?>
                                        <br>
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
</script>

</body>

</html>
