<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";


$id = $_GET['id'];
$data = getClientById($id)->fetch_assoc();
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
    * {
        box-sizing: border-box;
    }

    /* Create two equal columns that floats next to each other */
    .column {
        float: left;
        width: 50%;
        padding: 10px;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
        margin: auto;
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
                    s
                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div style="margin-left: 250px;" class="row" align= "left";>
            <img src="../../resources/images/aims_logo.png" alt="Aims-Global" width="80px;" align="left">

            <h4><b>AIMS-GLOBAL MARITIME SDN BHD</b></h4>
            <h5>NO 21 & 22, BLOK B, BESTARI CENTRE, JALAN HILIRAN,<br>
                20300 KUALA TERENGGANU, TERENGGANU DARUL IMAN<br>
                PHONE NUMBER: 09-6228848 FAKS NUMBER: 09-6238848<br>
                EMAIL: aims@aimsglobal.com.my</h5>
            <h2><b>GLOBAL LOUNGE BOOKING FORM</b></h2>
        </div>


        <div class="form-group" align="right">
        </div>


        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_gl_booking_add_exec.php">
                            <input id="client_id" name="client_id" type="hidden" value="<?php echo $data['id']; ?>"/>
                            <input id="pic_cin" name="pic_cin" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>

                            <div class="column">
                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">FULL NAME<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_name" name="client_name" type="text" readonly required value="<? echo $data['client_name'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label class="control-label">IC/PASSPORT NUMBER<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_ic" name="client_ic" type="text" readonly required value="<? echo $data['client_ic'];?>" style="text-transform:uppercase"/>
                                    </div>
                                    <div class="col-xs-6">
                                        <label class="control-label">CONTACT NUMBER<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_phone_no" name="client_phone_no" type="text" readonly required value="<? echo $data['client_phone_no'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label>COMPANY<font color="red">**</font>&nbsp;</label>
                                        <select readonly required class="form-control" name="client_company_id" id="client_company_id">
                                            <option value="">-- Choose Company Client --</option>
                                            <? echo getDropDownCompanyClient($data['client_company_id']);?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">ADDRESS<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_address" name="client_address" type="text" readonly required value="<? echo $data['client_address'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">STATE<font color="red">&nbsp;*</font></label>
                                        <select readonly class="form-control" name="client_state" id="client_state">
                                            <option value="">-- Choose State --</option>
                                            <? echo getDropDownState($data['client_state']); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label class="control-label">CITY<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_city" name="client_city" type="text" readonly value="<? echo $data['client_city'];?>" style="text-transform:uppercase"/>
                                    </div>

                                    <div class="col-xs-6">
                                        <label class="control-label">POSTCODE<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_postcode" name="client_postcode" type="text" readonly value="<? echo $data['client_postcode'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>


                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">CAR REGISTRATION<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_car" name="client_car" type="text" readonly value="<? echo $data['client_car'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>
                            </div>

                            <div class="column">

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label class="control-label">ARRIVAL DATE<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="arrival_date" name="arrival_date" type="date" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>

                                    <div class="col-xs-4">
                                        <label class="control-label">TIME<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="arrival_time" name="arrival_time" type="time" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label class="control-label">DEPARTURE DATE</label>
                                        <input class="form-control" id="departure_date" name="departure_date" type="date" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="control-label">TIME</label>
                                        <input class="form-control" id="departure_time" name="departure_time" type="time" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">ROOM NO<font color="red">&nbsp;*</font></label>
                                        <select  required class="form-control" name="room_id" id="room_id" onClick = "getroom()">
                                            <option value="">-- Choose Room --</option>
                                            <? echo getDropDownRoom(""); ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label class="control-label">BED NO<font color="red">&nbsp;*</font></label>
                                        <select  required class="form-control" name="bed_id" id="bed_id">
                                            <option value="">-- Choose Bed --</option>
                                            <? echo getDropDownBed(""); ?>
                                        </select>
                                    </div>

                                    <div class="col-xs-6">
                                        <label class="control-label">LOCKER NO<font color="red">&nbsp;*</font></label>
                                        <select  required class="form-control" name="locker_id" id="locker_id">
                                            <option value="">-- Choose Locker --</option>
                                            <? echo getDropDownLocker(""); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div align="center">

                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                </div>
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
        <? include ('../global/footer.php'); ?>
        <!-- /#wrapper -->

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