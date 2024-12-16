<?php

include ('../controller/auth.php');

require "../model/ahli_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_4'
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>
    <?php
    echo "Watch the page reload itself in 10 second!";
    ?>
    </body> -->

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
        <?include '../global/ahli_menu_konfigurasi.php'?>

        <div class="form-group" align="right">
        </div>
        <div class="form-group" align="right">
            <? if(getCountData("ahli_kelab_persatuan")==0){?>
                <a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="0">Tambah Baharu</a>
            <?}?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Kelab/Persatuan</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">Bil</th>
                                <th width="18%">Nama</th>
                                <th width="20%">Alamat</th>
                                <th width="20%">Nama Pengerusi</th>
                                <th width="18%">No. Telefon & Email</th>
                                <th width="10%">Status</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $kelab_persatuan = getKelabPersatuanList();
                            $i=1;
                            while($list_kelab_persatuan = $kelab_persatuan->fetch_assoc()) {
                                $status_text = "";
                                if ($list_kelab_persatuan['status'] == '1') {
                                    $status_text = "Nyah Aktif";
                                    $color = "danger";
                                }
                                else {
                                    $status_text = "Aktif";
                                    $color = "success";
                                }
                                ?>
                                <tr>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>"><?echo $i++;?></td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>"><?echo $list_kelab_persatuan['nama'];?>
                                        <br>
                                        <?if($list_kelab_persatuan['logo'] != ''){echo '<img width="120" height="120" src="data:image/jpeg;base64,'.base64_encode( $list_kelab_persatuan['logo'] ).'"/>';
                                        }?>
                                    </td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>"><?echo $list_kelab_persatuan['alamat'];?></td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>"><?echo $list_kelab_persatuan['nama_pengerusi'];?></td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>">+6<?echo $list_kelab_persatuan['tel'];?>
                                        <br><?echo $list_kelab_persatuan['email'];?>
                                    </td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>">
                                        <?if($list_kelab_persatuan['status'] == '1')
                                        {
                                            echo '<b><font color="green">'.'Aktif'.'</font></b>';
                                        }
                                        else {
                                            echo '<b><font color="red">'.'Tidak Aktif'.'</font></b>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#myModal3" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>"><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                        <a href="#myModal2" class="btn btn-primary" data-toggle="modal" data-id="<? echo $list_kelab_persatuan['id'];?>">Kemaskini</a>
                                        <br><a onclick="nyahAktifKelabPersatuan(<?echo $list_kelab_persatuan['id'] ;?>,<?echo $list_kelab_persatuan['status'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                        <input id="rowid" name="rowid" type="hidden" value="<?echo $list_kelab_persatuan['id'];?>"/>
                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Kelab/Persatuan</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'ahli_kelab_persatuan_tambah.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Kemaskini Maklumat Kelab/Persatuan</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'ahli_kelab_persatuan_kemaskini.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo2').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Maklumat Kelab/Persatuan</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal3').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'ahli_konfigurasi_kelab_persatuan_info.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo3').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

        function nyahAktifKelabPersatuan(id,status){
            $.ajax({
                url: "../model/ahli_functions.php",
                type: "POST",
                data: {action:"nyahAktifKelabPersatuan",id:id,status:status},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);

                    window.location='ahli_konfigurasi_kelab_persatuan.php';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

    </script>

</body>

</html>