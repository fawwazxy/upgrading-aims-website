<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";

$id_sesi=$_GET['id_sesi'];
$acara=getSesiAcaraById($id_sesi)->fetch_assoc();
$tarikh_mula = $acara['tarikh_mula'];
$tarikh_tamat = $acara['tarikh_tamat'];
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
    <style type="text/css">
        .aturcara {
            margin-top: 1em;
            margin-bottom: 1em;
            margin-left: 0;
            margin-right: 0;
            padding-left: 40px;
        }
    </style>
    <script type="text/javascript">
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
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Aturcara</h1>
                <h1><? echo $acara['nama'];?></h1>
            </div>
            <div class="form-group" align="right">
                <a href="acara_senarai_acara.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Aturcara
                    </div>
                    <div class="panel-body">
                        <? $i=1;
                        while (strtotime($tarikh_mula) <= strtotime($tarikh_tamat)) {
                            $hari=date("d F Y", strtotime($tarikh_mula)); ?>
                            <a data-toggle="collapse" href="#<? echo $i;?>" role="button" aria-expanded="false" aria-controls="collapseExample"><h4><strong><font color="black"><? echo $hari;?></font></strong></h4></a>
                            <div class="collapse" id="<? echo $i;?>">
                                <table style="width: 100%" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th >Masa Mula</th>
                                        <th >Masa Tamat</th>
                                        <th>Tajuk</th>
                                        <th >Kategori</th>
                                        <th>Status Lagu Tema</th>
                                        <th>Rating</th>
                                        <th>Q & A</th>
                                        <th>Tindakan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <form method="post" action="../controller/acara_aturcara_exec.php">
                                            <input type="hidden" name="action" value="aturcaraAddEdit" />
                                            <input type="hidden" name="id_sesi" value="<?echo $id_sesi?>" />
                                            <input type="hidden" name="tarikh" value="<?echo $tarikh_mula;?>" />
                                            <input type="hidden" name="created_by" value="<?echo $_SESSION['SESS_NAME'];?>" />
                                            <td><input class="form-control" id="masa_mula" name="masa_mula" type="text" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="23:59:00" required /></td>
                                            <td><input class="form-control" id="masa_tamat" name="masa_tamat" type="text" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="23:59:00" required /></td>
                                            <td><input class="form-control" id="tajuk" name="tajuk" type="text" required /></td>
                                            <td>
                                                <input style="width:20px;height:20px;" type="radio" id="kategori" name="kategori" value="0" checked>&nbsp; &nbsp;Bukan Keynote
                                                <br><input style="width:20px;height:20px;" type="radio" id="kategori" name="kategori" value="1">&nbsp; &nbsp;Keynote
                                            </td>
                                            <td>
                                                <input style="width:20px;height:20px;" type="radio" id="lagu_tema_status" name="lagu_tema_status" value="0" checked>&nbsp; &nbsp;Tiada
                                                <br><input style="width:20px;height:20px;" type="radio" id="lagu_tema_status" name="lagu_tema_status" value="1">&nbsp; &nbsp;Ada
                                            </td>
                                            <td>
                                                <input style="width:20px;height:20px;" type="radio" id="rating" name="rating" value="0" checked>&nbsp; &nbsp;Tiada
                                                <br><input style="width:20px;height:20px;" type="radio" id="rating" name="rating" value="1">&nbsp; &nbsp;Ada
                                            </td>
                                            <td>
                                                <input style="width:20px;height:20px;" type="radio" id="qna" name="qna" value="0" checked>&nbsp; &nbsp;Tiada
                                                <br><input style="width:20px;height:20px;" type="radio" id="qna" name="qna" value="1">&nbsp; &nbsp;Ada
                                            </td>
                                            <td><button type="submit" class="btn btn-primary">Simpan</button></td>
                                        </form>
                                    </tr>
                                    <?
                                    $data_aturcara = getAturcara($id_sesi,$tarikh_mula);
                                    while($list_aturcara = $data_aturcara->fetch_assoc()) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><? echo $list_aturcara['masa_mula']; ?></td>
                                            <td><? echo $list_aturcara['masa_tamat']; ?></td>
                                            <td><? echo $list_aturcara['tajuk']; ?></td>
                                            <td><? if($list_aturcara['kategori']==1){?>
                                                    <a href="acara_speaker.php?id_sesi=<?echo $id_sesi?>&id_aturcara=<?echo $list_aturcara['id']?>" class="btn btn-primary btn-small">Masukkan Speaker/Penyampai</a><br><br>
                                                    <?if($list_aturcara['youtube_link'] != ''){?>
                                                        <center><?$youtube = getThumbnail($list_aturcara['youtube_link'])->fetch_assoc();?></center>
                                                    <?}?>
                                                    <form method="post" action="../controller/acara_aturcara_exec.php" enctype="multipart/form-data">
                                                        <input type="hidden" name="action" value="add_youtube_link" />
                                                        <input type="hidden" name="id_sesi" value="<?echo $id_sesi?>" />
                                                        <input type="hidden" name="id_aturcara" value="<?echo $list_aturcara['id'];?>" />
                                                        <div class="form-group">
                                                            <label class="control-label">Masukkan Link Youtube</label>
                                                            <input  class="form-control" type="text" name="youtube_link" value="<?echo $list_aturcara['youtube_link'];?>"required />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                        </div>
                                                    </form>
                                                <?}else{
                                                    echo "Bukan Keynote";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                if($list_aturcara['lagu_tema_filename']!=""){?>
                                                    <audio controls>
                                                        <source src="../../acara/lagu_tema/<? echo $list_aturcara['lagu_tema_filename']; ?>" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                <?}
                                                if($list_aturcara['lagu_tema_status']==1){?>
                                                    <form method="post" action="../controller/acara_aturcara_exec.php" enctype="multipart/form-data">
                                                        <input type="hidden" name="action" value="add_music" />
                                                        <input type="hidden" name="id_sesi" value="<?echo $id_sesi?>" />
                                                        <input type="hidden" name="id_aturcara" value="<?echo $list_aturcara['id'];?>" />
                                                        <div class="form-group">
                                                            <label class="control-label">Masukkan Lagu Tema <font color="red">(file mp3 sahaja)</font></label>
                                                            <input required accept=".mp3" type="file" class="btn btn-link" name="lagu_tema" id="lagu_tema">

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                        </div>
                                                    </form>
                                                <?}else{
                                                    echo "Tiada Lagu Tema";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                if($list_aturcara['rating']==1){
                                                    echo 'Ada';
                                                }else{
                                                    echo 'Tiada';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                if($list_aturcara['qna']==1){
                                                    echo 'Ada';
                                                }else{
                                                    echo 'Tiada';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="#myModal1" class="btn btn-info btn-small" data-toggle="modal" data-id="<? echo $list_aturcara['id'];?>">Kemaskini</a><br><br>
                                            </td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                            <? $tarikh_mula = date ("Y-m-d", strtotime("+1 day", strtotime($tarikh_mula)));
                            $i++;} ?>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Galeri</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'acara_kemaskini_aturcara.php',
                            data:{id_aturcara:rowid,id_sesi:<? echo $id_sesi;?>},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
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
