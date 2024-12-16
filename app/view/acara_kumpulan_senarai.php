<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_1';
$id_sesi = $_GET['id_sesi'];
$datas = getKumpulanList($id_sesi)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                <h1 class="page-header">Senarai Kumpulan</h1>
                <?if($datas['nama']!=''){?>
                    <b><h4><font color="red"><?echo $datas['nama']?></font></h4></b><?}?>
                <?if($datas['lokasi']!=''){?>
                    <b><h4><?echo $datas['lokasi']?></h4></b><?}?>
                <?if($datas['tarikh_mula']!=''){?>
                    <b><h4><?echo date("d F Y",strtotime($datas['tarikh_mula']));?> - <?echo date("d F Y",strtotime($datas['tarikh_tamat']));?></h4></b><?}?>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>">Kumpulan</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="acara_peserta_senarai.php?id_sesi=<?echo $id_sesi?>">Peserta</a></li>
                    </ul>
                </div>
                <br>
                <div class="form-group" align="right">
                    <a href="acara_senarai_acara.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Kumpulan Berdaftar</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 5%">Bil.</th>
                                <th style="width: 50%">Nama Kumpulan</th>
                                <th style="width: 50%">Daftar Online</th>
                                <th style="width: 10%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form method="post" action="../controller/acara_kumpulan_exec.php" enctype="multipart/form-data">
                                    <div>
                                        <input type="hidden" id="id" name="id" value="0" />
                                        <input type="hidden" name="action" value="kumpulanAddEdit" />
                                        <input type="hidden" id="id_sesi" name="id_sesi" value="<?echo $id_sesi?>"/>
                                        <input type="hidden" id="created_by" name="created_by" value="<?echo $_SESSION['SESS_ID']?>">
                                    </div>
                                    <td></td>
                                    <td><input type="text" required class="form-control" size="30%" name="nama_kumpulan" id="nama_kumpulan"></td>
                                    <td><input type="radio" name="daftar_online" value="0"> TIDAK&nbsp;&nbsp;<input type="radio" name="daftar_online" value="1"> YA</td>
                                    <td><button type="submit" class="btn btn-primary">Tambah Baharu</button></td>
                                </form>
                            </tr>
                            <?
                            $i=1;
                            $datas = getKumpulanList($id_sesi);
                            while($list = $datas->fetch_assoc()) {
                                $daftar_online = $list['daftar_online'];
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list['nama_kumpulan'];?></td>
                                    <td>
                                        <? if ($daftar_online==0) {
                                            echo "TIDAK";
                                        } else {
                                            echo "YA";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#myModal2" class="btn btn-warning" data-toggle="modal" data-id="<? echo $list['kumpulan_id'];?>">Muat Naik Excel</a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-<?php echo $list['kumpulan_id'];?>">Kemaskini</button></a>
                                        <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>
                                        <input type="hidden" id="row_id" value="<? echo $list['kumpulan_id'];?>">
                                        <div class="modal" id="modal-<? echo $list['kumpulan_id'];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Kemaskini Info Kumpulan</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="../controller/acara_kumpulan_exec.php" enctype="multipart/form-data">
                                                            <div>
                                                                <input type="hidden" name="action" value="kumpulanAddEdit" />
                                                                <input type="hidden" id="id" name="id" value="<?echo $list['kumpulan_id']?>" />
                                                                <input type="hidden" id="id_sesi" name="id_sesi" value="<?echo $id_sesi?>" />
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="nama_kumpulan">Nama Kumpulan<span style="color: red; "> *</span>&nbsp;</label>
                                                                <input class="form-control" name="nama_kumpulan" id="nama_kumpulan" required value="<? echo $list['nama_kumpulan']?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Daftar Online<span style="color: red; "> **</span>&nbsp;</label>
                                                                <? if ($daftar_online==0) {?>
                                                                    <input type="radio" name="daftar_online" value="0" checked> TIDAK&nbsp;&nbsp;<input type="radio" name="daftar_online" value="1"> YA
                                                                <? } else {?>
                                                                    <input type="radio" name="daftar_online" value="0"> TIDAK&nbsp;&nbsp;<input type="radio" name="daftar_online" value="1" checked> YA
                                                                <? } ?>
                                                            </div>
                                                            <div class="form-group" align="right">
                                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Muatnaik Senarai Ms Excel</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'acara_upload_peserta.php',
                            data:{id_kumpulan:rowid,id_sesi:"<? echo $id_sesi;?>"},
                            success:function(html){
                                $('#demo2').html(html);
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
        // $('#dataTables-example').DataTable({
        //     responsive: true
        // });
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
                data: {action:"deleteKumpulan", row_id:row_id.val() },
                success: function (response) {
                    $(this).parents("tr").remove();
                    $(".add-new").removeAttr("disabled");
                    // you will get response from your php page (what you echo or print)
                    //$.alert(response);
                    $.confirm({
                        title: 'Info',
                        content: response,
                        buttons: {
                            OK: function () {
                                location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
                            }
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
                }
            });
        });
    });
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
</body>
</html>