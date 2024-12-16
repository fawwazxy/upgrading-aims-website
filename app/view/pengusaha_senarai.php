<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
//require "../model/lookup.php";
$status_pengusaha = $_GET['status_pengusaha'];
if (!isset($status_pengusaha) && $status_pengusaha == '') {
    $status_pengusaha = '1';
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
                <h1 class="page-header">Senarai Pengusaha</h1>
            </div>
        </div>
        <div class="form-group" align="right">
        </div>

        <div class="form-group" align="right">
            <a href="pengusaha_tambah.php"><button type="button" class="btn btn-primary">Tambah Baharu</button></a>
        </div>


        <!--
            <?include '../global/menu_keselamatan.php'?>
        -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Pengusaha <?if($status_pengusaha=='1'){echo '<strong><font color="green">'.'Aktif'.'</font></strong>';}else{echo '<strong><font color="red">'.'Tidak Aktif'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;
                        <a href="pengusaha_senarai.php?status_pengusaha=1">Aktif</a> &nbsp;|&nbsp;
                        <a href="pengusaha_senarai.php?status_pengusaha=0">Tidak Aktif</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="40%">Maklumat Pengusaha</th>
                                <th width="12%">Jumlah Lot Tanah</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $data_pengusaha = getPengusahaList($status_pengusaha);
                            $i=1;
                            while($list_pengusaha = $data_pengusaha->fetch_assoc()) {
                                $status_text = "";
                                if ($list_pengusaha['status_pengusaha'] == '1') {
                                    $status_text = "Nyah Aktif";
                                    $color = "danger";
                                }
                                else {
                                    $status_text = "Aktif";
                                    $color = "success";
                                }
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <label class="control-label">Nama Pengusaha</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?if($list_pengusaha['nama']!=''){ echo '<b>:'.'</b>'.'&nbsp;'.$list_pengusaha['nama'];}?>
                                        <br><label class="control-label">No. Kad Pengenalan</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?if($list_pengusaha['nokp']!=''){ echo '<b>:'.'</b>'.'&nbsp;'.$list_pengusaha['nokp'];}?>
                                        <br><label class="control-label">No. Telefon</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?if($list_pengusaha['notel']!=''){ echo '<b>:'.'</b>'.'&nbsp;'.'+6'.$list_pengusaha['notel'];}?>
                                        <br><label class="control-label">No. Pengusaha</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?if($list_pengusaha['no_pengusaha']!=''){ echo '<b>:'.'</b>'.'&nbsp;'.$list_pengusaha['no_pengusaha'];}?>
                                        <br><label class="control-label">No. Ahli</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?if($list_pengusaha['no_ahli']!=''){ echo '<b>:'.'</b>'.'&nbsp;'.$list_pengusaha['no_ahli'];}?>
                                        <div align="right">
                                            <?if($list_pengusaha['bil_lot_tanah'] != '0') {?>
                                            <a href="#myModal2" data-toggle="modal" data-id="<? echo $list_pengusaha['nokp'];?>"><button type="button" class="btn btn-info">Papar Lot Tanah</button></a><?}?>
                                        </div>
                                    </td>
                                    <td><center>
                                            <?if($list_pengusaha['bil_lot_tanah'] != '0') {?>
                                            <a href="#myModal2" class="btn btn-link" data-toggle="modal" data-id="<? echo $list_pengusaha['nokp'];?>"><?}?><strong><font color="blue" size="5">
                                                        <?echo $list_pengusaha['bil_lot_tanah'] ;?></font></strong></a>
                                        </center></td>

                                    <td>
                                        <a href="pengusaha_lot_tanah_senarai.php?nokp=<?echo $list_pengusaha['nokp']?>"><button type="button" class="btn btn-success">Tambah Lot Tanah</button></a>
                                        <br><a href="pengusaha_papar.php?id_pengusaha=<?echo $list_pengusaha['id_pengusaha']?>"><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                        <br><a href="pengusaha_kemaskini.php?id_pengusaha=<?echo $list_pengusaha['id_pengusaha']?>"><button type="button" class="btn btn-primary">Kemaskini</button></a>
                                        <br><a onclick="nyahaktifPengusaha(<?echo $list_pengusaha['id_pengusaha'] ;?>,<?echo $list_pengusaha['status_pengusaha'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_pengusaha['id_pengusaha'];?>">
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
                    <h4 class="modal-title" id="myModalLabel2">Senarai Lot Tanah</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'pengusaha_lot_tanah_details.php',
                                data:{nokp:rowid},
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

        function nyahaktifPengusaha(id_pengusaha,status_pengusaha){
            $.ajax({
                url: "../model/pengusaha_functions.php",
                type: "POST",
                data: {action:"nyahaktifPengusaha",id_pengusaha:id_pengusaha,status_pengusaha:status_pengusaha},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.location='pengusaha_senarai.php?status_pengusaha=<?echo $status_pengusaha?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

    </script>

</body>

</html>