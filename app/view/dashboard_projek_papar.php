<?php

include ('../controller/auth.php');

require "../model/dashboard_projek_functions.php";
require "../model/lookup.php";

$id_projek = $_GET['id_projek'];
$projek_info = getProjekInfoById($id_projek)->fetch_assoc();

date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$current_month=date("m");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));

?>
<!-- <style>
    td {
        padding-bottom: 20px;
        vertical-align: top;
    }
</style> -->

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
                <h2 class="page-header">Maklumat Projek</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="dashboard_projek_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Maklumat Projek</label>
                    </div>

                    <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <th width="13%"></th>
                                <th width="3%"></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><label>Kod Projek Utama</label></td>
                                <td><label>:</label></td>
                                <td>
                                    <?if($projek_info['kod_projek_parent']!=''){ echo '<b>'.$projek_info['kod_projek_parent'].'</b>';}
                                    else{echo '<b><font color="brown">'.'PROJEK UTAMA'.'</font></b>';}?></td>
                            </tr>

                            <tr>
                                <td><label>Kod Projek</label></td>
                                <td><label>:</label></td>
                                <td><?echo '<b>'.$projek_info['kod_projek'].'</b>';?></td>
                            </tr>

                            <tr>
                                <td><label>Nama Projek</label></td>
                                <td><label>:</label></td>
                                <td><?echo $projek_info['nama_projek'];?></td>
                            </tr>

                            <tr>
                                <td><label>Jenis Projek</label></td>
                                <td><label>:</label></td>
                                <td>
                                    <?if($projek_info['jenis_projek']=='1') {echo 'Projek Dalaman';}
                                    else if($projek_info['jenis_projek']=='2') {echo 'Projek Luar';}
                                    else {echo 'Tender';}
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td><label>Nama Pelanggan</label></td>
                                <td><label>:</label></td>
                                <td><?echo $projek_info['nama_client'];?></td>
                            </tr>

                            <tr>
                                <td><label>Negeri</label></td>
                                <td><label>:</label></td>
                                <td><?echo $projek_info['negeri'];?></td>
                            </tr>

                            <tr>
                                <td><label>Negara</label></td>
                                <td><label>:</label></td>
                                <td><?echo $projek_info['negara'];?></td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td><label>Tarikh Mula</label></td>
                                <td><label>:</label></td>
                                <td><?echo date("d-m-Y",strtotime($projek_info['tarikh_mula']))?></td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td><label>Tarikh Tamat</label></td>
                                <td><label>:</label></td>
                                <td><?echo date("d-m-Y",strtotime($projek_info['tarikh_tamat']))?></td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td><label>Catatan</label></td>
                                <td><label>:</label></td>
                                <td><?echo $projek_info['catatan'];?></td>
                                <td>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<script>

</script>
</body>

</html>