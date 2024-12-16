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
                <h1 class="page-header">PINJAMAN</h1>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="library_pinjaman_senarai.php">Pinjaman</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="library_pemulangan_senarai.php?status=1">Pemulangan</a></li>
                        <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="library_tempahan_pinjam.php?status=0">Tempahan</a></li>
                    </ul>
                </div>
                <div class="form-group" align="right">
                </div>
            </div>
        </div>

        <div class="form-group" align="right">
            <!--<button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='library_tambah_kandungan.php'">Tambah Baharu</button>-->
            <a class="view" href="library_imbas_pinjaman.php" target="blank"><button type="button" class="btn btn-success">Terminal Imbasan Pinjaman</button></a>
            <a class="btn btn-warning" onClick="popitup('library_senarai_bahan.php')" target="blank">Carian Bahan Bacaan</a>
            <!--<a class="view" target="blank" href="library_label_semua.php"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Semua Label</button></a>-->
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Bahan Pinjaman</label>
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
                            $kandungan = getPinjamanList();
                            $i=1;
                            while($list_kandungan = $kandungan->fetch_assoc()) {

                                $bil_masih_ada = $list_kandungan['bil_naskah_hardcopy']- getBilDokumenDipinjam($list_kandungan['id']);
                                $bil_ditempah = getBilDokumenDitempah($list_kandungan['id']);
                                $status_pinjam = $list_kandungan['status_pinjam'];
                                $status_naskah = $list_kandungan['status_naskah'];

                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><?echo '<img width="100" height="120" src="../../elibrary/frontpage/'.$list_kandungan['frontpage_cover_file'].'"/><br>';?>
                                        <?if($list_kandungan['status_naskah'] != 2){?>
                                            <br><a href="../controller/library_download_file_exec.php?id=<?echo $list_kandungan['id']?>">Tajuk : <?echo $list_kandungan['nama']?> <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a><br>
                                        <?}?>
                                        <br><label class="control-label" for="date">Kategori :</label> <?echo $list_kandungan['jenis'] ;?>
                                        <!--<br><label class="control-label" for="date">Topik :</label> <?echo $list_kandungan['topik'] ;?>
                                            <br><label class="control-label" for="date">Sub Topik :</label> <?echo $list_kandungan['subtopic'] ;?>
                                            <br><label class="control-label" for="date">Jilid :</label> <?echo $list_kandungan['bilangan'] ;?>-->
                                    </td>
                                    <td><!--<label class="control-label" for="date">Nama Pengarang :</label> <?echo $list_kandungan['pengarang'] ;?>
                                            <br>-->
                                        <label class="control-label" for="date">Nama Penerbit :</label> <?echo $list_kandungan['penerbit'] ;?>
                                        <br><label class="control-label" for="date">Tahun Penerbitan :</label> <?echo $list_kandungan['tahun_terbitan'] ;?>
                                        <?if($list_kandungan['isbn'] !=''){?>
                                            <br><label class="control-label" for="date">ISBN :</label> <?echo $list_kandungan['isbn'] ;
                                        }?>
                                        <?if($list_kandungan['bilangan'] != ''){?>
                                            <br><label class="control-label" for="date">Jilid :</label> <?echo $list_kandungan['bilangan'] ;
                                        }?>
                                        <br><label class="control-label" for="date">Status Naskah :</label>
                                        <?if($list_kandungan['status_naskah'] == 0){?>
                                            <br><strong><font color="red" size='3px'>**&nbsp;Dokumen PDF sahaja&nbsp;**</font></strong>
                                        <?}else if($list_kandungan['status_naskah'] == 1){?>
                                            <br><strong><font color="blue" size='3px'>**&nbsp;Dokumen PDF & Salinan Naskah&nbsp;**</font></strong>
                                        <?}else{?>
                                            <br><strong><font color="red" size='3px'>**&nbsp;Salinan Naskah sahaja&nbsp;**</font></strong>
                                        <?}?>
                                    </td>
                                    <td>
                                        <?if($list_kandungan['bil_naskah_hardcopy'] != "0"){?>
                                            <?if($list_kandungan['status_pinjam'] == "1"){?>

                                                <strong>Bil. Keseluruhan Salinan :<font size="5" color="blue"> <?echo $list_kandungan['bil_naskah_hardcopy']?></font></strong><br>


                                                <strong>Bil. Sedang Dipinjam :<font size="5" color="red"> <?echo getBilDokumenDipinjam($list_kandungan['id']);?></font></strong><br>
                                                <strong>Bil. Masih Ada :<font size="5" color="green"> <?echo $bil_masih_ada;?></font></strong><br>
                                                <strong>Bil. Ditempah :<font size="5" color="orange"> <?echo $bil_ditempah;?></font></strong>
                                                <?
                                            }else{
                                                ?>
                                                <strong>Bil. Keseluruhan Salinan :<font size="5" color="blue"> <?echo $list_kandungan['bil_naskah_hardcopy']?></font></strong><br>
                                                <strong><font size="3" color="red">** Tidak Dibenarkan Pinjam **</font></strong>
                                            <?}?>
                                        <?}else{?>
                                            <strong><font size="3" color="red">** Tiada Salinan Naskah **</font></strong>

                                        <?}?>

                                    </td>
                                    <!--<td><?if($list_kandungan['bil_naskah_hardcopy'] != "0"){?>
                                            <a class="view" target="blank" href="library_label.php?id=<?echo $list_kandungan['id'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Label</button></a><?}?>
                                            <a href="library_kemaskini_kandungan.php?id=<?echo $list_kandungan['id'] ;?>" ><button type="button" class="btn btn-info">Kemaskini</button></a>
											<?if($bil_masih_ada >0 && $bil_ditempah > 0){?>
												 <a href="../model/library_functions.php?id_elibrary=<?echo $list_kandungan['id'] ;?>&action=agihTempahan" ><button type="button" class="btn btn-primary">Agih Tempahan</button></a>
											
											<?}?>
											
                                        </td>-->
                                    <td><?if($bil_masih_ada > 0 && $bil_masih_ada > $bil_ditempah && $status_pinjam == 1){?>
                                            <a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $list_kandungan['id'];?>">Pinjaman</a>
                                        <?}else if($bil_masih_ada == 0 || $bil_ditempah >= $bil_masih_ada ){?>
                                            <?if($status_naskah!=0){?>
                                                <a href="#myModal2" class="btn btn-success" data-toggle="modal" data-id="<? echo $list_kandungan['id'];?>">Tempahan</a>
                                            <?}?>
                                        <?}?></td>
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
                <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Pinjaman</h4>
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
                <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Tempahan</h4>
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