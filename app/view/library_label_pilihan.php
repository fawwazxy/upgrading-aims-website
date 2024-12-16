<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";
require_once("../../util/qrcode.php");
$sys = getSys(1)->fetch_assoc();
$id_elibrary = $_GET['id'];
$elibrary=getElibraryDetails($id_elibrary)->fetch_assoc();

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

    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=800,width=1280');
            if (window.focus) {newwindow.focus()}
            return false;
        }

        // -->
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
                <h1 class="page-header"><?echo $elibrary['nama']?></h1>
                <div class="form-group" align="right">
                    <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal" id="btn_pelanggan" onclick="window.location.href='library_kandungan_senarai.php'">Kembali</button>
                </div>

                <table>
                    <tbody>
                    <tr>
                        <td rowspan="5"><?echo '<img width="120" height="150" src="../../elibrary/frontpage/'.$elibrary['frontpage_cover_file'].'"/>';?></td>
                        <td>&nbsp;&nbsp;&nbsp;<strong><font size="4px">Kategori</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><font size="4px">:&nbsp;<?echo $elibrary['jenis'] ;?></font></td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;<strong><font size="4px">Nama Penerbit</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <?if($elibrary['penerbit']!=''){
                                echo '<font size="4px">:&nbsp;'.$elibrary['penerbit'].'</font>' ;
                            }else{
                                echo ':&nbsp;-';
                            }?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;<strong><font size="4px">Tahun Terbitan</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><font size="4px">:&nbsp;<?echo $elibrary['tahun_terbitan'] ;?></font></td>
                    </tr>

                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;<strong><font size="4px">ISBN</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?if($elibrary['isbn']!=''){?>
                                <font size="4px">:&nbsp;<?echo $elibrary['isbn'] ;?></font>
                            <?}else{echo ':&nbsp;-';}?></td>
                    </tr>

                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;<strong><font size="4px">Status Pinjaman</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><font size="4px">:
                                <?if($elibrary['status_pinjam']==0){
                                    echo 'Tidak Boleh Dipinjam';
                                }else{
                                    echo 'Boleh Dipinjam';
                                }?>
                            </font></td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/library_kandungan_exec.php">
                    <input type="hidden" name="id_elibrary" value="<?echo $id_elibrary?>" />
                    <input type="hidden" name="action" value="choosen_print" />

                    <div class="panel panel-default">
                        <div class="panel-heading" align="left">
                            <label class="control-label" for="date">Senarai Salinan Bahan Bacaan</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="5%">Bil.</th>
                                    <th width="85%">No. Rujukan</th>
                                    <th width="10%">Pilih Semua<br><input type="checkbox" id="select_all" style="transform: scale(1);" class="form-control"/></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $datas = getElibraryInfo($id_elibrary);
                                $i=1;
                                while($list = $datas->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><strong><?echo 'elib-'.$id_elibrary.'-'.$list['id_naskah'];?></strong>
                                            <!--
                                            <br>
                                            <?
                                            $qr = new QRCode();
                                            $qr = QRCode::getMinimumQRCode('elib-'.$id_elibrary.'-'.$list['id_naskah'], QR_ERROR_CORRECT_LEVEL_L);
                                            $qr->printHTML("4px");
                                            ?>
                                        -->
                                        </td>
                                        <td width="10%"><input type="checkbox" name="naskah_ids[]"
                                                               class="form-control checkbox" value="<?echo $list['id_naskah'];?>"/>
                                        </td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;&nbsp;Cetak Label</button>
                            </div>
                        </div>

                        <!-- /.panel-body -->
                    </div>
                </form>

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