<?php

include ('../controller/auth.php');

require "../model/agromart_functions.php";
require "../model/lookup.php";

$id_agencies = $_GET['id_agencies'];
$id = $_GET['id'];
$agensi_info = getAgensiInfoById($id)->fetch_assoc();

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
                <h2 class="page-header">Maklumat Operator</h2>
                <h4><b><?echo $agensi_info['nama'];?></b></h4>
                <h4><b><?echo $agensi_info['no_pendaftaran'];?></b></h4>
                <h4><b><?echo $agensi_info['negeri'];?></b></h4>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <form method="post" action="../controller/agromart_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="operatorAdd" />
                        <input type="hidden" name="created_by" id="created_by" value="<?echo $_SESSION['SESS_NAME']?>" />
                        <input type="hidden" name="id_agencies" id="id_agencies" value="<?echo $id_agencies?>" />
                    </div>

                    <br><div class="form-group" align="right">
                        <a href="agromart_admin_operator_senarai.php?id=<?echo $id_agencies;?>" ><button type="button" class="btn btn-primary">Kembali</button></a>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Tambah Maklumat Operator</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Nama<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="nama" id="nama" required style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                                <div class="col-xs-5">
                                    <label>No. Kad Pengenalan<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="nokp" id="nokp" onchange="getCurrentAge()" required>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Umur<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="umur" id="umur" required>
                                </div>
                                <div class="col-xs-5">
                                    <label>No. Telefon<font color="red"> **&nbsp;(Contoh : +60123456789)</font></font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="notel" id="notel" required>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>ID Pengguna<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="username" id="username" required>
                                </div>
                                <div class="col-xs-5">
                                    <label>Katalaluan<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="password" id="password" required>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <!-- <div class="col-xs-5">
                            <label>Daerah<font color="red">&nbsp;**</font></label>
                            <select required class="form-control" id="daerah" name="daerah" value="">
                            <option value="">-- Pilih --</option>
                            <?echo getDropDown("lkp_daerah","daerah","CONCAT(kod_daerah,' - ',daerah)",$daerah);?>
                            </select>
                            </div> -->
                                <div class="col-xs-5">
                                    <label>Daerah<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="daerah" id="daerah" required>
                                </div>
                                <div class="col-xs-5">
                                    <label>Negeri<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="negeri" name="negeri" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_negeri","name","CONCAT(code,' - ',name)",$negeri);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label>Jantina<font color="red">&nbsp;**</font></label><br>
                                    <input type="radio" value="Lelaki" name="jantina" id="jantina" checked=""/>
                                    <label>Lelaki</label>&nbsp; &nbsp; &nbsp;
                                    <input type="radio" value="Perempuan" name="jantina" id="jantina" />
                                    <label>Perempuan</label>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-12">
                                    <label>Gambar&nbsp;<font color="red"><i>(Hanya fail format jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                    <input type="file" accept=".jpg,.jpeg,.png,.gif" name="photo" id="photo">
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

    function getCurrentAge(){
        var noic = document.getElementById("nokp").value;
        var noic_year = noic.slice(0,2);
        var age = "19" + noic_year;
        var today = new Date();
        var current_year = today.getFullYear();

        document.getElementById("umur").value = current_year - age;
        document.getElementById("umur").focus;
    }

</script>

</body>

</html>