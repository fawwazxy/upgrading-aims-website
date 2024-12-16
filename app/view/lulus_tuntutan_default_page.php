

<?php

include ('../controller/auth.php');


require "../model/claim_function.php";

?>
<?php
$value = $_GET['value'];
$table_ref=$_GET['table_ref'];
$no_pemohon=$_GET['no_pemohon'];
$id=$_GET['id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk teruskan?');
        }

    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>


    <!-- <title><? echo $list_sys['sys_name'];?>::<? echo $list_sys['sys_tagline'];?></title>-->




    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>
</head>

<body>

<div id="wrapper">

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



                <h1 class="page-header">Permohonan Tuntutan Pekerja</h1>

                <div class="panel-heading" align="right">
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->

            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


                                    <?


                                    $row_pemohon=  getMaklumatTuntutanPekerjaDefault($value)->fetch_assoc();

                                    ?>

                                    <form method="post" action="../controller/status_tuntut_default_exec.php">
                                        <div class="form-group" align="left">

                                            <input name="default_id" type="hidden" class="input-short" value="<? echo $row_pemohon['value'];?>" />
                                            <input name="table_ref" type="hidden" class="input-short" value="<? echo $row_pemohon['table_ref'];?>" />
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                                            <input name="jenis_tuntutan" type="hidden" class="input-short" value="<? echo $row_pemohon['jenis_tuntutan'];?>" />


                                            <div class="form-group"> <!-- Date input -->

                                                <input class="form-control" type='hidden' value="<?echo date('d/m/Y');?>" name="tarikh_approvement" placeholder="DD/MM/YYY" type="text"/>

                                            </div>


                                            <label>Nama Pekerja</label><br>
                                            <? echo $row_pemohon['nama_pekerja'];?>
                                            <br><br>

                                            <label>Bahagian</label><br>
                                            <? echo $row_pemohon['nama_bahagian'];?>
                                            <br><br>

                                            <label>Tarikh Dipohon</label><br>
                                            <? echo $row_pemohon['created_date'];?>
                                            <br><br>

                                            <label> Tarikh Rujukan Tuntutan</label><br>
                                            <? echo date('d/m/Y',strtotime($row_pemohon['tarikh_pohon']));?>
                                            <br><br>



                                            <label>Jenis Tuntutan Dipohon</label><br>
                                            <? echo $row_pemohon['nama_tuntutan'];?>
                                            <br><br>


                                            <label>Jumlah Tuntutan</label><br>
                                            RM <? echo $row_pemohon['jumlah_tuntut'];?>
                                            <br><br>

                                            <div class="form-group" align="left">
                                                <label>Muat Naik Dokumen/Bukti</label>
                                                <br>
                                                <?

                                                getTuntutanDefaultImg($no_pemohon,$row_pemohon['jenis_tuntutan'],$id);

                                                ?>

                                            </div>


                                            <label>Catatan Pemohon</label><br>
                                            <? echo $row_pemohon['catatan_pemohon'];?>
                                            <br><br>



                                            <label>Tindakan</label><br>

                                            <select required class="form-control" name="approve_status" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $status= statusKelulusanClaim();
                                                while ($pilih  = $status -> fetch_assoc()){ ?>
                                                    <option value="<? echo $pilih['code'];?>"><? echo $pilih['jenis_lulus'];?></option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                            <br><br>

                                            <label>Nama Pelulus</label><br>
                                            <? echo $_SESSION['SESS_NAME'] ?>
                                            <br><br>


                                            <div class="form-group">
                                                <label for="comment">Catatan Pelulus</label>
                                                <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
                                            </div>





                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-primary" onclick="return Confirm()" >Simpan</button>
                                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                            </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

</body>

</html>
  