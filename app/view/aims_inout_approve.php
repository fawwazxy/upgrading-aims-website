<?php

include ('../controller/auth.php');

require "../model/aims_inout_function.php";

$staff_record_id = $_GET['staff_record_id'];
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
                <h1 class="page-header">Aims_InOut_Approve</h1>
            </div>
        </div>

        <div class="panel-heading" align="right">
            <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        IN/OUT PERMISSION APPROVE
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">
                        <div class="col-sm-10">

                            <form method="post" action="../controller/aims_inout_approve_exec.php"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="action" value="login_edit" />
                                <input type="hidden" name="no_staff" value="<?echo $staff['no_staff']; ?>" />
                                <div class="form-group" align="left">
                                    <label><font color="red">** IN/OUT PERMISSION APPROVE.</font></label>
                                    <br>

                                    <table width="100%">
                                        <tr>
                                            <th width="14%"></th>
                                            <th width="2%"></th>
                                            <th></th>
                                        </tr>

                                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />

                                    </table>


                                    <div class="form-group" align="left">
                                        <label>aims_inout_id<font color="red">**</font>&nbsp;</label><br>
                                        <input type="text" required="" class="form-control" placeholder="" id="aims_inout_id" name="aims_inout_id" value="<?echo $staff_record_id?>" />
                                    </div>


                                    <div class="form-group" align="left">
                                        <label>approve<font color="red">**</font>&nbsp;&nbsp;&nbsp;</label><br>
                                        <label><input type="radio" required=""  id="approve" name="approve" value="APPROVE" />	APPROVE</label> &nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" required=""  id="approve" name="approve" value="DISAPPROVE" />	DISAPPROVE</label> &nbsp;&nbsp;&nbsp;
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>approve_name<font color="red">**</font>&nbsp;</label><br>
                                        <input type="text" required="" class="form-control" placeholder="" id="approve_name" name="approve_name" value="<?$_SESSION['SESS_DEPARTMENT'];?>" />
                                    </diV>

                                    <div class="modal-footer">
                                        <div align="left">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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