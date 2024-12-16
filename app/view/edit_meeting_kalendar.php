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
        <?
        $flagScreen="tab_3";
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
                                                <?

                                                $list = kemaskiniEvents($id)->fetch_assoc();

                                                ?>

                                                <div class="panel-body">
                                                    <form id="formsubmit" method="post" action="../controller/kalendar_aktiviti_edit_exec.php?id=<? echo $id;?>">
                                                        <h2>Kemaskini Maklumat</h2>
                                                        <div class="form-group" align="left">

                                                            <input name="id" type="hidden" class="input-short" value="<?  echo $_GET['id'];?>" />
                                                            <input type="hidden" id="catatancode" name="catatancode" value="" />

                                                            <div class="form-group" align="left">
                                                                <label>Tajuk Aktiviti <font color="red">**</font>&nbsp;</label>
                                                                <input type="text" class="form-control" placeholder=" " id="title" name="title" value = "<?php echo $list['title']?>">
                                                            </div>



                                                            <?
                                                            $tm = $list['start'];
                                                            $tarikh_mula= date('Y-m-d\TH:i:s', strtotime($tm));
                                                            ?>
                                                            <div class="form-group" align="left">
                                                                <label>Tarikh & Masa Mula <font color="red">**</font>&nbsp;</label>
                                                                <input type="datetime-local" class="form-control" placeholder=" " id="start" name="start" value = "<?php echo $tarikh_mula;?>">
                                                            </div>
                                                            <?
                                                            $tt = $list['end'];
                                                            $tarikh_tamat= date('Y-m-d\TH:i:s', strtotime($tt));
                                                            ?>

                                                            <div class="form-group" align="left">
                                                                <label>Tarikh & Masa Tamat<font color="red">**</font>&nbsp;</label>
                                                                <input type="datetime-local" class="form-control" placeholder=" " id="end" name="end" value = "<?php echo $tarikh_tamat;?>">
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
                                                                    <input type = "checkbox" name = "id_staff[]" value = "<?php echo "\'".$row["no_staff"]."\'" ?>"
                                                                        <?
                                                                        if(strpos($list['id_staff'],$row["no_staff"])){
                                                                            echo "checked";
                                                                        }
                                                                        ?>
                                                                    >&nbsp;<?php echo $row["name"];?>

                                                                    <?php
                                                                }
                                                                ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" align="left">
                                                                <label>Kategori<font color="red">**</font>&nbsp;</label>
                                                                <select name = "jenis_acara" class="form-control" >
                                                                    <option value = "<? echo $list['event_type']; ?>"><? echo $list['event_type']; ?></option>
                                                                    <br>
                                                                    <?echo getAktivitiKategori()?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" align="left">
                                                                <label>Status<font color="red" >**</font>&nbsp;</label>

                                                                <select name = "status" class="form-group">
                                                                    <option value = "<? echo $list['status']; ?>"><? echo $list['status']; ?></option>
                                                                    <br>
                                                                    <option value="BATAL">BATAL</option>
                                                                    <option value="BARU">BARU</option>
                                                                    <option value="DITERUSKAN">DITERUSKAN</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                    </form>
                                                    <div class="form-group" align="left">
                                                        <label>Butir - Butir Aktiviti<font color="red">**</font>&nbsp;</label>
                                                        <textarea type="text"  name="description" id="summernote" cols="45" rows="5"><?php echo $list['description']?></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" onClick="postForm()">Simpan</button>
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
