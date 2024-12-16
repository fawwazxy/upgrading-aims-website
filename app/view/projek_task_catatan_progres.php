<?php

include ('../controller/auth.php');

require "../model/projek_internal_task_functions.php";
require "../model/lookup.php";


$id_task = $_GET['id'];
$jenis_catatan= $_GET['jenis_catatan'];
$isShowCatatan=true;
$isShowCatatanInprogress=true;
$task = getDetailsTaskById($id_task)->fetch_assoc();
$tab = $_GET['page'];
if(isset($tab)){
    $page="senarai_tugasan_staf.php?nokp=".$task['assigned_to'];

}else{
    $page="projek_internal_senarai_task.php";
}
if($jenis_catatan=="inprogress"){
    $catatan=$task['catatan_inprogress'];
    $label="Catatan Dalam Pelaksanaan";
    $isShowCatatanInprogress=false;

}else{
    $catatan=$task['catatan_done'];
    $label="Catatan Sudah Selesai";
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
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>
    <!--<style>
    .note-group-select-from-files {
  display: none;
}
</style>-->


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
                <h3 class="page-header">Tugasan : <? echo $task['tajuk']; ?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="<? echo $page;?>"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>
                <?if($isShowCatatan){?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group" align="left">
                                <label class="control-label">Catatan Untuk Pelaksanaan</label>
                            </div>
                            <?
                            if($task['catatan']!=''){
                                echo $task['catatan'];
                            }else{
                                echo "Tiada Catatan";
                            }

                            ?>

                        </div>
                    </div>
                <?}?>
                <?if($isShowCatatanInprogress){?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group" align="left">
                                <label class="control-label">Catatan Dalam Pelaksanaan</label>
                            </div>
                            <?
                            if($task['catatan_inprogress']!=''){
                                echo $task['catatan_inprogress'];
                            }else{
                                echo "Tiada Catatan";
                            }
                            ?>

                        </div>
                    </div>
                <?}?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="formsubmit" method="post" action="../controller/projek_task_exec.php">
                            <div>
                                <input type="hidden" name="action" value="catatan_progress" />
                                <input type="hidden" name="id" value="<? echo $id_task;?>" />
                                <input type="hidden" name="jenis_catatan" value="<? echo $jenis_catatan;?>" />
                                <input type="hidden" id="catatancode" name="catatancode" value="" />
                            </div>




                        </form>
                        <div class="form-group" align="left">
                            <label class="control-label"><? echo $label;?></label>
                            <!--<textarea class="form-control" rows="5" name="catatan" id="catatan"><? echo $task['catatan'];?></textarea>-->
                            <textarea id="summernote" name="catatan" rows="10"><? echo $catatan;?></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onClick="postForm()">Simpan</button>
                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                        </div>



                    </div>
                </div>



            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: "300px",
            styleWithSpan: false

        });
    });
    function postForm() {
        var markupStr = $('#summernote').summernote('code');

        markupStr = markupStr.replace(/\(/g, "^)·(");
        markupStr = markupStr.replace(/\{/g, "=?¿¡12");
        markupStr = markupStr.replace(/\</g, "++ççcsacsa");
        //alert(markupStr);
        $('#catatancode').val(markupStr);

        $("#formsubmit").submit();
    }
</script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
</body>

</html>