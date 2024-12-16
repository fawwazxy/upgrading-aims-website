<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
require "../model/lookup.php";

$id_pengusaha = $_GET['id_pengusaha'];
$nokp = $_GET['nokp'];
$pemilik = $_GET['nokp'];
$kod_negeri = $_GET['kod_negeri'];
$kod_jajahan = $_GET['kod_jajahan'];
$kod_daerah = $_GET['kod_daerah'];
$kod_mukim = $_GET['kod_mukim'];
$data_pengusaha = getPengusahaInfoById($nokp)->fetch_assoc();
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

                    <? include ('../../app/global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Lot Tanah</h1>
                <label>Nama Pengusaha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['nama']?><br>
                <label>No. Kad Pengenalan &nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['nokp']?><br>
                <label>No. Pengusaha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['no_pengusaha']?><br>
                <label>No. Ahli &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pengusaha['no_ahli']?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="pengusaha_lot_tanah_senarai.php?nokp=<?echo $nokp;?>" ><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label">Senarai Carian</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group row" align="left">
                            <div class="col-xs-12">
                                <label>Negeri<font color="red">&nbsp;**</font></label>
                                <select required class="form-control" id="kod_negeri" name="kod_negeri" value="<?echo $kod_negeri?>"
                                        onchange="reloadNegeri(this)">
                                    <option value="">-- Pilih --</option>
                                    <?echo getDropDown("lkp_negeri","code","CONCAT(code,' - ', name)",$kod_negeri);?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-12">
                                <label>Jajahan<font color="red">&nbsp;**</font></label>
                                <select required class="form-control" id="kod_jajahan" name="kod_jajahan" value="<?echo $kod_jajahan?>" onchange="reloadJajahan(this)">
                                    <option value="">-- Pilih --</option>
                                    <?echo getDropDownPengusaha("lkp_jajahan","kod_jajahan","CONCAT(kod_jajahan,' - ',jajahan)","kod_negeri",$kod_negeri,$kod_jajahan);?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-12">
                                <label>Daerah<font color="red">&nbsp;**</font></label>
                                <select required class="form-control" id="kod_daerah" name="kod_daerah" value="<?echo $kod_daerah?>" onchange="reloadDaerah(this)">
                                    <option value="">-- Pilih --</option>
                                    <?echo getDropDownPengusaha("lkp_daerah","kod_daerah","CONCAT(kod_daerah,' - ',daerah)","kod_negeri",$kod_negeri,$kod_daerah);?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <form method="post" action="../controller/pengusaha_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="pengusahaAddLotTanah" />
                        <input type="hidden" name="id" id="id" value="<?echo $id?>" />
                        <input type="hidden" name="pemilik" id="pemilik" value="<?echo $nokp?>" />
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Tambah Maklumat Lot Tanah</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="5%">Bil.</th>
                                    <th>Kod Lot Tanah</th>
                                    <th>Pertubuhan Peladang Kawasan (PPK) & Mukim</th>
                                    <th>Daerah</th>
                                    <th>Jajahan</th>
                                    <th>Negeri</th>
                                    <th width="15%"><center><input type="checkbox" id="select_all" style="width:20px;height:20px;" class="form-control"/></center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $lot_tanah = getLotTanahCheckboxList($kod_negeri,$kod_jajahan,$kod_daerah,$pemilik);
                                $i=1;
                                while($list_lot_tanah = $lot_tanah->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td>
                                            <?if($list_lot_tanah['kod_tanah']!=''){ echo '<b>'.$list_lot_tanah['kod_tanah'].'</b>';}?>
                                        </td>
                                        <td>
                                            <?if($list_lot_tanah['kod_mukim']!=''){ echo '<b>'.$list_lot_tanah['nama_ppk'].'</b>'.'&nbsp;-&nbsp;'.$list_lot_tanah['mukim'];}?>
                                        </td>
                                        <td>
                                            <?if($list_lot_tanah['kod_daerah']!=''){ echo $list_lot_tanah['daerah'];}?>
                                        </td>
                                        <td>
                                            <?if($list_lot_tanah['kod_jajahan']!=''){ echo $list_lot_tanah['jajahan'];}?>
                                        </td>
                                        <td>
                                            <?if($list_lot_tanah['kod_negeri']!=''){ echo $list_lot_tanah['name'];}?>
                                        </td>
                                        <td><center><input type="checkbox" name="lot_tanah_ids[]" style="width:20px;height:20px;" class="form-control checkbox" value="<?echo $list_lot_tanah['kod_tanah'];?>"/></center></td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group" align="center">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                    </div>
                </form>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<!-- /#wrapper -->


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

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

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function reloadNegeri(negeri){
        //console.log(obj);
        location.href = "pengusaha_lot_tanah_tambah.php?nokp=<?echo $nokp?>&kod_negeri="+negeri.value;
    }

    function reloadJajahan(jajahan){
        //console.log(obj);
        location.href = "pengusaha_lot_tanah_tambah.php?nokp=<?echo $nokp?>&kod_negeri=<?echo $kod_negeri?>&kod_jajahan="+jajahan.value;
    }

    function reloadDaerah(daerah){
        //console.log(obj);
        location.href = "pengusaha_lot_tanah_tambah.php?nokp=<?echo $nokp?>&kod_negeri=<?echo $kod_negeri?>&kod_jajahan=<?echo $kod_jajahan?>&kod_daerah="+daerah.value;
    }
</script>

</body>

</html>