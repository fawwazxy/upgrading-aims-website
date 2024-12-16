<?php
include ('../controller/auth.php');

require "../model/chat_function.php";

?>

<?
$category_id = $_GET['id'];
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



    <style>
        .myDiv{
            display: none;
        }

        .myDiv1{
            display: none;
        }
    </style>


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
    <

    <div id="page-wrapper">
        <div class="row">

            <div class="col-lg-8">
                <div class="panel-heading" align="right">
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                </div>

                <form method="POST" id="formsubmit" action="../controller/forum_add_exec1.php?id=<? echo $id;?> & name=<? echo $_SESSION['SESS_NO_STAFF']?>">
                    <input type="hidden" id="catatancode" name="catatancode" value="" />
                    <div class="form-group" align="left">
                        <label>Kategori </label>

                        <? $forum_category= getCategoryForum($category_id);
                        while ($list  = $forum_category -> fetch_assoc()){ ?>

                            <p><?php echo $list['category_name'] ?></p>

                        <?}?>
                    </div>

                    <div class="form-group" align="left">
                        <label>Tajuk </label>
                        <input class="form-control" placeholder=" " id="topik" name="topik" required autocomplete="" >
                    </div>

                    <div class="form-group" align="left">
                        <label>Jenis Perbincangan</label>
                        <br>
                        <input id="umum" type="radio" name="perbincangan" value="umum"> UMUM<br>
                        <input id="individu" type="radio" name="perbincangan" value="individu"> INDIVIDU<br>
                        <input id="department" type="radio" name="perbincangan" value="department"> DEPARTMENT
                    </div>

                    <div id="showdepartment" class="myDiv1">
                        <div class="form-group" align="left">
                            <label>Department</label>
                            </br>
                            <?
                            $staffN= getDepartment();
                            while ($listN  = $staffN -> fetch_assoc()){ ?>

                                <input type="checkbox" name="department[]" value="<? echo $listN['code_department'];?>"><? echo $listN['code_department'];?>
                                </br>
                            <?}?>
                        </div>
                    </div>


                    <div id="showindividu" class="myDiv">
                        <div class="form-group" align="left">
                            <label>Penerima</label>
                            </br>
                            <?
                            $staffN= getStaff();
                            while ($listN  = $staffN -> fetch_assoc()){ ?>

                                <input type="checkbox" name="penerima[]" value="<? echo $listN['no_staff'];?>"><? echo $listN['name'];?>
                                </br>
                            <?}?>
                        </div>
                    </div>


                </form>
                <div class="form-group" align="left">
                    <label>Topik<font color="red">**</font>&nbsp;</label>
                    <textarea id="summernote" cols="45" rows="5" name="topik"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="submit" form="formsubmit" class="btn btn-success" >Simpan</button>
                    <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                </div>

            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>



    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: "300px",
                styleWithSpan: false

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


    <script>
        $(document).ready(function () {
            $("#individu, #department, #umum").change(function () {
                if ($("#individu").is(":checked")) {
                    $('#showindividu').show();
                    $('#showdepartment').hide();
                }
                else if ($("#department").is(":checked")) {
                    $('#showdepartment').show();
                    $('#showindividu').hide();
                } else {
                    $('#showdepartment').hide();
                    $('#showindividu').hide();
                }

            });
        });
    </script>


</body>
</html>