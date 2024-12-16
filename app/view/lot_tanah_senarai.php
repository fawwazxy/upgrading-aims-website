<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
//require "../model/lookup.php";
$status_tanah = $_GET['status_tanah'];
if (!isset($status_tanah) && $status_tanah == '') {
    $status_tanah = '1';
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
                <h1 class="page-header">Senarai Lot Tanah</h1>
            </div>
        </div>
        <div class="form-group" align="right">
        </div>

        <div class="form-group" align="right">
            <a href="lot_tanah_tambah.php"><button type="button" class="btn btn-primary">Tambah Baharu</button></a>
        </div>


        <!--
            <?include '../global/menu_keselamatan.php'?>
        -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Lot Tanah <?if($status_tanah=='1'){echo '<strong><font color="green">'.'Aktif'.'</font></strong>';}else{echo '<strong><font color="red">'.'Tidak Aktif'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;
                        <a href="lot_tanah_senarai.php?status_tanah=1">Aktif</a> &nbsp;|&nbsp;
                        <a href="lot_tanah_senarai.php?status_tanah=0">Tidak Aktif</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th>Nama PPK & Mukim</th>
                                <th width="15%">Daerah</th>
                                <th width="15%">Jajahan</th>
                                <th width="15%">Negeri</th>
                                <th width="15%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $data_tanah = getLotTanahList($status_tanah);
                            $i=1;
                            while($list_tanah = $data_tanah->fetch_assoc()) {
                                $status_text = "";
                                if ($list_tanah['status_tanah'] == '1') {
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
                                        <?if($list_tanah['kod_mukim']!=''){ echo '<b>'.$list_tanah['nama_ppk'].'</b>'.'&nbsp;-&nbsp;'.$list_tanah['mukim'];}?>
                                    </td>
                                    <td>
                                        <?if($list_tanah['kod_daerah']!=''){ echo $list_tanah['daerah'];}?>
                                    </td>
                                    <td>
                                        <?if($list_tanah['kod_jajahan']!=''){ echo $list_tanah['jajahan'];}?>
                                    </td>
                                    <td>
                                        <?if($list_tanah['kod_negeri']!=''){ echo $list_tanah['negeri'];}?>
                                    </td>
                                    </td>
                                    <td>
                                        <a href="lot_tanah_papar.php?id=<?echo $list_tanah['id']?>"><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                        <br><a href="lot_tanah_kemaskini.php?id=<?echo $list_tanah['id']?>"><button type="button" class="btn btn-primary">Kemaskini</button></a>
                                        <br><a onclick="nyahaktifLotTanah(<?echo $list_tanah['id'] ;?>,<?echo $list_tanah['status_tanah'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_tanah['id'];?>">
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

        <? include ('../global/footer.php'); ?>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
        function nyahaktifLotTanah(id,status_tanah){
            $.ajax({
                url: "../model/pengusaha_functions.php",
                type: "POST",
                data: {action:"nyahaktifLotTanah",id:id,status_tanah:status_tanah},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.location='lot_tanah_senarai.php?status_tanah=<?echo $status_tanah?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }


    </script>

</body>

</html>