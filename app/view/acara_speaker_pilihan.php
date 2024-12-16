<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
//require "../model/lookup.php";

$id_aturcara = $_GET['id_aturcara'];
$id_sesi = $_GET['id_sesi'];
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Penceramah Pilihan</h1>
            </div>
            <div class="form-group" align="right">
                <a href="acara_speaker.php?id_aturcara=<?echo $id_aturcara?>&id_sesi=<?echo $id_sesi?>" ><button type="button" class="btn btn-primary">Kembali</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/acara_speaker_exec.php">
                    <input type="hidden" name="action" value="addSpeaker" />
                    <input type="hidden" name="id_sesi" value="<? echo $id_sesi;?>" />
                    <input type="hidden" name="id_aturcara" value="<?echo $id_aturcara;?>" />
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Senarai Peserta
                        </div>
                        <div class="panel-body">
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" >
                                <thead>
                                <tr>
                                    <th style="width: 10%">Bil.</th>
                                    <th style="width: 80%">Nama Peserta</th>
                                    <th style="width: 10%">Pilihan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? $i=1;
                                $data_peserta = getPesertaAcara($id_sesi,$id_aturcara);
                                while($list_peserta = $data_peserta->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><? echo $i++;?></td>
                                        <td><label>Nama : </label><?echo $list_peserta['nama'];?>
                                            <br><label>No.Kad Pengenalan : </label><?echo $list_peserta['nokp']?>
                                        </td>
                                        <td><input type="checkbox" name="speaker_ids[]" class="form-control checkbox" value="<?echo $list_peserta['nokp'];?>"/></td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>