<?php

include ('../controller/auth.php');

require "../model/jejakasnaf_functions.php";
require "../model/lookup.php";

$negeri = $_GET['negeri'];
$daerah = $_GET['daerah'];
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
                <h1 class="page-header">Senarai Pentadbir</h1>
            </div>

            <div class="col-lg-6">
                <div class="form-group" align="right">
                </div>
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <center><b>Analisa Pentadbir Berdaftar Aktif</b></center>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover">

                        <tbody>
                        <tr>
                            <th width="25%" bgcolor="#AAB9BE"><center>Bil. Pentadbir</center></th>
                            <th width="25%" bgcolor="#AAB9BE"><center>Admin</center></th>
                            <th width="25%" bgcolor="#AAB9BE"><center>Penyiasat</center></th>
                            <th width="25%" bgcolor="#AAB9BE"><center>Imam</center></th>
                        </tr>
                        <tr>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="blue"><?echo getCountPentadbir('',$negeri,$daerah,'1');?></font></strong>
                            </td>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="purple"><?echo getCountPentadbir('ADMIN',$negeri,$daerah,'1');?></font></strong>
                            </td>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="green"><?echo getCountPentadbir('PENYIASAT',$negeri,$daerah,'1');?></font></strong>
                            </td>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="black"><?echo getCountPentadbir('IMAM',$negeri,$daerah,'1');?></font></strong>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div></div>

            <div class="col-lg-6">
                <div class="form-group" align="right">
                </div>
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <center><b>Analisa Pentadbir Berdaftar Tidak Aktif</b></center>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover">

                        <tbody>
                        <tr>
                            <th width="25%" bgcolor="#AAB9BE"><center>Bil. Pentadbir</center></th>
                            <th width="25%" bgcolor="#AAB9BE"><center>Admin</center></th>
                            <th width="25%" bgcolor="#AAB9BE"><center>Penyiasat</center></th>
                            <th width="25%" bgcolor="#AAB9BE"><center>Imam</center></th>
                        </tr>
                        <tr>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="blue"><?echo getCountPentadbir('',$negeri,$daerah,'0');?></font></strong>
                            </td>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="purple"><?echo getCountPentadbir('ADMIN',$negeri,$daerah,'0');?></font></strong>
                            </td>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="green"><?echo getCountPentadbir('PENYIASAT',$negeri,$daerah,'0');?></font></strong>
                            </td>
                            <td rowspan="3" bgcolor="#FDFEFE" align="center">
                                <strong><font size="5" color="black"><?echo getCountPentadbir('IMAM',$negeri,$daerah,'0');?></font></strong>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div></div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <label class="control-label" for="date">Negeri</label>
                <select required class="form-control" id="negeri" name="negeri" >
                    <option value="">-- Pilih --</option>
                    <?echo getNegeriPentadbir($negeri);?>
                </select><br>
            </div>

            <div class="col-lg-4">
                <label class="control-label" for="date">Daerah</label>
                <select required class="form-control" id="daerah" name="daerah" >
                    <option value="">-- Pilih --</option>
                    <?echo getDaerahPentadbir($negeri,$daerah);?>
                </select><br>
            </div>

            <div class="col-lg-4">
                <label class="control-label" for="date"></label>
                <div class="form-group" align="right">
                    <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='ja_pentadbir_tambah.php'">Tambah Baharu</button>
                </div><br>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Pentadbir <?if($status=='1'){echo '&nbsp;<strong><font color="green">'.'Aktif'.'</font></strong>';}else{echo '&nbsp;<strong><font color="red">'.'Tidak Aktif'.'</font></strong>';}?></label>&nbsp;&nbsp;&nbsp;
                        <a href="ja_pentadbir_senarai.php?status=1">Aktif</a> &nbsp;|&nbsp;
                        <a href="ja_pentadbir_senarai.php?status=0">Tidak Aktif</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil</th>
                                <th width="22%">Info Pentadbir</th>
                                <th width="12%">Jawatan</th>
                                <th width="12%">Peranan</th>
                                <th width="14%">No. Telefon</th>
                                <th width="10%">Status</th>
                                <th width="10%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $pentadbir = getPentadbirList($negeri,$daerah,$status);
                            $i=1;
                            while($list_pentadbir = $pentadbir->fetch_assoc()) {
                                $status_text = "";
                                if ($list_pentadbir['status'] == '1') {
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
                                    <td><label class="control-label">Nama : </label>
                                        <br><?echo $list_pentadbir['nama'];?>
                                        <br><label class="control-label">Negeri : </label>
                                        <br><?echo $list_pentadbir['kod_negeri'].' - '.$list_pentadbir['nama_negeri'];?>
                                        <br><label class="control-label">Daerah : </label>
                                        <br><?echo $list_pentadbir['kod_daerah'].' - '.$list_pentadbir['nama_daerah'];?>
                                    </td>
                                    <td><?echo $list_pentadbir['jawatan'];?></td>
                                    <td><b><font color="green"><?echo $list_pentadbir['jenis_acc'];?></font></b></td>
                                    <td><b><font color="brown" size="4"><?echo $list_pentadbir['notel'];?></font></b>&nbsp;<a i class="fa fa-whatsapp" style="font-size:20px;color:green" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $list_pentadbir['notel']; ?>&text=<? echo '*'.$sys['sys_ja'].'::Maklumat Pendaftaran Akaun*';?>%0aAssalamualaikum w.b.t,%0aSukacita dimaklumkan akaun *<?echo $list_pentadbir['nama'];?>* telah berjaya didaftarkan.%0aUntuk mulakan akses *<?echo $sys['sys_ja'];?>* ,sila ke link <?echo $sys['sys_domain'].'/jejakasnaf/view/login.php';?>%0aMaklumat akaun adalah seperti berikut : %0aID Pengguna : *<?echo $list_pentadbir['id_pengguna'];?>*%0aKatalaluan : *<?echo $list_pentadbir['katalaluan'];?>*%0aSekian, terima kasih.')"></a></td>
                                    <td>
                                        <?if($list_pentadbir['status'] == '1')
                                        {
                                            echo '<b><font color="green">'.'AKTIF'.'</font></b>';
                                        }
                                        else {
                                            echo '<b><font color="red">'.'TIDAK AKTIF'.'</font></b>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?if($list_pentadbir['status'] == '1'){?>
                                        <a class="view" href="../../jejakasnaf/view/login.php?id=<?echo $list_pentadbir['id'];?>" target="blank"><button type="button" class="btn btn-warning">Log Masuk</button></a><?}?>
                                        <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_pentadbir['id'];?>"><button type="button" class="btn btn-info">Info Pentadbir</button></a>
                                        <?if($list_pentadbir['status'] == '1'){?>
                                            <br><a href="ja_pentadbir_kemaskini.php?id=<?echo $list_pentadbir['id'] ;?>"><button type="button" class="btn btn-primary">Kemaskini</button></a><?}?>
                                        <br><a onclick="nyahAktifPentadbir(<?echo $list_pentadbir['id'] ;?>,<?echo $list_pentadbir['status'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                        <input id="rowid" name="rowid" type="hidden" value="<?echo $list_pentadbir['id'];?>"/>
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
                    <h4 class="modal-title" id="myModalLabel2">Info Pentadbir</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'ja_pentadbir_info.php',
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

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

        function nyahAktifPentadbir(id,status){
            $.ajax({
                url: "../model/jejakasnaf_functions.php",
                type: "POST",
                data: {action:"nyahAktifPentadbir",id:id,status:status},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);

                    window.location='ja_pentadbir_senarai.php?status=<?echo $status;?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        $(document).ready(function() {
            $("#negeri").change(function(){
                var negeri = $(this).val();
                location.href = "ja_pentadbir_senarai.php?negeri="+negeri;
            });

            $("#daerah").change(function(){
                var daerah = $(this).val()
                var negeri = $('#negeri').val();
                location.href = "ja_pentadbir_senarai.php?negeri="+negeri+"&daerah="+daerah;
            });
        });

    </script>

</body>

</html>