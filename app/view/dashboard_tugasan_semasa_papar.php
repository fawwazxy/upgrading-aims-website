<?php

include ('../controller/auth.php');

require "../model/projek_internal_task_functions.php";
require "../model/lookup.php";


$id_task = $_GET['id'];
$code = $_GET['code'];
$isShowButton=true;
$task = getDetailsTaskById($id_task)->fetch_assoc();
$tab = $_GET['page'];
if(isset($tab)){
    $page="dashboard_tugasan_semasa_pantauan_senarai.php?code=".$code;
    $isShowButton=false;

}else{
    $page="dashboard_tugasan_semasa_senarai.php?code=".$code;
}
//date_default_timezone_set("Asia/Kuala_Lumpur");
//$current_year = date(Y);
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
                <h3 class="page-header">Tugasan : <? echo $task['tajuk']; ?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <? if($isShowButton){?>
                        <!--<a href="projek_task_tambah.php?id=<? echo $id_task;?>"><button type="button" class="btn btn-primary">kemaskini</button></a>-->
                    <?}?>
                    <a href="<? echo $page;?>"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Maklumat Tugasan</label>
                    </div>
                    <div class="panel-body">



                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table width="100%">
                                    <tr>
                                        <th width="15%"></th>
                                        <th width="5%"></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Projek Utama</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['projek_utama'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Sub Projek</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['projek_sub'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Kategori</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['nama_kategori'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Tajuk</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['tajuk'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Ditugaskan Oleh</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['oleh'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Ditugaskan Kepada</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['kepada'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Kumpulan</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['nama_kumpulan'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Tarikh Mula</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['tarikh_start'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Tarikh Tamat</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['tarikh_end'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Jangka Masa</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['duration'];?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Selang Masa</label></td>
                                        <td><label class="control-label">:</label></td>
                                        <td><? echo $task['slack'];?> Jam</td>
                                    </tr>
                                </table>


                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group" align="left">
                                    <label class="control-label">Catatan Untuk Pelaksanaan</label>
                                </div>
                                <?
                                if($task['catatan']!=''){
                                    echo $task['catatan'];
                                }else{
                                    echo "Tiada Catatan";
                                }

                                ?>

                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group" align="left">
                                    <label class="control-label">Catatan Dalam Pelaksanaan</label>
                                </div>
                                <?
                                if($task['catatan_inprogress']!=''){
                                    echo $task['catatan_inprogress'];
                                }else{
                                    echo "Tiada Catatan";
                                }
                                ?>

                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group" align="left">
                                    <label class="control-label">Catatan Sudah Selesai</label>
                                </div>
                                <?
                                if($task['catatan_done']!=''){
                                    echo $task['catatan_done'];
                                }else{
                                    echo "Tiada Catatan";
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</div>


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
</body>

</html>