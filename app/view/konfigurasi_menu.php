<?php
include ('../controller/auth.php');
require "../model/functions.php";
require "../model/lookup.php";
$flagScreen = 'tab_2';
$module_code = $_GET['modul'];
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
        .status{
            padding:3px;
            border-radius: 5px;
            font-weight:bold;
            color: #ffffff;
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
    <div id="page-wrapper">
        <?include '../global/menu_keselamatan.php'?>
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <label class="control-label" for="module">Modul</label>
                    <select required class="form-control" id="module" name="module" value="" onchange="reloadMenuList(this)">
                        <option value="">-- Semua --</option>
                        <? echo menuDropdown("sec_module","module_code","module",$module_code);?>
                    </select>
                </div>
            </div>
            <div class="col-lg-7" style="text-align: right">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal" id="btn_pelanggan" style="margin-top: 25px">Tambah Menu</button>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>SENARAI MENU</b></div>
                    <div class="panel-body" style="overflow: auto">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Kod</th>
                                <th>Modul</th>
                                <th>Pautan</th>
                                <th>Susunan</th>
                                <th>New Tab</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $datas = getModuleMenu($module_code);
                            $i=1;
                            while($list = $datas->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><?echo $list['module_code'];?></td>
                                    <td><?echo $list['menu'];?></td>
                                    <td><?echo $list['link'];?></td>
                                    <td><?echo $list['susunan'];?></td>
                                    <td class="text-center"><? echo ($list['new_tab'] == 1? "<i class='fa fa-check-circle-o' style='color: #1d841d; font-size: 24pt'></i>" :"<i class='fa fa-times-circle-o' style='color: red; font-size: 24pt'></i>");?></td>
                                    <td class="text-center"><?echo ($list['status'] == 1?"<p class='status' style='background-color: green'>Aktif</p>":"<p class='status' style='background-color: red'>Tidak Aktif</p>");?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="menuEdit('<?echo $list['id'];?>','<?echo $list['module_code'];?>','<?echo $list['menu'];?>','<?echo $list['susunan'];?>','<?echo $list['status'];?>','<?echo $list['link'];?>','<?echo $list['new_tab'];?>')">Kemaskini</button>
                                        <input type="hidden" id="row_id" value="<?echo $list['id'];?>">
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Pelanggan</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/keselamatan_exec.php">
                    <div>
                        <input type="hidden" name="action" value="menuAddEdit" />
                        <input type="hidden" id="id" name="id" value="0" />
                        <label><span style="color: red; ">* Maklumat Wajib Diisi.</span></label>
                    </div>
                    <div class="form-group">
                        <label for="module_code">Modul<span style="color: red; ">*</span>&nbsp;</label>
                        <select required class="form-control" id="module_code" name="module_code" value="">
                            <option value="">-- Pilih --</option>
                            <?echo getDropDown("sec_module","module_code","module",$module_code);?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="menu">Menu<span style="color: red; ">*</span>&nbsp;</label>
                        <input class="form-control" name="menu" id="menu" required>
                    </div>
                    <div class="form-group">
                        <label for="susunan">Susunan</label>
                        <input class="form-control" name="susunan" id="susunan" value="<? echo getMaxSusunan(); ?>">
                    </div>
                    <div class="form-group">
                        <label for="link">Pautan</label>
                        <textarea rows="4" cols="50" class="form-control" placeholder="file.php" id="link" name="link"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Akses New Tab</label><br>
                        <input type="radio" value="1" name="new_tab" id="new_tab"/>
                        <label>Ya</label>&nbsp; &nbsp; &nbsp;

                        <input type="radio" value="0" name="new_tab" id="new_tab" checked/>
                        <label>Tidak</label>
                    </div>
                    <div class="form-group">
                        <label>Status</label><br>
                        <input type="radio" value="1" name="status" id="status" checked/>
                        <label>Aktif</label>&nbsp; &nbsp; &nbsp;

                        <input type="radio" value="0" name="status" id="status" />
                        <label>Tidak Aktif</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
        });
    });
    $(document).ready(function() {
        $("#myModal").on("hidden.bs.modal", function(){
            $('#menu').val("");
            $('#susunan').val("");
            $('#link').val("");
            $('input[name=status][value=1]').prop('checked', 'checked');
            $('input[name=new_tab][value=1]').prop('checked', 'checked');
            $("#id").val("0");
            $("#module_code").val("");
        });
    });
    function reloadMenuList(obj){
        location.href = "konfigurasi_menu.php?modul="+obj.value;
    }

    function menuEdit(id,module_code,menu,susunan,status,link,new_tab){
        $('#id').val(id);
        $('#module_code').val(module_code);
        $('#menu').val(menu);
        $('#susunan').val(susunan);
        $('#link').val(link);
        $('input[name=status][value='+status+']').prop('checked', 'checked');
        $('input[name=new_tab][value='+new_tab+']').prop('checked', 'checked');
        $('#myModal').modal('toggle');
    }
</script>
</body>
</html>