<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarsummonById($id)->fetch_assoc();
$readonly = (empty($car_info['reserve_id'])) ? "" : "readonly";
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
                <h1 class="page-header">Edit Summon</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label">SUMMON DETAILS</label>
                    </div>
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_carSummon_update.php">
                            <input type="hidden" name="id" value="<?php echo $car_info['id']; ?>">
                            <input type="hidden" name="reserve_id" value="<?php echo $car_info['reserve_id']; ?>">

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="name" class="control-label">Applicant Name&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" value="<? echo (empty($car_info['reserve_id'])) ? $car_info['guest_name'] : $car_info['name']?>" <? echo $readonly?> />
                                </div>

                                <div class="col-xs-6">
                                    <label for="company_name" class="control-label"> Company&nbsp;<span style="color: red; ">*</span></label>
                                    <? if (empty($car_info['reserve_id'])){ ?>
                                        <select required class="form-control" name="company_name" id="company_name">
                                            <option value="">-- Choose Company Name --</option>
                                            <? echo getDropDownCompany($car_info['guest_company_name']); ?>
                                        </select>
                                    <? } else { ?>
                                        <input class="form-control" id="company_name" name="company_name" type="text" value="<? echo getCompanyName($car_info['company_name']) ?>" disabled/>
                                    <? } ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-xs-3">
                                    <label class="control-label">Plate Number&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="company_name" name="car_plate_no" type="text" value="<? echo (empty($car_info['reserve_id'])) ? $car_info['guest_car_plate_no'] : $car_info['car_plate_no'] ?>" <? echo $readonly ?>
                                           style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                                <div class="col-xs-3">
                                    <label for="destination" class="control-label">Destination<span style="color: red; ">&nbsp;*</span></label>
                                    <input class="form-control" id="destination" name="destination" type="text" value="<? echo (empty($car_info['reserve_id'])) ? $car_info['guest_destination'] : $car_info['destination'] ?>" required <? echo $readonly ?>
                                           style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-6">
                                    <label for="issue_district" class="control-label">Issue district&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="issue_district" name="issue_district" type="text" required value="<?php echo $car_info['issue_distric']; ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="summons_no" class="control-label">Summon No&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="summons_no" name="summons_no" type="text" required value="<?php echo $car_info['summons_no']; ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-6">
                                    <label for="offense" class="control-label">Offense (Datetime)&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="offense" name="offense" type="datetime-local" value="<?php echo date('Y-m-d\TH:i:s', strtotime($car_info['offense'])); ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-4">
                                    <label for="enforcement_date" class="control-label">Enforcement Date&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="enforcement_date" name="enforcement_date" type="date" required value="<?php echo $car_info['enforcement_date']; ?>"/>
                                </div>

                                <div class="col-xs-4">
                                    <label for="offense_details" class="control-label">Offense Details&nbsp;<span style="color: red;">*</span></label>
                                    <input class="form-control" id="offense_details" name="offense_details" type="text" value="<?php echo $car_info['offense_details']; ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-4">
                                    <label for="original_amount" class="control-label">Original Amount (RM)&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="original_amount" name="original_amount" type="number" min="0" step="0.01" value="<?php echo $car_info['original_amount']; ?>"/>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="reset" onclick="goBack()" class="btn btn-info">Back</button>
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