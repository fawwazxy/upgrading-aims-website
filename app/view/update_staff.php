<?php

include ('../controller/auth.php');


require "../model/staff_function.php";
require "../model/lookup.php";

?>
<?php

$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$cawangan_kod=$_GET['cawangan_kod'];
$nama = getNama($id) -> fetch_assoc();


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


    <!-- <title><? echo $list_sys['sys_name'];?>::<? echo $list_sys['sys_tagline'];?></title>-->




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
        <?
        $flagScreen="tab_1";
        include ('../global/menu_staff.php');
        ?>
        <div class="row">
            <div class="col-lg-12">





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
                                    $list_staff = getStafIn($id) -> fetch_assoc();
                                    ?>

                                    <form id="myform" method="post"  action="../controller/update_staff_exec.php" name="myform"  enctype="multipart/form-data" >
                                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                                        <input name="shortcode" type="hidden" class="input-short" value="<? echo $shortcode;?>" />
                                        <input name="company_id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_COM'];?>" />
                                        <label><font color="red">** Maklumat Wajib Diisi **</font></label>
                                        <br>

                                        <div class="form-group" align="left">
                                            <label>No Staf <font color="red">&nbsp;**(Cannot be changed)</font></label>
                                            <?   if($id == 0){
                                                $disable="";
                                            }else{
                                                $disable="readonly";
                                            }
                                            ?>
                                            <input type="text" class="form-control"  name="no_staff" value="<?
                                            if($id == 0){
                                                //echo getRunning_NoView("no_staff",$shortcode);
                                            }else{
                                                echo $list_staff['no_staff'];
                                            }
                                            ?>" <? echo $disable;?>>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nama Staf<font color="red">&nbsp;**</font></label>
                                            <input type="text" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" class="form-control"  name="name" value="<? echo $list_staff['name']; ?>">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>No. Kad Pengenalan<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" id="noic" name="noic" value="<? echo $list_staff['noic']; ?>" onchange="Age()">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Umur<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" id="umur" name="umur" value="<? echo $list_staff['umur']; ?>">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Status Perkahwinan<font color="red">&nbsp;**</font></label>
                                            <select id="disabledSelect" class="form-control" name="martial_status" value="<? echo $list_staff['martial_status']; ?>">
                                                <option value="<? echo $list_staff['martial_status'];?>" selected ><? echo $list_staff['status_kahwin'];?> </option>
                                                <option value="">-- Pilih --</option>
                                                <? $martial_status= getMartial();
                                                while ($list  = $martial_status -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['id'];?>" <?echo($list['martial_status']==$list_staff['martial_status']?'selected':'');?>><? echo $list['desc'];?> </option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Tanggungan<font color="red"><i>&nbsp;(Jika Ada)</i></font></label>
                                            <input type="text" class="form-control" name="tanggungan" value="<? echo $list_staff['tanggungan']; ?>">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nombor Telefon<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" name="phone" value="<? echo $list_staff['phone']; ?>" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Email<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" name="email" value="<? echo $list_staff['email']; ?>">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Alamat Tetap<font color="red"></font>&nbsp;</label>
                                            <textarea class="form-control" name="alamat_tetap" rows="5" ><? echo $list_staff['alamat_tetap']; ?></textarea>
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Alamat Surat Menyurat<font color="red">&nbsp;**</font></label>
                                            <textarea class="form-control" name="alamat_surat" rows="5"><? echo $list_staff['alamat_surat']; ?></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Lokasi<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="id_lkp_cawangan" name="id_lkp_cawangan" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("lkp_cawangan","cawangan_kod","nama",$list_staff['cawangan_kod']);?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Kumpulan Peranan<font color="red"></font>&nbsp;</label>
                                            <p><? echo $list_staff['role_group_name']; ?></p>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Peranan<font color="red"></font>&nbsp;</label>
                                            <p><? echo $list_staff['role']; ?></p>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Bahagian<font color="red"></font>&nbsp;</label>
                                            <p><? echo $list_staff['description']; ?></p>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Caw. / Unit<font color="red"></font>&nbsp;</label>
                                            <p><? echo $list_staff['sub_department']; ?></p>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Status <font color="red">**</font>&nbsp;</label>
                                            <select id="disabledSelect" class="form-control" name="status" value="<? echo $list_staff['status']; ?>">
                                                <option value="">-- Pilih --</option>

                                                <? $status = getAddStatus();
                                                while ($list  = $status -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code'];?>" <?echo($list['code']==$list_staff['status']?'selected':'');?>><? echo $list['desc'];?> </option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>ID Akses Pengguna<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control"  name="username" value="<? echo $list_staff['username']; ?>">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Katalaluan<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" name="accs_pwd" value="<? echo $list_staff['accs_pwd']; ?>">
                                        </div>



                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Jantina<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="gender" name="gender" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("gender","gender","description",$list_staff['gender']);?>
                                            </select>
                                        </div>


                                        <?
                                        $list_staff['pantau_kehadiran'];
                                        $statuspantau = $list_staff['pantau_kehadiran'];

                                        ?>

                                        <div class="form-group row" align="left">
                                            <div class="col-xs-12">
                                                <label>Pelulus Cuti</label>
                                                <select class="form-control" id="leave_approval" name="leave_approval" value="">
                                                    <option value="">-- Pilih --</option>
                                                    <?echo getDropDownStaff($list_staff['leave_approval']);?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jumlah Jam Kerja<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" name="jum_jam_kerja" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="08:00:00" value="<? echo $list_staff['jum_jam_kerja']; ?>" required>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jumlah Jam Rehat<font color="red">&nbsp;**</font></label>
                                            <input type="text" class="form-control" name="jum_jam_break" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="01:00:00" value="<? echo $list_staff['jum_jam_break']; ?>" required>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Pemantauan Kehadiran<font color="red"></font>&nbsp;</label><br>
                                            <? if ($statuspantau == '1') { ?>
                                                <input type="radio" name="pantau_kehadiran" value="1" checked="checked"> YA &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="pantau_kehadiran" value="0"> TIDAK &nbsp;&nbsp;&nbsp;
                                            <? } else { ?>
                                                <input type="radio" name="pantau_kehadiran" value="1"> YA &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="pantau_kehadiran" value="0" checked="checked"> TIDAK &nbsp;&nbsp;&nbsp;
                                            <? } ?>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Status Qr-code<font color="red"></font>&nbsp;</label><br>
                                            <? if ($list_staff['status_qrcode'] == '1') { ?>
                                                <input type="radio" name="status_qrcode" value="1" checked="checked"> ON &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="status_qrcode" value="0"> OFF &nbsp;&nbsp;&nbsp;
                                            <? } else { ?>
                                                <input type="radio" name="status_qrcode" value="1"> ON &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="status_qrcode" value="0" checked="checked"> OFF &nbsp;&nbsp;&nbsp;
                                            <? } ?>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Status Swafoto<font color="red"></font>&nbsp;</label><br>
                                            <? if ($list_staff['status_swafoto']  == '1') { ?>
                                                <input type="radio" name="status_swafoto" value="1" checked="checked"> ON &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="status_swafoto" value="0"> OFF &nbsp;&nbsp;&nbsp;
                                            <? } else { ?>
                                                <input type="radio" name="status_swafoto" value="1"> ON &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="status_swafoto" value="0" checked="checked"> OFF &nbsp;&nbsp;&nbsp;
                                            <? } ?>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Status Tag<font color="red"></font>&nbsp;</label><br>
                                            <? if ($list_staff['status_tag']  == '1') { ?>
                                                <input type="radio" name="status_tag" value="1" checked="checked"> ON &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="status_tag" value="0"> OFF &nbsp;&nbsp;&nbsp;
                                            <? } else { ?>
                                                <input type="radio" name="status_tag" value="1"> ON &nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="status_tag" value="0" checked="checked"> OFF &nbsp;&nbsp;&nbsp;
                                            <? } ?>
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Gambar</label>
                                            <br>
                                            <?
                                            getstaffImg($no_staff)
                                            ?>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                            <input class="form-control"  type="file" accept=".jpg,.jpeg,.png,.gif" name="photo" id="photo">
                                            <br>
                                        </div>

                                        <div align="right">
                                            <!--a href="update_staff_edu.php"--><button class="btn btn-success">Seterusnya</button></a>
                                            <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
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
        });


    </script>
    <script>
        function Age(){
            var ic= document.getElementById("noic").value;
            var year= ic.slice(0,2);
            var age= "19" +year;

            document.getElementById("umur").value=2018-age;
            document.getElementById("umur").focus;

        }
        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }
    </script>



</body>

</html>
