<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
//require "../model/lookup.php";
$id_pengusaha = $_GET['id_pengusaha'];
$pemilik = $_GET['nokp'];
$nokp = $_GET['nokp'];
// $status_lot_tanah = $_GET['status_lot_tanah'];
// if (!isset($status_lot_tanah) && $status_lot_tanah == '') {
//     $status_lot_tanah = '1';
// }
$data_pengusaha = getPengusahaInfoById($nokp)->fetch_assoc();
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
                <h1 class="page-header">Senarai Lot Tanah</h1>
                <label>Nama Pengusaha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['nama']?><br>
                <label>No. Kad Pengenalan &nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['nokp']?><br>
                <label>No. Pengusaha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['no_pengusaha']?><br>
                <label>No. Ahli &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['no_ahli']?>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>

        <div class="form-group" align="right">
            <a href="pengusaha_lot_tanah_tambah.php?nokp=<?echo $pemilik;?>"><button type="button" class="btn btn-primary">Tambah Baharu</button></a>
            <a href="pengusaha_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Lot Tanah <!-- <?if($status_lot_tanah=='1'){echo '<strong><font color="green">'.'Aktif'.'</font></strong>';}else{echo '<strong><font color="red">'.'Tidak Aktif'.'</font></strong>';}?> --></label>&nbsp;&nbsp;&nbsp;
                        <!-- <a href="pengusaha_lot_tanah_senarai.php?id_pengusaha=<?echo $id_pengusaha;?>&nokp=<?echo $pemilik;?>&status_lot_tanah=1">Aktif</a> &nbsp;|&nbsp;
                        <a href="pengusaha_lot_tanah_senarai.php?id_pengusaha=<?echo $id_pengusaha;?>&nokp=<?echo $pemilik;?>&status_lot_tanah=0">Tidak Aktif</a>  -->
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="12%">Kod Lot Tanah</th>
                                <th width="40%">Maklumat Lot Tanah</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $lot_tanah = getPengusahaLotTanahListByNokp($pemilik);
                            $i=1;
                            while($list_lot_tanah = $lot_tanah->fetch_assoc()) {
                                // $status_text = "";
                                //     if ($list_lot_tanah['status_lot_tanah'] == '1') {
                                //         $status_text = "Nyah Aktif";
                                //         $color = "danger";
                                //     }
                                //     else {
                                //         $status_text = "Aktif";
                                //         $color = "success";          kod,namappk&mukim,daerah,jajahan,negeri
                                //     }
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <?if($list_lot_tanah['kod_tanah']!=''){ echo '<b>'.$list_lot_tanah['kod_tanah'].'</b>';}?>
                                    </td>
                                    <td>
                                        <?if($list_lot_tanah['kod_mukim']!=''){ echo '<label class="control-label">Nama PPK'.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'<b>:&nbsp;</b>'.$list_lot_tanah['nama_ppk'].'<br><label class="control-label">Mukim'.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'<b>:&nbsp;</b>'.$list_lot_tanah['mukim'];}?><br>
                                        <?if($list_lot_tanah['kod_daerah']!=''){ echo '<label class="control-label">Daerah'.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'<b>:&nbsp;</b>'.$list_lot_tanah['daerah'];}?><br>
                                        <?if($list_lot_tanah['kod_jajahan']!=''){ echo '<label class="control-label">Jajahan'.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'<b>:&nbsp;</b>'.$list_lot_tanah['jajahan'];}?><br>
                                        <?if($list_lot_tanah['kod_negeri']!=''){ echo '<label class="control-label">Negeri'.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'<b>:&nbsp;</b>'.$list_lot_tanah['name'];}?>
                                    </td>
                                    <td>
                                        <a href="#myModal2" data-toggle="modal" data-id="<? echo $list_lot_tanah['id'];?>"><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                        <!-- <br><a onclick="nyahAktifPengusahaLotTanah(<?echo $list_lot_tanah['id'] ;?>,<?echo $list_lot_tanah['status_lot_tanah'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a> -->
                                        <input type="hidden" id="row_id" value="<?echo $list_lot_tanah['id'];?>"></td>
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
                    <h4 class="modal-title" id="myModalLabel2">Maklumat Lot Tanah</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'pengusaha_lot_tanah_info.php',
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

        function nyahAktifPengusahaLotTanah(id,status_lot_tanah){
            $.ajax({
                url: "../model/pengusaha_functions.php",
                type: "POST",
                data: {action:"nyahAktifPengusahaLotTanah",id:id,status_lot_tanah:status_lot_tanah},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.location='pengusaha_lot_tanah_senarai.php?id_pengusaha=<?echo $id_pengusaha?>&nokp=<?echo $pemilik?>&status_lot_tanah=<?echo $status_lot_tanah?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }


    </script>

</body>

</html>