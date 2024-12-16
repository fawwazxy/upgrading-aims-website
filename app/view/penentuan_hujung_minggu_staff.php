<?php

include ('../controller/auth.php');

require "../model/tarikh_bekerja_functions.php";


$flagScreen = 'tab_1';
$sys = getSys(1)->fetch_assoc();
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$nama = getNama($id) -> fetch_assoc();


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
                <h1 class="page-header">Penentuan Tarikh Bekerja</h1>
                <h4><b><font color="blue"><? echo $nama['name'];?></font></b></h4>

                <div class="row">
                    <? if(checkTahunAvailbility(date('Y'),$no_staff) <= 0){?>
                        <div class="panel-heading" align="right">
                            <a href="../controller/tarikh_bekerja_exec.php?action=jana_tarikh&id=<? echo $id;?>&no_staff=<? echo $no_staff;?>"><button class="btn btn-primary" type="button">Jana Tarikh</button></a>
                        </div>
                    <?}?>
                    <div class="col-lg-12">
                        <div id='cssmenu'>
                            <ul>
                                <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="penentuan_hujung_minggu_staff.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Offday</a></li>
                                <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="penentuan_tarikh_bekerja_staff.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Tarikh Bekerja</a></li>
                            </ul>
                        </div>
                    </div>
                </div><br>
                <form method="post" action="../controller/tarikh_bekerja_exec.php?action=editStatusHujungMinggu&id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">
                    <div class="panel-heading" align="right">
                        <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <label class="control-label" for="date">Tahun Semasa : <? echo date('Y');?></label>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">

                                    <table width="100%" class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Bil.</th>
                                            <th>Hari</th>
                                            <th>Pilih Semua<br><input type="checkbox" id="select_all" style="transform: scale(1);" class="form-control"/></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?
                                        $datas = getHari($no_staff);
                                        $i=1;
                                        while($list = $datas->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?echo $i++;?></td>
                                                <td><?echo $list['desc'];?></td>
                                                <td width="10%"><input type="checkbox" name="hari_ids[]"
                                                                       class="form-control checkbox" value="<?echo $list['id'];?>"
                                                        <?echo $list['status']==1?"checked":""; ?> />
                                                </td>
                                            </tr>
                                        <?}?>

                                        </tbody>
                                    </table>
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