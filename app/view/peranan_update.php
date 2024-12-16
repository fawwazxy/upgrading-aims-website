<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?
$com_id=$_GET['SESS_COM'];
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
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
                <h1 class="page-header">Kemaskini Penawaran Jawatan</h1>


            </div>

            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">



                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">


                                <?



                                $log_peranan = getPerananAct($id)-> fetch_assoc();


                                ?>

                                <form method="post" action="../controller/peranan_update_exec.php?&id=<? echo $id;?>" >


                                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />

                                    <label><font color="red">Maklumat Wajib Diisi.</font></label>
                                    <br>



                                    <div class="form-group" align="left">



                                        <div class="form-group" align="left">
                                            <label>Kod<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="code" value="<? echo $log_peranan['code']; ?>"/><br>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Peranan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="role" value="<? echo $log_peranan['role']; ?>"/><br>
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Pilih Kumpulan Peranan<font color="red">**</font>&nbsp;</label>
                                            <select id="disabledSelect" class="form-control" name="role_group_id" value="<? echo $log_peranan['role_group_name']; ?>">
                                                <option value="">-- Pilih --</option>

                                                <? $role_group = getRoleGroup();
                                                while ($list_group  = $role_group-> fetch_assoc()){ ?>
                                                    <option value="<? echo $list_group['id'];?>" <?echo($list_group['id']==$log_peranan['role_group_id']?'selected':'');?>><? echo $list_group['role_group_name'];?> </option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group row" align="left">
                                            <div class="col-xs-6">
                                                <label>Slip Gaji<font color="red">&nbsp;**</font></label><br>
                                                <input type="radio" value="1" name="slip_gaji" id="slip_gaji" <?echo $log_peranan['slip_gaji'] == '1'?'checked':''?> />
                                                <label>Ya</label>&nbsp; &nbsp; &nbsp;
                                                <input type="radio" value="0" name="slip_gaji" id="slip_gaji" <?echo $log_peranan['slip_gaji'] == '0'?'checked':''?> />
                                                <label>Tidak</label>
                                            </div>
                                        </div>

                                        <div class="form-group row" align="left">
                                            <div class="col-xs-6">
                                                <label>Pelulus Cuti<font color="red">&nbsp;**</font></label><br>
                                                <input type="radio" value="1" name="status_pelulus_cuti" id="status_pelulus_cuti" <?echo $log_peranan['status_pelulus_cuti'] == '1'?'checked':''?> />
                                                <label>Ya</label>&nbsp; &nbsp; &nbsp;
                                                <input type="radio" value="0" name="status_pelulus_cuti" id="status_pelulus_cuti" <?echo $log_peranan['status_pelulus_cuti'] == '0'?'checked':''?> />
                                                <label>Tidak</label>
                                            </div>
                                        </div>




                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });



    });


</script>


</body>

</html>
