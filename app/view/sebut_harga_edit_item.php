<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>
<?

$id = $_GET['id'];
$id_sebut_harga = $_GET['id_sebut_harga'];



?>

<?
if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
{
    deleteSebutHarga($id);
}

?>


<script>
    function calculate(){
        var kuantiti_item = document.getElementById("kuantiti_item").value;
        var harga_item = document.getElementById("harga_item").value;
        var jumlah_harga_item_sh = kuantiti_item*harga_item ;


        document.getElementById("jumlah_harga_item").value=(jumlah_harga_item_sh);
    }
</script>




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

    <script language="JavaScript" type="text/javascript">
        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
        }
    </script>

    <style>
        hr{
            border-top: 3px double #000000;
            margin-top: 0;
        }
    </style>
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
                <h1 class="page-header">Tambah Item Sebutharga</h1>   </div></div>
        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                <a href="" onclick="return popitup('../template/sebutharga.php?id=<? echo $id_sebut_harga; ?>')"><button class="btn btn-warning" type="button" >Papar Sebutharga</button></a>



            </div>

            <div class="col-lg-8">





                <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                <!-- Button trigger modal -->


                <?
                $data = getPelangganEdit($id_sebut_harga) -> fetch_assoc();
                ?>

                <input name="id_sebut_harga" type="hidden" class="input-short" value="<? echo $id_sebut_harga;?>" />
                <p><b> Nama Rujukan </b> : <?php echo $data['nama_rujukan'] ?> </p>
                <p><b> Agensi Rujukan </b> : <?php echo $data['agensi_rujukan'] ?> </p>
                <p><b> Alamat Rujukan </b> : <?php echo $data['alamat_rujukan'] ?> </p>
                <p><b> No Tel Rujukan </b> : <?php echo $data['notel_rujukan'] ?> </p>
                <p><b> Tajuk Rujukan </b> : <?php echo $data['tajuk_sebut_harga'] ?> </p>
                <p><b> Terma Rujukan </b> : <?php echo $data['terma_sebut_harga'] ?> </p>
                <p><b> Tempoh Sah Rujukan </b> : <?php echo $data['tempoh_sah_sebut_harga'] ?> </p>





                <form method="post" action="../controller/sebut_harga_edit_item_exec.php?id_sebut_harga=<? echo $id_sebut_harga; ?>" >


                    <?

                    $list = getItemInfo($id_sebut_harga,$id) -> fetch_assoc();

                    ?>
                    <input name="id_sebut_harga" type="hidden" class="input-short" value="<? echo $id_sebut_harga;?>" />

                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />



                    <br><br>


                    <div>

                        <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                    </div>


                    <div class="form-group" align="left">
                        <label>Item<font color="red">**</font>&nbsp;</label>
                        <input class="form-control" placeholder=" " id="keterangan_item" name="keterangan_item" required autocomplete="" type="text" value="<? echo $list['keterangan_item']; ?>">
                    </div>


                    <div class="form-group" align="left">
                        <label>Kuantiti<font color="red">**</font>&nbsp;</label>
                        <input class="form-control" placeholder=" " id="kuantiti_item" name="kuantiti_item" required autocomplete="" type="text" value="<? echo $list['kuantiti_item']; ?>">
                    </div>

                    <div class="form-group" align="left">
                        <label>Harga Item (RM)<font color="red">**</font>&nbsp;</label>
                        <input class="form-control" placeholder=" " id="harga_item" name="harga_item" required autocomplete="" type="text" value="<? echo $list['harga_item']; ?>" onblur="calculate()">
                    </div>

                    <div class="form-group" align="left">
                        <label>Jumlah Harga Item (RM)<font color="red">**</font>&nbsp;</label>
                        <input class="form-control" placeholder=" " id="jumlah_harga_item" name="jumlah_harga_item" required autocomplete="" type="text" value="<? echo $list['jumlah_harga_item']; ?>">
                    </div>



                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                    </div>
                </form>









                <!-- /.panel-body -->

                <!-- /.panel -->


                <!-- /.col-lg-12 -->


            </div></div>
        <? include ('../global/footer.php'); ?></div></div>
<!-- /.row -->
<!-- /.container-fluid -->
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
