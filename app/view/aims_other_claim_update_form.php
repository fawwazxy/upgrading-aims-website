<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_function.php";


$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$claim = getStaffById2($id) -> fetch_assoc();
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
    <form method="post" action="../controller/aims_otherclaim_update_form_exec.php"
          enctype="multipart/form-data">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">CLAIM UPDATE FORM</h1>
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
                                        <select  required class="form-control" name="company_claim" id="company_claim" disabled>
                                            <option value="">-- Choose Company--</option>
                                            <? echo getDropDownCompany($claim['company_claim'])?>
                                        </select>
                                    </div>

                                    <div class="col-xs-6">
                                        <label>Job No: </label><br>
                                        <input type="text" required="" class="form-control" placeholder="" id="job_no" name="job_no" value="<?php echo $claim['job_no']?>" readonly/>
                                    </div>

                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-6">
                                        <label>Date: </label><br>
                                        <input type="date"  class="form-control" placeholder="" id="date_purchase" name="date_purchase" value="<?php echo $claim['date_purchase']?>" />
                                        <input type="hidden" required="" class="form-control" placeholder="" id="id" name="id" value="<?php echo $id?>" />
                                    </div>

                                    <div class="col-xs-6">
                                        <div id="head2">
                                            <label>Claim For The Month Ended: <font color="red">**</font>&nbsp;</label><br>
                                            <select class="form-control" id='month_claim' name="month_claim" onchange="show_month()" disabled>
                                                <option selected value='<?php echo $claim['month_claim']?>'><?php echo $claim['month_claim']?></option>
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
                                        <input type="datetime-local"  class="form-control" placeholder="" id="time_departure" name="time_departure" value="<?php echo date('Y-m-d\TH:i', strtotime($claim['time_departure']));?>" /><br>
                                        <label>Date Time Arrival: <font color="red">**</font>&nbsp;</label><br>
                                        <input type="datetime-local"  class="form-control" placeholder="" id="time_arrival" name="time_arrival" value="<?php echo date('Y-m-d\TH:i', strtotime($claim['time_arrival']));?>" />
                                    </div>
                                    <div class="col-xs-6">
                                        <label>Details Description: </label><br>
                                        <textarea id="description" name="description" rows="5" cols="70"  required="" class="form-control" placeholder="" onkeyup="convertToUppercase(this)" value="<?php echo $claim['description']?>"><?php echo $claim['description']?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-3">
                                        <label>Milage (KM*RM)</label><br>
                                        <input size="int" type="" class="form-control" placeholder="" id="milage" name="milage" value="<?php echo $claim['milage']?>" readonly>
                                        <input type="hidden" name="no_staff" value="<? echo $no_staff?>">
                                    </div>
                                    <div class="col-xs-3">
                                        <label>Hotel/Lodging Allowance (RM)<font color="red">**</font>&nbsp;</label><br>
                                        <input size="int" type="" class="form-control" placeholder="" id="hotel_allowance" name="hotel_allowance" value="<?php echo $claim['hotel_allowance']?>" readonly>
                                    </div>
                                    <div class="col-xs-3">
                                        <label>Daily Allowance (RM)</label><br>
                                        <input size="int" type=""  class="form-control" placeholder="" id="daily_allowance" name="daily_allowance" value="<?php echo $claim['daily_allowance']?>" readonly>
                                    </div>
                                    <div class="col-xs-3">
                                        <label>Others Claim (RM)</label><br>
                                        <input size="int" type="" class="form-control" placeholder="" id="total_claim" name="total_claim" value="<?php echo $claim['total_claim']?>" readonly>
                                    </div>
                                </div>



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
<script type="text/javascript">
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>


</body>

</html>