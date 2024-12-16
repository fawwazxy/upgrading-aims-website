<?php

include ('../controller/auth.php');

require "../model/meeting_functions.php";

session_start()



?>
<?

$bln=$_GET['mnt'];
$thn=$_GET['yr'];

?>

<?
$id=$_GET['id'];
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
                <h1 class="page-header">Jadual Perancangan</h1>
            </div>
        </div>
        <?
        $flagScreen="tab_2";
        include ('../global/admin_menu_meeting.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <!-- /.POP up modal  ------------------------------------------------------------------------------------------------------------------------------------->
                <!-- /.POP up modal  ---------------------------------------------------------------------------------------------------------------------------------------->
            </div>
        </div>
        <div class="row">


            <div class="col-lg-12">
                <!-- /.panel -->

            </div>
            <div>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Butir - Butir Aktiviti</h1>
                    </div>

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" align="right">
                                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                            </div>
                            <div class="panel-body">


                                <table width="100%" class="table table-striped table-bordered table-hover" >
                                    <tbody>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">


                                                <div class="panel-body">

                                                    <form id="formsubmit" method="post" action="../controller/kalendar_aktiviti_add_exec.php?id=<? echo $id;?>">
                                                        <div class="form-group" align="left">
                                                            <input type="hidden" id="catatancode" name="catatancode" value="" />
                                                            <br>


                                                            <div class="form-group" align="left">
                                                                <label>Tajuk<font color="red">**</font>&nbsp;</label>
                                                                <input type="text" class="form-control" placeholder=" " id="title" name="title" required autocomplete="">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="color" class="col-sm-2 control-label">Warna</label>
                                                                <select name="color" class="form-control" id="color">
                                                                    <option value="">Pilih</option>
                                                                    <option style="color:#0071c5;" value="#0071c5">&#9724; Biru Gelap</option>
                                                                    <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                                                    <option style="color:#008000;" value="#008000">&#9724; Hijau</option>
                                                                    <option style="color:#FFD700;" value="#FFD700">&#9724; Kuning</option>
                                                                    <option style="color:#FF8C00;" value="#FF8C00">&#9724; Oren</option>
                                                                    <option style="color:#FF0000;" value="#FF0000">&#9724; Merah</option>
                                                                    <option style="color:#000;" value="#000">&#9724; Hitam</option>

                                                                </select>
                                                            </div>

                                                            <? $tarikh_mula=date('Y-m-d\T08:00:00')?>

                                                            <div class="form-group" align="left">
                                                                <label>Tarikh & Masa Mula <font color="red">**</font>&nbsp;</label>
                                                                <input type="datetime-local" class="form-control" placeholder=" " id="start" name="start" required autocomplete="" value = "<? echo $tarikh_mula;?>">
                                                            </div>
                                                            <? $tarikh_tamat=date('Y-m-d\T16:00:00')?>
                                                            <div class="form-group" align="left">
                                                                <label>Tarikh & Masa Tamat<font color="red">**</font>&nbsp;</label>
                                                                <input type="datetime-local" class="form-control" placeholder=" " id="end" name="end" required autocomplete="" value = "<? echo $tarikh_tamat; ?>">
                                                            </div>

                                                            <div class="form-group" align="left">
                                                                <label>Individu Terlibat<font color="red">**</font>&nbsp;</label>
                                                                <?php
                                                                $result = getStaffInfo();
                                                                ?>
                                                                <?php
                                                                //display dept code
                                                                while($row = mysqli_fetch_assoc($result)){
                                                                    ?>
                                                                    <br>
                                                                    <input type = "checkbox" name = "id_staff[]" value = "<?php echo $row["id"] ?>"><?php echo $row["name"];?>

                                                                    <?php
                                                                }
                                                                ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group" align="left">
                                                                <label>Status <font color="red">**</font>&nbsp;</label>
                                                                <select name = "status" class = "form-control">
                                                                    <option value = "BARU">BARU</option>
                                                                </select>
                                                            </div>


                                                            <div class="form-group" align="left">
                                                                <label>Kategori<font color="red">**</font>&nbsp;</label>
                                                                <select name = "event_type" class = "form-control">
                                                                    <?echo getAktivitiKategori()?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" align="left">
                                                                <label>Disediakan oleh <font color="red">**</font>&nbsp;</label>
                                                                <input type = "text" name = "prepared_by" class = "form-control" value = "<? echo ($_SESSION['SESS_NAME']); ?>" readonly>
                                                            </div>

                                                    </form>
                                                    <div class="form-group" align="left">
                                                        <label>Keterangan<font color="red">**</font>&nbsp;</label>
                                                        <textarea id="summernote" name="description" rows="10"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" onClick="postForm()">Simpan</button>
                                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                    </div>
                                                </div></div>
                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                    </div>
                </div>

                <!-- /.row -->
                <!-- /.container-fluid -->
            </div>

            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });


    $(document).ready(function() {
        $('#summernote').summernote({
            height: "300px",
            styleWithSpan: false
        });
    });
    function postForm() {
        var markupStr = $('#summernote').summernote('code');

        markupStr = markupStr.replace(/\(/g, "^)·(");
        markupStr = markupStr.replace(/\{/g, "=?¿¡12");
        markupStr = markupStr.replace(/\</g, "++ççcsacsa");
        //alert(markupStr);
        $('#catatancode').val(markupStr);

        $("#formsubmit").submit();
    }
</script>
</body>

</html>
