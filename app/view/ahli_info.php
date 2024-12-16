<?php

include ('../controller/auth.php');


require "../model/ahli_functions.php";
require "../model/lookup.php";

?>
<?php

$id = $_GET['id'];
$statact=$_GET['statact'];
$tab=$_GET['tab'];

if($id>0){
    $head="Kemaskini Maklumat Ahli";
}else{
    $head="Tambah Ahli";
}

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
    <style>
        .jarak{
            padding-left: 15px;

        }
    </style>

    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>
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
                <h1 class="page-header"><? echo $head;?></h1>
                <div class="panel-heading" align="right">
                    <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->

            <div class="row">


                <div class="col-lg-12">



                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <?
                                    $list_ahli = getAhliById($id) -> fetch_assoc();
                                    ?>

                                    <form id="myform" method="post"  action="../controller/ahli_exec.php" name="myform"  enctype="multipart/form-data" >
                                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                                        <input name="statact" type="hidden" class="input-short" value="<? echo $statact;?>" />
                                        <input name="tab" type="hidden" class="input-short" value="<? echo $tab;?>" />
                                        <input name="action" type="hidden" class="input-short" value="addEditAhli" />
                                        <label><font color="red">** Maklumat Wajib Diisi **</font></label>
                                        <br>
                                        <div class="form-group" align="left">
                                            <label>Nama<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control"  style="text-transform:uppercase"  name="nama" value="<? echo $list_ahli['nama']; ?>" required>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nama Panggilan</label>
                                            <input type="text" class="form-control"  style="text-transform:uppercase"  name="nama_panggilan" value="<? echo $list_ahli['nama_panggilan']; ?>">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>No. Kad Pengenalan<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" id="nokp" name="nokp" value="<? echo $list_ahli['nokp']; ?>" required>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>No. Telefon<font color="red">&nbsp;** (cth: +60123456789)</font></label>
                                            <input type="text" class="form-control" id="notel" name="notel" value="<? echo $list_ahli['notel']; ?>" required>
                                        </div>
                                        <? if($id!=0){?>
                                            <div class="form-group" align="left">
                                                <label>Peranan<font color="red">&nbsp;**</font></label>
                                                <select required class="form-control" name="role" id="role">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="1" <?php if($list_ahli['role'] == '1'){echo 'selected="selected"';}?>>ADMIN</option>
                                                    <option value="0" <?php if($list_ahli['role'] == '0'){echo 'selected="selected"';}?>>AHLI</option>
                                                </select>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Katalaluan<font color="red">&nbsp;**</font></label>
                                                <input type="text" class="form-control" id="password" name="password" value="<? echo $list_ahli['password']; ?>">
                                            </div>
                                        <?}?>

                                        <div class="form-group" align="left">
                                            <label>Gps Koordinat<font color="red"><i>&nbsp;(Jika Ada)</i></font></label>
                                            <input type="text" class="form-control" name="gps_koordinat" value="<? echo $list_ahli['gps_koordinat']; ?>">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Kategori Umur<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="kategori_umur" name="kategori_umur" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDownKategoriUmur($list_ahli['kategori_umur']);?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Galur<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="galur" name="galur" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("ahli_lkp_galur","kod","nama_galur",$list_ahli['galur']);?>
                                            </select>
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Alamat<font color="red"></font>&nbsp;</label>
                                            <textarea class="form-control" style="text-transform:uppercase" name="alamat" rows="5" ><? echo $list_ahli['alamat']; ?></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Negeri<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="negeri" name="negeri" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("lkp_negeri","code","name",$list_ahli['negeri']);?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Daerah<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="daerah" name="daerah" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("lkp_daerah","kod_daerah","daerah",$list_ahli['daerah']);?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Asnaf</label>
                                            <select class="form-control" id="asnaf" name="asnaf" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDownAsnaf($list_ahli['asnaf']);?>
                                            </select>
                                        </div>

                                        <?
                                        if($list_ahli['anak_yatim']=="0" || $list_ahli['anak_yatim']==""  ){
                                            $anak_yatim_tidak="checked";
                                        }else{
                                            $anak_yatim_tidak="";
                                        }
                                        if($list_ahli['anak_yatim']=="1" ){
                                            $anak_yatim_ya="checked";
                                        }else{
                                            $anak_yatim_ya="";
                                        }
                                        ?>

                                        <div class="form-group"  align="left">
                                            <label>ANAK YATIM&nbsp;</label>
                                            <div class="radio">
                                                <label><input type="radio" name="anak_yatim" value="1" <?echo $anak_yatim_ya;?>>YA</label><span class="jarak"></span>
                                                <label><input type="radio" name="anak_yatim" value="0" <?echo $anak_yatim_tidak;?>>TIDAK</label>
                                            </div>
                                        </div>

                                        <?
                                        if($list_ahli['oku']=="0" || $list_ahli['oku']==""  ){
                                            $oku_tidak="checked";
                                        }else{
                                            $oku_tidak="";
                                        }
                                        if($list_ahli['oku']=="1" ){
                                            $oku_ya="checked";
                                        }else{
                                            $oku_ya="";
                                        }
                                        ?>

                                        <div class="form-group"  align="left">
                                            <label>OKU&nbsp;</label>
                                            <div class="radio">
                                                <label><input type="radio" name="oku" value="1" <?echo $oku_ya;?>>YA</label><span class="jarak"></span>
                                                <label><input type="radio" name="oku" value="0" <?echo $oku_tidak;?>>TIDAK</label>
                                            </div>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nota<font color="red"></font>&nbsp;</label>
                                            <textarea class="form-control" style="text-transform:uppercase" name="nota" rows="5" ><? echo $list_ahli['nota']; ?></textarea>
                                        </div>



                                        <div class="form-group" align="left">
                                            <label>Gambar Profil&nbsp;<font color="red"><i>(Hanya fail format jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
                                            <br><?if($list_ahli['photo_filename'] != ''){
                                                echo '<img width="120" height="120" src="../../iahli/user_photo/'.$list_ahli['photo_filename'].'"/><br>'.$list_ahli['photo_filename'];
                                            }?>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                            <input type="file" accept=".jpg,.jpeg,.png,.gif" name="photo" id="photo">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
            $("#negeri").change(function(){
                var negeri = $(this).val();
                //alert(negeri);

                $.ajax({
                    url: '../model/ahli_functions.php',
                    type: 'post',
                    data: {kod_negeri:negeri,action:"checkDaerah"},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;
                        //alert(len);

                        $("#daerah").empty();
                        for( var i = 0; i<len; i++){
                            var kod_daerah = response[i]['kod_daerah'];
                            var daerah = response[i]['daerah'];
                            console.log(kod_daerah);

                            $("#daerah").append("<option value='"+kod_daerah+"'>"+daerah+"</option>");

                        }
                    }
                });
            });
        });


    </script>




</body>

</html>
