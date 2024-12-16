<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>
<?
//$id_sebut_harga=$_GET['id_sebut_harga'];
//$lead = $_GET['lead'];
echo $shortcode = $_GET['shortcode'];

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
        $flagScreen="tab_0";
        include ('../global/menu_niaga.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Permohonan Sebutharga</h1>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading" align="right">

                <!--<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Permohonan Sebutharga</button>-->

            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Permohonan Sebutharga
                    </div>

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Permohonan Sebutharga</h4>
                                </div>

                                <div class="modal-body">

                                    <?

                                    $data = getCompanySC();
                                    while($row_data = $data->fetch_assoc()){

                                    ?>

                                    <form method="post" action="../controller/jana_sebutharga_exec.php?reqid=" >

                                        <input name="shortcode" type="hidden" class="input-short" value="<?php echo $row_data['shortcode']; ?>" />

                                        <?}?>


                                        <div class="form-group" align="left">
                                            <label>Pelanggan<font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="agensi_rujukan" value="">
                                                <option value="">-- Pilih --</option>

                                                <?
                                                $lead= getLead();
                                                while ($list  = $lead -> fetch_assoc()){

                                                    ?>
                                                    <option value="<? echo $list['id'];?>"><? echo $list['lead_name'];?>: <? echo $list['pic_name'];?></option>

                                                <?}?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Tajuk<font color="red">**</font>&nbsp;</label>
                                            <br>SEBUTHARGA  <input class="form-control" id="tajuk_sebut_harga" name="tajuk_sebut_harga" required autocomplete="" >
                                        </div>

                                        <div class="form-group">
                                            <label for="comment">Terma Sebutharga</label>
                                            <textarea class="form-control" rows="5" name="terma_sebut_harga" id="terma_sebut_harga" ></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Tempoh Sah (Hari)<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " id="tempoh_sah_sebut_harga" name="tempoh_sah_sebut_harga" required autocomplete="" type="number" >
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
                                <th>Tarikh Permohonan Dibuat</th>
                                <th>Produk</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Status Data Prospect</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getReqSebutharga();
                            while($row_data = $data->fetch_assoc()) {
                                $notel_rujukan=$row_data['notel'];
                                //$id_sebut_harga=$row_data['id_sebut_harga'];
                                $status_quote=$row_data['status_quote'];
                                echo $reqid=$row_data['id'];


                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['created_date']; ?></td>
                                    <td><b><?php echo $row_data['nama_produk']; ?></b></td>
                                    <td>
                                        <b><?php echo $row_data['nama_syarikat']; ?></b><br>Bil. Pekerja Syarikat: <?php echo $row_data['bil_pekerja']; ?><br>
                                        Alamat: <?php echo $row_data['alamat']; ?><br>Untuk perhatian: <?php echo $row_data['nama_penuh']; ?></td>
                                    <td>
                                        <?php
                                        $status_quote=$row_data['status_quote'];
                                        if ($status_quote == 0 ) {
                                            echo "<font color=red><strong>BARU</strong></font>";
                                            ?>
                                            <?
                                        }else{
                                            echo "<font color=blue><strong>SELESAI</strong></font><br>";}
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($row_data['status_data_prospect'] == '') {
                                            echo "<font color=red><strong>DATA BAHARU</strong></font>";

                                        } else {
                                            echo "<font color=blue><strong>DATA TELAH WUJUD</strong></font><br>";
                                        }
                                        ?>
                                        <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $notel_rujukan; ?>&text=Assalamualaikum w.b.t. Pihak kami telah menerima permohonan sebutharga daripada pihak tuan.')" >WhatsApp Pemohon</button>

                                    </td>

                                    <td>




                                        <?php
                                        if ($row_data['status_quote']== 0) {



                                            ?>
                                            <!--<a href="sebut_harga_edit_pelanggan.php?id_sebut_harga=<? echo $row_data['id_sebut_harga'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a><br>
                        <a href="niaga_pesanan_belian_add.php?id_sebut_harga=<? echo $row_data['id_sebut_harga'];?>"><button class="btn btn-primary" type="button" >Tambah Data Prospek</button></a>-->
                                            &nbsp;<button class="btn btn-warning" data-toggle="modal" data-target="#myModal" value=1>Jana Sebutharga</button>

                                            <?
                                        }
                                        ?>

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
