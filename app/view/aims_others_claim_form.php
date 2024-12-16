<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_function.php";


$staff_record_id = $_GET['staff_record_id'];
$no_staff = $_GET['no_staff'];
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
    $staff = getStaffForm($no_staff) -> fetch_assoc();
    ?>
    <form method="post" action="../controller/aims_others_claim_exec.php"
          enctype="multipart/form-data">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">CLAIM FORM</h1>
                </div>

            </div>




            <div class="panel-heading" align="right">
                <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <!-- /.panel-heading -->
                        <br>

                        <div class="panel-body">
                            <div class="col-sm-12">


                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label>Company: <font color="red">**</font>&nbsp;</label><br>
                                        <select  required class="form-control" name="company_claim" id="company_claim">
                                            <option value="">-- Choose Company--</option>
                                            <? echo getDropDownCompany("");?>
                                        </select>
                                    </div>

                                    <div class="col-xs-6">
                                        <label>Job No: </label><br>
                                        <input type="text"  class="form-control" placeholder="" id="job_no" name="job_no" value="" onkeyup="convertToUppercase(this)"/>
                                    </div>

                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label>Date: </label><br>
                                        <input type="date"  class="form-control" placeholder="" id="date_purchase" name="date_purchase" value="" />
                                        <input type="hidden" required="" class="form-control" placeholder="" id="staff_record_id" name="staff_record_id" value="<?php echo $staff_record_id?>" />
                                    </div>

                                    <div class="col-xs-6">
                                        <div id="head2">
                                            <label>Claim For The Month Ended: <font color="red">**</font>&nbsp;</label><br>
                                            <select required="" class="form-control" id='month_claim' name="month_claim" onchange="show_month()" >
                                                <option selected value=''>--SELECT MONTH--</option>
                                                <option value='JANUARY'>JANUARY</option>
                                                <option value='FEBRUARY'>FEBRUARY</option>
                                                <option value='MARCH'>MARCH</option>
                                                <option value='APRIL'>APRIL</option>
                                                <option value='MAY'>MAY</option>
                                                <option value='JUNE'>JUNE</option>
                                                <option value='JULY'>JULY</option>
                                                <option value='AUGUST'>AUGUST</option>
                                                <option value='SEPTEMBER'>SEPTEMBER</option>
                                                <option value='OCTOBER'>OCTOBER</option>
                                                <option value='NOVEMBER'>NOVEMBER</option>
                                                <option value='DECEMBER'>DECEMBER</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label>Date Time departure: </label><br>
                                        <input type="datetime-local"  class="form-control" placeholder="" id="time_departure" name="time_departure" value="" /><br>
                                        <label>Date Time Arrival: </label><br>
                                        <input type="datetime-local"  class="form-control" placeholder="" id="time_arrival" name="time_arrival" value="" />
                                    </div>
                                    <div class="col-xs-6">
                                        <label>Details Description: </label><br>
                                        <textarea id="description" name="description" rows="5" cols="70"  required="" class="form-control" placeholder="" onkeyup="convertToUppercase(this)"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-3">
                                        <label>Milage (KM*RM)</label><br>
                                        <input size="int" type="" class="form-control" placeholder="" id="milage" name="milage" value="">
                                        <input type="hidden" name="no_staff" value="<? echo $no_staff?>">
                                    </div>
                                    <div class="col-xs-3">
                                        <label>Hotel/Lodging Allowance (RM)</label><br>
                                        <input size="int" type="" class="form-control" placeholder="" id="hotel_allowance" name="hotel_allowance" value="">
                                    </div>
                                    <div class="col-xs-3">
                                        <label>Daily Allowance (RM)</label><br>
                                        <input size="int" type=""  class="form-control" placeholder="" id="daily_allowance" name="daily_allowance" value="">
                                    </div>
                                    <div class="col-xs-3">
                                        <label>Others Claim (RM)</label><br>
                                        <input size="int" type="" class="form-control" placeholder="" id="total_claim" name="total_claim" value="">
                                    </div>
                                </div>
                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Attachment&nbsp;<font color="red"><i>(Only pdf/jpeg/jpg/png/gif format file are allowed)</i></font></label>
                                        <input type="hidden" name="MAX_FILE_SIZE">
                                        <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                                    </div>
                                </div>

                                <label>REMINDER: PLEASE ATTACH TOGETHER THE RELATED SUPPORTING DOCUMENT</label>
                                <div class="modal-footer">
                                    <div align="center">
                                        <button href="aims_others_claim_list.php?" type="submit" class="btn btn-primary">SUBMIT</button>

                                    </div>
                                </div><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <? include ('../global/footer.php'); ?>
        </div>
    </form>
</div>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>


</body>

</html>