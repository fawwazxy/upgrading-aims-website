<?php

include ('../controller/auth.php');
require "../model/ahli_functions.php";
require "../model/lookup.php";

?>
<?
$status=$_GET['status'];
$tahun=$_GET['tahun'];

if(!isset($tahun)){
    $tahun=$date_year;
}
if(!isset($status)){
    $status=0;
}
$sys = getSys(1)->fetch_assoc();


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
    <link href="../../js/jquery/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <script src="../../js/jquery/jquery-ui.min.js"></script>


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
    <style>

        .ui-autocomplete {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1510 !important;
            float: left;
            display: none;
            min-width: 160px;
            width: 160px;
            padding: 4px 0;
            margin: 2px 0 0 0;
            list-style: none;
            background-color: #ffffff;
            border-color: #ccc;
            border-color: rgba(0, 0, 0, 0.2);
            border-style: solid;
            border-width: 1px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding;
            background-clip: padding-box;
            *border-right-width: 2px;
            *border-bottom-width: 2px;
        }
        .ui-menu-item > a.ui-corner-all {
            display: block;
            padding: 3px 15px;
            clear: both;
            font-weight: normal;
            line-height: 18px;
            color: #555555;
            white-space: nowrap;
            text-decoration: none;
        }
        .ui-state-hover, .ui-state-active {
            color: #ffffff;
            text-decoration: none;
            background-color: #0088cc;
            border-radius: 0px;
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            background-image: none;
        }
        td.headColor {
            background-color: #E16300;
            color: white;
            font-weight: bold;
        }
    </style>

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
                <h1 class="page-header">Penggunaan Biaya Khairat Kematian</h1>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">



                <div class="panel panel-red">
                    <!-- /.panel-heading -->
                    <div class="panel-heading">
                        <center><b>ANALISA PENGGUNAAN BIAYA KHAIRAT kEMATIAN BAGI TAHUN <? echo $tahun;?></b></center>
                    </div>
                    <table width="100%" class="table  table-bordered">


                        <tbody>
                        <tr>
                            <td align="center" class="headColor">JUM. PENGGUNAAN</td>
                        </tr>
                        <tr>
                            <td align="center"><strong><font size="7">RM<? echo number_format(getTotalBiayaKhairatByTahun($tahun),2,'.',',');?></font></strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-4">

                    <select  required class="form-control" name="tahun" id="tahun">
                        <option value="">-- Pilih Tahun--</option>
                        <? echo getDropDownTahunBiayaKhairat($tahun) ;?>
                    </select>

                </div>
                <div class="panel-heading" align="right">
                    <a href="#myModal2" class="btn btn-primary" data-toggle="modal" data-id="0">Tambah</a>
                    <a href="ahli_penyata_biaya_khairat.php?tahun=<? echo $tahun;?>" target="_blank"><button class="btn btn-warning">Cetak Penyata</button></a>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Maklumat Ahli</th>
                                <th>Maklumat Bayaran</th>
                                <th>Nota</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_ahli = getSenaraiBiayaKhairat($tahun);
                            while($row_data_ahli = $data_ahli->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i;?></td>
                                    <td>
                                        <label class="control-label">No. Ahli : </label> <? echo $row_data_ahli['no_ahli'];?>
                                        <br><label class="control-label">Kategori Ahli : </label> <? echo $row_data_ahli['kategori_ahli'];?><br>
                                        <label class="control-label">Nama : </label> <? echo $row_data_ahli['nama'];?>
                                        <br><label class="control-label">No. Kad Pengenalan : </label> <? echo $row_data_ahli['nokp'];?>
                                        <br><label class="control-label">No. Telefon : </label> <? echo $row_data_ahli['notel'];?>

                                    </td>
                                    <td>
                                        <label class="control-label">Jumlah : </label> RM<? echo $row_data_ahli['jum_khairat'];?>
                                        <br>
                                        <label class="control-label">Tarikh : </label> <? echo $row_data_ahli['tarikh'];?>
                                    </td>
                                    <td><? echo $row_data_ahli['nota_biaya'];?></td>
                                    <td>

                                        <a href="#myModal2" class="btn btn-info" data-toggle="modal" data-id="<? echo $row_data_ahli['id_biaya'];?>">Kemaskini</a>

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

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Biaya Khairat</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');

                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'ahli_tambah_edit_biaya_khairat.php',
                            data:{id:rowid,tahun:"<? echo $tahun;?>",created_by:"<? echo $_SESSION['SESS_NOKP'];?>"},
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
            responsive: true
        });



    });

</script>

</body>

</html>
