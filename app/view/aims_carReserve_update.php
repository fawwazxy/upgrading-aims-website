<?php
include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$status = $_GET['status'];
$status1 = $_GET['status1'];
$car_info = getcarRequestById($id)->fetch_assoc();
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
        #car_type{
            margin-left: 16px;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Car Reserve Info</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_carReserve_update_exec.php">
                            <input id="id" name="id" type="hidden" value="<? echo $id?>"/>
                            <input id="status" name="status" type="hidden" value="<? echo $status?>"/>
                            <input id="app_status" name="app_status" type="hidden" value="<? echo $status1?>"/>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Applicant Name&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="name" name="name" type="text" value="<?php echo $car_info['name'] ?>" readonly />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="jawatan">Designation&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="jawatan" name="jawatan" type="text" value="<? echo $car_info['jawatan'] ?>" readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="department_name">Department&nbsp;<span style="color: red">*</span></label>
                                        <select  required class="form-control" name="department_name" id="department_name">
                                            <option value="">-- Choose Department --</option>
                                            <? echo getDropDowndepartment($car_info['department_name']);?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="drivername">Driver Name&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="drivername" name="drivername" type="text" value="<? echo $car_info['drivername'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="purpose">Purpose&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="purpose" name="purpose" type="text" value="<? echo $car_info['purpose'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="destination">Destination&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="destination" name="destination" type="text" value="<? echo $car_info['destination'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="company_name">Company Name&nbsp;<span style="color: red">*</span></label>
                                        <!--                                    <input class="form-control" id="company_name" name="company_name" type="text" value="--><?php //echo $_SESSION['SESS_DEPARTMENT'] ?><!--" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" />-->
                                        <select class="form-control" name="company_name" id="company_name" required>
                                            <? echo getDropdownCompany($_SESSION['SESS_DEPARTMENT']) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="car_type">Type Of Vehicle&nbsp;<span style="color: red">*</span></label><br>

                                        <input type="radio" id="car_type" name="car_type" <?php if($car_info['car_type']=="SUV") echo "checked";?> value="SUV">
                                        <span>SUV</span>
                                        <input type="radio" id="car_type" name="car_type" <?php if($car_info['car_type']=="4X4") echo "checked";?> value="4X4">
                                        <span>4X4</span>
                                        <input type="radio" id="car_type" name="car_type" <?php if($car_info['car_type']=="VAN") echo "checked";?> value="VAN">
                                        <span>VAN</span>
                                        <input type="radio" id="car_type" name="car_type" <?php if($car_info['car_type']=="MPV") echo "checked";?> value="MPV">
                                        <span>MPV</span>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="no_passengers">Number Of Passengers&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="no_passengers" name="no_passengers" type="number"
                                               value="<? echo $car_info['no_passengers'] ?>" min="0" max="10" step="1"/>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="car_plate_no" class="control-label">Plate No. - Car Model&nbsp;<span style="color: red; ">*</span></label>
                                        <select required class="form-control" id="car_plate_no" name="car_plate_no" required>
                                            <? echo getDropDownCarName($car_info['car_plate_no']) ;?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="dep_date">Departure Date&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="dep_date" name="dep_date" type="date"  value="<? echo $car_info['dep_date'] ?>" style="text-transform:uppercase" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="dep_time">Depature Time&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="dep_time" name="dep_time" type="time"  value="<? echo $car_info['dep_time'] ?>" style="text-transform:uppercase" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="dep_mileage">Departure Mileage&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="dep_mileage" name="dep_mileage" type="text" value="<? echo $car_info['dep_milage'] ?>" style="text-transform:uppercase" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="return_date">Return Date&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="return_date" name="return_date" type="date"  value="<? echo $car_info['return_date'] ?>" style="text-transform:uppercase" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="return_time">Return Time&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="return_time" name="return_time" type="time"  value="<? echo $car_info['return_time'] ?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="return_mileage">Return Mileage&nbsp;<span style="color: red">*</span></label>
                                        <input class="form-control" id="return_mileage" name="return_mileage" type="text"  value="<? echo $car_info['return_milage'] ?>" style="text-transform:uppercase"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="">I hearby declare that : &nbsp;<span style="color: red">*</span></label><br>
                                        <input type="radio" id="healty_status" name="healty_status" <?php if($car_info['healty_status']=="Fit_To_Travel") {echo "checked";}?> value="Fit_To_Travel">
                                        <label for="healty_status">Fit To Travel</label><br>
                                        <input type="radio" id="healty_status" name="healty_status" <?php if($car_info['healty_status']=="Not_Fit_To_Travel") {echo "checked";}?> value="Not_Fit_To_Travel">
                                        <label for="healty_status">Not Fit To Travel</label><br>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="illness">Illness :</label>
                                        <input class="form-control" id="illness" name="illness" type="text" <? echo ($car_info['healty_status'] == "Fit_To_Travel") ? "disabled" : "" ?>
                                               value="<? echo $car_info['illness'] ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <? if ($status != 'admin'){ ?>
                                    <button type="reset" onclick="goBack()" class="btn btn-primary">Back</button>
                                <? } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        $('input[name="healty_status"]').on('change', function (){
            let val = $(this).val();
            $('#illness').prop('disabled', val==="Fit_To_Travel");
        })
    });

    function goBack() {
        window.history.back();
    }

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
</body>
</html>