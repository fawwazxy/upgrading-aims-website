<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
//$no_staff = $_GET['no_staff'];
//$no_staff_login = $_SESSION['SESS_NO_STAFF'];
$id = $_GET['id'];
$data_aduan=  getSupportDetails($id)->fetch_assoc();


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

    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>
    <script>

        function star(){
            var level=document.getElementById("level_aduan").value;
            var i=0;
            for(i=0;i<=level;i++){
                document.write(*);

            }

        }


    </script>

    <style>
        .accordion1 {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active1, .accordion1:hover {
            background-color: #ccc;
        }

        .panel1 {
            padding: 0 18px;
            display: none;
            background-color: white;
            overflow: hidden;
        }

        .col-sm-8{
            margin-left: 200px;
            margin-right: 200px;
        }.option {
             background: #eee;
             display: block;
             padding: 5px 10px 5px;
             color: #000;
             -moz-border-radius: 6px;
             -webkit-border-radius: 6px;
             -khtml-border-radius: 6px;
             border-radius: 6px;
             cursor: pointer;
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
                <h1 class="page-header">Pembahagian Sokongan</h1>
            </div>
            <div class="panel-heading" align="right">
                <a href="list_support_belum_disahkan.php" ><button type="button" class="btn btn-success">Kembali</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form id="formsubmit" method="post" action="../controller/support_exec.php?action=aduan_assign" >
                                    <input name="created_by" type="hidden" class="input-short" value="<? echo $data_aduan['created_by']?>" />
                                    <input type="hidden" class="form-control" placeholder=" " id="shortcode" name="shortcode" value="<? echo $shortcode; ?>"/>
                                    <input type="hidden"  id="support_parent" name="support_parent" value="<? echo $data_aduan['norujukan_support']; ?>"/>
                                    <input type="hidden"  id="staff_created" name="staff_created" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>"/>
                                    <input type="hidden"  id="nama_projek" name="nama_projek" value="<? echo $data_aduan['kod_projek']; ?>"/>
                                    <input type="hidden"  id="nama_client" name="nama_client" value="<? echo $data_aduan['nama_client']; ?>"/>
                                    <input type="hidden"  id="notel" name="notel" value="<? echo $data_aduan['notel']; ?>"/>

                                    <input type="hidden" id="catatancode" name="catatancode" value="" />
                                    <input type="hidden" id="aduancode" name="aduancode" value="" />

                                    <label><font color="red">**Maklumat Wajib Diisi.</font></label><br>
                                    <div class="form-group" align="left">
                                        <p><b>Projek/Sistem/Produk</b></p> <? echo $data_aduan['kod_projek'].' - '.$data_aduan['nama_projek'];?><br><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <p><b>Nama Penghantar</b></p> <? echo $data_aduan['nama_client'];?><br><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <p><b>No Telefon</b></p> <? echo $data_aduan['notel'];?><br><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <p><b>Aduan Asal</b></p> <? echo $data_aduan['aduan'];?><br><br>
                                    </div>

                                    <label>Tindakan Oleh<font color="red">**</font>&nbsp;</label><br>
                                    <select required class="form-control"  name="developer" id="developer" value="<? echo $row['developer']; ?>">
                                        <option value="">-- Pilih --</option>
                                        <? $person= getNamaDeveloper();
                                        while ($pilih  = $person -> fetch_assoc()){ ?>
                                            <option value="<? echo $pilih['no_staff'];?>" <? echo ($pilih['no_staff']==$row['developer']?'selected':'');?>><? echo $pilih['name']?></option>
                                        <?}?>
                                    </select><br>

                                    <div class="form-group">
                                        <label>Tahap Keutamaan<font color="red">**</font>&nbsp;</label><br>
                                        <?
                                        for ($i = 1; $i <= 5; $i++) {
                                            $ratingClass = "btn-default btn-grey";
                                            if($i <= $data_aduan['level_aduan']) {
                                                $ratingClass = "btn-warning";
                                            }
                                            ?>
                                            <button type="button" class="btn btn-sm <?php echo $ratingClass; ?> rateButton" aria-label="Left Align"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></button>

                                        <?}?>
                                        <input type="hidden" class="form-control" id="level_aduan" name="level_aduan" value="<?echo $data_aduan['level_aduan']?>">

                                    </div>

                                </form>
                                <br>
                                <div class="form-group" align="left">
                                    <label>Pembahagian Aduan<font color="red">**</font>&nbsp;</label>
                                    <textarea id="summernote" cols="45" rows="5" name="remarks"></textarea>
                                </div>
                                <div class="form-group" align="left">
                                    <label>Komen/Catatan&nbsp;</label>
                                    <textarea id="summernote2" cols="45" rows="5" name="comments"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" form="formsubmit" class="btn btn-success" >Simpan</button>
                                    <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                                    <!--
    							    	<a href="../controller/tutup_aduan_exec.php?no_staff=<? echo $row['no_staff'];?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>&id=<? echo $row['id'];?>nama_projek=<?php echo $row['nama_projek']; ?>"> <button class="btn btn-danger">Tutup Aduan</button></a>
    							    -->

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $( ".rateButton" ).click(function() {
            if($(this).toggleClass('btn-grey')) {
                $(this).removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).prevAll('.rateButton').removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            } else {
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            }
            $("#level_aduan").val($('.star-selected').length);
        });
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $('#summernote').summernote({
            height: "200px",
            styleWithSpan: false
        });
        $('#summernote2').summernote({
            height: "300px",
            styleWithSpan: false
        });

    });
    $("#summernote").on("summernote.change", function (e) {   // callback as jquery custom event 
        var markupStr = $('#summernote').summernote('code');

        markupStr = markupStr.replace(/\(/g, "^)·(");
        markupStr = markupStr.replace(/\{/g, "=?¿¡12");
        markupStr = markupStr.replace(/\</g, "++ççcsacsa");
        //alert(markupStr);
        $('#catatancode').val(markupStr);
    });
    $("#summernote2").on("summernote.change", function (e) {   // callback as jquery custom event 
        var markupStr = $('#summernote2').summernote('code');

        markupStr = markupStr.replace(/\(/g, "^)·(");
        markupStr = markupStr.replace(/\{/g, "=?¿¡12");
        markupStr = markupStr.replace(/\</g, "++ççcsacsa");
        //alert(markupStr);
        $('#aduancode').val(markupStr);
    });
    function reset() {
        $("#formsubmit").trigger("reset");
        $('#summernote').summernote('reset');
    }
</script>

</body>

</html>
