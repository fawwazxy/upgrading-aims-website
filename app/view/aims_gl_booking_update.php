<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$book_info = getBookingById($id)->fetch_assoc();
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
                <h1 class="page-header"> Update Booking List</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_gl_booking_update_exec.php">
                            <!-- <input id="updated_by" name="updated_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/> -->
                            <input id="id" name="id" type="hidden" value="<?php echo $book_info['id']; ?>"/>

                            <div class="column">
                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">CLIENT NAME<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_name" name="client_name" type="text" required readonly value="<? echo $book_info['client_name'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label class="control-label">IC/PASSPORT NUMBER<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_ic" name="client_ic" type="text" required readonly value="<? echo $book_info['client_ic'];?>" style="text-transform:uppercase"/>
                                    </div>
                                    <div class="col-xs-6">
                                        <label class="control-label">CONTACT NUMBER<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_phone_no" name="client_phone_no" type="text" required readonly value="<? echo $book_info['client_phone_no'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">COMPANY<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_company_id" name="client_company_id" type="text" required readonly value="<? echo $book_info['company_name'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">ADDRESS<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="client_address" name="client_address" type="text" required readonly value="<? echo $book_info['client_address'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">STATE</label>
                                        <select readonly required class="form-control" name="client_state" id="client_state">
                                            <option value="">-- Choose State --</option>
                                            <? echo getDropDownState($book_info['client_state']);?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label class="control-label">CITY</label>
                                        <input class="form-control" id="client_city" name="client_city" type="text" required readonly value="<? echo $book_info['client_city'];?>" style="text-transform:uppercase"/>
                                    </div>

                                    <div class="col-xs-6">
                                        <label class="control-label">POSTCODE</label>
                                        <input class="form-control" id="client_postcode" name="client_postcode" type="text" required readonly value="<? echo $book_info['client_postcode'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>


                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">CAR REGISTRATION</label>
                                        <input class="form-control" id="client_car" name="client_car" type="text" readonly value="<? echo $book_info['client_car'];?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>
                            </div>

                            <div class="column">

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label class="control-label">ARRIVAL DATE<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="arrival_date" name="arrival_date" type="date" required value="<? echo $book_info['arrival_date'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>

                                    <div class="col-xs-4">
                                        <label class="control-label">TIME<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="arrival_time" name="arrival_time" type="time" required value="<? echo $book_info['arrival_time'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label class="control-label">DEPARTURE DATE</label>
                                        <input class="form-control" id="departure_date" name="departure_date" type="date" value="<? echo $book_info['departure_date'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="control-label">TIME</label>
                                        <input class="form-control" id="departure_time" name="departure_time" type="time" value="<? echo $book_info['departure_time'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label class="control-label">ROOM NO<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="room_id" name="room_id" readonly value="<? echo $book_info['room_id'];?>"/>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label class="control-label">LOCKER NO<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="locker_id" name="locker_id" readonly value="<? echo $book_info['locker_id'];?>"/>
                                    </div>
                                    <div class="col-xs-6">
                                        <label class="control-label">BED NO<font color="red">&nbsp;*</font></label>
                                        <input class="form-control" id="bed_id" name="bed_id" readonly value="<? echo $book_info['bed_id'];?>"/>
                                    </div>
                                </div>
                                <!-- <div class="form-group row" align="left">
					<div class="col-xs-12">
						<label class="control-label">ACCESS NO<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="access_no" name="access_no" type="text" value="<? echo $book_info['access_no'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					</div>
				</div> -->
                            </div>

                            <div class="row">
                                <div align="center">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>


                            <!-- <div align="center">
                                <button type="submit" class="btn btn-success">Edit</button>
                                <input class="btn btn-primary" type="button" value="Back" onclick="goBack()">
                            </div> -->
                        </form>
                    </div>
                    <script>
                        function convertToUppercase(el) {
                            if(!el || !el.value) return;
                            el.value = el.value.toUpperCase();
                        }
                    </script>
                </div>
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

</body>

</html>