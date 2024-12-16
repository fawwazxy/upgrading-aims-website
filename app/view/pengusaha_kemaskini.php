<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
require "../model/lookup.php";
//date_default_timezone_set("Asia/Kuala_Lumpur");
//$current_year = date(Y);
$id_pengusaha = $_GET['id_pengusaha'];
$data_pengusaha = getPengusahaById($id_pengusaha)->fetch_assoc();
//$kod_ppk = $_GET['kod_ppk'];

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
                <h1 class="page-header">Pengusaha</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="pengusaha_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <form method="post" action="../controller/pengusaha_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="kemaskiniPengusaha" />
                        <input type="hidden" name="id_pengusaha" id="id_pengusaha" value="<?echo $id_pengusaha?>" />
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Kemaskini Maklumat Pengusaha</label>
                        </div>

                        <div class="panel-body">

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama Pertubuhan Peladang Kawasan (PPK)<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_ppk" name="kod_ppk" value="<?echo $kod_ppk?>"
                                            onchange="reloadPPK(this.value)">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_ppk","kod_ppk","CONCAT(kod_ppk,' - ',nama_ppk)",$data_pengusaha['kod_ppk']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama Mukim<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_mukim" name="kod_mukim" value="<?echo $data_pengusaha['kod_mukim']?>">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDownPengusaha("lkp_mukim","kod_mukim","CONCAT(kod_mukim, ' - ', mukim)","kod_ppk",$data_pengusaha['kod_ppk'],$data_pengusaha['kod_mukim']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="nama" id="nama" value="<?echo $data_pengusaha['nama']?>" readonly style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>No. Kad Pengenalan<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="nokp" id="nokp" value="<?echo $data_pengusaha['nokp']?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Umur<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="umur" id="umur" required value="<?echo $data_pengusaha['umur']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>No. Telefon<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="notel" id="notel" required value="<?echo $data_pengusaha['notel']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Jantina<font color="red">&nbsp;**</font></label><br>
                                    <input type="radio" value="L" name="jantina" id="jantina"<?echo $data_pengusaha['jantina'] == 'L'?'checked':''?> />
                                    <label>Lelaki</label>&nbsp; &nbsp; &nbsp;
                                    <input type="radio" value="P" name="jantina" id="jantina" <?echo $data_pengusaha['jantina'] == 'P'?'checked':''?> />
                                    <label>Perempuan</label>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>No. Pengusaha<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="no_pengusaha" id="no_pengusaha" required value="<?echo $data_pengusaha['no_pengusaha']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>No. Ahli<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="no_ahli" id="no_ahli" required value="<?echo $data_pengusaha['no_ahli']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Alamat<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="alamat" id="alamat" required value="<?echo $data_pengusaha['alamat']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <input class="form-control" placeholder=" " name="alamat2" id="alamat2" value="<?echo $data_pengusaha['alamat2']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <input class="form-control" placeholder=" " name="alamat3" id="alamat3" value="<?echo $data_pengusaha['alamat3']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-2">
                                    <label>Poskod<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="poskod" id="poskod" required value="<?echo $data_pengusaha['poskod']?>">
                                </div>

                                <div class="col-xs-3">
                                    <label>Bandar<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="bandar" id="bandar" required value="<?echo $data_pengusaha['bandar']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>

                                <div class="col-xs-3">
                                    <label>Negeri<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_negeri" name="kod_negeri" value="<?echo $data_pengusaha['kod_negeri']?>">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_negeri","code","CONCAT(code,' - ', name)",$data_pengusaha['kod_negeri']);?>
                                    </select>
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

    function reloadPPK(val) {
        $.ajax({
            type: "POST",
            url: "../model/pengusaha_functions.php",
            data:{action:"get_mukim_ppk",kod_ppk:val},
            success: function(data){
                $("#kod_mukim").html(data);
                console.log(val);//reloadJajahan();
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