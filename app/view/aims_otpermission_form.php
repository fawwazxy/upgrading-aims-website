<?php

include ('../controller/auth.php');
require "../model/lookup.php";
require "../model/aims_ot_function.php";

$flag=$_GET['flg'];
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
                <h1 class="page-header">
                    OVERTIME PERMISSION
                    <!--<a href="v02_aims_otpermission_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>
        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <?
        $flag="tab_1";
        include ('../global/menu_otp.php');
        ?>

        <div class="panel-heading" align="right">

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        OVERTIME PERMISSION FORM
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">


                        <form method="post" action="../controller/aims_otpadd_exec.php" enctype="multipart/form-data">

                            <div class="form-group row" align="left">
                                <div class="col-sm-6">
                                    <div class="form-group" align="left">
                                        <label>TO<font color="red">**</font>&nbsp;</label><br>
                                        <select required class="form-control" name="hod_name" id="hod_name">
                                            <option value="">-- HOD/SBU NAME --</option>
                                            <?echo getDropDownStaff("");?>
                                            <!--		<option value="ALIAS BIN ZAKARIA">ALIAS BIN ZAKARIA</option>
                                                    <option value="AZIMAH BINTI SAAT">AZIMAH BINTI SAAT</option>
                                                    <option value="C. WAN NURUL AZLINI BINTI C. WAN RAMLI">C. WAN NURUL AZLINI BINTI C. WAN RAMLI</option>
                                                    <option value="CAPT. MOHD TARMIZI BIN MEJAM">CAPT. MOHD TARMIZI BIN MEJAM</option></option>
                                                    <option value="HAFIZUDDIN B. SHUHAIMI">HAFIZUDDIN B. SHUHAIMI</option>
                                                    <option value="HAJI AMINUDIN BIN MAT YUSOF">HAJI AMINUDIN BIN MAT YUSOF</option>
                                                    <option value="KHAIRUL AZNAM BIN ALIAS">KHAIRUL AZNAM BIN ALIAS</option>
                                                    <option value="MASHITAH MURNI BINTI SELAWI@ABD MALIK">MASHITAH MURNI BINTI SELAWI@ABD MALIK</option>
                                                    <option value="MOHAMMAD HANIFA BIN MOHAMED KAMAL">MOHAMMAD HANIFA BIN MOHAMED KAMAL</option>
                                                    <option value="NIK MAIZATUL AKMAR BT NIK MUSTAFA">NIK MAIZATUL AKMAR BT NIK MUSTAFA</option>
                                                    <option value="NOR AZILA BINTI ISMAIL">NOR AZILA BINTI ISMAIL</option>
                                                    <option value="NOR FUDHLANAH BINTI MD SUKOR">NOR FUDHLANAH BINTI MD SUKOR</option>
                                                    <option value="NUR KHALILAH BT KHALIL">NUR KHALILAH BT KHALIL</option>
                                                    <option value="RINI FAZRINA BINTI MAZLAN">RINI FAZRINA BINTI MAZLAN</option>
                                                    <option value="ROSLIHA BINTI A HAMID">ROSLIHA BINTI A HAMID</option>
                                                    <option value="SHARUL NAZRI BIN HARUN">SHARUL NAZRI BIN HARUN</option>
                                                    <option value="SITI AISYAH MAISARAH BINTI BOHANG">SITI AISYAH MAISARAH BINTI BOHANG</option>
                                                    <option value="W MUHAMAD MURSYID BIN W RAZALI">W MUHAMAD MURSYID BIN W RAZALI</option>
                                                    <option value="WAN RAFIDAH BT A WAHAB">WAN RAFIDAH BT A WAHAB</option>
                                                    <option value="ZAILY BIN MOHD ZAKI">ZAILY BIN MOHD ZAKI</option> -->
                                        </select>
                                        <!--  <input type="text" required class="form-control" placeholder="HOD/SBU NAME" id="hod_name" name="hod_name" value="" onkeyup="convertToUppercase(this)"/> -->
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group" align="left">
                                        <label>FROM<font color="red">**</font>&nbsp;</label><br>
                                        <input readonly type="text" required class="form-control" placeholder="" id="staff_name" name="staff_name" value="<?php echo $_SESSION['SESS_NAME'] ?>" />
                                        <input type="hidden" required class="form-control" placeholder="" id="no_staff" name="no_staff" value="<?php echo $_SESSION['SESS_NO_STAFF'] ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-sm-6">
                                    <div class="form-group" align="left">
                                        <label>DATE<font color="red">**</font>&nbsp;</label></label><br>
                                        <input type="date" required class="form-control" placeholder="YYYY-MM-DD" id="otp_date" name="otp_date" value="" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group" align="left">
                                        <label>DEPARTMENT<font color="red">**</font>&nbsp;</label><br>
                                        <input readonly type="text" required class="form-control" placeholder="" id="code_department" name="code_department" value="<?php echo $_SESSION['SESS_DEPARTMENT_SUB'] ?>" />
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row" align="left">
                                <div class="col-sm-8">
                                    <div class="form-group" align="left">
                                        <label>DESCRIPTION<font color="red">**</font>&nbsp;</label><br>
                                        <textarea class="form-control" id="otp_description" name="otp_description" type="text" value="" rows="5" value="" onkeyup="convertToUppercase(this)"> </textarea>
                                    </div>
                                </div>
                            </div>

                            <div align="center">
                                <button type="submit" class="btn btn-success">Apply</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </form>
                        <br>
                        <div class="col-sm-12">
                            <div class="form-group" align="center">
                                <label>REMINDER :</label>

                                <p>1. THIS FORM MUST BE FILLED AND APPROVED BY HEAD OF DEPARTMENT ON THAT DAY BEFORE START OVERTIME</p>
                                <p>2. THIS FORM DESCRIPTION WILL BE ATTACHED WITH OVERTIME CLAIM FORM BEFORE SUBMIT TO HUMAN RESOURCE DEPARTMENT</p>


                            </div>
                        </div>


                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>


    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

</script>

</body>

</html>