<?php

include ('../controller/auth.php');

require "../model/aims_ot_function.php";


$staff_record_id = $_GET['staff_record_id'];
$no_staff = $_GET['no_staff'];

date_default_timezone_set("Asia/Kuala_Lumpur");
$current_date = date("Y-m-d");
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
    <?
    $staff = getOtStaffInfo($no_staff) -> fetch_assoc();
    ?>


    <div id="page-wrapper">



        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    OVERTIME FORM
                    <!--<a href="v02_aims_ot_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>

        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="panel-heading" align="right">
            <div align="right">
                <a href="aims_ot_list.php"><button class="btn btn-primary">Back</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <!-- /.panel-heading -->
                    <br>

                    <div class="panel-body">
                        <div class="col-sm-12">

                            <form method="post" action="../controller/aims_otadd_exec.php" enctype="multipart/form-data">
                                <input type="hidden" id="staff_record_id" name="staff_record_id" value="<?php echo $staff_record_id; ?>" />
                                <input type="hidden" id="no_staff" name="no_staff" value="<? echo $no_staff; ?>" />
                                <input type="hidden" id="staff_name" name="staff_name" value="<? echo $staff['name']; ?>" />
                                <input type="hidden" id="icno" name="icno" value="<? echo $staff['noic']; ?>" />
                                <input type="hidden" id="company_id" name="company_id" value="<? echo $staff['department_id']; ?>" />
                                <input type="hidden" id="position" name="position" value="<? echo $_SESSION['SESS_ROLE']; ?>"/>
                                <input type="hidden" id="current_date" name="current_date" value="<? echo $current_date; ?>" />


                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label>Claim For The Month Ended: <font color="red">**</font></label><br>
                                        <select required class="form-control" name="month_claim" id="month_claim">
                                            <option value="">-- Choose Month--</option>
                                            <? echo getDropDownMonthHuruf("");?>
                                        </select>
                                    </div>
                                </div>

                                <!--	<div class="form-group row" align="left">

                                        <div class="col-xs-6">
                                            <label>Position: <font color="red">**</font>&nbsp;</label><br>

                                        </div>
                                    </div> -->

                                <div class="form-group row" align="left">

                                    <div class="col-xs-6">
                                        <label>Date: <font color="red">**</font>&nbsp;</label><br>
                                        <input type="date" required="" class="form-control" placeholder="" id="date_ot" name="date_ot" onchange="showDate(this.value)" value="" />
                                    </div>

                                    <div class="col-xs-6">
                                        <label>Day:<font color="red">**</font>&nbsp;</label><br>
                                        <input type="text" required class="form-control" placeholder="" id="day_ot" name="day_ot" value="" />
                                    </div>
                                </div>

                                <div class="form-group row" align="left">

                                    <div class="col-xs-6">
                                        <label>Start: <font color="red">**</font>&nbsp;</label><br>
                                        <input type="time" required="" class="form-control" placeholder="" onchange="diff()" id="start_ot" name="start_ot" value="" />
                                    </div>

                                    <div class="col-xs-6">
                                        <label>End:<font color="red">**</font>&nbsp;</label><br>
                                        <input type="time" required class="form-control" placeholder="" onchange="diff()" id="end_ot" name="end_ot" value="" />
                                    </div>
                                </div>


                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label>Working Period: <font color="red">**</font>&nbsp;</label><br>
                                        <input type="text" required class="form-control" placeholder="0H 00M" id="working_hours" name="working_hours" value="" onkeyup="convertToUppercase(this)">
                                    </div>

                                    <div class="col-xs-6">
                                        <label>Types of Claim: <font color="red">**</font>&nbsp;</label><br>
                                        <input type="text" required class="form-control" placeholder="" id="type_claim" name="type_claim" value="OT CLAIM" onkeyup="convertToUppercase(this)">
                                    </div>
                                </div>


                                <div class="form-group row" align="left">
                                    <div class="col-xs-12">
                                        <label>Work Description: <font color="red">**</font>&nbsp;</label><br>
                                        <textarea id="description_ot" name="description_ot" rows="7" cols="70"  required="" class="form-control" placeholder="" onkeyup="convertToUppercase(this)"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Attachment&nbsp;<font color="red"><i>(Only pdf/jpeg/jpg/png/gif format file are allowed)</i></font></label>
                                        <input type="hidden" name="MAX_FILE_SIZE">
                                        <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                                    </div>
                                </div>

                                <label>REMINDER: PLEASE FILL UP CLAIM BEFORE 15th DAY OF EVERY MONTH.</label>
                                <label>FOR DATES <font color="red">OVER 15th, PLEASE CHOOSE NEXT MONTH AS THE MONTH CLAIM.</font></label>
                                <div class="modal-footer">
                                    <div align="center">
                                        <button href="aims_others_claim_list.php?" type="submit" class="btn btn-primary">Submit</button>

                                    </div>
                                </div><br>
                            </form>
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

</div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function showDate(getdate) {
        var selectedDate = new Date(getdate);
        var dateformat = getdate.split('-')
        var displaydate = document.getElementById('day_ot')
        var days = ["SUNDAY", "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY"];


        displaydate.value = days[selectedDate.getDay()];

    }

    function diff() {
        var timeOfCall = $('#start_ot').val(),
            timeOfResponse = $('#end_ot').val(),
            hours = timeOfResponse.split(':')[0] - timeOfCall.split(':')[0],
            minutes = timeOfResponse.split(':')[1] - timeOfCall.split(':')[1];

        minutes = minutes.toString().length<2?'0'+minutes:minutes;
        if(minutes<0){
            hours--;
            minutes = 60 + minutes;
        }
        hours = hours.toString().length<2?''+hours:hours;

        if(hours>='0'){
            $('#working_hours').val(hours + 'H ' + minutes + 'M');
        }
    }

</script>



</body>

</html>