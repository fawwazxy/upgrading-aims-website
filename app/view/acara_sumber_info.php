<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
require "../model/lookup.php";

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
        <!--<?include '../global/menu_keselamatan.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Info Sumber</h1>
            </div>
            <div class="form-group" align="right">
                <a href="acara_senarai_acara.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Info Sumber
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Kategori</th>
                                <th>Tajuk</th>
                                <th>Kandungan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form method="post" action="../controller/acara_sumber_exec.php" enctype="multipart/form-data">
                                    <div>
                                        <input type="hidden" name="action" value="sumberAddEdit" />
                                        <input type="hidden" id="id" name="id" value="0" />
                                        <input type="hidden" id="id_sesi" name="id_sesi" value="<?echo $id_sesi?>"/>
                                        <input type="hidden" id="created_by" name="created_by" value="<?echo $_SESSION['SESS_ID']?>">
                                    </div>
                                    <td></td>
                                    <td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="30%" name="kategori" id="kategori"></td>
                                    <td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="50%" name="tajuk" id="tajuk"></td>
                                    <td><input required accept=".pdf" type="file" name="kandungan" id="kandungan" class="btn btn-link"></td>
                                    <td><button type="submit" class="btn btn-info">Tambah Baharu</button></td>
                                </form>
                            </tr>
                            <? $i=1;
                            $datas = getSumberAcara($id_sesi);
                            while($list = $datas->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list['kategori'];?></td>
                                    <td><? echo $list['tajuk'];?></td>
                                    <td><a href="../controller/download_exec.php?id=<?echo $list['id']?>"><?echo $list['tajuk']?><i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a></td>
                                    <td>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-<?php echo $list['id'];?>">Kemaskini</button></a>
                                        <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list['id'];?>">
                                        <div class="modal" id="modal-<?php echo $list['id'];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Kemaskini Info Sumber</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="../controller/acara_sumber_exec.php" enctype="multipart/form-data">
                                                            <div>
                                                                <input type="hidden" name="action" value="sumberAddEdit" />
                                                                <input type="hidden" id="id" name="id" value="<?echo $list['id']?>" />
                                                                <input type="hidden" id="id_sesi" name="id_sesi" value="<?echo $id_sesi?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kategori">Kategori<span style="color: red; ">**</span>&nbsp;</label>
                                                                <input class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="30%"
                                                                       name="kategori" id="kategori" required value="<?echo $list['kategori']?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tajuk">Tajuk<span style="color: red; ">**</span>&nbsp;</label>
                                                                <input class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="30%"
                                                                       name="tajuk" id="tajuk" required value="<?echo $list['tajuk']?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kandungan</label>
                                                                <br><a href="../controller/download_exec.php?id=<?echo $list['id']?>"><?echo $list['tajuk']?>.pdf
                                                                    <input accept=".pdf" type="file" name="kandungan" id="kandungan" class="btn btn-link">
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
                data: {action:"sumberRemove", row_id:row_id.val() },
                success: function (response) {
                    $(this).parents("tr").remove();
                    $(".add-new").removeAttr("disabled");
                    $.confirm({
                        title: 'Info',
                        content: response,
                        buttons: {
                            OK: function () {
                                location.href = "acara_sumber_info.php?id_sesi=<?echo $id_sesi?>";
                            }
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    location.href = "acara_sumber_info.php?id_sesi=<?echo $id_sesi?>";
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