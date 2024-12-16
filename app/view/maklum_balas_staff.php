<?php

include ('../controller/auth.php');

require "../model/support_function.php";

//$data_staff = getStaffByNokp($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
$id = $_GET['id'];
$data = getSupportMaklumBalas($id)->fetch_assoc();
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row" align="center">
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-body" >
                    <div class="row" >
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-7">
                            <div class="panel-heading" align="right">
                                <button class="btn btn-success" id="btn_pelanggan" onclick="window.location.href='list_aduan.php'">Kembali</button>
                            </div>
                            <h3><b>MAKLUM BALAS ADUAN</b></h3><br>
                            <div class="form-group" align="left">
                                <b>No Rujukan Tiket</b>:&nbsp;<?php echo $data['norujukan_support'] ?><br>
                                <b>Tarikh Aduan Dihantar</b>:&nbsp;<?php echo $data['created_date'] ?><br>
                                <b>Nama Penghantar</b>:&nbsp;<?php echo $data['nama_client'] ?><br>
                                <b>No. Tel Penghantar</b>:&nbsp;<?php echo $data['notel'] ?><br>
                                <b>Nama Projek</b>:&nbsp;<?php echo $data['nama_projek'] ?><br>
                                <b>Agensi Rujukan</b>:&nbsp;<?php echo $data['agensi_rujukan'] ?><br>
                                <b>Aduan</b>:&nbsp;<?php echo $data['aduan'] ?><br>
                            </div>

                            <form method="post" enctype="multipart/form-data" action="../controller/add_maklumbalas_exec.php?id=<? echo $id;?>">

                                <input type="hidden" class="form-control" placeholder=" " id="id" name="id" value="<? echo $id; ?>"/>

                                <br>

                                <div class="form-group" align="left">
                                    <label>Komen/Catatan</label>
                                    <textarea id="summernote" cols="45" rows="5" name="client_feedback"  required autocomplete=""></textarea>
                                </div>


                                <div class="modal-footer">

                                    <button type="submit"  class="btn btn-primary" onclick="return Confirm()">Simpan</button>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                </div>

                            </form>

                        </div>

                        <div class="col-sm-2">&nbsp;</div>
                        <!-- /.panel -->
                    </div>

                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>

<script>

    $(document).ready(function() {
        $('#summernote').summernote({
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
    function reset() {
        $("#formsubmit").trigger("reset");
        $('#summernote').summernote('reset');
    }

</script>
</body>

</html>