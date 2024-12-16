<?php

include ('../controller/auth.php');
require "../model/ahli_functions.php";
require "../model/lookup.php";

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
    <?

    $tahun=$_GET['tahun'];

    if(!isset($tahun)){
        $tahun=$date_year;
    }
    ?>


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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Pengumuman & Aktiviti</h1>
            </div>

        </div>


        <div class="row">

            <div class="panel-heading" align="right">
                <a href="#myModal1" class="btn btn-primary btn-small" data-toggle="modal" data-id="<? echo 0;?>">Tambah</a>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pengumuman & Aktiviti
                    </div>



                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tajuk</th>
                                <th>Tarikh Mula & Tarikh Tamat</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $pengumuman = getSenaraiPengumuman();
                            while($list_pengumuman = $pengumuman->fetch_assoc()) {
                                $status=$list_pengumuman['status'];
                                $id=$list_pengumuman['id'];
                                $str=$list_pengumuman['dokumen_filename'];
                                $kategori = $list_pengumuman['kategori'];

                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i;?></td>
                                    <td><? echo $list_pengumuman['tajuk'];?></td>
                                    <td><b><? echo $list_pengumuman['tarikh_mula']." Hingga ".$list_pengumuman['tarikh_tamat'];?></b></td>
                                    <td>
                                        <?
                                        if ($kategori == 1) {
                                            echo "<font ><strong>AKTIVITI</strong></font>";
                                        }
                                        else {
                                            echo "<font ><strong>PENGUMUMAN</strong></font>";
                                        }

                                        ?>

                                    </td>
                                    <td><? echo $list_pengumuman['keterangan'];?></td>
                                    <td>
                                        <?
                                        if ($status == 1) {
                                            echo "<font color=blue><strong>AKTIF</strong></font>";
                                        }
                                        else {
                                            echo "<font color=red><strong>TIDAK AKTIF</strong></font>";
                                        }

                                        ?>

                                    </td>
                                    <td>
                                        <?
                                        if ($status == 1) {
                                            echo " <a><button class='btn btn-danger' onclick='updateStatus($id,0)'>Nyah Aktif</button></a>";
                                        }
                                        else {
                                            echo " <a><button class='btn btn-success' onclick='updateStatus($id,1)'>Aktif</button></a>";
                                        }?>

                                        <a href="#myModal1" class="btn btn-info btn-small" data-toggle="modal" data-id="<? echo $id;?>">Kemaskini</a>
                                        <?if ($str!=""){?>
                                            <a href="#myModal2" class="btn btn-warning btn-small" data-toggle="modal" data-id="<? echo $id;?>">Papar Lampiran</a>
                                        <?}?>
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
                <h4 class="modal-title" id="myModalLabel">Pengumuman</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'ahli_tambah_edit_pengumuman.php',
                            data:{id:rowid,created_by:"<? echo $_SESSION['SESS_NOKP'];?>"},
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
                <h4 class="modal-title" id="myModalLabel">Lampiran</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');

                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'ahli_papar_lampiran_pengumuman.php',
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


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    function updateStatus(id,status){
        $.ajax({
            url: "../model/ahli_functions.php",
            type: "POST",
            data: {action:"updateStatusPengumuman",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='ahli_senarai_pengumuman.php';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>
</body>

</html>
