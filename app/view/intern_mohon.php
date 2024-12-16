<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<?
require "../model/pemohon_functions.php";
?>

<?
$id = $_GET['id'];
$com_id=$_GET['company_id'];
$iklan_id=$_GET['id'];
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
<? $sys = getSys(1) -> fetch_assoc(); ?>
<body>

<div class="row" >
    <div class="col-sm-1"></div>
    <div class="col-sm-10" align="center">


        <?
        $flagScreen="tab_1";
        $act="add";
        include ('../global/menu_intern.php');
        ?>

        <!-- /.col-lg-12 -->
    </div>
    <div class="col-sm-1"></div>

</div>
</div>

<!-- /.row -->

<div class="row" align="center">

    <div class="col-lg-12">

        <div class="panel panel-default">

            <div class="panel-body" >
                <div class="row">

                    <div class="col-sm-3"></div>
                    <div class="col-sm-7" align="center">

                        <?

                        $log_penawaran = getPenawaranJawatanById($id)-> fetch_assoc();

                        ?>

                        <form method="post" action="../controller/intern_add_exec.php" >
                            <div class="form-group" align="left">
                                <input name="id" type="hidden" class="input-short" value=" <? echo $log_penawaran['id']; ?>" />
                                <input name="company_id" type="hidden" class="input-short" value="<? echo $log_penawaran['company_id']; ?>" />
                                <input name="iklan_id" type="hidden" class="input-short" value=" <? echo $iklan_id; ?>" />

                                <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                <br>

                                <div class="form-group" align="left">
                                    <label>No K/P<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " id="noic" name="noic" required autocomplete="" onchange="Age()">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Nama Pemohon<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="name" required autocomplete="" >
                                </div>

                                <div class="form-group" align="left">
                                    <label>Jantina<font color="red">**</font>&nbsp;</label>
                                    <select required class="form-control" name="gender" value="">
                                        <option value="">-- Pilih --</option>

                                        <? $gender= getGender();
                                        while ($list  = $gender -> fetch_assoc()){ ?>
                                            <option value="<? echo $list['gender'];?>"><? echo $list['description'];?></option>

                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group" align="left">
                                    <label>No Telefon<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder="60139342668 " name="phone" required autocomplete="">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Emel<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="email" required autocomplete="">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Alamat Tetap<font color="red">**</font>&nbsp;</label>
                                    <textarea class="form-control" name="alamat_tetap" id="alamat_tetap" rows="5" required autocomplete=""></textarea>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Alamat Surat Menyurat<font color="red">**</font>&nbsp;</label>
                                    <button onclick="copyToClipboard()">Salin Alamat</button>&nbsp;
                                    <textarea class="form-control" name="alamat_surat" id="alamat_surat" rows="5" required autocomplete=""></textarea>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Umur<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " id="umur" name="umur" required autocomplete="">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Peranan Dipohon<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="hidden" id="role_id" name="role_id" value="<? echo $log_penawaran['role']; ?>"/>
                                    <input class="form-control"  value="<? echo $log_penawaran['peranan']; ?>" readonly>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Status Perkahwinan<font color="red">**</font>&nbsp;</label>
                                    <select required class="form-control" name="martial_status" value="">
                                        <option value="">-- Pilih --</option>

                                        <? $kawin= getKawin();
                                        while ($list  = $kawin -> fetch_assoc()){ ?>
                                            <option value="<? echo $list['martial_status'];?>"><? echo $list['desc'];?></option>

                                            <?
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Tanggungan<font color="red">(Jika Ada)</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="tanggungan"  autocomplete="">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Tarikh Mula Latihan Industri<font color="red">**</font>&nbsp;</label>
                                    <input type="date" class="form-control" placeholder=" " id="tarikh_mula" name="tarikh_mula" required autocomplete="">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Tarikh Tamat Latihan Industri<font color="red">**</font>&nbsp;</label>
                                    <input type="date" class="form-control" placeholder=" " id="tarikh_tamat" name="tarikh_tamat" required autocomplete="">
                                </div>

                                <input name="status_pemohon" type="hidden" class="input-short" value="DLMPOHON" />

                                <div class="modal-footer">
                                    <a href="intern_ed.php"><button class="btn btn-info">Seterusnya</button></a>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                </div>

                        </form>
                    </div>

                </div>
                <div class="col-sm-7"></div>

            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <? include ('../global/footer.php'); ?>
</div>
<!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function copyToClipboard() {
        var alamat_tetap=document.getElementById("alamat_tetap").value;
        document.getElementById("alamat_surat").value=alamat_tetap;
    }
</script>


<script>
    function Age(){
        var ic= document.getElementById("noic").value;
        var year= ic.slice(0,2);
        var age= "19" +year;

        document.getElementById("umur").value=<? echo $date_year;?>-age;
        document.getElementById("umur").focus;

    }


</script>

</body>

</html>