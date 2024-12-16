<?php

include ('../controller/auth.php');


require "../model/pembekal_function.php";

$id=$_GET['id'];

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
                        <h1 class="page-header">Kemaskini Pembekal</h1>
                    </div>
                </div>





                <div class="panel-heading" align="right">
                    <!-- 					<input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                     -->                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->

            <div class="row">


                <div class="col-lg-12">



                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form id="myform" method="post"  action="../controller/pembekal_exec.php?act=pembekal_edit" name="myform"  enctype="multipart/form-data" >

                                        <?

                                        $pembekal = getPembekalInfo($id)->fetch_assoc();

                                        ?>


                                        <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                        <br>

                                        <input name="id" type="hidden" class="input-short" value="<?  echo $_GET['id'];?>" />

                                        <div class="form-group" align="left">
                                            <label>Nama Syarikat<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control"  name="nama_syarikat" value="<? echo $pembekal['company_name']; ?>" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nama Singkatan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control"  name="short_name" value="<? echo $pembekal['short_name']; ?>" required="">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Nama Pegawai Perhubungan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="person_incharge" value="<? echo $pembekal['person_incharge']; ?>" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nombor Daftar Syarikat<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" id="supplier_code" name="supplier_code" value="<? echo $pembekal['supplier_code']; ?>" required="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Alamat1<font color="red">**</font>&nbsp;</label>
                                            <textarea class="form-control" name="address1" rows="5" required=""><? echo $pembekal['address1']; ?></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Alamat2<font color="red">**</font>&nbsp;</label>
                                            <textarea class="form-control" name="address2" rows="5" required="" ><? echo $pembekal['address2']; ?></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jajahan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="district" value="<? echo $pembekal['district']; ?>" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Bandar<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="city" value="<? echo $pembekal['city']; ?>" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Negeri<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="state" value="<? echo $pembekal['state']; ?>" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Negara<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="country" value="<? echo $pembekal['country']; ?>" required="" >
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Nombor Telefon<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="contact_no" value="<? echo $pembekal['contact_no']; ?>" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nombor Fax<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="fax_no"  value="<? echo $pembekal['fax_no']; ?>" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Email<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="official_email" value="<? echo $pembekal['official_email']; ?>" required="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Email Jabatan<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="dept_email" value="<? echo $pembekal['dept_email']; ?>" required="" >
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Id Facebook<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control"  name="facebook_id" value="<? echo $pembekal['facebook_id']; ?>" required="">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Nama Bank<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="bank" value="<? echo $pembekal['bank']; ?>" required="">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Nombor Akaun Bank<font color="red">**</font>&nbsp;</label>
                                            <input type="text" class="form-control" name="account_no" value="<? echo $pembekal['account_no']; ?>" required="">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Zon</label>
                                            </br>
                                            <?
                                            $staffN= getZone();
                                            while ($listN  = $staffN -> fetch_assoc()){ ?>
                                                <input type="checkbox" name="zone[]" value="<? echo $listN['id'];?>"<? echo($pembekal['zone_id']==$listN['id']?'checked':'');?>>&nbsp;<? echo $listN['zone_name'];?> : <? echo $listN['zone_desc'];?>
                                                </br>
                                            <?}?>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jenis</label>
                                            </br>
                                            <?
                                            $staffM= getCategoryType();
                                            while ($listM = $staffM -> fetch_assoc()){ ?>

                                                <input type="checkbox" name="type[]" value="<? echo $listM['id'];?>"<? echo($listM['id']==$pembekal['type_id']?'checked':'');?>>&nbsp;<? echo $listM['type'];?>
                                                </br>
                                            <?}?>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-info">Simpan</button>
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

