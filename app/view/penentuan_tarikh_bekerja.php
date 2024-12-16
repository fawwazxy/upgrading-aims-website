<?php

include ('../controller/auth.php');

require "../model/tarikh_bekerja_functions.php";

$flagScreen = 'tab_2';
$no_staff = $_GET['no_staff'];
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
    <style>
        ol {
            display: block;
            list-style-type: decimal;
            margin-top: 1em;
            margin-bottom: 1em;
            margin-left: 0;
            margin-right: 0;
            padding-left: 40px;
        }
    </style>

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
                <h1 class="page-header">Penentuan Tarikh Bekerja
                    <a href="v02_aims_attendance_workday_calendar.php" class="btn btn-primary">Switch to version 2</a></h1>

                <div class="row">
                    <? if(checkTahunAvailbility(date('Y'), $no_staff) <= 0){?>
                        <div class="panel-heading" align="right">
                            <a href="../controller/tarikh_bekerja_exec.php?action=jana_tarikh"><button class="btn btn-primary" type="button">Jana Tarikh</button></a>
                        </div>
                    <?}?>
                    <div class="col-lg-12">
                        <div id='cssmenu'>
                            <ul>
                                <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="penentuan_hujung_minggu.php">Hujung Minggu</a></li>
                                <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="penentuan_tarikh_bekerja.php">Tarikh Bekerja</a></li>
                            </ul>
                        </div>
                    </div>
                </div><br>
                <form method="post" action="../controller/tarikh_bekerja_exec.php?action=editStatus">
                    <div class="panel-heading" align="right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <label class="control-label" for="date">Tahun Semasa : <? echo date('Y');?></label>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body" style="height:500px;overflow-y: scroll;">
                                    <div align="center">

                                    </div>
                                    <?
                                    $datas = getBulanTarikhBekerja(date('Y'), $no_staff);
                                    $i=1;
                                    while($list_bulan = $datas->fetch_assoc()) {
                                        $bulan_bekerja= $list_bulan['bulan'];
                                        ?>
                                        <u><h2><strong><font color="black"><? echo $bulan_bekerja;?></font></strong></h2></u>
                                        <table width="100%" class="table table-bordered">
                                            <?
                                            $minggu = getMingguBekerja(date('Y'),$bulan_bekerja, $no_staff);
                                            $m=1;
                                            while($list_minggu = $minggu->fetch_assoc()) {
                                                $minggu_bekerja= "Minggu ".$m;

                                                ?>
                                                <tr>
                                                    <td><? echo $minggu_bekerja;?></td>
                                                    <?
                                                    $data_tarikh = getTarikhbekerja(date('Y'),$bulan_bekerja,$list_minggu['minggu'], $no_staff);
                                                    $bil_hari=$list_minggu['bil_hari'];
                                                    while($list = $data_tarikh->fetch_assoc()) {
                                                        $hari= date("l", strtotime($list['tarikh']));
                                                        ?>
                                                        <td><center><?echo $hari."<br>".$list['tarikh'];?>
                                                                <input type="checkbox" name="tarikh_ids[]"
                                                                       class="form-control checkbox" value="<?echo $list['id'];?>"
                                                                    <?echo $list['status']==1?"checked":""; ?> /></center></td>
                                                    <?}?>
                                                </tr>

                                                <?$m++;}?>
                                        </table>
                                    <?}?>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group" align="center">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>

                                <!-- /.panel-body -->
                            </div>
                </form>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        //select all checkboxes
        $("#select_all").change(function(){  //"select all" change 
            $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkbox').change(function(){
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_all").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length ){
                $("#select_all").prop('checked', true);
            }
        });
    });

</script>

</body>

</html>