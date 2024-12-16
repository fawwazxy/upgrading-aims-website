<?php
include ('../controller/auth.php');
require "../model/agromart_functions.php";
require "../model/lookup.php";

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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../../app/global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Info Agensi</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/agromart_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="agensiEdit" />
                        <input type="hidden" name="id" id="id" value="<?echo $id?>" />
                    </div>
                    <br><div class="form-group" align="right">
                        <a href="agromart_admin_agensi_senarai.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Kemaskini Info Agensi</label>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-xs-5">
                                    <label for="nama">Nama<span style="color: red; "> **</span>&nbsp;</label>
                                    <input class="form-control" name="nama" id="nama" required value="<?echo $agensi_info['nama'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                                <div class="col-xs-5">
                                    <label for="no_pendaftaran">No. Pendaftaran<span style="color: red; "> **</span>&nbsp;</label>
                                    <input class="form-control" name="no_pendaftaran" id="no_pendaftaran" required value="<?echo $agensi_info['no_pendaftaran'];?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-5">
                                    <label for="notel">No. Telefon<span style="color: red; ">&nbsp;*</span></label>
                                    <input class="form-control" placeholder="+60123456789" name="notel" id="notel" required value="<?echo $agensi_info['notel'];?>">
                                </div>
                                <div class="col-xs-5">
                                    <label for="email">Email</label>
                                    <input class="form-control" placeholder="example@gmail.com" name="email" id="email" value="<?echo $agensi_info['email'];?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-5">
                                    <label for="username">ID Pengguna<span style="color: red; "> *</span>&nbsp;</label>
                                    <input class="form-control" name="username" id="username" required value="<?echo $agensi_info['username'];?>">
                                </div>
                                <div class="col-xs-5">
                                    <label for="password">Katalaluan<span style="color: red; "> *</span>&nbsp;</label>
                                    <input class="form-control" name="password" id="password" required value="<?echo $agensi_info['password'];?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- <div class="col-xs-5">
                            <label>Daerah<font color="red">&nbsp;**</font></label>
                            <select required class="form-control" id="daerah" name="daerah" value="">
                            <option value="">-- Pilih --</option>
                            <? echo getDropDown("lkp_daerah","daerah","CONCAT(kod_daerah,' - ',daerah)",$agensi_info['daerah']);?>
                            </select>
                            </div> -->
                                <div class="col-xs-5">
                                    <label for="daerah">Daerah<span style="color: red; "> *</span>&nbsp;</label>
                                    <input class="form-control" name="daerah" id="daerah" required value="<?echo $agensi_info['daerah'];?>">
                                </div>
                                <div class="col-xs-5">
                                    <label for="negeri">Negeri<span style="color: red; ">&nbsp;**</span></label>
                                    <select required class="form-control" id="negeri" name="negeri" value="">
                                        <option value="">-- Pilih --</option>
                                        <? echo getDropDown("lkp_negeri","name","CONCAT(code,' - ',name)",$agensi_info['negeri']);?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-5">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="5"><? echo $agensi_info['alamat'];?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <label>Logo&nbsp;<span style="color: red; "><i>(Hanya fail format jpeg/jpg/png/gif sahaja dibenarkan)</i></span></label>
                                    <br><? if($agensi_info['logo'] != ''){
                                        echo '<img width="120" height="120" src="data:image/jpeg;base64,'.base64_encode( $agensi_info['logo'] ).'"/><br>'.$agensi_info['logo_filename'];
                                    }?>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                    <input type="file" accept=".jpg,.jpeg,.png,.gif" name="logo" id="logo">
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
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
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