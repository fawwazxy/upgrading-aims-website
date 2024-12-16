<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$ex_info = getExById($id)->fetch_assoc();
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

<style>

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

                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row" align="center" style="background-color: orange;">
            <div class="col-lg-12">
                <h3><b>Aims-Global Maritime Sdn Bhd (1041517-X)</b></h3>
                <h4>02-03, Level 3, No. 2, Block C, Bestari Centre,<br>
                    Jalan Hiliran, 20300 Kuala Terengganu, Terengganu Darul Iman<br>
                    No. Tel: 09-6228848 No. Faks: 09-6238848<br>
                    Email: aims@aimsglobal.com.my<br>
                    Website: www.aimsglobal.com.my</h4>
                <h2><b>ROOM EXCHANGES FORM - GLOBAL LOUNGE</b></h2>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>


        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_gl_exchange_exec.php">
                            <input id="action_by" name="action_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>

                            <input id="booking_id" name="booking_id" type="hidden" value="<? echo $id?>"/>

                            <div class="form-group row" align="left">
                                <label class="control-label col-sm-3" for="er_no">Exchanges Room Number:</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" id="er_no" name="er_no"  value="AGMSB/ERN/GL/<?php echo date("y"); ?>-000">
                                </div>
                            </div>

                            <div style="background-color: #ffb833; text-align: center;font-size: 18px;" class="form-group row" align="left">
                                <div class="col-xs-12">
                                    <label class="control-label">PERSONAL DETAILS</label>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">FULL NAME<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="client_name" name="client_name" type="text" required readonly value="<? echo $ex_info['client_name'];?>" style="text-transform:uppercase"/>
                                </div>

                                <div class="col-xs-6">
                                    <label class="control-label">COMPANY<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="client_company_id" name="client_company_id" type="text" required readonly value="<? echo $ex_info['company_name'];?>" style="text-transform:uppercase"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">IC/PASSPORT NUMBER<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="client_ic" name="client_ic" type="text" required readonly value="<? echo $ex_info['client_ic'];?>" style="text-transform:uppercase"/>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">CONTACT NUMBER<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="client_phone_no" name="client_phone_no" type="text" required readonly value="<? echo $ex_info['client_phone_no'];?>" style="text-transform:uppercase"/>
                                </div>
                            </div>

                            <div style="background-color: #ffb833; text-align: center;font-size: 18px; margin-top: 35px; " class="form-group row" align="left">
                                <div class="col-xs-12">
                                    <label class="control-label">ROOM DETAILS</label>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div style="font-size: 17px; text-align: center; padding-top: 25px;"  class="col-xs-2">
                                    <label class="control-label">PRESENT ROOM</label>
                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">ROOM NUMBER<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="room_pass" name="room_pass" type="text" required readonly value="<? echo $ex_info['room_id'];?>" style="text-transform:uppercase"/>
                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">BED NUMBER<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="bed_pass" name="bed_pass" type="text" required readonly value="<? echo $ex_info['bed_id'];?>" style="text-transform:uppercase"/>
                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">LOCKER NUMBER<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="locker_pass" name="locker_pass" type="text" required readonly value="<? echo $ex_info['locker_id'];?>" style="text-transform:uppercase"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div style="font-size: 17px; text-align: center; padding-top: 25px;"  class="col-xs-2">
                                    <label class="control-label">NEW ROOM</label>
                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">ROOM NUMBER<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="room_id" id="room_id">
                                        <option value="">-- Choose New Room --</option>
                                        <? echo getDropDownRoom("");?>
                                    </select>
                                </div>

                                <div class="col-xs-3">
                                    <label class="control-label">BED NUMBER<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="bed_id" id="bed_id">
                                        <option value="">-- Choose New Bed --</option>
                                        <? echo getDropDownBed("");?>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">LOCKER NUMBER<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="locker_id" id="locker_id">
                                        <option value="">-- Choose New Locker --</option>
                                        <? echo getDropDownLocker("");?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">REASON FOR MOVE<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="reason" name="reason" type="text" required value=""  onkeyup="convertToUppercase(this)"/>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">DATE<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="date_change" name="date_change" type="date" required value="" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>



                            <div align="center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </form>
                        <script>
                            function convertToUppercase(el) {
                                if(!el || !el.value) return;
                                el.value = el.value.toUpperCase();
                            }
                        </script>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- /.container-fluid -->
            </div>

            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <? include ('../global/footer.php'); ?>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

</body>

</html>