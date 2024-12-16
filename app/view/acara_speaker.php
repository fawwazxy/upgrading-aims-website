<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
require "../model/lookup.php";

$id_sesi = $_GET['id_sesi'];
$id_aturcara = $_GET['id_aturcara'];
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <!--<?include '../global/menu_keselamatan.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Penceramah</h1>
            </div>
            <div class="form-group" align="right">
                <button class="btn btn-info" id="btn_pelanggan" onclick="window.location.href='acara_speaker_pilihan.php?id_aturcara=<?echo $id_aturcara?>&id_sesi=<?echo $id_sesi?>'">Tambah Penceramah</button>
                <a href="acara_senarai_aturcara.php?id_sesi=<?echo $id_sesi?>" ><button type="button" class="btn btn-primary">Kembali</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Info Penceramah
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 10%;">Bil.</th>
                                <th style="width: 80%;">Maklumat Penceramah</th>
                                <th style="width: 10%;">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $data_speaker = getSpeakerAcara($id_aturcara);
                            while($list_speaker = $data_speaker->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><label>Nama : </label><?echo $list_speaker['speaker_name'];?>
                                        <br><label>No. Kad Pengenalan : </label><?echo $list_speaker['nokp_peserta']?>
                                        <br><label>No. Telefon : </label><?echo $list_speaker['speaker_tel']?>
                                        <br><label>Jawatan : </label><?echo $list_speaker['speaker_jawatan']?>
                                    </td>
                                    <td>
                                        <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_speaker['id'];?>">
                                    </td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    // Delete row on delete button click
    $(document).on("click", ".delete", function(){
        var row_id = $(this).parents("tr").find('input[type="hidden"]');
        var curr_id="";
        row_id.each(function(){
            curr_id = $(this).val();
        });
        $.ajax({
            url: "../model/acara_functions.php",
            type: "POST",
            data: {action:"speakerRemove", row_id:row_id.val() },
            success: function (response) {
                $(this).parents("tr").remove();
                $(".add-new").removeAttr("disabled");
                //$.alert(response);
                $.confirm({
                    title: 'Info',
                    content: response,
                    buttons: {
                        OK: function () {
                            location.href = "acara_speaker.php?id_sesi=<?echo $id_sesi?>&id_aturcara=<?echo $id_aturcara?>";
                        }
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                location.href = "acara_speaker.php?id_sesi=<?echo $id_sesi?>&id_aturcara=<?echo $id_aturcara?>";
            }
        });
    });
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>