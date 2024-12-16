<?php

include ('../controller/auth.php');

require "../model/agromart_functions.php";
require "../model/lookup.php";

$id_agencies = $_GET['id'];
$id = $_GET['id'];
$status = $_GET['status'];
if (!isset($status) && $status == '') {
    $status = '1';
}
$sys = getSys(1)->fetch_assoc();
$agensi_info = getAgensiInfoById($id)->fetch_assoc();

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>
    <?php
    echo "Watch the page reload itself in 10 second!";
    ?>
    </body> -->

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
                <h1 class="page-header">Senarai Pembekal</h1>
                <h4><b><?echo $agensi_info['nama'];?></b></h4>
                <h4><b><?echo $agensi_info['no_pendaftaran'];?></b></h4>
                <h4><b><?echo $agensi_info['negeri'];?></b></h4>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>
        <div class="form-group" align="right">
            <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='agromart_admin_pembekal_tambah.php?id=<?echo $id;?>&id_agencies=<?echo $id_agencies;?>'">Tambah Baharu</button>
            <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='agromart_admin_agensi_senarai.php'">Kembali</button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Pembekal <?if($status=='1'){echo '&nbsp;<strong><font color="green">'.'Aktif'.'</font></strong>';}else{echo '&nbsp;<strong><font color="red">'.'Tidak Aktif'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;
                        <a href="agromart_admin_pembekal_senarai.php?id=<?echo $id_agencies;?>&status=1">Aktif</a> &nbsp;|&nbsp;
                        <a href="agromart_admin_pembekal_senarai.php?id=<?echo $id_agencies;?>&status=0">Tidak Aktif</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil</th>
                                <th width="10%">Gambar</th>
                                <th width="25%">Maklumat Peribadi</th>
                                <th width="12%">No. Telefon</th>
                                <th width="10%">Status</th>
                                <th width="10%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $pembekal = getPembekalList($id_agencies,$status);
                            $i=1;
                            while($list_pembekal = $pembekal->fetch_assoc()) {
                                $status_text = "";
                                if ($list_pembekal['status'] == '1') {
                                    $status_text = "Nyah Aktif";
                                    $color = "danger";
                                }
                                else {
                                    $status_text = "Aktif";
                                    $color = "success";
                                }
                                ?>
                                <tr>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $list_pembekal['id'];?>"><?echo $i++;?></td>
                                    <td align="center" href="#myModal1" data-toggle="modal" data-id="<? echo $list_pembekal['id'];?>">
                                        <?if($list_pembekal['photo'] != ''){echo '<img width="100" height="130" src="data:image/jpeg;base64,'.base64_encode( $list_pembekal['photo'] ).'"/>';
                                        }?>
                                    </td>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $list_pembekal['id'];?>">
                                        <label class="control-label">Nama : </label>
                                        <br><?echo $list_pembekal['nama'];?>
                                        <br><label class="control-label">No. Kad Pengenalan : </label>
                                        <br><?echo $list_pembekal['nokp'];?>
                                        <br><label class="control-label">Alamat : </label>
                                        <br><?echo $list_pembekal['alamat'];?>
                                    </td>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $list_pembekal['id'];?>"><b><font color="brown" size="4"><?echo $list_pembekal['notel'];?></font></b>&nbsp;<a i class="fa fa-whatsapp" style="font-size:25px;color:green" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_ahli['notel']; ?>&text=<? echo '*'.$sys['sys_name'].'::Resit Bayaran Yuran Keahlian*';?>%0aNama : *<?echo $row_data_ahli['nama'];?>*%0aNo. Ahli : *<?echo $row_data_ahli['no_ahli'];?>*%0aResit bayaran yuran keahlian anda telah sedia dijana. Sila klik link <?echo $sys['sys_domain'].'/app/view/ahli_yuran_cetak.php';?>?id=<?echo $row_data_ahli['id_yuran'];?> bagi paparan resit anda. %0aTerima kasih.')"></a></td>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $list_pembekal['id'];?>">
                                        <?if($list_pembekal['status'] == '1')
                                        {
                                            echo '<b><font color="green">'.'AKTIF'.'</font></b>';
                                        }
                                        else {
                                            echo '<b><font color="red">'.'TIDAK AKTIF'.'</font></b>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?if($list_pembekal['status'] == '1'){?>
                                        <a href="agromart_admin_pembekal_hasiltani_senarai.php?id=<?echo $list_pembekal['id'] ;?>&id_agencies=<?echo $list_pembekal['id_agencies'] ;?>&nokp=<?echo $list_pembekal['nokp'];?>"><button type="button" class="btn btn-warning">Daftar Produk</button></a><?}?>
                                        <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_pembekal['id'];?>"><button type="button" class="btn btn-info">Maklumat Pembekal</button></a>
                                        <?if($list_pembekal['status'] == '1'){?>
                                            <br><a href="agromart_admin_pembekal_kemaskini.php?id=<?echo $list_pembekal['id'] ;?>&id_seller=<?echo $id;?>&id_agencies=<?echo $list_pembekal['id_agencies'] ;?>"><button type="button" class="btn btn-primary">Kemaskini</button></a><?}?>
                                        <br><a onclick="nyahAktifPembekal(<?echo $list_pembekal['id'] ;?>,<?echo $list_pembekal['status'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                        <input id="rowid" name="rowid" type="hidden" value="<?echo $list_pembekal['id'];?>"/>
                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Maklumat Peribadi Pembekal</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'agromart_admin_pembekal_info.php',
                                data:{id:rowid,id_agencies:<?echo $id_agencies;?>},
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

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

        function nyahAktifPembekal(id,status){
            $.ajax({
                url: "../model/agromart_functions.php",
                type: "POST",
                data: {action:"nyahAktifPembekal",id:id,id_agencies:<?echo $id_agencies;?>,status:status},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);

                    window.location='agromart_admin_pembekal_senarai.php?id=<?echo $id_agencies;?>&status=<?echo $status;?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

    </script>

</body>

</html>