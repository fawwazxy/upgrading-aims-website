<?php

include ('../controller/auth.php');

require "../model/lawatan_functions.php";
require "../model/lookup.php";

$status_masuk_keluar = $_GET['status_masuk_keluar'];
if (!isset($status_masuk_keluar) && $status_masuk_keluar == '') {
    $status_masuk_keluar = '1';
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
                <h1 class="page-header">Senarai Pelawat</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>

        <div class="form-group" align="right">
            <a href="lawatan_pelawat_tambah.php"><button type="button" class="btn btn-primary">Tambah Baharu</button></a>
            <a class="view" href="<?echo $sys['sys_domain']?>/app/view/lawatan_pelawat_imbas_masuk.php" target="blank"><button type="button" class="btn btn-success">Terminal Imbasan Masuk</button></a>
            <a class="view" href="<?echo $sys['sys_domain']?>/app/view/lawatan_pelawat_imbas_keluar.php" target="blank"><button type="button" class="btn btn-danger">Terminal Imbasan Keluar</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Pelawat <?if($status_masuk_keluar=='1'){echo '<strong><font color="green">'.'Masuk'.'</font></strong>';}else{echo '<strong><font color="red">'.'Keluar'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;
                        <a href="lawatan_pelawat_senarai.php?status_masuk_keluar=1">Masuk</a> &nbsp;|&nbsp;
                        <a href="lawatan_pelawat_senarai.php?status_masuk_keluar=0">Keluar</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="35%">Maklumat Pelawat</th>
                                <th width="30%">Maklumat Staf</th>
                                <th width="30%">Masa Lawatan</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $pelawat = getPelawatList($status_masuk_keluar);
                            $i=1;
                            while($list_pelawat = $pelawat->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td href="#myModal2" data-toggle="modal" data-id="<? echo $list_pelawat['id_lawatan'];?>"><?echo $i++;?></td>
                                    <td href="#myModal2" data-toggle="modal" data-id="<? echo $list_pelawat['id_lawatan'];?>">
                                        <label class="control-label">Kod Kad :</label>
                                        <br><?if($list_pelawat['kod_kad']!=''){ echo '<b>'.$list_pelawat['kod_kad'].'</b>'.'&nbsp;-&nbsp;'.$list_pelawat['nama_kad'];}?>
                                        <br><label class="control-label">Nama Pelawat :</label>
                                        <br><?if($list_pelawat['nama']!=''){ echo $list_pelawat['nama'];}?>
                                        <br><label class="control-label">No. Kad Pengenalan :</label>
                                        <br><?if($list_pelawat['nokp']!=''){ echo $list_pelawat['nokp'];}?>
                                        <br><label class="control-label">No. Telefon :</label>
                                        <br><?if($list_pelawat['notel']!=''){ echo '+6'.$list_pelawat['notel'];}?>
                                        <?if($list_pelawat['status_masuk_keluar'] == '0'){?>
                                            <?if($list_pelawat['status_kad']== '0'){?>
                                                <br><label class="control-label">Catatan :</label>
                                                <br><?echo '<b><font color="red">'.'Kad Hilang / Kad Rosak'.'</b></font>';}}?>
                                        <!-- <br><label class="control-label">Nama Syarikat :</label>
                                        <br><?if($list_pelawat['nama_company']!=''){ echo $list_pelawat['nama_company'];}?>
                                        <br><label class="control-label">Jenis Kenderaan :</label>
                                        <br><?if($list_pelawat['jenis_kenderaan']!=''){ echo $list_pelawat['jenis_kenderaan'];}?>
                                        <br><label class="control-label">No. Kenderaan :</label>
                                        <br><?if($list_pelawat['no_kenderaan']!=''){ echo $list_pelawat['no_kenderaan'];}?> -->
                                    <td href="#myModal2" data-toggle="modal" data-id="<? echo $list_pelawat['id_lawatan'];?>">
                                        <label class="control-label">Nama Staf :</label>
                                        <br><?if($list_pelawat['name']!=''){ echo $list_pelawat['name'];}?>
                                        <br><label class="control-label">No. Kad Pengenalan :</label>
                                        <br><?if($list_pelawat['noic']!=''){ echo $list_pelawat['noic'];}?>
                                    </td>
                                    <td><label class="control-label">Masuk :</label>
                                        <br><?if($list_pelawat['tarikh_masa_masuk']!=''){ echo '<b><font color ="blue">'.$list_pelawat['tarikh_masa_masuk'].'</font></b>';}?>
                                        <?if($list_pelawat['status_masuk_keluar'] == '0') {?>
                                            <br><label class="control-label">Keluar :</label>
                                            <br><?if($list_pelawat['tarikh_masa_keluar']!=''){ echo '<b><font color ="red">'.$list_pelawat['tarikh_masa_keluar'].'</font></b>';}?>
                                            <br><label class="control-label">Jum. Masa Lawatan :</label>
                                            <br><?echo '<b><font color ="purple">'.$list_pelawat['jum_masa_lawatan'].'</font></b>';?>
                                        <?}?>
                                    </td>
                                    <td>
                                        <a href="lawatan_pelawat_papar.php?id_lawatan=<?echo $list_pelawat['id_lawatan']?>"><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                        <?if($list_pelawat['status_masuk_keluar'] == '1'){?>
                                            <br><a onclick="updateStatusKeluarByList(<?echo $list_pelawat['id_lawatan'] ;?>,<?echo $list_pelawat['status_masuk_keluar'] ;?>)" ><button type="button" class="btn btn-danger">Sahkan Keluar</button></a><?}?>

                                        <?if($list_pelawat['status_kad']== '1'){?>
                                        <?}else {?>
                                            <?if($list_pelawat['status_masuk_keluar'] == '0'){?>
                                                <br><a onclick="updateStatusKadTidakHilang(<?echo $list_pelawat['id_lawatan'] ;?>,<?echo $list_pelawat['status_kad'] ;?>)" ><button type="button" class="btn btn-success">Kad Dijumpai</button></a><?}}?>

                                        <?if($list_pelawat['status_kad']== '0'){?>
                                        <?}else {?>
                                            <?if($list_pelawat['status_masuk_keluar'] == '0'){?>
                                                <br><a onclick="updateStatusKadHilang(<?echo $list_pelawat['id_lawatan'] ;?>,<?echo $list_pelawat['status_kad'] ;?>)" ><button type="button" class="btn btn-danger">Kehilangan Kad</button></a><?}}?>

                                        <?if($list_pelawat['status_masuk_keluar'] == '1'){?>
                                            <br><a class="view" target="blank" href="lawatan_slip_cetak.php?id_lawatan=<?echo $list_pelawat['id_lawatan'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Slip</button></a><?}?>
                                        <?if($list_pelawat['status_masuk_keluar'] == '1'){?>
                                            <br><a href="lawatan_pelawat_kemaskini.php?id_lawatan=<?echo $list_pelawat['id_lawatan']?>"><button type="button" class="btn btn-primary">Kemaskini</button></a><?}?>
                                        <br><a i class="fa fa-whatsapp" style="font-size:48px;color:green" onclick="return popitup('https://web.whatsapp.com/send?phone=6<?php echo $list_pelawat['notel']; ?>&text=<? echo "*:: PERHATIAN ::*"?>%0aNama Pelawat : *<?echo $list_pelawat['nama'];?>*%0aNo. Kad Pengenalan : *<?echo $list_pelawat['nokp'];?>*')"></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_pelawat['id_lawatan'];?>">
                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Maklumat Pelawat</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'lawatan_pelawat_info.php',
                                data:{id_lawatan:rowid},
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

        function updateStatusKeluarByList(id_lawatan,status_masuk_keluar){
            $.ajax({
                url: "../model/lawatan_functions.php",
                type: "POST",
                data: {action:"updateStatusKeluarByList",id_lawatan:id_lawatan,status_masuk_keluar:status_masuk_keluar},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.location='lawatan_pelawat_senarai.php?status_masuk_keluar=<?echo $status_masuk_keluar?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        function updateStatusKadTidakHilang(id_lawatan){
            $.ajax({
                url: "../model/lawatan_functions.php",
                type: "POST",
                data: {action:"updateStatusKadTidakHilang",id_lawatan:id_lawatan},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.location='lawatan_pelawat_senarai.php?status_masuk_keluar=0';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        function updateStatusKadHilang(id_lawatan){
            $.ajax({
                url: "../model/lawatan_functions.php",
                type: "POST",
                data: {action:"updateStatusKadHilang",id_lawatan:id_lawatan},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.location='lawatan_pelawat_senarai.php?status_masuk_keluar=0';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

    </script>

</body>

</html>