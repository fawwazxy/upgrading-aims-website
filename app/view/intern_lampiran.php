<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<?
require "../model/pemohon_functions.php";
?>

<?
$pemohon_id=$_GET['pemohon_id'];
$com_id=$_GET['company_id'];
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
<? $sys = getSys(1) -> fetch_assoc(); ?>
<body>

<div class="row" >
    <div class="col-sm-1"></div>
    <div class="col-sm-10" align="center">
        <?
        $flagScreen="tab_6";
        $act="add";
        include ('../global/menu_intern.php');
        ?>

        <!-- /.col-lg-12 -->
    </div>
    <div class="col-sm-1"></div>

    <!-- /.row -->

    <div class="row" align="center">

        <div class="col-lg-12">

            <div class="panel panel-default">

                <div class="panel-body" >
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-7" align="center">

                            <br>

                            <br>

                            <br>
                            <form method="post" action="../controller/lampiran_intern_exec.php" enctype="multipart/form-data" >
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
                        </div>
                    </div>
                    <div class="col-sm-3"></div>
                </div>

            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <? include ('../global/footer.php'); ?>

    <!-- /.row -->
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
    function Age(){
        var ic= document.getElementById("noic").value;
        var year= ic.slice(0,2);
        var age= "19" +year;

        document.getElementById("umur").value=2018-age;
        document.getElementById("umur").focus;

    }
</script>

</body>

</html>