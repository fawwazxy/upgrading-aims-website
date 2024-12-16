<?php

include ('../controller/auth.php');

require "../model/tarikh_bekerja_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_2';
$sys = getSys(1)->fetch_assoc();
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$nama = getNama($id) -> fetch_assoc();
$shift_code=$_GET['shift_code'];

if(!isset($shift_code)){
    $shift_code=getDefaultShift();
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
                <h1 class="page-header">Penentuan Shift Bekerja</h1>
                <h4><b><font color="blue"><? echo $nama['name'];?></font></b></h4>
                <h4><b><font color="blue"><? echo $no_staff;?></font></b></h4>


            </div>
        </div>
        <div class="col-lg-4">

            <div class="form-group">
                <label class="control-label col-sm-3"for="shift_code" style="font-size:20px;">Shift</label>
                <select  required class="form-control" name="shift_code" id="shift_code">
                    <option value="0">-- Pilih shift--</option>
                    <? echo getDropDown("masa_bekerja","shift_code","description",$shift_code);?>
                </select>
            </div>
        </div>
        <form method="post" action="../controller/shift_bekerja_exec.php?action=editStatus&id=<? echo $id;?>&no_staff=<? echo $no_staff;?>&shift_code=<? echo $shift_code;?>">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <input type="checkbox" id="select_all" /><font size='4'> Select All</font></li><br>
                            <label class="control-label" for="date">Tahun Semasa : <? echo date('Y');?></label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="height:500px;overflow-y: scroll;">
                            <div align="center">

                            </div>
                            <?
                            $datas = getBulanTarikhBekerja(date('Y'),$no_staff);
                            $i=1;
                            while($list_bulan = $datas->fetch_assoc()) {
                                $bulan_bekerja= $list_bulan['bulan'];
                                ?>
                                <u><h2><strong><font color="black"><? echo $bulan_bekerja;?></font></strong></h2></u>
                                <table width="100%" class="table table-bordered">
                                    <?
                                    $minggu = getMingguBekerja(date('Y'),$bulan_bekerja,$no_staff);
                                    $m=1;
                                    while($list_minggu = $minggu->fetch_assoc()) {
                                        $minggu_bekerja= "Minggu ".$m;

                                        ?>
                                        <tr>
                                            <td><? echo $minggu_bekerja;?></td>
                                            <?
                                            $data_tarikh = getShiftBekerja(date('Y'),$bulan_bekerja,$list_minggu['minggu'],$no_staff);
                                            $bil_hari=$list_minggu['bil_hari'];
                                            while($list = $data_tarikh->fetch_assoc()) {
                                                $hari= date("l", strtotime($list['tarikh']));
                                                $disable="";
                                                if($list['tarikh']<date('Y-m-d')){
                                                    $disable="disabled";

                                                }
                                                ?>
                                                <td><center><?echo $hari."<br>".$list['tarikh'];?>
                                                        <input type="checkbox" name="tarikh_ids[]"
                                                               class="form-control checkbox" value="<?echo $list['id'];?>"
                                                            <?echo $list['shift_kerja']==$shift_code?"checked":""; ?> <? echo $disable;?>/></center></td>
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
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.container-fluid -->
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
        $("#shift_code").change(function(){
            var shift_code=$("#shift_code").val();

            sendType(shift_code);
        });

    });
    function sendType(shift_code)
    {

        window.location.href="penentuan_shift_bekerja_staf.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>&shift_code="+shift_code;
    }
</script>

</body>

</html>