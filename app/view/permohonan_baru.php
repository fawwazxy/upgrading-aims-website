<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?
$id = $_GET['id'];
$com_id = $_GET['company_id'];
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

                <?
                $flagScreen="tab_1";
                $act="add";
                include ('../global/menu_pemohon.php');
                ?>

                <div class="panel-heading" align="right">
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                </div>

            </div>

            <!-- /.row -->

            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


                                    <?

                                    $id = $_GET['id'];

                                    $log_pemohon = getPemohon($id)-> fetch_assoc();

                                    ?>

                                    <form method="post" action="../controller/pemohonAdd_exec.php" >
                                        <div class="form-group" align="left">
                                            <input name="id" type="hidden" class="input-short" value="<? echo $id; ?>" />
                                            <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $log_pemohon['pemohon_id'];?>" />
                                            <input name="company_id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_COM']; ?>" />

                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group" align="left">
                                                <label>No K/P<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " id="noic" name="noic" required autocomplete="" onchange="Age()">
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Nama Pemohon<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder="" name="name" required autocomplete="" >
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
                                                <input class="form-control" placeholder="60139342668" name="phone" required autocomplete="">
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
                                                <label>Peranan DiPohon<font color="red">**</font>&nbsp;</label>
                                                <select required class="form-control" name="role" value="">
                                                    <option value="">-- Pilih --</option>

                                                    <? $role= getRole();
                                                    while ($list  = $role -> fetch_assoc()){ ?>
                                                        <option value="<? echo $list['code'];?>"><? echo $list['role'];?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <input name="status_pemohon" type="hidden" class="input-short" value="DLMPOHON" />



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
                                                <label>Tanggungan&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="tanggungan"  autocomplete="">
                                            </div>


                                            <div class="form-group" align="left">
                                                <label>Tarikh Mula<font color="red">**(Latihan Industri)</font>&nbsp;</label>
                                                <input type="date" class="form-control" placeholder=" " id="tarikh_mula" name="tarikh_mula" required autocomplete="">
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Tarikh Tamati<font color="red">**(Latihan Industri)</font>&nbsp;</label>
                                                <input type="date" class="form-control" placeholder=" " id="tarikh_tamat" name="tarikh_tamat" required autocomplete="">
                                            </div>


                                            <div class="modal-footer">
                                                <a href="pemohon_ed.php"><button class="btn btn-info">Seterusnya</button>
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
        <? include ('../global/footer.php'); ?>
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
