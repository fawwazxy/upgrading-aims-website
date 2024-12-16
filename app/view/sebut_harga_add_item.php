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


                <!-- <a href="" onclick="return popitup('../template/Sebutharga.php?id=<? echo $id_sebut_harga; ?>')"><button class="btn btn-warning" type="button" >Papar Sebutharga</button></a>  
                     -->
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tambah Item
                </button>
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

            </div>


            <?
            $log = getPelangganEdit($id_sebut_harga) -> fetch_assoc();
            ?>

            <input name="id_sebut_harga" type="hidden" class="input-short" value="<? echo $id_sebut_harga;?>" />
            <p><b> Nama Rujukan </b> : <?php echo $log['nama_rujukan'] ?> </p>
            <p><b> Agensi Rujukan </b> : <?php echo $log['agensi_rujukan'] ?> </p>
            <p><b> Alamat Rujukan </b> : <?php echo $log['alamat_rujukan'] ?> </p>
            <p><b> No Tel Rujukan </b> : <?php echo $log['notel_rujukan'] ?> </p>
            <p><b> Tajuk Rujukan </b> : <?php echo $log['tajuk_sebut_harga'] ?> </p>
            <p><b> Terma Rujukan </b> : <?php echo $log['terma_sebut_harga'] ?> </p>
            <p><b> Tempoh Sah Rujukan </b> : <?php echo $log['tempoh_sah_sebut_harga'] ?> hari </p>
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Item
                    </div>






                    <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                    <!-- Button trigger modal -->


                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Item Sebutharga</h4>
                                </div>

                                <div class="modal-body">





                                    <form method="post" action="../controller/sebut_harga_add_item_exec.php?id_sebut_harga=<? echo $id_sebut_harga; ?>" >


                                        <?

                                        $data = getSebutHargaID($id_sebut_harga);
                                        while($row_data = $data->fetch_assoc()){

                                            ?>
                                            <input name="id_sebut_harga" type="hidden" class="input-short" value="<?php echo $row_data['id_sebut_harga']; ?>" /> <?}?>


                                        <div>

                                            <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Item<font color="red">**</font>&nbsp;</label>
                                            <textarea class="form-control" placeholder=" " id="keterangan_item" name="keterangan_item" required autocomplete="" type="text"></textarea>
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Kuantiti<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " id="kuantiti_item" name="kuantiti_item" required autocomplete="" type="text">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Harga Item (RM)<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " id="harga_item" name="harga_item" required autocomplete="" type="text" onblur="calculate()">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jumlah Harga Item (RM)<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " id="jumlah_harga_item" name="jumlah_harga_item" required autocomplete="" type="text">
                                        </div>



                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>
                                    </form>


                                </div>

                            </div><!--modal-body-->

                        </div>
                        <!-- /.modal-content -->
                        <!-- /.modal-dialog -->
                    </div><!-- /.modal -->





                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Keterangan</th>

                                <th>Kuantiti</th>
                                <th>Harga (RM)</th>
                                <th>Jumlah Harga (RM)</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $sum=0;
                            $data = getItemSebutharga($id_sebut_harga);
                            while($row_data = $data->fetch_assoc()) {




                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_data['keterangan_item']; ?></td>
                                <td><?php echo $row_data['kuantiti_item']; ?><td><?php echo number_format($row_data['harga_item'],2); ?></td>

                                <td><?php echo number_format($row_data['jumlah_harga_item'],2); ?></td>
                                <td>

                                    <a href="../controller/deleteitem_exec.php?id=<? echo $row_data['id']; ?>&id_sebut_harga=<? echo $id_sebut_harga; ?>"><button type="button" class="btn btn-danger">Padam</button>

                                        <a href="sebut_harga_edit_item.php?id=<? echo $row_data['id']; ?>&id_sebut_harga=<? echo $id_sebut_harga; ?>"><button type="button" class="btn btn-info">Kemaskini</button>


                                </td>

                                <? $sum=$sum + $row_data['total'];?>


                                <?php $i++; } ?>
                            </tr>

                            <tr>
                                <td colspan="3"> &nbsp </td>
                                <td align="right"><b> Jumlah (RM)</b></td>
                                <td><b><u><? echo number_format($sum,2); ?></u></b></td>
                                <td>



                                    <a href="../controller/update_total_exec.php?id_sebut_harga=<? echo $id_sebut_harga; ?>&jumlah_sebut_harga=<? echo $sum; ?>"><button type="submit" class="btn btn-primary">Simpan</button></a>
                                </td>

                            </tr>



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
