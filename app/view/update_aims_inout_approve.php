<?php

include ('../controller/auth.php');

require "../model/aims_inout_function.php";

$id = $_GET['id'];
$aims_inout_approve_info = getaims_inout_approvebyId($id)->fetch_assoc();
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">UPDATE IN/OUT PERMISSION APPROVE</h1>
            </div>
        </div>

        <div class="panel-heading" align="right">
            <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Update Approve
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">
                        <div class="col-sm-10">

                            <form method="post" action="../controller/update_aims_inout_approve_exec.php"
                                  enctype="multipart/form-data">

                                <input type="text" name="aims_inout_id" value="<?echo $id; ?>" />

                                <div class="form-group" align="left">
                                    <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                    <br>




                                    <div class="form-group" align="left">
                                        <label>verified<font color="red">**</font>&nbsp;&nbsp;&nbsp;</label><br>
                                        <label><input type="radio" required=""  id="verified_name" name="verified_name" value="" />	VERIFIED</label> &nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" required=""  id="verified_name" name="verified_name" value="" />	NOT VERIFIED</label> &nbsp;&nbsp;&nbsp;
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>verified_name<font color="red">**</font>&nbsp;</label><br>
                                        <input type="text" required="" class="form-control" placeholder="" id="verified_name" name="verified_name" value="<?echo $verified_name?>" />

                                    </div>

                                    <div class="form-group" align="left">
                                        <label>verified_date<font color="red">**</font>&nbsp;</label><br>
                                        <input type="date" required="" class="form-control" id="virefied_date" name="vefired_date" value="<?echo $verified_date?>" />
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>approve<font color="red">**</font>&nbsp;&nbsp;&nbsp;</label><br>
                                        <label><input type="radio" required=""  id="verified_name" name="verified_name" value="" />	APPROVE</label> &nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" required=""  id="verified_name" name="verified_name" value="" />	NOT APPROVE</label> &nbsp;&nbsp;&nbsp;
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>approve_name<font color="red">**</font>&nbsp;</label><br>
                                        <input type="text" required="" class="form-control" placeholder="" id="approve_name" name="approve_name" value="<?echo $approve_name?>" />
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>approve_date<font color="red">**</font>&nbsp;</label><br>
                                        <input type="date" required="" class="form-control" placeholder="" id="approve_date" name="approve_date" value="<?echo $approve_date?>" />
                                    </div>


                                    <div class="modal-footer">
                                        <div align="left">
                                            <button type="submit" class="btn btn-primary">submit</button>
                                        </div>
                                    </div><br>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
</script>

</body>

</html>