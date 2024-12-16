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
            <?include '../global/menu_keselamatan.php'?>
             
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pilihan Modul
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group" align="left">
                            <label class="control-label" for="date">Modul</label>
                            <select required class="form-control" id="module" name="module" value="" onchange="reloadMenuList(this)">
                            <option value="">-- Pilih --</option>
                            <?echo getDropDown("sec_modules_age","module_code","module",$module_code);?>
                            </select>
                            </div>


                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" align="right">
                            <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal" id="btn_pelanggan">Tambah Menu Baru</button>
                        </div>
                        <div class="panel-heading">
                            Senarai Menu
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Kod Modul</th>
                                        <th>Modul</th>
                                        <th>Pautan</th>
                                        <th>Susunan</th>
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
                                        <td><?echo ($list['status'] == 1?"Aktif":"Tidak Aktif");?></td>
                                        <td>
                                            <button type="button" class="btn btn-info" onclick="menuEdit('<?echo $list['id'];?>','<?echo $list['module_code'];?>','<?echo $list['menu'];?>','<?echo $list['susunan'];?>','<?echo $list['status'];?>','<?echo $list['link'];?>')">Kemaskini</button>
                                            <input type="hidden" id="row_id" value="<?echo $list['id'];?>">
                                        </td>
                                    </tr>
                                <?}?> 
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>


    <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Maklumat Pelanggan</h4>
                    </div>
                
                <div class="modal-body">
                
                <form method="post" action="../controller/keselamatan_exec.php">
                         <div>
                        <input type="hidden" name="action" value="menuAddEdit" />
                        <input type="hidden" id="id" name="id" value="0" />
                         <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>                       
                           </div>
                           
                                <div class="form-group" align="left">
                                <label>Modul<font color="red">**</font>&nbsp;</label>
                                <select required class="form-control" id="module_code" name="module_code" value="">
                                <option value="">-- Pilih --</option>
                                <?echo getDropDown("sec_modules_age","module_code","module",$module_code);?>
                                </select>
                                </div>
                              <div class="form-group" align="left">
                                  <label>Menu<font color="red">**</font>&nbsp;</label>
                                  <input class="form-control" placeholder=" " name="menu" id="menu" required >
                                </div>
                                
                                <div class="form-group" align="left">
                                  <label>Susunan</label>
                                  <input class="form-control" placeholder=" " name="susunan" id="susunan" 
                                  value="<? echo getMaxSusunan(); ?>">
                                </div>

                                <div class="form-group" align="left">
                                  <label>Pautan</label>
                                  <textarea rows="4" cols="50"class="form-control" placeholder="file.php" id="link" name="link"></textarea>
                                </div>
                                
                               <div class="form-group" align="left">
                              <label>Status</label><br>
                               <input type="radio" value="1" name="status" id="status" checked=""/>
                               <label>Aktif</label>&nbsp; &nbsp; &nbsp;
                              
                        
                              
                               <input type="radio" value="0" name="status" id="status" />
                               <label>Tidak Aktif</label>
                             
                               </div>
                                
                        
                             
                            
                                            
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                        </div>
                        
                    
                         
                </form>
                </div><!--modal-body-->
        
                </div>
        <!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $("#myModal").on("hidden.bs.modal", function(){
            //alert('here');
            //$(this).removeData();
            $('#menu').val("");
            $('#susunan').val("");
            $('#link').val("");
            //$('#status').val("1");
            $('input[name=status][value=1]').prop('checked', 'checked');
            $("#id").val("0");
            $("#module_code").val("");
        });
    });
    function reloadMenuList(obj){
        location.href = "konfigurasi_menu.php?modul="+obj.value;
    }

    function menuEdit(id,module_code,menu,susunan,status,link){
        $('#id').val(id);
        $('#module_code').val(module_code);
        $('#menu').val(menu);
        $('#susunan').val(susunan);
        $('#link').val(link);
        //$('#status').val([2]);
        //alert(status);
        //$('input[name=status][value='+status+']').attr('checked', true);
        $('input[name=status][value='+status+']').prop('checked', 'checked');
        //$("input[name=type]").val(['1']);
        //$('input[name=type][value=2]').attr('checked', 'checked');

        $('#myModal').modal('toggle');
    }
    </script>

</body>

</html>