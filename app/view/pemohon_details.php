<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";


$id = $_GET['id'];
$pemohon_id = $_GET['pemohon_id'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        <? require "../global/header.php"; ?>

    </script>

</head>

<body>
<?
$nama = getValueName($pemohon_id) -> fetch_assoc();

?>

<div class="row">
    <center>
        <div class="col-lg-12">
            <h1 class="page-header">Maklumat Pemohon </h1><br><br>
            <h2><strong><? echo $nama['name'];?></strong></h2><br>
        </div>
    </center>
</div>



<!-- /Maklumat Peribadi-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">

        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Lampiran</b></strong></font>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $pemohon_id;?>" />
                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>"/>

                    <!-- <tbody>


        <tr class="odd gradeX">

        <td align="center">
        <a href="../controller/downloadFile.php?pemohon_id=<?echo $pemohon_id;?>&action=resume"><button class="btn"><i class="fa fa-download"></i>Muat Turun Resume</button></a>
    <a href="../controller/downloadFile.php?pemohon_id=<?echo $pemohon_id;?>&action=transkrip"><button class="btn"><i class="fa fa-download"></i>Muat Turun Transkrip</button></a>
    <a href="../controller/downloadFile.php?pemohon_id=<?echo $pemohon_id;?>&action=cv"><button class="btn"><i class="fa fa-download"></i>Muat Turun CV</button></a>
    </td>

    </tr>
    </tbody> -->

                    <thead>
                    <tr>

                        <th width="35%">Transkrip Peperiksaan</th>
                        <th width="35%">Resume</th>
                        <th width="30%">Kurikulum Vitae (CV)</th>

                    </thead>

                    <tbody>
                    <?
                    $data_pemohon= getPemohonRecords($pemohon_id)->fetch_assoc();

                    ?>
                    <tr class="odd gradeX">

                        <td><?if($data_pemohon['document'] != '') {?>
                                <?echo '<object width="300" height="150" data="data:application/pdf;base64,'.base64_encode( $data_pemohon['document'] ).'"/><br>'.'" type="application/pdf"></object>';?>
                                <br><br>
                            <a href="#myModal1" data-toggle="modal" data-id="<? echo $data_pemohon['pemohon_id'];?>"><button class="btn btn-info" type="button">Papar Lampiran</button></a><?}?>
                        </td>

                        <td><?if($data_pemohon['document_resume'] != '') {?>
                                <?echo '<object width="300" height="150" data="data:application/pdf;base64,'.base64_encode( $data_pemohon['document_resume'] ).'"/><br>'.'" type="application/pdf"></object>';?>
                                <br><br>
                            <a href="#myModal2" data-toggle="modal" data-id="<? echo $data_pemohon['pemohon_id'];?>"><button class="btn btn-info" type="button">Papar Lampiran</button></a><?}?>
                        </td>
                        <td><?if($data_pemohon['document_cv'] != '') {?>
                                <?echo '<object width="300" height="150" data="data:application/pdf;base64,'.base64_encode( $data_pemohon['document_cv'] ).'"/><br>'.'" type="application/pdf"></object>';?>
                                <br><br>
                            <a href="#myModal3" data-toggle="modal" data-id="<? echo $data_pemohon['pemohon_id'];?>"><button class="btn btn-info" type="button">Papar Lampiran</button></a><?}?>
                        </td>

                    </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Maklumat Peribadi</b></strong></font>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $pemohon_id;?>" />
                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>"/>
                    <thead>
                    <tr>

                        <th>No IC</th>
                        <th>No Telefon</th>
                        <th>Email</th>
                        <th>Alamat Tetap</th>
                        <th>Umur</th>
                        <th>Status Perkahwinan</th>
                        <th>Tanggungan</th>

                    </thead>
                    <tbody>

                    <?
                    $data_pemohon= getPemohonRecords($pemohon_id)->fetch_assoc();

                    ?>
                    <tr class="odd gradeX">

                        <td><?php echo $data_pemohon['noic']; ?></td>
                        <td><?php echo $data_pemohon['phone']; ?></td>
                        <td><?php echo $data_pemohon['email']; ?></td>
                        <td><?php echo $data_pemohon['alamat_tetap']; ?></td>
                        <td><?php echo $data_pemohon['umur']; ?></td>
                        <td><?php echo $data_pemohon['desc']; ?></td>
                        <td><?php echo $data_pemohon['tanggungan']; ?></td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>




        <!-- /Maklumat Pendidikan -->


        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Maklumat Pendidikan</b></strong></font>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Pencapaian</th>
                        <th>Tempat</th>
                        <th>Tahun Mula</th>
                        <th>Tahun Akhir</th>
                        <th>Keputusan</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?
                    $data_pemohon =getPemohonPendidikan($pemohon_id)->fetch_assoc();
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $data_pemohon ['pencapaian']; ?></td>
                        <td><?php echo $data_pemohon ['tempat']; ?></td>
                        <td><?php echo $data_pemohon ['tahun_mula']; ?></td>
                        <td><?php echo $data_pemohon['tahun_akhir']; ?></td>
                        <td><?php echo $data_pemohon ['keputusan']; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>





        <!-- /maklumat experience -->

        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Maklumat Pekerjaan Terdahulu</b></strong></font>

            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>

                        <th>Tempat Bekerja</th>
                        <th>Tarikh Mula</th>
                        <th>Tarikh Akhir</th>
                        <th>Gaji</th>
                        <th>Jawatan</th>
                        <th>Peranan</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?
                    $list_experience = getPemohonPengalaman($pemohon_id)->fetch_assoc();
                    ?>
                    <tr class="odd gradeX">

                        <td><?php echo $list_experience['tempat_berkerja']; ?></td>
                        <td><?php echo $list_experience['tarikh_mula']; ?></td>
                        <td><?php echo $list_experience['tarikh_akhir']; ?></td>
                        <td><?php echo $list_experience['gaji']; ?></td>
                        <td><?php echo $list_experience['jawatan']; ?></td>
                        <td><?php echo $list_experience['peranan']; ?></td>

                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->





        <!-- /maklumat skill -->

        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Maklumat Kemahiran</b></strong></font>

            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>

                        <th>Kemahiran</th>
                        <th>Tahap</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?
                    $i= 1;
                    $data_pemohon = getPemohonKemahiran($pemohon_id);
                    while($list_skill= $data_pemohon->fetch_assoc()) {

                        ?>
                        <tr class="odd gradeX">

                            <td><?php echo $list_skill['skill']; ?></td>
                            <td><?php echo $list_skill['level']; ?></td>

                        </tr>
                        <?php $i++; } ?>


                    </tbody>
                </table>
            </div>
        </div>


        <!-- /maklumat family -->

        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Maklumat Keluarga</b></strong></font>

            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>

                        <th>Nama</th>
                        <th>Hubungan</th>
                        <th>Pekerjaan</th>
                        <th>No Telefon</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?

                    $list_family = getPemohonFamily($pemohon_id)->fetch_assoc();


                    ?>
                    <tr class="odd gradeX">


                        <td>

                            <?php

                            echo $list_family['nama']; ?>

                        </td>

                        <td><?php echo $list_family['hubungan']; ?></td>
                        <td><?php echo $list_family['pekerjaan']; ?></td>
                        <td><?php echo $list_family['phone']; ?></td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>
    <? include ('../global/footer.php'); ?>
</div>
<div class="col-lg-1"></div>



<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div> -->
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal1').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'permohonan_document_papar.php',
                        data:{pemohon_id:rowid},
                        success:function(html){
                            $('#demo1').html(html);
                        }
                    });
                });
            </script>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo2">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'permohonan_resume_papar.php',
                        data:{pemohon_id:rowid},
                        success:function(html){
                            $('#demo2').html(html);
                        }
                    });
                });
            </script>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo3">
            <script type="text/javascript">
                $('#myModal3').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'permohonan_cv_papar.php',
                        data:{pemohon_id:rowid},
                        success:function(html){
                            $('#demo3').html(html);
                        }
                    });
                });
            </script>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



</body>

</html>
