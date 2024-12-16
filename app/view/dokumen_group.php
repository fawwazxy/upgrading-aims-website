<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";

?>
<?
$nama_staf=$_SESSION['SESS_NAME'];
$file_name=$_GET['file_name'];
$_SESSION['SESS_NO_STAFF'];
$no_staffs = $_SESSION['SESS_NO_STAFF'];
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$time_hour = date(H);
$time_min = date(i);
$time_sec = date(s);

$uniqueKeyID = $no_staffs.$date_year.$date_month.$date_day.$time_hour.$time_min.$time_sec;

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

    <script language="javascript" type="text/javascript">
        <!--
            function popitup(url) {
                /*newwindow=window.open(url,'name','height=842,width=595');*/
                newwindow=window.open(url,'name','height=800,width=800');
                if (window.focus) {newwindow.focus()}
                return false;
            }

    </script>
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

    <!-- Modal Kumpulan -->
    <div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Direktori Baharu</h4>
                </div>

                <div class="modal-body">

                    <form method="post" action="../controller/spesifikasi_exec.php?act=dokumen_group">
                        <div class="form-group" align="left">

                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                            <br>

                            <input type="hidden" class="form-control"  name="nama_staf" value="<? echo $nama_staf;?>" required autocomplete="">

                            <div class="form-group" align="left">
                                <label>Nama Direktori<font color="red">**</font>&nbsp;</label>
                                <input type="text" class="form-control"  name="nama_group" value="" required autocomplete="">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-info">Tetapan Semula</button>
                            </div>
                        </div>

                    </form>
                </div><!--modal-body-->

            </div>
            <!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Pengurusan Direktori & Dokumen</h1>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-12" align="center">
                <h4>Carian**</h4>
                <table>
                    <tr>
                        <td><input class="form-control" type="text" placeholder="Carian" id="file_name" name="file_name" value="<?echo $file_name;?>"></td>
                        <td>&nbsp;&nbsp;<button onclick="submit_cari()" align="right" class="btn btn-primary">Cari</button></td>
                    </tr>
                </table>
                <h6>** Masukkan kata kunci carian anda</h6>
            </div>

            <div class="panel-heading" align="right">
                <button align="right" class="btn btn-primary" data-toggle="modal"  data-target="#myModals">Tambah Direktori</button>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Direktori & Dokumen
                    </div>


                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th width="39%" >Nama Direktori</th>
                                <th width="35%" >Dicipta oleh</th>
                                <th width="26%" >Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $a= 1;
                            $data = getKumpulan();
                            while($row_data = $data->fetch_assoc()) {
                                // pilih projek
                                ?>

                                <tr id="icon<?echo $a;?>" data-toggle="collapse" data-target="#demo<?echo $a;?>" class="accordion-toggle">
                                    <td><div class="glyphicon glyphicon-minus" data-toggle="collapse" href="#collapse1">&nbsp;<?php echo $row_data['nama_group'];?></div></td>
                                    <td><?php echo $row_data['created_by'];?></td>
                                    <td>
                                        <button align="right" class="btn btn-primary" data-toggle="modal"  data-target="#myModal<?php echo $row_data['id'];?>">Tambah Dokumen</button>
                                        <a href="../controller/spesifikasi_exec.php?act=dokumen_group_delete_group&id=<?php echo $row_data['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Anda pasti untuk padam kumpulan ini?');">Padam</button><br></a>
                                        <button align="right" class="btn btn-info" data-toggle="modal"  data-target="#myModalUpdateGroup<?php echo $row_data['id'];?>">Kemaskini</button>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body expand" id="demo<?echo $a;?>">
                                            <table width="100%" class="table table-bordered table-hover" id="dataTables-example">
                                                <thead>
                                                <tr>
                                                    <th width="5%" >#</th>
                                                    <th width="51%" >Nama Dokumen</th>

                                                    <th width="24%" >Dokumen</th>
                                                    <th width="20%" >Tindakan</th>

                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?
                                                $b=1;
                                                $data1 = getDokumen($row_data['id'],$file_name);
                                                while($row_data1 = $data1->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $b;?></td>
                                                        <td><?php echo $row_data1['file_name'];?></td>
                                                        <td>
                                                            <?if ($row_data1['document']!=''){ ?>
                                                                <!--<button align="left" class="btn btn-success" data-toggle="modal"  data-target="#myModalPapar<?php echo $row_data1['id'];?>">Papar</button>-->
                                                                <a onclick="return popitup('dokumen_view.php?id_dokumen=<?echo $row_data1['id'];?>')"><button class="btn btn-success" type="button" >Papar</button></a>
                                                                <a href="../controller/spesifikasi_exec.php?act=dokumen_group_download&id_dokumen=<?echo $row_data1['id'];?>"><button class="btn"><i class="fa fa-download">Muat Turun</i></button></a>
                                                            <?}else{?>
                                                                <font color="red"> Tiada Dokumen Dimuat Naik</font>
                                                            <?}?>
                                                        </td>
                                                        <td> <button align="right" class="btn btn-info" data-toggle="modal"  data-target="#myModalUpdateDokumen<?php echo $row_data1['id'];?>">Kemaskini</button>
                                                            <a href="../controller/spesifikasi_exec.php?act=dokumen_group_delete_dokumen&id=<?php echo $row_data1['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Anda pasti untuk padam dokumen ini?');">Padam</button><br></a>
                                                        </td>

                                                    </tr>
                                                    <!----------------- Modal kemaskini Dokumen---------->
                                                    <div class="modal fade" id="myModalUpdateDokumen<?php echo $row_data1['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Dokumen</h4>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=dokumen_group_kemaskini_dokumen">
                                                                        <div class="form-group" align="left">

                                                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                                                            <br>

                                                                            <input type="hidden" class="form-control"  name="id_dokumen" value="<?php echo $row_data1['id'];?>" required autocomplete="">

                                                                            <div class="form-group" align="left">
                                                                                <label>Nama Dokumen<font color="red">**</font>&nbsp;</label>
                                                                                <input type="text" class="form-control"  name="file_name" value="<?php echo $row_data1['file_name'];?>" required autocomplete="">
                                                                            </div>
                                                                            <div class="form-group" align="left">
                                                                                <label>Dokumen</label><br>
                                                                                <input type="file" name="file" id="file" placeholder="" value="" class = "form-control">
                                                                                <input type="hidden" name="namaFiles" id="namaFiles" placeholder="" value="<?echo $uniqueKeyID?>">

                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary" >Simpan</button>
                                                                                <button type="reset" class="btn btn-info">Tetapan Semula</button>
                                                                            </div>

                                                                        </div>
                                                                    </form>
                                                                </div><!--modal-body-->
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

                                                          <!---------------Modal Papar---------------->
                                                    <div class="modal fade" id="myModalPapar<?php echo $row_data1['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Dokumen</h4>
                                                                </div>

                                                                <div class="modal-body">

                                                                </div><!--modal-body-->
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    <?$b++;}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <!---------------- Modal tambah Dokumen---------------->
                                <div class="modal fade" id="myModal<?php echo $row_data['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" align="left" id="myModalLabel">Tambah Dokumen</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=dokumen_group_add_dokumen">
                                                    <div class="form-group" align="left">
                                                        <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                                        <br>
                                                        <input type="hidden" class="form-control"  name="id_group_dokumen" value="<?php echo $row_data['id'];?>" required autocomplete="">
                                                        <div class="form-group" align="left">
                                                            <label>Nama Dokumen<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control"  name="file_name" value="" required autocomplete="">
                                                        </div>
                                                        <div class="form-group" align="left">
                                                            <label>Dokumen</label><br>
                                                            <input type="file" name="file" id="file" placeholder="" value="" class = "form-control">
                                                            <input type="hidden" name="namaFiles" id="namaFiles" placeholder="" value="<?echo $uniqueKeyID?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" >Simpan</button>
                                                            <button type="reset" class="btn btn-info">Tetapan Semula</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div><!--modal-body-->
                                        </div>
                                        <!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                      <!--------------- Modal Kemaskini Group------------->
                                <div class="modal fade" id="myModalUpdateGroup<?php echo $row_data['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Direktori</h4>
                                            </div>

                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=dokumen_group_kemaskini_group">
                                                    <div class="form-group" align="left">

                                                        <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                                        <br>

                                                        <input type="hidden" class="form-control"  name="id_group_dokumen" value="<?php echo $row_data['id'];?>" required autocomplete="">
                                                        <div class="form-group" align="left">
                                                            <label>Nama Direktori<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control"  name="nama_group" value="<?php echo $row_data['nama_group'];?>" required autocomplete="">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" >Simpan</button>
                                                            <button type="reset" class="btn btn-info">Tetapan Semula</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div><!--modal-body-->
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->



                                <script>
                                    // nak bagi icon dekat accordion tu berubah bila clicked

                                    $('#icon<?echo $a;?> td').click(function(){
                                        $(this).find('div').toggleClass('glyphicon-plus glyphicon-minus')
                                    });

                                </script>
                                <?$a++;}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /.page-wrapper -->
</div>
<!-- /.wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function submit_cari(){
        var file_name=$('#file_name').val();
        location.href='dokumen_group.php?file_name='+file_name;
    }
</script>
</body>

</html>
