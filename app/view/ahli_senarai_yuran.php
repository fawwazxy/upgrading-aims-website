<?php

include ('../controller/auth.php');
require "../model/ahli_functions.php";
require "../model/lookup.php";

?>
<?
$statact=$_GET['statact'];
$flagScreen=$_GET['tab'];
$tahun=$_GET['tahun'];
if(!isset($statact)){
    $statact="BD";
    $flagScreen="tab_1";
}
if(!isset($tahun)){
    $tahun=$date_year;
}
$sys = getSys(1)->fetch_assoc();


?>



<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>


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
                <h1 class="page-header">Yuran Ahli Tahun <?echo $tahun;?></h1>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4">

                    <select  required class="form-control" name="tahun" id="tahun">
                        <option value="">-- Pilih Tahun--</option>
                        <? echo getDropDownTahun($tahun) ;?>
                    </select>

                </div>
                <div class="panel-heading" align="right">
                    <a href="ahli_penyata_kutipan_yuran.php?tahun=<? echo $tahun;?>" target="_blank"><button class="btn btn-warning">Cetak Penyata</button></a>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Senarai Transaksi Bayaran Yuran</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Tarikh Transaksi</th>
                                <th>Maklumat Ahli</th>
                                <th>Maklumat Bayaran</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_ahli = getSenaraiBayaranYuran($tahun);
                            while($row_data_ahli = $data_ahli->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i;?></td>
                                    <td><? echo $row_data_ahli['created_date'];?></td>
                                    <td>
                                        <label class="control-label">No. Ahli : </label> <? echo $row_data_ahli['no_ahli'];?>
                                        <br><label class="control-label">Kategori Ahli : </label> <? echo $row_data_ahli['kategori_ahli'];?><br>
                                        <label class="control-label">Nama : </label> <? echo $row_data_ahli['nama'];?>
                                        <br><label class="control-label">No. Kad Pengenalan : </label> <? echo $row_data_ahli['nokp'];?>
                                        <br><label class="control-label">No. Telefon : </label> <? echo $row_data_ahli['notel'];?>

                                    </td>
                                    <td>
                                        <label class="control-label">Jum. Bayaran : </label> RM<? echo $row_data_ahli['jum_yuran'];?>
                                        <br><label class="control-label">Kaedah Bayaran : </label> <? echo $row_data_ahli['jenis_bayaran'];?>
                                        <br><label class="control-label">No. Rujukan : </label> <? echo $row_data_ahli['no_rujukkan'];?>
                                    </td>
                                    <td>
                                        <a class="view" target="blank" href="ahli_yuran_cetak.php?id=<?echo $row_data_ahli['id_yuran'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Resit</button></a>
                                        <br><a href="#myModal2" class="btn btn-primary" data-toggle="modal" data-id="<? echo $row_data_ahli['id_yuran'];?>" data-nokp="<? echo $row_data_ahli['nokp'];?>">Kemaskini</a>
                                        <br><a i class="fa fa-whatsapp" style="font-size:48px;color:green" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_ahli['notel']; ?>&text=<? echo '*'.$sys['sys_name'].'::Resit Bayaran Yuran Keahlian*';?>%0aNama : *<?echo $row_data_ahli['nama'];?>*%0aNo. Ahli : *<?echo $row_data_ahli['no_ahli'];?>*%0aResit bayaran yuran keahlian anda telah sedia dijana. Sila klik link <?echo $sys['sys_domain'].'/app/view/ahli_yuran_cetak.php';?>?id=<?echo $row_data_ahli['id_yuran'];?> bagi paparan resit anda. %0aTerima kasih.')"></a>
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
                            data:{id_yuran:rowid,nokp:nokp_ahli},
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
        window.location.href="ahli_senarai_yuran.php?tahun="+type;

    }
</script>

</body>

</html>
