<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
require "../model/lookup.php";
//date_default_timezone_set("Asia/Kuala_Lumpur");
//$current_year = date(Y);
$id = $_GET['id'];

$data_tanah = getLotTanahById($id)->fetch_assoc();

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
                <h1 class="page-header">Lot Tanah</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="lot_tanah_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <form method="post" action="../controller/pengusaha_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="kemaskiniLotTanah" />
                        <input type="hidden" name="id" id="id" value="<?echo $id?>" />
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Kemaskini Maklumat Lot Tanah</label>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Negeri<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_negeri" name="kod_negeri" value="<?echo $data_tanah['kod_negeri']?>"
                                            onchange="reloadNegeri(this.value)">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_negeri","code","CONCAT(code, ' - ', name)",$data_tanah['kod_negeri']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Jajahan<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_jajahan" name="kod_jajahan" value="<?echo $data_tanah['']?>" >
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDownPengusaha("lkp_jajahan","kod_jajahan","CONCAT(kod_jajahan, ' - ', jajahan)","kod_negeri",$data_tanah['kod_negeri'],$data_tanah['kod_jajahan']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Daerah<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_daerah" name="kod_daerah" value="<?echo $data_tanah['kod_daerah']?>" onchange="reloadJajahan(this.value)">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDownPengusaha("lkp_daerah","kod_daerah","CONCAT(kod_daerah, ' - ', daerah)","kod_negeri",$data_tanah['kod_negeri'],$data_tanah['kod_daerah']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Mukim<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_mukim" name="kod_mukim" value="<?echo $data_tanah['']?>">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDownPengusaha("lkp_mukim","kod_mukim","CONCAT(kod_mukim, ' - ', mukim)","kod_daerah",$data_tanah['kod_daerah'],$data_tanah['kod_mukim']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Kod<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" id="kod_tanah" name="kod_tanah" type="text" readonly value="<?echo $data_tanah['kod_tanah']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Seksyen<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="seksyen" id="seksyen" value="<?echo $data_tanah['seksyen']?>" required >
                                </div>
                                <div class="col-xs-4">
                                    <label>Lot<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="lot" id="lot" value="<?echo $data_tanah['lot']?>" required>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Kawasan Kaji Selidik<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="svy_area" id="svy_area" required value="<?echo $data_tanah['svy_area']?>">
                                </div>
                                <div class="col-xs-4">
                                    <label>Unit Kawasan Kaji Selidik<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="areaunit" id="areaunit" required value="<?echo $data_tanah['areaunit']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Keluasan<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="hektar" id="hektar" required value="<?echo $data_tanah['hektar']?>">
                                </div>
                                <div class="col-xs-4">
                                    <label>Unit Keluasan<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="unit" id="unit" required value="<?echo $data_tanah['unit']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Pusat Kemajuan Peladang (PKP)<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="pkp" id="pkp" required value="<?echo $data_tanah['pkp']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Pengairan dan Saliran<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="pengairan" id="pengairan" required value="<?echo $data_tanah['pengairan']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Luas Kawasan<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="area" id="area" required value="<?echo $data_tanah['area']?>">
                                </div>
                                <div class="col-xs-4">
                                    <label>Perimeter Kawasan<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="perimeter" id="perimeter" required value="<?echo $data_tanah['perimeter']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Koordinat<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="koordinat" id="koordinat" required value="<?echo $data_tanah['koordinat']?>">
                                </div>
                            </div>



                            <div class="form-group" align="right">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {

    });

    function reloadNegeri(val) {
        $.ajax({
            type: "POST",
            url: "../model/pengusaha_functions.php",
            data:{action:"get_daerah_list",kod_negeri:val},
            success: function(data){
                $("#kod_daerah").html(data);
                //console.log(val);//reloadJajahan();
            }
        });
        $.ajax({
            type: "POST",
            url: "../model/pengusaha_functions.php",
            data:{action:"get_jajahan_list",kod_negeri:val},
            success: function(data){
                $("#kod_jajahan").html(data);
                //console.log(val);
            }
        });
    }

    function reloadJajahan(val) {
        $.ajax({
            type: "POST",
            url: "../model/pengusaha_functions.php",
            data:{action:"get_mukim_list",kod_daerah:val},
            success: function(data){
                $("#kod_mukim").html(data);
                //console.log(val);//reloadJajahan();
            }
        });
    }

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

</script>
</body>

</html>