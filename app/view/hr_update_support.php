<?php

include ('../controller/auth.php');

require "../model/support_function.php";

//$no_staff = $_GET['no_staff'];
$no_staff_login = $_SESSION['SESS_NO_STAFF'];
$id = $_GET['id'];
$row=  getSupportUpdate($id)->fetch_assoc();
$parent = getParentSub($row['support_parent'])->fetch_assoc();


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
    <script>

        function star(){
            var level=document.getElementById("level_aduan").value;
            var i=0;
            for(i=0;i<=level;i++){
                document.write(*);

            }

        }


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
                <h1 class="page-header">Kemaskini Tahap Keutamaan</h1>
            </div>

            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form id="formsubmit" method="post" action="../controller/update_aduan_support_exec.php?id=<?php echo $row_data['id']; ?>" >
                                    <input name="id" type="hidden" class="input-short" value="<? echo $id; ?>" />
                                    <input name="created_by" type="hidden" class="input-short" value="<? echo $no_staff_login ?>" />
                                    <input name="previous_dev" type="hidden" value="<? echo $row['id_support_developer'] ?>" />
                                    <input name="status_tindakan" type="hidden" value="<? echo $row['status_tindakan'] ?>" />
                                    <input type="hidden" id="catatancode" name="catatancode" value="" />

                                    <label><font color="red">Maklumat Wajib Diisi.</font></label><br>

                                    <label>Nama Projek/Sistem</label><br><? echo $row['nama_projek'];?><br><br>

                                    <label>Aduan</label><br><? echo $row['aduan'];?><br><br>

                                    <label>Nama Pelanggan</label><br><? echo $row['nama_client'];?><br><br>

                                    <label>Nombor Telefon</label><br><? echo $row['notel'];?><br><br>

                                    <label>Yang dipertanggungjawabkan sebelum ini</label><br>
                                    <?
                                    $developer = getListSupportDeveloper($row['id']);
                                    $z=1;
                                    while ($list_developer  = $developer -> fetch_assoc()){
                                        echo $z.'.&nbsp;'.$list_developer['name'].'<br>';
                                        $z++;
                                    }
                                    ?><br><br>

                                    <label>Tindakan Oleh<font color="red">**</font>&nbsp;</label>
                                    <select disabled class="form-control"  name="developer" id="developer" value=" <? echo $row['developer']; ?>">
                                        <option value="">-- Pilih --</option>
                                        <? $person= getNamaDeveloper();
                                        while ($pilih  = $person -> fetch_assoc()){ ?>
                                            <option readonly value="<? echo $pilih['no_staff'];?>"  <? echo ($pilih['no_staff']==$row['developer']?'selected':'');?>>   <? echo $pilih['name']?></option>
                                        <?}?>
                                    </select><br>

                                    <div class="form-group">
                                        <label>Tahap Keutamaan<font color="red">**</font>&nbsp;</label><br>
                                        <?
                                        for ($i = 1; $i <= 5; $i++) {
                                            $ratingClass = "btn-default btn-grey";
                                            if($i <= $row['level_aduan']) {
                                                $ratingClass = "btn-warning";
                                            }
                                            ?>
                                            <button type="button" class="btn btn-sm <?php echo $ratingClass; ?> rateButton" aria-label="Left Align"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></button>

                                        <?}?>
                                        <input type="hidden" class="form-control" id="level_aduan" name="level_aduan" value="<?echo $row['level_aduan']?>">

                                    </div>

                                </form><br>
                                <div class="modal-footer">
                                    <button type="submit" form="formsubmit" class="btn btn-success" >Simpan</button>
                                    <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                                    <?if($row['status_tindakan']=='TT'){?>
                                        <a href="../controller/tutup_aduan_exec.php?id=<? echo $row['id'];?>&id_developer=<?echo $row['id_support_developer']?>"> <button class="btn btn-danger">Tutup Aduan</button></a>
                                    <?}?>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <?if(!is_null($row['support_parent'])){?>
                                    <div class="panel panel-default">
                                        <div class="panel-body" >
                                            <center><h4><b><font color="blue">Maklumat Aduan Asal</font></b></h4></center><br>
                                            <p><b>No. Rujukan Tiket : </b></p><?php echo $parent['norujukan_support'];?><br><br>
                                            <p><b>Aduan : </b></p><?php echo $parent['aduan'];?><br><br>
                                        </div>
                                    </div>
                                <?}if(!is_null(getSubSupportList($row['norujukan_support'])->fetch_assoc())){
                                    $j= 1;?>
                                    <div class="panel panel-default">
                                        <div class="panel-body"><center><h4><b><font color="blue">Sub Aduan</font></b></h4></center><br>
                                            <?
                                            $data_sub = getSubSupportList($row['norujukan_support']);
                                            echo '<label>Pembahagian Aduan</label>';
                                            while($list_sub = $data_sub->fetch_assoc()) {?>
                                                <p><b><?echo $j++;?>. a) No. Rujukan Tiket : </b></p><?php echo $list_sub['norujukan_support'];?><br><br>
                                                <p><b>&nbsp;b) Aduan : </b></p><?php echo $list_sub['aduan'];?><br><br>
                                            <?}?>
                                        </div>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>



        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $( ".rateButton" ).click(function() {
            if($(this).toggleClass('btn-grey')) {
                $(this).removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).prevAll('.rateButton').removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            } else {
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            }
            $("#level_aduan").val($('.star-selected').length);
        });
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

</script>

</body>

</html>
