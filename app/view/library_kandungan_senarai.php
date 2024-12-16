<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_1';

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
            newwindow=window.open(url,'name','height=800,width=1280');
            if (window.focus) {newwindow.focus()}
            return false;
        }

        // -->
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

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Bahan Bacaan</h1>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="library_kandungan_senarai.php">Bahan Bacaan</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="library_kategori_senarai.php">Kategori</a></li>
                    </ul>
                </div>
                <div class="form-group" align="right">
                </div>
            </div>
        </div>


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" align="left" id="myModalLabel">Muat Naik Fail</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../controller/library_upload_excel_exec.php" enctype="multipart/form-data">
                            <input id="action" name="action" type="hidden" value="upload"/>
                            <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_ID'];?>"/>
                            <div class="form-group">
                                <label class="control-label">Fail<font color="red"> **</font>&nbsp;(Fail Excel Sahaja)</label>
                                <input required  accept=".xlsx" type="file" name="csv_file" id="csv_file" class="btn btn-link">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Contoh Excel : </label>
                                <br><a href="../../elibrary/template/excel_template.xlsx">Muat Turun Format</a>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                            </div>
                        </form>
                    </div><!--modal-body-->
                </div>
                <!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <div class="form-group" align="right">
            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Muat Naik Excel</button>
            <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='library_tambah_kandungan.php'">Tambah Baharu</button>
            <a class="btn btn-warning" href="library_senarai_bahan.php" target="blank">Carian Bahan Bacaan</a>
            <a class="view" target="blank" href="library_label_semua.php"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Semua Label</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Bahan Bacaan</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="30%">Maklumat Bahan Bacaan</th>
                                <th width="30%">Maklumat Penerbitan</th>
                                <th width="35%">Bil. Naskah & Status Pinjaman</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $kandungan = getKandunganList();
                            $i=1;
                            while($list_kandungan = $kandungan->fetch_assoc()) {

                                $bil_masih_ada=$list_kandungan['bil_naskah_hardcopy']- getBilDokumenDipinjam($list_kandungan['id']);
                                $bil_ditempah=getBilDokumenDitempah($list_kandungan['id']);

                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><?echo '<img width="100" height="120" src="../../elibrary/frontpage/'.$list_kandungan['frontpage_cover_file'].'"/><br>';?>
                                        <?if($list_kandungan['status_naskah'] != 2){?>
                                            <br><a href="../controller/library_download_file_exec.php?id=<?echo $list_kandungan['id']?>&action=elibrary">Tajuk : <?echo $list_kandungan['nama']?><i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a><br>
                                            <?
                                            $terjemahan = getTerjemahanByElibrary($list_kandungan['id']);
                                            $i=1;
                                            while($list_terjemahan = $terjemahan->fetch_assoc()) {?>
                                                <a href="../controller/library_download_file_exec.php?id_terjemahan=<?echo $list_terjemahan['id']?>&action=terjemahan">Bahasa : <?echo $list_terjemahan['language']."(".$list_kandungan['nama'].")";?><i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a><br>
                                            <?}?>

                                        <?}?>
                                        <br><label class="control-label" for="date">Kategori :</label> <?echo $list_kandungan['jenis'] ;?>
                                    </td>
                                    <td>
                                        <?if($list_kandungan['penerbit'] !=''){?>
                                            <label class="control-label" for="date">Nama Penerbit :</label> <?echo $list_kandungan['penerbit'].'<br>' ;}?>
                                        <?if($list_kandungan['tahun_terbitan'] !=''){?>
                                            <label class="control-label" for="date">Tahun Penerbitan :</label> <?echo $list_kandungan['tahun_terbitan'].'<br>' ;}?>
                                        <?if($list_kandungan['isbn']!=''){?>
                                            <label class="control-label" for="date">ISBN :</label> <?echo $list_kandungan['isbn'].'<br>' ;
                                        }?>
                                        <?if($list_kandungan['bilangan'] !=''){?>
                                            <label class="control-label" for="date">Jilid :</label> <?echo $list_kandungan['bilangan'].'<br>' ;
                                        }?>
                                        <label class="control-label" for="date">Status Naskah :</label>
                                        <?if($list_kandungan['status_naskah'] == 0){?>
                                            <br><strong><font color="red" size='3px'>**&nbsp;Dokumen PDF sahaja&nbsp;**</font></strong>
                                        <?}else if($list_kandungan['status_naskah'] == 1){?>
                                            <br><strong><font color="blue" size='3px'>**&nbsp;Dokumen PDF & Salinan Naskah&nbsp;**</font></strong>
                                        <?}else{?>
                                            <br><strong><font color="brown" size='3px'>**&nbsp;Salinan Naskah sahaja&nbsp;**</font></strong>
                                        <?}?>
                                        <?if($list_kandungan['status_naskah'] != 2){?>
                                            <br><br><br><center><a href="#myModal3" class="btn btn-warning" data-toggle="modal" data-id="<? echo $list_kandungan['id'];?>">Muat Naik Terjemahan</a></center>

                                        <?}?>
                                    </td>
                                    <td>
                                        <?if($list_kandungan['bil_naskah_hardcopy'] != "0"){?>
                                            <?if($list_kandungan['status_pinjam'] == "1"){?>

                                                <strong>Bil. Keseluruhan Salinan :<font size="5" color="blue"> <?echo $list_kandungan['bil_naskah_hardcopy']?></font></strong><br>


                                                <strong>Bil. Sedang Dipinjam :<font size="5" color="red"> <?echo getBilDokumenDipinjam($list_kandungan['id']);?></font></strong><br>
                                                <strong>Bil. Masih Ada :<font size="5" color="green"> <?echo $bil_masih_ada;?></font></strong><br>
                                                <strong>Bil. Ditempah :<font size="5" color="orange"> <?echo $bil_ditempah;?></font></strong><br>
                                                <?if($bil_masih_ada >= 0 && $bil_masih_ada > $bil_ditempah){?>
                                                    <br><a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $list_kandungan['id'];?>">Pinjaman</a>
                                                <?}else if($bil_masih_ada == 0 || $bil_ditempah >= $bil_masih_ada ){?>
                                                    <br><a href="#myModal2" class="btn btn-success" data-toggle="modal" data-id="<? echo $list_kandungan['id'];?>">Tempahan</a>
                                                <?}?>
                                                <?
                                            }else{
                                                ?>
                                                <strong>Bil. Keseluruhan Salinan : <font size="5" color="blue"><?echo $list_kandungan['bil_naskah_hardcopy']?></font></strong><br>
                                                <strong><font size="3" color="red">** Tidak Dibenarkan Pinjam **</font></strong>
                                            <?}?>
                                        <?}else{?>
                                            <strong><font size="3" color="red">** Tiada Salinan Naskah **</font></strong>

                                        <?}?>

                                    </td>
                                    <td><?if($list_kandungan['bil_naskah_hardcopy'] != "0"){?>
                                            <a class="view" target="blank" href="library_label_pilihan.php?id=<?echo $list_kandungan['id'] ;?>"><button class="btn btn-warning hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Label Pilihan</button></a>

                                            <a class="view" target="blank" href="library_label.php?id=<?echo $list_kandungan['id'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Label</button></a>

                                        <?}?>
                                        <a href="library_kemaskini_kandungan.php?id=<?echo $list_kandungan['id'] ;?>" ><button type="button" class="btn btn-info">Kemaskini</button></a>
                                        <?if($bil_masih_ada >0 && $bil_ditempah > 0){?>
                                            <a href="../model/library_functions.php?id_elibrary=<?echo $list_kandungan['id'] ;?>&action=agihTempahan" ><button type="button" class="btn btn-primary">Agih Tempahan</button></a>

                                        <?}?>

                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>

                    <!-- /.panel-body -->
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Peminjam</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_peminjam.php',
                            data:{id_library:rowid},
                            success:function(html){
                                $('#demo').html(html);
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
                <h4 class="modal-title" id="myModalLabel">Tambah Tempahan</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_tempahan_tambah.php',
                            data:{id_library:rowid},
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
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Peminjam</h4>
            </div>
            <div class="modal-body" id="demo3">
                <script type="text/javascript">
                    $('#myModal3').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_terjemahan.php',
                            data:{id_library:rowid},
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
<script>

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var row_id = $(this).parents("tr").find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });
            //alert("ghggg");
            $.ajax({
                url: "../model/acara_functions.php",
                type: "POST",
                data: {action:"deleteKumpulan", row_id:row_id.val() },
                success: function (response) {
                    $(this).parents("tr").remove();
                    $(".add-new").removeAttr("disabled");
                    // you will get response from your php page (what you echo or print)
                    //$.alert(response);
                    $.confirm({
                        title: 'Info',
                        content: response,
                        buttons: {
                            OK: function () {
                                location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
                            }
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
                }


            });

        });



    });
    function getPeminjam(obj){
        if(obj.value.length > 11){
            $.ajax({
                url: "../model/library_functions.php",
                type: "POST",
                data: {action:"peminjam_detail",nokp:obj.value},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)   
                    var dataObject = $.parseJSON(response);
                    // $.alert('test here:'+response.length);
                    if(response.length == 2){

                        $('#nama').val("");
                        $('#notel').val("");

                    }else{

                        $('#nama').val(dataObject[0].nama);
                        $('#notel').val(dataObject[0].notel);
                    }


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }


            });
        }
    }
</script>

</body>

</html>