<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>
<?
$id_sebut_harga=$_GET['id_sebut_harga'];
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

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Kemaskini Sebutharga</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <?
                                // $data = getCompanySC();
                                //  while($row_data = $data->fetch_assoc()){

                                $list = getSebutHargaPelanggan($id_sebut_harga)->fetch_assoc();
                                // $log = getLeadInformation($lead)-> fetch_assoc();
                                ?>
                                <form method="post" action="../controller/sebut_harga_edit_pelanggan_exec.php" >

                                    <input name="id_sebut_harga" type="hidden" class="input-short" value="<? echo $id_sebut_harga;?>" />

                                    <div>

                                        <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                                    </div>



                                    <div class="form-group" align="left">
                                        <label>Agensi Rujukan<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control" name="agensi_rujukan" id="agensi_rujukan" value="<? echo $list['agensi_rujukan'] ?>">
                                            <option value="<? echo $list['id_lead'];?>" selected><b><? echo $list['agensi_rujukan'];?></b> - <? echo $list['nama_rujukan'];?></option>
                                            <option value="0">-- Pilih --</option>

                                            <? $lead= getLead();
                                            while ($data  = $lead -> fetch_assoc()){ ?>
                                                <option value="<? echo $data['id'];?>"><? echo $data['lead_name'];?>: <? echo $data['pic_name'];?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Pegawai Rujukan Dalaman<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control" name="pegawai_dalaman" id="pegawai_dalaman" value="<? echo $list['pegawai_dalaman'] ?>">
                                            <option value="<? echo $list['nostaff_pegawai_dalaman'];?>" selected><b><? echo $list['nostaff_pegawai_dalaman'];?></b> - <? echo $list['namastaff_pegawai_dalaman'];?></option>
                                            <option value="">-- Pilih --</option>

                                            <? $pegawai= getPegawai();
                                            while ($data  = $pegawai -> fetch_assoc()){ ?>
                                                <option value="<? echo $data['no_staff'];?>"><b><? echo $data['no_staff'];?></b> - <? echo $data['name'];?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Kategori Produk/Perkhidmatan<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control" name="id_produk" id="id_produk" value="<? echo $list['id_produk'] ?>">
                                            <option value="<? echo $list['id_produk'];?>" selected><b><? echo $list['code'];?></b> - <? echo $list['produk'];?></option>
                                            <option value="">-- Pilih --</option>

                                            <? $product= getProduct();
                                            while ($data  = $product -> fetch_assoc()){ ?>
                                                <option value="<? echo $data['id'];?>"><b><? echo $data['code'];?></b> - <? echo $data['produk'];?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>





                                    <div class="form-group" align="left">
                                        <label>Tajuk<font color="red">**</font>&nbsp;</label>
                                        <br>Sebutharga<input class="form-control"  name="tajuk_sebut_harga" value="<? echo $list['tajuk_sebut_harga']; ?>" >
                                    </div>

                                    <div class="form-group">
                                        <label for="comment">Terma Sebut Harga</label>
                                        <textarea rows="5" class="form-control"  name="terma_sebut_harga" ><? echo $list['terma_sebut_harga']; ?>  </textarea>
                                    </div>




                                    <div class="form-group" align="left">
                                        <label>Tempoh Sah<font color="red">**</font>&nbsp;</label>
                                        <input class="form-control"  name="tempoh_sah_sebut_harga" value="<? echo $list['tempoh_sah_sebut_harga']; ?>" >
                                    </div>


                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button></a>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                    </div>
                            </div>

                            </form>

                        </div>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <? include ('../global/footer.php'); ?>
        <!-- /#page-wrapper -->

    </div></div>
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
