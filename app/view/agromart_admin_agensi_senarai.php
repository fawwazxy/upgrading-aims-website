<?php
include ('../controller/auth.php');
require "../model/agromart_functions.php";
require "../model/lookup.php";

$status = $_GET['status'];
if (!isset($status) && $status == '') {
    $status = '1';
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Agensi</h1>
            </div>
        </div>
        <div class="form-group" align="right">
            <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='agromart_admin_agensi_tambah.php'">Tambah Baharu</button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Agensi <?if($status=='1'){echo '&nbsp;<strong><font color="green">'.'Aktif'.'</font></strong>';}else{echo '&nbsp;<strong><font color="red">'.'Tidak Aktif'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;
                        <a href="agromart_admin_agensi_senarai.php?status=1">Aktif</a> &nbsp;|&nbsp;
                        <a href="agromart_admin_agensi_senarai.php?status=0">Tidak Aktif</a>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 7%;">Bil</th>
                                <th style="width: 10%;">Logo</th>
                                <th style="width: 22%;">Info Agensi</th>
                                <th style="width: 12%;">No. Telefon</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 10%;">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $agensi = getAgensiList($status);
                            while($list_agensi = $agensi->fetch_assoc()) {
                                $status_text = "";
                                if ($list_agensi['status'] == '1') {
                                    $status_text = "Nyah Aktif";
                                    $color = "danger";
                                }
                                else {
                                    $status_text = "Aktif";
                                    $color = "success";
                                }
                                ?>
                                <tr>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $list_agensi['id'];?>"><?echo $i++;?></td>
                                    <td align="center" style="text-align: center" href="#myModal1" data-toggle="modal" data-id="<? echo $list_agensi['id'];?>">
                                        <?if($list_agensi['logo'] != ''){echo '<img width="100" height="130" src="data:image/jpeg;base64,'.base64_encode( $list_agensi['logo'] ).'"/>';
                                        }?>
                                    </td>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $list_agensi['id'];?>">
                                        <label class="control-label">Nama : </label>
                                        <br><?echo $list_agensi['nama'];?>
                                        <br><label class="control-label">No. Pendaftaran : </label>
                                        <br><?echo $list_agensi['no_pendaftaran'];?>
                                        <br><label class="control-label">Alamat : </label>
                                        <br><?echo $list_agensi['alamat'];?>
                                    </td>
                                    <td><b><span style="color: brown; font-size: medium; "><?echo $list_agensi['notel'];?></span></b>&nbsp;<a i class="fa fa-whatsapp" style="font-size:25px;color:green" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $list_agensi['notel']; ?>&text=<? echo '*'.$sys['sys_pos'].'::Maklumat Pendaftaran Akaun*';?>%0aAssalamualaikum w.b.t,%0aSukacita dimaklumkan akaun *<?echo $list_agensi['nama'];?>* telah berjaya didaftarkan.%0aUntuk mulakan akses *<?echo $sys['sys_pos'];?>* ,sila ke link <?echo $sys['sys_domain'].'/pointofsale/view/login.php';?>%0aMaklumat akaun adalah seperti berikut : %0aID Pengguna : *<?echo $list_agensi['username'];?>*%0aKatalaluan : *<?echo $list_agensi['password'];?>*%0aSekian, terima kasih.')"></a></td>
                                    <td href="#myModal1" data-toggle="modal" data-id="<? echo $list_agensi['id'];?>">
                                        <?if($list_agensi['status'] == '1')
                                        {
                                            echo '<b><span style="color: green; ">' .'AKTIF'. '</span></b>';
                                        }
                                        else {
                                            echo '<b><span style="color: red; ">' .'TIDAK AKTIF'. '</span></b>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <!-- <?if($list_agensi['status'] == '1'){?>
                                            <a href="agromart_admin_operator_senarai.php?id=<?echo $list_agensi['id'] ;?>"><button type="button" class="btn btn-primary">Daftar Admin/Operator</button></a>
                                            <a href="agromart_admin_pembekal_senarai.php?id=<?echo $list_agensi['id'] ;?>"><button type="button" class="btn btn-warning">Daftar Pembekal</button></a><?}?> -->
                                        <?if($list_agensi['status'] == '1'){?>
                                        <a class="view" href="../../pointofsale/view/login.php?id=<?echo $list_agensi['id'];?>" target="blank"><button type="button" class="btn btn-warning">Log Masuk</button></a><?}?>
                                        <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_agensi['id'];?>"><button type="button" class="btn btn-info">Info Agensi</button></a>
                                        <?if($list_agensi['status'] == '1'){?>
                                            <br><a href="agromart_admin_agensi_kemaskini.php?id=<?echo $list_agensi['id'] ;?>"><button type="button" class="btn btn-primary">Kemaskini</button></a><?}?>
                                        <br><a onclick="nyahAktifAgensi(<?echo $list_agensi['id'] ;?>,<?echo $list_agensi['status'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                        <input id="rowid" name="rowid" type="hidden" value="<?echo $list_agensi['id'];?>"/>
                                    </td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Info Agensi</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'agromart_admin_agensi_info.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
    function nyahAktifAgensi(id,status){
        $.ajax({
            url: "../model/agromart_functions.php",
            type: "POST",
            data: {action:"nyahAktifAgensi",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='agromart_admin_agensi_senarai.php?status=<?echo $status;?>';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>
</body>
</html>