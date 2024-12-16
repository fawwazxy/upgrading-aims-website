<?php

include ('../controller/auth.php');

require "../model/projek_internal_task_functions.php";
require "../model/lookup.php";


$id_task = $_GET['id'];

$task = getTaskById($id_task)->fetch_assoc();
$tab = $_GET['page'];
if(isset($tab)){
    $page="admin_projek_senarai.php";
}else{
    $page="projek_internal_senarai_task.php";
}

//date_default_timezone_set("Asia/Kuala_Lumpur");
//$current_year = date(Y);
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
    <link href="../../js/jquery/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="../../js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../js/jquery/jquery-ui.min.js"></script>
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>

    <!-- <style>
        .note-group-select-from-files {
      display: none;
    }
    </style> -->
</head>

<body>

<div id="wrapper">
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Tugasan</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="<? echo $page;?>"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Tambah Maklumat Tugasan</label>
                    </div>

                    <div class="panel-body">
                        <form id="formsubmit" method="post" action="../controller/projek_task_exec.php">
                            <div>
                                <input type="hidden" name="action" value="AddEditProjek" />
                                <input type="hidden" name="assigned_by" value="<? echo $_SESSION['SESS_NOKP'];?>" />
                                <input type="hidden" name="id" value="<? echo $id_task;?>" />
                                <input type="hidden" id="catatancode" name="catatancode" value="" />
                            </div>

                            <label><font color="red">** Maklumat Wajib Diisi **</font></label>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">Projek Utama<font color="red">&nbsp;**</font></label>
                                    <select  required class="form-control" name="kod_projek" id="kod_projek" onchange="reloadProjek(this.value)">
                                        <option value="">-- Pilih Projek --</option>
                                        <? echo getDropDownKodProjek("projek_internal","kod_projek","nama_projek",$task['kod_projek'],"");?>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">Sub Projek</label>
                                    <select class="form-control" name="sub_projek" id="sub_projek">
                                        <option value="">-- Pilih Sub Projek --</option>
                                        <? echo getDropDownKodProjek("projek_internal","kod_projek","nama_projek",$task['kod_subprojek'],$task['kod_projek']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">Tajuk<font color="red">&nbsp;**</font></label>
                                    <input type="text" class="form-control" name="tajuk" id="tajuk" value="<? echo $task['tajuk'];?>" required>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">Ditugaskan Kepada<font color="red">&nbsp;**</font></label>
                                    <input type="text" class="form-control" name="autocomplete" id="autocomplete" value="<? echo $task['name'];?>" onfocus="javascript:$(this).autocomplete('search','');" required>
                                    <input type="hidden" name="assigned_to" id="assigned_to" value="<? echo $task['assigned_to'] ;?>" />
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">Kumpulan Projek<font color="red">&nbsp;**</font></label>
                                    <select  required class="form-control" name="task_based" id="task_based">
                                        <option value="">-- Pilih Kumpulan --</option>
                                        <? echo getDropDown("lkp_projek_kumpulan","id_kumpulan","nama_kumpulan",$task['task_based']);?>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">Selang Masa</label>
                                    <input type="number" step="0" class="form-control" name="slack" id="slack" min="0" value="<? echo $task['slack'];?>">
                                </div>
                            </div>

                            <?
                            $tm = $task['tarikh_mula'];
                            if(isset($tm)){
                                $tarikh_mula= date('Y-m-d\TH:i:s', strtotime($tm));
                            }else{
                                $tarikh_mula= date('Y-m-d\TH:i:00');
                            }

                            ?>

                            <?
                            $tt = $task['tarikh_tamat'];
                            if(isset($tt)){
                                $tarikh_tamat= date('Y-m-d\TH:i:s', strtotime($tt));
                            }else{
                                $tarikh_tamat= date('Y-m-d\TH:i:00');
                            }
                            ?>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">Tarikh Mula<font color="red">&nbsp;**</font></label>
                                    <input type="datetime-local" class="form-control" name="tarikh_mula" id="tarikh_mula" value="<? echo $tarikh_mula;?>" required>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">Tarikh Tamat<font color="red">&nbsp;**</font></label>
                                    <input type="datetime-local" class="form-control" name="tarikh_tamat" id="tarikh_tamat" value="<? echo $tarikh_tamat;?>" required>
                                </div>
                            </div>

                        </form>

                        <div class="form-group" align="left">
                            <label class="control-label">Catatan<font color="red">&nbsp;**</font></label>
                            <!--<textarea class="form-control" rows="5" name="catatan" id="catatan"><? echo $task['catatan'];?></textarea>-->
                            <textarea id="summernote" name="catatan" rows="10"><? echo $task['catatan'];?></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" form="formsubmit" class="btn btn-success" >Simpan</button>
                            <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: "300px",
            styleWithSpan: false

        });
    });
    function reloadProjek(val) {
        $.ajax({
            type: "POST",
            url: "../model/projek_internal_task_functions.php",
            data:{action:"subProjek",kod_projek:val},
            success: function(data){
                $("#sub_projek").html(data);
                //console.log(val);//reloadJajahan();
            }
        });
    }
    $( function() {
        $( "#autocomplete" ).autocomplete({
            source: function( request, response ) {
                // Fetch data

                $.ajax({
                    url: "../model/projek_internal_task_functions.php",
                    type: 'post',
                    dataType: "json",
                    data: {action:"searchStaff",search: request.term},
                    success: function(data) {
                        response(data );
                        //console.log(data);
                    }
                });
            },
            minLength: 0,
            open: function() {

            },
            select: function (event, ui) {
                // Set selection
                $('#autocomplete').val(ui.item.label); // display the selected text
                $('#assigned_to').val(ui.item.value); // save selected id to input
                return false;
            }
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