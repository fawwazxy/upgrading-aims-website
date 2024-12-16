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
                <h1 class="page-header">Daftar / Kutipan Khairat Kematian</h1>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">



                <div class="panel panel-red">
                    <!-- /.panel-heading -->
                    <div class="panel-heading">
                        <center><b>ANALISA DAFTAR / KUTIPAN KHAIRAT KEMATIAN BAGI TAHUN <? echo $tahun;?></b></center>
                    </div>
                    <table width="100%" class="table  table-bordered">


                        <tbody>
                        <tr>
                            <td align="center" class="headColor">JUM. TELAH BAYAR</td>
                            <td align="center" class="headColor">JUM. BELUM BAYAR</td>
                        </tr>
                        <tr>
                            <td align="center"><strong><font size="7" color="green">RM<? echo number_format(getTotalKutipanKhairatTelahBayarByTahun($tahun),2,'.',',') ;?></font></strong></td>
                            <td align="center"><strong><font size="7" color="red">RM<? echo number_format(getTotalKutipanKhairatBelumBayarByTahun($tahun),2,'.',',') ;?></font></strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-4">

                    <select  required class="form-control" name="tahun" id="tahun">
                        <option value="">-- Pilih Tahun--</option>
                        <? echo getDropDownTahunKhairat($tahun) ;?>
                    </select>

                </div>
                <div class="panel-heading" align="right">
                    <a href="ahli_penyata_kutipan_khairat.php?tahun=<? echo $tahun;?>" target="_blank"><button class="btn btn-warning">Cetak Penyata</button></a>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Senarai Transaksi Kutipan Khairat
                            <a href="ahli_senarai_kutipan_khairat.php?tahun=<? echo $tahun;?>&status=0">Belum Bayar &nbsp;</a>|
                            <a href="ahli_senarai_kutipan_khairat.php?tahun=<? echo $tahun;?>&status=1">Telah Bayar</a>


                        </label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Maklumat Ahli</th>
                                <th>Maklumat Bayaran</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_ahli = getSenaraiAhliKhairat($tahun,$status);
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
                                        <?
                                        if ($status == 1) {
                                            echo "<font color=green><strong>SUDAH DIBAYAR</strong></font>";?>
                                            <br><label class="control-label">Jumlah : </label> RM<? echo $row_data_ahli['jum_khairat'];?>
                                            <br>
                                            <label class="control-label">Tarikh : </label> <? echo $row_data_ahli['tarikh'];?>

                                        <?}
                                        else {
                                            echo "<font color=red><strong>TIADA MAKLUMAT KUTIPAN</strong></font>";
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?
                                        if ($status == 0) {?>
                                            <a href="#myModal2" class="btn btn-primary" data-toggle="modal" data-id="0" data-nokp="<? echo $row_data_ahli['nokp'];?>" data-nama="<? echo $row_data_ahli['nama'];?>" >Daftar Kutipan</a>
                                        <?}else{?>
                                            <a href="#myModal2" class="btn btn-info" data-toggle="modal" data-id="<? echo $row_data_ahli['id_kutipan'];?>" data-nokp="<? echo $row_data_ahli['nokp'];?>" data-nama="<? echo $row_data_ahli['nama'];?>">Kemaskini</a>
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

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Kutipan Khairat</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        var nokp_ahli = $(e.relatedTarget).data('nokp');
                        var nama_ahli = $(e.relatedTarget).data('nama');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'ahli_tambah_edit_kutipan_khairat.php',
                            data:{id:rowid,nokp:nokp_ahli,nama:nama_ahli,tahun:"<? echo $tahun;?>",status:"<? echo $status;?>",created_by:"<? echo $_SESSION['SESS_NOKP'];?>"},
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
        $("#tahun").change(function(){
            var selected_tahun=$(this).val();
            sendType(selected_tahun);
        });

    });
    function sendType(type)
    {
        window.location.href="ahli_senarai_kutipan_khairat.php?tahun="+type+"&status=<? echo $status;?>";

    }
</script>

</body>

</html>
