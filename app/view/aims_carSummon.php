<?
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";
$staff_name = $_SESSION['SESS_NAME'];
$id = $_GET['id'];
$car_info = getcarRequestById($id)->fetch_assoc();

$car_applicant_name = ($id=='0') ? "" : $car_info['name'];
$readonly = ($id=='0') ? "" : "readonly";
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
                <h1 class="page-header">Summon Add</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label">SUMMON DETAILS</label>
                    </div>
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_carSummon_add.php">
                            <input type="hidden" name="reserve_id" value="<?php echo $car_info['id']; ?>">
                            <input type="hidden" name="summon_by" value="<?php echo $staff_name; ?>">

                            <div class="form-group row">
                                <div class="col-xs-4">
                                    <label for="name" class="control-label">Applicant Name&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" value="<? echo $car_applicant_name ?>" <? echo $readonly ?>/>
                                </div>

                                <div class="col-xs-4">
                                    <label for="company_name" class="control-label">Company Name&nbsp;<span style="color: red; ">*</span></label>
                                    <? if ($id != '0') {?>
                                        <input type="hidden" name="company_name" id="company_name" value="<? echo $car_info['company_name'] ?>">
                                    <? } ?>
                                    <select required class="form-control" name="company_name" id="company_name" <? echo ($id != '0') ? "disabled" : ""; ?>>
                                        <option value="">-- Choose Company Name --</option>
                                        <? echo getDropDownCompany($car_info['department_id']); ?>
                                    </select>
                                </div>

                                <div class="col-xs-4">
                                    <label for="car_plate_no" class="control-label">Plate Number - Car Model&nbsp;<span style="color: red; ">*</span></label>
                                    <? if ($id != '0') {?>
                                        <input type="hidden" name="car_plate_no" id="car_plate_no" value="<? echo $car_info['car_plate_no'] ?>">
                                    <? } ?>
                                    <select required class="form-control" name="car_plate_no" id="car_plate_no" <? echo ($id != '0') ? "disabled" : ""; ?>>
                                        <? echo getDropDownCarName($car_info['car_plate_no']) ;?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-3">
                                    <label for="issue_district" class="control-label">Issue district&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="issue_district" name="issue_district" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" />
                                </div>
                                <div class="col-xs-3">
                                    <label for="offense_details" class="control-label">Offense Details&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="offense_details" name="offense_details" type="text" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label" for="destination">Destination&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="destination" name="destination" type="text" value="" <? echo ($id == '0') ? 'required' : 'placeholder="'.$car_info['destination'].'" disabled' ?>/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-3">
                                    <label for="summons_no" class="control-label">Summon No&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="summons_no" name="summons_no" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-3">
                                    <label for="offense" class="control-label">Offense (datetime)&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="offense" name="offense" type="datetime-local" required value="" style="text-transform:uppercase"/>
                                </div>
                                <div class="col-xs-3">
                                    <label for="enforcement_date" class="control-label">Enforcement Date&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="enforcement_date" name="enforcement_date" type="date" required value="" style="text-transform:uppercase" />
                                </div>

                                <div class="col-xs-3">
                                    <label for="original_amount" class="control-label">Original Amount (RM)&nbsp;<span style="color: red; ">*</span></label>
                                    <input class="form-control" id="original_amount" name="original_amount" type="text" value=""
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <? if ($id == '0'){ ?>
                                    <button type="reset" onclick="window.history.back();" class="btn btn-primary">Back</button>
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
    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
</body>
</html>