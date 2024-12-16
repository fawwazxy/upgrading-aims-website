<?php

include ('../controller/auth.php');

require "../model/functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_1';

$role_code = $_GET['role'];
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
                    <form method="post" action="../controller/keselamatan_exec.php">
                        <input type="hidden" name="action" value="menuAccess" />
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pilih Peranan
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group" align="left">
                            <label>Peranan<font color="red">**</font>&nbsp;</label>
                            <select required class="form-control" id="role_code" name="role_code" value=""
                            onchange="reloadRoleMenu(this)">
                            <option value="">-- Pilih --</option>
                            <?echo getDropDown("role","code","role",$role_code);?>
                            </select>
                            </div>


                            
                        </div>
                    </div>
                        <div class="panel panel-default">
                        
                        <div class="panel-heading">
                            Senarai Menu
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">Bil.</th>
                                        <th width="15%">Kod Modul</th>
                                        <th width="30%">Modul</th>
                                        <th width="10%">Menu Access<br><input type="checkbox" id="select_allM" style="transform: scale(1);"/> <i>Pilih Semua</i></th>
                                        <th width="10%">View Access<br><input type="checkbox" id="select_allV" style="transform: scale(1);"/> <i>Pilih Semua</i></th>
                                        <th width="10%">Edit Access<br><input type="checkbox" id="select_allE" style="transform: scale(1);"/> <i>Pilih Semua</i></th>
                                        <th width="10%">Add Access<br><input type="checkbox" id="select_allA" style="transform: scale(1);"/> <i>Pilih Semua</i></th>
                                        <th width="10%">Delete Access<br><input type="checkbox" id="select_allD" style="transform: scale(1);"/> <i>Pilih Semua</i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $datas = getModuleMenuAktif($role_code);
                                    $i=1;
                                    while($list = $datas->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $list['module_code'];?></td>
                                        <td><?echo $list['menu'];?></td>
                                        <td width="10%"><input type="checkbox" name="menu_ids[]" 
                                            class="form-control checkboxM" value="<?echo $list['id'];?>"
                                            <?echo $role_code!="" && $list['role_code']==$role_code?"checked":""; ?> />
                                        </td>
                                        <td width="10%"><input type="checkbox" name="view_ids[]" 
                                            class="form-control checkboxV" value="<?echo $list['id'];?>"
                                            <?echo $list['views']==1?"checked":""; ?> />
                                        </td><td width="10%"><input type="checkbox" name="edit_ids[]" 
                                            class="form-control checkboxE" value="<?echo $list['id'];?>"
                                            <?echo $list['edits']==1?"checked":""; ?> />
                                        </td><td width="10%"><input type="checkbox" name="add_ids[]" 
                                            class="form-control checkboxA" value="<?echo $list['id'];?>"
                                            <?echo $list['adds']==1?"checked":""; ?> />
                                        </td><td width="10%"><input type="checkbox" name="delete_ids[]" 
                                            class="form-control checkboxD" value="<?echo $list['id'];?>"
                                            <?echo $list['deletes']==1?"checked":""; ?> />
                                        </td>
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

                        <!-- /.panel-body -->
                    </div>
                    </form>
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        //checkboxes menu
        $("#select_allM").change(function(){  //"select all" change 
            $(".checkboxM").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkboxM').change(function(){ 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_allM").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkboxM:checked').length == $('.checkboxM').length ){
                $("#select_allM").prop('checked', true);
            }
        });
        //checkboxes menu end
        
        //checkboxes view
        $("#select_allV").change(function(){  //"select all" change 
            $(".checkboxV").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkboxV').change(function(){ 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_allV").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkboxV:checked').length == $('.checkboxM').length ){
                $("#select_allV").prop('checked', true);
            }
        });
        //checkboxes view end
        
        //checkboxes edit
        $("#select_allE").change(function(){  //"select all" change 
            $(".checkboxE").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkboxE').change(function(){ 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_allE").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkboxE:checked').length == $('.checkboxM').length ){
                $("#select_allE").prop('checked', true);
            }
        });
        //checkboxes edit end
        
        //checkboxes add
        $("#select_allA").change(function(){  //"select all" change 
            $(".checkboxA").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkboxA').change(function(){ 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_allA").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkboxA:checked').length == $('.checkboxM').length ){
                $("#select_allA").prop('checked', true);
            }
        });
        //checkboxes add end
        
        //checkboxes delete
        $("#select_allD").change(function(){  //"select all" change 
            $(".checkboxD").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkboxD').change(function(){ 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_allD").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkboxD:checked').length == $('.checkboxM').length ){
                $("#select_allD").prop('checked', true);
            }
        });
        //checkboxes delete end
    });

    function reloadRoleMenu(obj){
        location.href = "konfigurasi_role_menu.php?role="+obj.value;
    }
    </script>

</body>

</html>