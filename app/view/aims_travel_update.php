<?php

include ('../controller/auth.php');

require "../model/aims_travel_function.php";
require "../model/lookup.php";


$id = $_GET['id'];
$travel_info = getTravelById($id)->fetch_assoc();
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

    .text{transition: all 1s linear;}

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
                <h1 class="page-header">TRAVEL AUTHORISATION AND APARTMENT/HOTEL APPLICATION</h1>
            </div>
        </div>



        <div class="form-group" align="right">
            <input class="btn btn-primary" type="button" value="Back" onclick="goBack()">
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <label class="control-label">TRAVEL AUTHORISATION FORM (TAF)</label>
                    </div>

                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_travel_update_exec.php">
                            <input id="id" name="id" type="hidden" value="<?php echo $travel_info['id'] ?>"/>



                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label class="control-label">Company<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="company_id" id="company_id">
                                        <option value="">-- Choose Company --</option>
                                        <? echo getDropDownCompany($travel_info['company_id']);?>
                                    </select>

                                </div>
                                <div class="col-xs-5">
                                    <label class="control-label">Department<font color="red">&nbsp;*</font></label>
                                    <input readonly class="form-control" id="department_id" name="department_id" type="text" required value="<? echo $travel_info['department_id'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Staff No<font color="red">&nbsp;*</font></label>
                                    <input readonly class="form-control" id="no_staff" name="no_staff" type="text" required value="<? echo $travel_info['no_staff'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-6">
                                    <label class="control-label">Name<font color="red">&nbsp;*</font></label>
                                    <input readonly class="form-control" id="name" name="name" type="text" required value="<? echo $travel_info['name'] ?>"  onkeyup="convertToUppercase(this)"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Designation<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="staff_designation" name="staff_designation" type="text" required value="<? echo $travel_info['staff_designation'] ?>" onkeyup="convertToUppercase(this)"/>
                                </div>

                                <div class="col-xs-6">
                                    <label class="control-label">I/C No<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="noic" name="noic" type="text" required value="<? echo $travel_info['noic'] ?>" onkeyup="multi()"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Mode of Travel<font color="red">&nbsp;*</font></label>
                                    <select  required class="form-control" name="travel_mode_id" id="travel_mode_id" style="">
                                        <option value="">-- Choose Transport --</option>
                                        <? echo getDropDownTravelMode($travel_info['travel_mode_id']);?>
                                    </select>
                                </div>

                                <div class="col-xs-6">
                                    <label class="control-label">Job No<font color="red">&nbsp;</font></label>
                                    <input class="form-control" id="job_no" name="job_no" type="text" value="" onkeyup="convertToUppercase(this)" value="<? echo $travel_info['job_no'] ?>"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label class="control-label">Purpose<font color="red">&nbsp;*</font></label>
                                    <textarea class="form-control" id="travel_purpose" name="travel_purpose" type="text" value="" rows="5" onkeyup="convertToUppercase(this)"><? echo $travel_info['travel_purpose'] ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Departure Date<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="departure_date" name="departure_date" type="date" required value="<? echo $travel_info['departure_date'] ?>" style="text-transform:uppercase;"/>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Departure Time (hh:mm:AM/PM)<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="departure_time" name="departure_time" type="time" required value="<? echo $travel_info['departure_time'] ?>" style="text-transform:uppercase;"/>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label class="control-label">Return Date<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="return_date" name="return_date" type="date" required value="<? echo $travel_info['return_date'] ?>" style="text-transform:uppercase;"/>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Return Time (hh:mm:AM/PM)<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="return_time" name="return_time" type="time" value="<? echo $travel_info['return_time'] ?>" style="text-transform:uppercase;"/>
                                </div>
                            </div>



                            <div class="form-group row" align="left">

                            </div>

                    </div>
                    <div class="panel-heading">
                        <label class="control-label">APARTMENT/HOTEL ACCOMODATION</label>
                    </div>
                    <div class="panel panel-body">


                        <div class="form-group row" align="left" style="margin-left:0.1%">
                            <label class="control-label">Request for hotel: </label>&nbsp;&nbsp;&nbsp;
                            <input type="radio" <?php if($travel_info['request_hotel']=="YES") {echo "checked";}?> name="request_hotel" id="r1" value="YES" onclick="myFunction()"> Yes&nbsp;&nbsp;
                            <input type="radio" <?php if($travel_info['request_hotel']=="NO") {echo "checked";}?> name="request_hotel" id="r2" value="NO" onclick="myFunction()"> No</p>

                            <div id="text" class="text">

                                <div class="form-group" style="width: 30%; float: left; margin-left: 1%">
                                    <label class="control-label">Duration of Stay (Days):<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" type="number" id="hotel_duration" name="hotel_duration" step="1" min="0" value="<? echo $travel_info['hotel_duration'] ?>"/>
                                </div>

                                <div class="form-group" style="width: 30%; float: left; margin-left: 4%">
                                    <label class="control-label">Date Check In<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="check_in" name="check_in" type="date" value="" style="text-transform:uppercase;" value="<? echo $travel_info['check_in'] ?>"/>
                                </div>

                                <div class="form-group" style="width: 30%; float: left; margin-left: 35%">
                                    <label class="control-label">Date Check Out<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="check_out" name="check_out" type="date" value="" style="text-transform:uppercase;" value="check_out"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <label class="control-label">TRANSPORTATION</label>
                    </div>
                    <div class="panel panel-body">

                        <div class="form-group row" align="left">
                            <div class="col-xs-5">
                                <div style="float:left" style="margin-left:1%">
                                    <p><label class="control-label">Transportation From Airport (KT/KUA) :</label></p>
                                    <p><input type="radio" id="transport_fairport" <?php if($travel_info['transport_fairport']=="YES") {echo "checked";}?> name="transport_fairport" value="YES"> Yes &nbsp;
                                        <input type="radio" name="transport_fairport" <?php if($travel_info['transport_fairport']=="NO") {echo "checked";}?> value="NO"> No</p>

                                </div>
                            </div>
                            <div class="col-xs-5">
                                <p><label class="control-label">Transportation To Airport (KT/KUA) :</label></p>
                                <p><input type="radio" id="transport_tairport" name="transport_tairport" <?php if($travel_info['transport_tairport']=="YES") {echo "checked";}?> value="YES"> Yes &nbsp;
                                    <input type="radio" name="transport_tairport" <?php if($travel_info['transport_tairport']=="NO") {echo "checked";}?> value="NO"> No</p>
                            </div>
                        </div>


                        <div class="form-group row" align="left">
                            <div class="col-xs-8">
                                <label class="control-label">Request for Company Driver: </label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="request_driver" id="request_driver" <?php if($travel_info['request_driver']=="YES") {echo "checked";}?> value="YES"> Yes&nbsp;&nbsp;
                                <input type="radio" name="request_driver" <?php if($travel_info['request_driver']=="NO") {echo "checked";}?> value="NO"> No</p>
                                <div id="text2">
                                    <label class="control-label">Destination<font color="red">&nbsp;*</font></label>
                                    <input required class="form-control" id="destination" name="destination" type="text" onkeyup="convertToUppercase(this)" style="width:50%" value="<? echo $travel_info['destination'] ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" align="left" >
                            <div class="col-xs-8">
                                <label class="control-label">Advance Required: </label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="advance1" name="advance_required" onclick="myFunction3()" <?php if($travel_info['advance_required']=="YES") {echo "checked";}?> value="YES"> Yes&nbsp;&nbsp;
                                <input type="radio" id="advance2" name="advance_required" onclick="myFunction3()" <?php if($travel_info['advance_required']=="NO") {echo "checked";}?> value="NO"> No</p>
                                <div id="text3" margin-left: 1%">
                                <div id="left" style="float:left">
                                    <label class="control-label">Total (RM):<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" id="travel_advance" name="travel_advance" type="text" value="<? echo $travel_info['travel_advance'] ?>" style="text-transform:uppercase;width:150%" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div align="center">
                        <button type="submit" class="btn btn-success">Edit</button>
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
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /.row -->
    <!-- /.container-fluid -->
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




    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    /*	function myFunction() {
          var r1 = document.getElementById("r1");
          var r2 = document.getElementById("r2");
          var text = document.getElementById("text");
            if (r1.checked == true){
            text.style.display = "block";
          } else if (r2.checked == true) {
             text.style.display = "none";
          }
        } */

    /*		function myFunction2() {
              var checkBox = document.getElementById("request_driver");
              var text = document.getElementById("text2");
              if (checkBox.checked == true){
                text.style.display = "block";
              } else {
                 text.style.display = "none";
              }
            }
    */
    /*		function myFunction3() {
              var r1 = document.getElementById("advance1");
              var r2 = document.getElementById("advance2");
              var text = document.getElementById("text3");
             if (r1.checked == true){
                text.style.display = "block";
              } else if (r2.checked == true) {
                 text.style.display = "none";
              }
            }
            */

    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }


    setInputFilter(document.getElementById("travel_advance"), function(value) {
        return /^-?\d*[.,]?\d{0,2}$/.test(value); });

</script>

</body>

</html>