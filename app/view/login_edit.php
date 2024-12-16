<?php
include ('../controller/auth.php');
require "../model/staff_function.php";
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
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Kemaskini Kata Laluan</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Kemaskini Kata Laluan
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10">
                            <? $staff = getPekerja($_SESSION['SESS_NO_STAFF'])->fetch_assoc(); ?>
                            <form method="post" action="../controller/staff_exec.php"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="action" value="login_edit" />
                                <input type="hidden" name="id" value="<? echo $staff['id']; ?>">
                                <div class="form-group">
                                    <label><span style="color: red; ">* Maklumat Wajib Diisi.</span></label>
                                    <br>
                                    <div class="form-group">
                                        <label for="username">Nama Log Masuk <span style="color: red; ">*</span>&nbsp;</label><br>
                                        <input class="form-control" readonly placeholder="" id="username" name="username" value="<? echo $staff['username']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="old_password">Kata Laluan Asal <span style="color: red; ">*</span>&nbsp;</label><br>
                                        <input type="password" required="" class="form-control" id="old_password" name="old_password">
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password">Kata Laluan Baharu <span style="color: red; ">*</span>&nbsp;</label><br>
                                        <input type="password" required="" class="form-control" id="new_password" name="new_password">
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">Taip Semula Kata Laluan Baharu <span style="color: red; ">*</span>&nbsp;</label><br>
                                        <input type="password" required="" class="form-control" id="confirm_password" name="confirm_password">
                                    </div>
                                    <div class="modal-footer">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div><br>
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