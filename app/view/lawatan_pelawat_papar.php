<?php

include ('../controller/auth.php');

require "../model/lawatan_functions.php";
require "../model/lookup.php";

$id_lawatan = $_GET['id_lawatan'];
$data_pelawat = getPelawatInfoById($id_lawatan)->fetch_assoc();

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
                <h1 class="page-header">Pelawat</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="lawatan_pelawat_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Maklumat Pelawat</label>
                    </div>

                    <!-- <div class="panel-body">

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Kod Kad</label>
                                </div>
                                <div class="col-xs-8">
                                    <?echo '<b>'.$data_pelawat['kod_kad'].'</b>'.'&nbsp;-&nbsp;'.$data_pelawat['nama_kad'];?>
                                </div>
                            </div>

                        	<div class="form-group row" align="left">
	                    		<div class="col-xs-4">
	                            	<label>Nama</label>
	                            </div>
	                            <div class="col-xs-8">
	                            	<?echo $data_pelawat['nama'];?>
	                            </div>
                            </div>

                            <div class="form-group row" align="left">
	                    		<div class="col-xs-4">
	                            	<label>No. Kad Pengenalan</label>
	                            </div>
	                            <div class="col-xs-8">
	                            	<?echo $data_pelawat['nokp'];?>
	                            </div>
                            </div>

                            <div class="form-group row" align="left">
	                    		<div class="col-xs-4">
	                            	<label>No. Telefon</label>
	                            </div>
	                            <div class="col-xs-8">
	                            	<?echo '+6'.$data_pelawat['notel'];?>
	                            </div>
                            </div>

                            <div class="form-group row" align="left">
	                            <div class="col-xs-4">
		                            <label>Nama Syarikat</label>
	                            </div>
	                            <div class="col-xs-8">
		                            <?echo $data_pelawat['nama_company'];?>
	                            </div>
                            </div>
                            
                            <div class="form-group row" align="left">
	                            <div class="col-xs-4">
		                            <label>Jenis Kenderaan</label>
	                            </div>
	                            <div class="col-xs-8">
		                            <?echo $data_pelawat['jenis_kenderaan'];?>
	                            </div>
                            </div>

                            <div class="form-group row" align="left">
	                            <div class="col-xs-4">
		                            <label>No. Kenderaan</label>
	                            </div>
	                            <div class="col-xs-8">
		                            <?echo $data_pelawat['no_kenderaan'];?>
	                            </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Nama Staff</label>
                                </div>
                                <div class="col-xs-8">
                                    <?echo $data_pelawat['name'];?>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>No. Kad Pengenalan</label>
                                </div>
                                <div class="col-xs-8">
                                    <?echo $data_pelawat['noic'];?>
                                </div>
                            </div>

                            <!-- <div class="form-group row" align="left">
	                            <div class="col-xs-4">
		                            <label>Kategori Kad</label><br>
	                            </div>
	                            <div class="col-xs-8">
		                            <?if($data_pelawat['kategori_kad']=='1'){echo 'Kad';}else{echo 'Slip';}?>
	                            </div>
                            </div> -->
                    <!--   </div> -->
                    <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <th width="18%"></th>
                                <th width="5%"></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><label>Kod Kad</label></td>
                                <td><label>:</label></td>
                                <td><?echo '<b>'.$data_pelawat['kod_kad'].'</b>'.'&nbsp;-&nbsp;'.$data_pelawat['nama_kad'];?></td>
                            </tr>
                            <tr>
                                <td><label>Nama</label></td>
                                <td><label>:</label></td>
                                <td><?echo $data_pelawat['nama'];?></td>
                            </tr>
                            <tr>
                                <td><label>No. Kad Pengenalan</label></td>
                                <td><label>:</label></td>
                                <td><?echo $data_pelawat['nokp'];?></td>
                            </tr>
                            <tr>
                                <td><label>No. Telefon</label></td>
                                <td><label>:</label></td>
                                <td><?echo '+6'.$data_pelawat['notel'];?></td>
                            </tr>
                            <tr>
                                <td><label>Nama Syarikat</label></td>
                                <td><label>:</label></td>
                                <td><?echo $data_pelawat['nama_company'];?></td>
                            </tr>
                            <tr>
                                <td><label>Jenis Kenderaan</label></td>
                                <td><label>:</label></td>
                                <td><?echo $data_pelawat['jenis_kenderaan'];?></td>
                            </tr>
                            <tr>
                                <td><label>No. Kenderaan</label></td>
                                <td><label>:</label></td>
                                <td><?echo $data_pelawat['no_kenderaan'];?></td>
                            </tr>
                            <tr>
                                <td><label>Nama Staf</label></td>
                                <td><label>:</label></td>
                                <td><?echo $data_pelawat['name'];?></td>
                            </tr>
                            <tr>
                                <td><label>No. Kad Pengenalan</label></td>
                                <td><label>:</label></td>
                                <td><?echo $data_pelawat['noic'];?></td>
                            </tr>
                            <tr>
                                <td><label>Masa Masuk</label></td>
                                <td><label>:</label></td>
                                <td><?echo '<b><font color ="blue">'.$data_pelawat['tarikh_masa_masuk'].'</font></b>';?></td>
                            </tr>
                            <tr>
                                <td><?if($data_pelawat['status_masuk_keluar'] == '0') {?><label>Masa Keluar</label></td>
                                <td><label>:</label></td>
                                <td>
                                    <?if($data_pelawat['tarikh_masa_keluar']!=''){echo '<b><font color ="red">'.$data_pelawat['tarikh_masa_keluar'].'</font></b>';}?></td>
                            </tr>
                            <tr>
                                <td><label>Jum. Masa Lawatan</label></td>
                                <td><label>:</label></td>
                                <td><?echo '<b><font color ="purple">'.$data_pelawat['jum_masa_lawatan'].'</font></b>';?></td>
                            </tr><?}?>
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