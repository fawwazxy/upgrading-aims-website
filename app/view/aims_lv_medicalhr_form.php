<?php

include ('../controller/auth.php');


require "../model/aims_lv_medical_function.php";

$no_staff = $_GET['no_staff'];
$medical_id = $_GET['medical_id'];
$staff_record_id = $_GET['staff_record_id'];
$id = $_GET['id'];
$staff = getStaffMedicalById($id)-> fetch_assoc();

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

    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>

</head>
<style type="text/css">
    input.unit{
        width: 100px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 6px 6px 6px 6px;
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

                    <? include ('../../app/global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">TOTAL MEDICAL CLAIM</h1>

                <div class="row">
                    <div class="col-lg-12">
                        <label>NAME &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['name'];?>
                        <br><label>IC NUMBER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['noic'];?>
                        <br><label>POSITION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['role_id'];?>
                        <br><label>DEPARTMENT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['department_sub'];?>
                        <br><label>COMPANY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['department_id'];?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/aims_lv_medicalver_exec.php" enctype="multipart/form-data">
                    <div>
                        <!--  <input name="id" type="text" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" /> -->
                        <input name="medical_id" type="hidden" class="input-short" value="<? echo $staff['id'];?>" />
                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff['staff_record_id'];?>" />
                        <input name="department_id" type="hidden" class="input-short" value="<? echo $staff['department_id'];?>"/>
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                        <input name="position" type="hidden" class="input-short" value="<? echo $staff['role_id'];?>"/>
                        <input name="code_department" type="hidden" class="input-short" value="<? echo $staff['company_name'];?>"/>
                    </div>

                    <div class="form-group" align="right">
                        <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">MEDICAL CLAIM</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="form-group row" align="center">
                                <table border="1" cellspacing="3" cellpadding="5" >
                                    <tr>
                                        <th style="text-align:center;">TOTAL MEDICAL(RM)</th>
                                        <th style="text-align:center;">TOTAL CLAIM (RM)</th>
                                        <th style="text-align:center;">BALANCE (RM)</th>
                                        <th style="text-align:center;">REMARKS</th>
                                    </tr>
                                    <tr>
                                        <td><input style="padding:30px;" type="text" id="baki_claim" name="baki_claim" style="text-transform:uppercase" value="<? echo $staff['baki_claim'];?>" onkeyup="subtract()"></td>
                                        <td><input style="padding:30px;" type="text" id="total_claim" name="total_claim" style="text-transform:uppercase" value="<? echo $staff['total_claim'];?>" onkeyup="subtract()"></td>
                                        <td><input style="padding:30px;" type="text" id="jumlah_claim" name="jumlah_claim" style="text-transform:uppercase" value="<? echo $staff['jumlah_claim'];?>" value="subtract()"></td>
                                        <td><input style="padding:30px;" type="text" id="remarks" name="remarks" style="text-transform:uppercase" value="<? echo $staff['remarks'];?>"></td>
                                    </tr>

                                </table></div>

                            <div class="col-sm-12">
                                <br>
                                <div class="form-group" align="left">
                                    <!-- <label>REMINDER</label>

                                     <p>1. PLEASE ATTACHED TOGETHER SUPPORTING DOCUMENT.</p>
                                     <p>2. THE FORM MUST BE VERIFIED BY HUMAN RESOUCES DEPARTMENT</p> -->


                                </div>




                            </div>
                        </div>
                    </div>
                    <div class="form-group" align="center">

                        <button type="submit" class="btn btn-success">Simpan</button>

                        <!-- <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()"> -->
                    </div>
                </form>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<!-- /#wrapper -->


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageprev').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });


</script>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>

<script>

    function subtract(){

        var baki_claim = document.getElementById('baki_claim').value;
        var total_claim = document.getElementById('total_claim').value;

        var total = (baki_claim - total_claim);
        var totals = total;
        var jumlah_claim = document.getElementById('jumlah_claim');
        jumlah_claim.value = totals;
    }


</script>

</body>

</html>