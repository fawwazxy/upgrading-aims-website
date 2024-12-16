<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>


<?php
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
if($no_staff == ""){
    $no_staff = $_SESSION['SESS_NO_STAFF'];
}

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
$nama = getValueName($no_staff) -> fetch_assoc();

?>

<div class="row">
    <center>
        <div class="col-lg-12">
            <h1 class="page-header">Maklumat Pekerja </h1>
        </div>
    </center>
</div>



<center><?echo '<img src="../../staffphoto/'.$nama['nama_photo'].'" border="0" width="90px" height="100px"/>';?>
    </br><h4><strong><? echo $nama['name'];?></strong></h4>
</center>
<br>


<!-- /Maklumat Peribadi-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Maklumat Peribadi</b></strong></font>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
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
                    $data_staff= getStaffrecord($no_staff)->fetch_assoc();

                    ?>
                    <tr class="odd gradeX">


                        <td><?php echo $data_staff['noic']; ?></td>
                        <td><?php echo $data_staff['phone']; ?></td>
                        <td><?php echo $data_staff['email']; ?></td>
                        <td><?php echo $data_staff['alamat_tetap']; ?></td>
                        <td><?php echo $data_staff['umur']; ?></td>
                        <td><?php echo $data_staff['desc']; ?></td>
                        <td><?php echo $data_staff['tanggungan']; ?></td>

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
                    $data_pendidikan =getStaffPendidikan($no_staff);
                    while($data= $data_pendidikan->fetch_assoc()) {
                        ?>
                        <tr class="odd gradeX">
                            <td><?php echo $data ['pencapaian']; ?></td>
                            <td><?php echo $data ['tempat']; ?></td>
                            <td><?php echo $data ['tahun_mula']; ?></td>
                            <td><?php echo $data['tahun_akhir']; ?></td>
                            <td><?php echo $data ['keputusan']; ?></td>
                        </tr>
                    <?}?>
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
                    $list_experience = getStaffPengalaman($no_staff);
                    while($data= $list_experience->fetch_assoc()) {
                        ?>
                        <tr class="odd gradeX">

                            <td><?php echo $data['tempat_berkerja']; ?></td>
                            <td><?php echo date('d-F-Y',strtotime($data['tarikh_mula'])); ?></td>
                            <td><?php echo date('d-F-Y',strtotime($data['tarikh_akhir'])); ?></td>
                            <td><?php echo $data['gaji']; ?></td>
                            <td><?php echo $data['jawatan']; ?></td>
                            <td><?php echo $data['peranan']; ?></td>

                        </tr>
                    <?}?>
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
                    $data_kemahiran = getStaffKemahiran($no_staff);
                    while($list_skill= $data_kemahiran->fetch_assoc()) {

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

                    $list_family = getStaffFamily($no_staff);
                    while($data= $list_family->fetch_assoc()) {

                        ?>
                        <tr class="odd gradeX">


                            <td>

                                <?php

                                echo $data['nama']; ?>

                            </td>

                            <td><?php echo $data['hubungan']; ?></td>
                            <td><?php echo $data['pekerjaan']; ?></td>
                            <td><?php echo $data['phone']; ?></td>

                        </tr>
                    <?}?>
                    </tbody>

                </table>

            </div>

        </div>
        <? include ('../global/footer.php'); ?></div></div>
<div class="col-lg-1"></div>






</body>

</html>
