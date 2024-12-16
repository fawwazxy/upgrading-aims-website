<?php
include ('../controller/auth.php');
require "../model/functions.php";

$id = $_GET['id'];
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
                <h1 class="page-header">Tambah Kategori Arkib</h1>
            </div>
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-6">
                            <form method="post" action="../controller/category_add_exec.php?id=<? echo $id;?>" enctype="multipart/form-data" >
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="category_name">Nama Kategori</label>
                                        <input class="form-control" id="category_name" name="category_name" maxlength="50" required autocomplete="" >
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" onclick="return alert('Data telah ditambah');">Simpan</button>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</body>
</html>
