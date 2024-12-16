<?php

include ('../controller/auth.php');

require "../model/dashboard_projek_functions.php";
require "../model/lookup.php";

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
<style type="text/css">
    input.unit{
        width: 100px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 6px 6px 6px 6px;
    }
</style>
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
                <h2 class="page-header">Maklumat Projek</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <form method="post" action="../controller/dashboard_projek_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="projekAdd" />
                        <input type="hidden" name="created_by" id="created_by" value="<?echo $_SESSION['SESS_NOKP']?>" />
                    </div>

                    <br><div class="form-group" align="right">
                        <a href="dashboard_projek_senarai.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Tambah Maklumat Projek</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Kod Projek Utama<font color="blue">&nbsp;&nbsp;&nbsp;** Pilih Jika Sub Projek **</font></label>
                                    <select class="form-control" id="kod_projek_parent" name="kod_projek_parent" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDownKodProjek("projek_internal","kod_projek","CONCAT(kod_projek,' - ',nama_projek)",$kod_projek_parent);?>
                                    </select>
                                </div>
                                <div class="col-xs-5">
                                    <label>Kod Projek<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="kod_projek" id="kod_projek" required>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Nama Projek<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="nama_projek" id="nama_projek" required>
                                </div>
                                <div class="col-xs-5">
                                    <label>Nama Pelanggan</label>
                                    <input class="form-control" placeholder="" name="nama_client" id="nama_client">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Negeri<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="negeri" name="negeri" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_negeri","name","CONCAT(code,' - ',name)",$negeri);?>
                                    </select>
                                </div>
                                <div class="col-xs-5">
                                    <label>Negara</label>
                                    <input class="form-control" placeholder="" name="negara" value="MALAYSIA" id="negara" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Tarikh Mula<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " type="date" name="tarikh_mula" id="tarikh_mula" required value="<?if(!$tarikh_mula){
                                        echo date("Y-m-d");
                                    }else{
                                        echo date($tarikh_mula);
                                    }
                                    ?>">
                                </div>
                                <div class="col-xs-5">
                                    <label>Tarikh Tamat<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " type="date" name="tarikh_tamat" id="tarikh_tamat" required value="<?if(!$tarikh_tamat){
                                        echo date("Y-m-d");
                                    }else{
                                        echo date($tarikh_tamat);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label>Kategori Projek<font color="red">&nbsp;**</font></label><br>
                                    <input type="radio" value="1" name="jenis_projek" id="jenis_projek" checked=""/>
                                    <label>Projek Dalaman</label>&nbsp; &nbsp; &nbsp;
                                    <input type="radio" value="2" name="jenis_projek" id="jenis_projek" />
                                    <label>Projek Luar</label>&nbsp; &nbsp; &nbsp;
                                    <input type="radio" value="3" name="jenis_projek" id="jenis_projek" />
                                    <label>Tender</label>
                                </div>
                            </div>

                            <!-- <div class="form-group row" align="left">
                            <div class="col-xs-6">
                            <label>Kumpulan Projek<font color="red">&nbsp;**</font></label><br>
                            <input type="radio" value="1" checked="" name="kumpulan_projek" id="utama"/>
                            <label>Projek Utama</label>&nbsp; &nbsp; &nbsp;
                            <input type="radio" value="2" name="kumpulan_projek" id="sub"/>
                            <label>Sub Projek</label>
                            </div>
                            </div>

                            <div id = "projek_utama">
                            <label><font color="red"> ***</font>&nbsp;Tiada Pilihan Kod Projek Utama&nbsp;<font color="red"> ***</font>&nbsp;</label><br>
                            </div>

                            <div id = "sub_projek">
                            <div class="form-group row" align="left">
                            <div class="col-xs-6">
                            <label>Kod Projek Utama<font color="red"> **</font>&nbsp;</label><br>
                            <select required class="form-control" id="kod_projek_parent" name="kod_projek_parent">
                            <option value="">-- Pilih --</option>
                            <?echo getDropDownKodProjek("projek_internal","kod_projek","CONCAT(kod_projek,' - ',nama_projek)",$kod_projek_parent);?>
                            </select>
                            </div>
                            </div>
                            </div> -->

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label>Catatan</label>
                                    <textarea class="form-control" name="catatan" id="catatan" rows="5"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
            </div>
            </form>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
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

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    $("#tarikh_tamat").change(function() {
        var startDate = document.getElementById("tarikh_mula").value;
        var endDate = document.getElementById("tarikh_tamat").value;

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            alert("Tarikh tamat mestilah lebih besar daripada tarikh mula.");
            document.getElementById("tarikh_tamat").value = "";
        }
    });

</script>

</body>

</html>