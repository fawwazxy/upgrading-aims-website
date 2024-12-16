<?php
echo "<script>
alert('This module has been migrated to Aims-Corp. Please visit https://corp.aimsglobal.com.my to use this module.');
window.history.back();
</script>";
exit();

include ('../controller/auth.php');
require "../model/aims_car_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$taf_id = $_GET['taf_id'];
$staff_designation = $_GET['staff_designation'];
$destination = $_GET['destination'];
$departure_date = $_GET['departure_date'];
$return_date = $_GET['return_date'];
$departure_time = $_GET['departure_time'];
$return_time = $_GET['return_time'];
$travel_purpose = $_GET['travel_purpose'];
$car_info = getcarById($id)->fetch_assoc();

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
                <h1 class="page-header">Vehicle Usage Form</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_carReserve_add_exec.php">
                            <input type="hidden" name="id" value="<?php echo $car_info['id']; ?>">
                            <input type="hidden" name="taf_id" value="<?php echo $taf_id ?>">
                            <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>


                            <label class="control-label">APPLICANT DETAIL<font color="red">&nbsp;</font></label>
                            <hr>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">Applicant Name<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="name" name="name" type="text" value="<?php echo $_SESSION['SESS_NAME'] ?>" readonly />
                                </div>

                                <div class="col-xs-6">
                                    <label class="control-label">Designation</label>
                                    <input class="form-control" id="jawatan" name="jawatan" type="text" value="<?php echo $staff_designation ?>"/>
                                </div>



                            </div>



                            <div class="form-group row" align="left">

                                <div class="col-xs-4">
                                    <label class="control-label">Department<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="department_name" name="department_name" type="text" value="<?php echo $_SESSION['SESS_DEPARTMENT_SUB'] ?>" readonly />
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Driver Name<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="drivername" name="drivername" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Purpose<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="purpose" name="purpose" type="text" value="<?php echo $travel_purpose ?>" required value="" style="text-transform:uppercase"  onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-6">
                                    <label class="control-label">Destination<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="destination" name="destination" type="text" value="<?php echo $destination ?>" required value="" style="text-transform:uppercase"  onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-6">
                                    <label class="control-label">Company Name<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="company_name" name="company_name" type="text" value="<?php echo $_SESSION['SESS_DEPARTMENT'] ?>" readonly />
                                </div>


                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Type Of Vehicle<font color="red">&nbsp;*</font></label><br><br>
                                    <input type="checkbox" id="car_type" name="car_type" <?php if($car_info['car_type']=="SUV") {echo "checked";}?> value="SUV">
                                    <label for="car_type">SUV</label><br>
                                    <input type="checkbox" id="car_type" name="car_type" <?php if($car_info['car_type']=="4X4") {echo "checked";}?> value="4X4">
                                    <label for="car_type"> 4X4</label><br>
                                    <input type="checkbox" id="car_type" name="car_type" <?php if($car_info['car_type']=="VAN") {echo "checked";}?> value="VAN">
                                    <label for="car_type"> VAN</label><br>
                                    <input type="checkbox" id="car_type" name="car_type" <?php if($car_info['car_type']=="MPV") {echo "checked";}?> value="MPV">
                                    <label for="car_type"> MPV </label><br><br>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Number Of Passengers<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="no_passengers" name="no_passengers" type="text" required value="" style="text-transform:uppercase" />
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Plate Number<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="car_plate_no" id="car_plate_no">
                                        <option value="">-- Choose Plate --</option>
                                        <? echo getDropDownCarplate($car_info['car_plate_no']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Departure Date<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="dep_date" name="dep_date" type="date" value="<?php echo $departure_date ?>" required value="" style="text-transform:uppercase" />
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Depature Time<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="dep_time" name="dep_time" type="time" value="<?php echo $departure_time ?>" required value="" style="text-transform:uppercase" />
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Departure Mileage<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="dep_milage" name="dep_milage" type="text" value="" style="text-transform:uppercase" />
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Return Date<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="return_date" name="return_date" type="date" value="<?php echo $return_date ?>" required value="" style="text-transform:uppercase" />
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Return Time<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="return_time" name="return_time" type="time" value="<?php echo $return_time ?>" required value="" style="text-transform:uppercase"/>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Return Mileage<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="return_milage" name="return_milage" type="text" value="" style="text-transform:uppercase"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-12">
                                    <label class="control-label">I hearby declare that : <font color="red">&nbsp;*</font></label><br>
                                    <input type="checkbox" id="healty_status" name="healty_status" value="Fit_To_Travel">
                                    <label for="healty_status">Fit To Travel</label><br>
                                    <input type="checkbox" id="healty_status" name="healty_status" value="Not_Fit_To_Travel">
                                    <label for="healty_status">Not Fit To Travel</label><br>

                                </div>
                            </div>
                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>illness :</label> <input class="form-control" id="illness" name="illness" type="text" value="" style="text-transform:uppercase"/>

                                </div>
                            </div>




                            <div align="center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="reset" onclick="goBack()" class="btn btn-primary">Back</button>
                            </div>
                    </div>
                    </form>
                </div>
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


    function multi() {

        var amount_to_invoice = document.getElementById('amount_to_invoice').value;
        var sst = document.getElementById('sst').value;
        var b = (amount_to_invoice * sst);
        var total_amount = ((amount_to_invoice * 1) + b).toFixed(2);
        var total= total_amount.toString().replace(/\B(?=(\d{4})+(?!\d))/g, ",");
        var total_amount = document.getElementById('total_amount');
        total_amount.value = total;


    }


    function myFunction1() {
        var checkBox = document.getElementById("hod");
        var checkBox1 = document.getElementById("sbu");
        var text = document.getElementById("input");
        var text = document.getElementById("input1");


        if (checkBox.checked == true){
            input.style.display = "block";
        }

        else if (checkBox1.checked == true){
            input1.style.display = "block";
        }

        else {
            input.style.display = "none";
            input1.style.display = "none";
        }
    }


</script>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>

</html>