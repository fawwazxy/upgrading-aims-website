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
                <h1 class="page-header">Rekod Sumbangan/Infaq/Derma</h1>
            </div>

        </div>


        <div class="row">
            <div class="col-lg-4">

                <select  required class="form-control" name="tahun" id="tahun">
                    <option value="">-- Pilih Tahun--</option>
                    <? echo getDropDownTahunSumbangan($tahun) ;?>
                </select>

            </div>
            <div class="panel-heading" align="right">
                <a href="ahli_penyata_sumbangan.php?tahun=<? echo $tahun;?>" target="_blank"><button class="btn btn-warning">Cetak Penyata</button></a>
                <a href="#myModal1" class="btn btn-primary btn-small" data-toggle="modal" data-id="<? echo 0;?>">Tambah</a>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Rekod Sumbangan
                    </div>



                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarikh</th>
                                <th>Keterangan</th>
                                <th>Penyumbang</th>
                                <th>Diterima Oleh</th>
                                <th>No. Rujukan</th>
                                <th>Jumlah (RM)</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $sumbangan = getRekodSumbangan($tahun);
                            while($rekod_sumbangan = $sumbangan->fetch_assoc()) {



                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i;?></td>
                                    <td><? echo $rekod_sumbangan['tarikh_sumbangan'];?></td>
                                    <td><? echo $rekod_sumbangan['keterangan'];?></td>
                                    <td><? echo $rekod_sumbangan['penyumbang'];?></td>
                                    <td><? echo $rekod_sumbangan['diterima_oleh'];?></td>
                                    <td><? echo $rekod_sumbangan['no_rujukan'];?></td>
                                    <td><strong><font size="4"><? echo number_format($rekod_sumbangan['jumlah'],2,'.',',');?></font></strong></td>
                                    <td><a href="#myModal1" class="btn btn-info btn-small" data-toggle="modal" data-id="<? echo $rekod_sumbangan['id'];?>">Kemaskini</a>
                                        <a class="view" target="blank" href="ahli_cetak_resit_sumbangan.php?id=<?echo $rekod_sumbangan['id'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Resit</button></a>
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
                <h4 class="modal-title" id="myModalLabel">Sumbangan/Infaq/Derma</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'ahli_tambah_edit_sumbangan.php',
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#tahun").change(function(){
            var selected_tahun=$(this).val();
            sendType(selected_tahun);
        });

    });
    function sendType(type)
    {
        window.location.href="ahli_rekod_sumbangan.php?tahun="+type;

    }
</script>

</body>

</html>
