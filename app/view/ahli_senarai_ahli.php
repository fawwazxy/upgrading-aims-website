<?php

include ('../controller/auth.php');
require "../model/ahli_functions.php";
require "../model/lookup.php";

?>
<?
$statact=$_GET['statact'];
$flagScreen=$_GET['tab'];
if(!isset($statact)){
    $statact="BD";
    $flagScreen="tab_1";
}


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
    <script src="../../js/jszip/dataTables.buttons.min.js"></script>
    <script src="../../js/jszip/jszip.min.js"></script>
    <script src="../../js/jszip/pdfmake.min.js"></script>
    <script src="../../js/jszip/vfs_fonts.js"></script>
    <script src="../../js/jszip/buttons.html5.min.js"></script>
    <script src="../../js/jszip/buttons.colVis.min.js"></script>


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }
    </script>

    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
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

                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <?

        include ('../global/ahli__menu_status.php');
        ?>
        <br>

        <!--<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Pekerja</h1>
            </div>

        </div>-->
        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" align="left" id="myModalLabel">Muat Naik Fail</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../controller/ahli_exec.php" enctype="multipart/form-data">


                            <input id="action" name="action" type="hidden" value="uploadExcel"/>
                            <div class="form-group">
                                <label class="control-label">Fail<font color="red"> **</font>&nbsp;(Fail Excel Sahaja)</label>
                                <input required  accept=".xlsx" type="file" name="csv_file" id="csv_file" class="btn btn-link">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Contoh Excel : </label>
                                <br><a href="../../resources/items/format_add_ahli.xlsx">Muat Turun Format</a>
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

        <div class="row">
            <div class="panel-heading" align="right">
                <a href="ahli_daftar_online.php" target="_blank"><button class="btn btn-success">Daftar Online</button></a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#myModal3">Muat Naik Excel</button>
                <a href="ahli_info.php?id=0&statact=<? echo $statact;?>&tab=<? echo $flagScreen;?>"><button class="btn btn-primary">Tambah</button></a>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Ahli
                    </div>



                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <?if($statact!="BD"){?>
                                    <th>No. Ahli</th>
                                    <th>Kategori Ahli</th>
                                <?}?>
                                <th>Nama</th>
                                <th>No. Telefon</th>
                                <th>Alamat</th>
                                <th>Galur</th>
                                <th>kategori Umur</th>
                                <?if($statact!="BD"){?>
                                    <th>Status Yuran</th>
                                <?}?>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_ahli = getAhli($statact);
                            while($row_data_ahli = $data_ahli->fetch_assoc()) {
                                $status=$row_data_ahli['status'];
                                $status_text = "";
                                if ($status== '1') {
                                    $status_text = "Nyah Aktif";
                                    $color = "danger";
                                }
                                else {
                                    $status_text = "Aktif";
                                    $color = "success";
                                }



                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i;?></td>
                                    <?if($statact!="BD"){?>
                                        <td><? echo $row_data_ahli['no_ahli'];?></td>
                                        <td><? echo $row_data_ahli['kategori_ahli'];?></td>
                                    <?}?>
                                    <td><? echo $row_data_ahli['nama'];?></td>
                                    <td><? echo $row_data_ahli['notel'];?></td>
                                    <td><? echo $row_data_ahli['alamat'];?></td>
                                    <td><? echo $row_data_ahli['nama_galur'];?></td>
                                    <td><? echo $row_data_ahli['keterangan'];?></td>
                                    <?if($statact!="BD"){?>
                                        <td><? $status_yuran=getStatusYuran($row_data_ahli['nokp'],$row_data_ahli['status_ahli'])->fetch_object()->id;
                                            $jum_bayaran=getStatusYuran($row_data_ahli['nokp'],$row_data_ahli['status_ahli'])->fetch_object()->jum_bayaran;
                                            $jum_belum_bayar=$row_data_ahli['yuran']-$jum_bayaran;

                                            if ($status_yuran >= 1) {
                                                echo "<font color=green><strong>SUDAH DIBAYAR</strong></font>";
                                            }
                                            else {
                                                echo "<font color=red><strong>BELUM DIBAYAR</strong></font>";
                                            }
                                            ?>
                                        </td>
                                    <?}?>
                                    <td>
                                        <?
                                        if ($status == 1) {
                                            echo "<font color=blue><strong>AKTIF</strong></font>";
                                        }
                                        else {
                                            echo "<font color=red><strong>MENINGGAL</strong></font>";
                                        }?>

                                    </td>
                                    <td><a href="ahli_info.php?id=<? echo $row_data_ahli['id'];?>&statact=<? echo $statact;?>&tab=<? echo $flagScreen;?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>
                                        <? if ($status_yuran <= 0 & $statact!="BD") {?>
                                            <a href="#myModal1" class="btn btn-primary btn-small" data-toggle="modal" data-id="<? echo $row_data_ahli['id'];?>">Kategori Keahlian</a>
                                            <a href="#myModal2" class="btn btn-warning btn-small" data-toggle="modal" data-id="<? echo $row_data_ahli['id'];?>" data-nokp="<? echo $row_data_ahli['nokp'];?>">Yuran Ahli</a>
                                        <?}else if($statact=="BD"){?>
                                            <a href="#myModal1" class="btn btn-primary btn-small" data-toggle="modal" data-id="<? echo $row_data_ahli['id'];?>">Kategori Keahlian</a>
                                            <a onclick="delAhli(<?echo $row_data_ahli['id'] ;?>,<?echo $status ;?>)" ><button type="button" class="btn btn-danger">Padam</button></a>

                                        <?}else if($status_yuran > 0 & $statact=="AB"){?>
                                            <a href="#myModal1" class="btn btn-primary btn-small" data-toggle="modal" data-id="<? echo $row_data_ahli['id'];?>">Kategori Keahlian</a>
                                        <?}else if($status_yuran > 0 & $statact=="SH" && $jum_belum_bayar>0 ){?>
                                            <a href="#myModal2" class="btn btn-warning btn-small" data-toggle="modal" data-id="<? echo $row_data_ahli['id'];?>" data-nokp="<? echo $row_data_ahli['nokp'];?>">Yuran Ahli</a>
                                        <?}?>


                                        <a onclick="nyahAktifAhli(<?echo $row_data_ahli['id'] ;?>,<?echo $status ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>

                                    </td>





                                </tr>
                                <?php $i++; } ?>


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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kategori Keahlian</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'ahli_daftar_ahli.php',
                            data:{id:rowid,statact:"<? echo $statact;?>",tab:"<? echo $flagScreen;?>"},
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
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Yuran Ahli</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        var nokp_ahli = $(e.relatedTarget).data('nokp');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'ahli_pembayaran_yuran.php',
                            data:{id:rowid,nokp:nokp_ahli,statact:"<? echo $statact;?>",tab:"<? echo $flagScreen;?>"},
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                }
            ]
        });

    });
    function nyahAktifAhli(id,status){
        $.ajax({
            url: "../model/ahli_functions.php",
            type: "POST",
            data: {action:"nyahAktifAhli",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='ahli_senarai_ahli.php?statact=<? echo $statact;?>&tab=<? echo $flagScreen;?>';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    function delAhli(id,status){

        $.confirm({
            title: 'Warning',
            content: 'Anda Pasti Ingin Padam Maklumat Ini?',
            buttons: {
                YA: function () {
                    $.ajax({
                        url: "../model/ahli_functions.php",
                        type: "POST",
                        data: {action:"delAhli",id:id,status:status},
                        success: function (response) {
                            // you will get response from your php page (what you echo or print)
                            //$.alert('test here:'+response);

                            window.location='ahli_senarai_ahli.php?statact=<? echo $statact;?>&tab=<? echo $flagScreen;?>';
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                },
                TIDAK: function(){
                    window.location='ahli_senarai_ahli.php?statact=<? echo $statact;?>&tab=<? echo $flagScreen;?>';

                }

            }
        });

    }

</script>

</body>

</html>
