<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";


?>
<?
$pemohon_id = $_GET['pemohon_id'];
$no_staff = $_GET['no_staff'];
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
                <?
                $flagScreen="tab_6";
                include ('../global/menu_pemohon.php');
                ?>

                <div class="panel-heading" align="right">
                    <a href="pemohon_senarai.php?pemohon_id=<?echo $pemohon_id?>"><button class="btn btn-success">Kembali</button></a>
                    <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pemohon
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Muatnaik Lampiran</h4>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/pemohon_resume_exec.php" enctype="multipart/form-data" >
                                        <div class="form-group" align="left">

                                            <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $pemohon_id;?>" />

                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group" align="left">
                                                <label>Lampirkan Transkrip Peperiksaan<font color="red">**(Fail PDF Sahaja)</font></label>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                                <input class="form-control" type="file" placeholder="" name="document" id="document" required autocomplete="off">
                                                <br>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Lampirkan Resume<font color="red">**(Fail PDF Sahaja)</font></label>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                                <input class="form-control" type="file" placeholder="" name="document_resume" id="document_resume" required autocomplete="off">
                                                <br>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Lampirkan Kurikulum Vitae (CV)<font color="red">**(Fail PDF Sahaja)</font></label>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                                <input class="form-control" type="file" placeholder="" name="document_cv" id="document_cv" required autocomplete="off">
                                                <br>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-success">Hantar</button></a>
                                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                            </div>

                                    </form>
                                </div><!--modal-body-->

                            </div>
                            <!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>



                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $i= 1;
                        $pemohon= getResumeCv($pemohon_id);
                        while($row_pemohon = $pemohon->fetch_assoc()) {
                            ?>

                            <tr class="odd gradeX">

                                <td><?php echo $row_pemohon['nama_pemohon']; ?></td>
                                <td>
                                    <a href="../controller/downloadFile.php?pemohon_id=<?echo $pemohon_id;?>&action=resume"><button class="btn"><i class="fa fa-download"></i>Muat Turun Resume</button></a>
                                    <a href="../controller/downloadFile.php?pemohon_id=<?echo $pemohon_id;?>&action=transkrip"><button class="btn"><i class="fa fa-download"></i>Muat Turun Transkrip</button></a>
                                    <a href="../controller/downloadFile.php?pemohon_id=<?echo $pemohon_id;?>&action=cv"><button class="btn"><i class="fa fa-download"></i>Muat Turun CV</button></a>
                                </td>
                            </tr>

                            <?php $i++; } ?>
                        </tbody>

                    </table><center>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
        <? include ('../global/footer.php'); ?>
    </div>
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
