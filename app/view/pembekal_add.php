<?php

include ('../controller/auth.php');


require "../model/pembekal_function.php";

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

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tambah Pembekal</h1>
                    </div>
                </div>





                <div class="panel-heading" align="right">
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->

            <div class="row">


                <div class="col-lg-12">



                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


                                    <form id="myform" method="post"  action="../controller/pembekal_exec.php?act=pembekal_add" name="myform"  enctype="multipart/form-data" >


                                        <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                        <br>

                                        <div class="form-group" align="left">
                                            <label>Nama Syarikat<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control"  name="nama_syarikat" value="" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nama Singkatan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control"  name="short_name" value="" required="">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Nama Pegawai Perhubungan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="person_incharge" value="" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nombor Daftar Syarikat<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" id="supplier_code" name="supplier_code" value="" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Alamat1<font color="red">**</font>&nbsp;</label>
                                            <textarea class="form-control" name="address1" rows="5" required="" ></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Alamat2<font color="red">**</font>&nbsp;</label>
                                            <textarea class="form-control" name="address2" rows="5" required="" ></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jajahan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="district" value="" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Bandar<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="city" value="" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Negeri<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="state" value="" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Negara<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="country" value="" required="" >
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Nombor Telefon<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="contact_no" value="" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nombor Fax<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="fax_no"  value="" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Email<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="official_email" value="" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Email Jabatan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="dept_email" value="" required="" >
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Id Facebook<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control"  name="facebook_id" value="" required="">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Nama Bank<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="bank" value="" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nombor Akaun Bank<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="account_no" value="" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Zon</label>
                                            </br>
                                            <?
                                            $staffN= getZone();
                                            while ($listN  = $staffN -> fetch_assoc()){ ?>

                                                <input type="checkbox" name="zone[]" value="<? echo $listN['id'];?>">&nbsp;<? echo $listN['zone_name'];?>: <? echo $listN['zone_desc'];?>
                                                </br>
                                            <?}?>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jenis</label>
                                            </br>
                                            <?
                                            $staff= getCategoryType();
                                            while ($list  = $staff -> fetch_assoc()){ ?>

                                                <input type="checkbox" name="type[]" value="<? echo $list['id'];?>">&nbsp;<? echo $list['type'];?>
                                                </br>
                                            <?}?>
                                        </div>

                                        <div class="modal-footer">
                                            <!--a href="update_staff_edu.php"--><button class="btn btn-info">Simpan</button></a>
                                            <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>


</body>

</html>

