<?php

include ('../controller/auth.php');
require "../model/cuti_function.php";

$start_maintenance = strtotime('2022-12-10 14:00:00');
$end_maintenance = strtotime('2022-12-10 16:00:00');
if (time() > $start_maintenance && time() < $end_maintenance){
    echo "<script>
            alert('Modul cuti sedang diselenggara sehingga jam 04.00pm.')
            window.history.back();
            </script>";
    exit();
}

$no_staff = $_GET['no_staff'];
$staff_record_id = $_GET['staff_record_id'];
$staff = getStaffInformation($_SESSION['SESS_NO_STAFF'])-> fetch_assoc();

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

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

    input.mycheck{

        display: inline-block;
        margin-left: 250px;
    }

    /* On mouse-over, add a grey background color */
    .mycheck:hover{
        background-color: black;
    }

    input{
        text-transform: uppercase;
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
                <h1 class="page-header">Borang Permohonan Cuti(Special)</h1>

                <div class="row">
                    <? include "v02_aims_lv_migration_message.php"; ?>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <label>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['staff_name'];?>
                        <br><label>No. Kad Pengenalan &nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['noic'];?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/aims_lv_special_exec.php" enctype="multipart/form-data">
                    <div>
                        <input name="id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" />
                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff['id'];?>" />
                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />
                        <input name="department_id" type="hidden" class="input-short" value="<? echo $staff['department_id'];?>"/>
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                    </div>

                    <div class="form-group" align="right">
                        <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">LEAVE FORM</label>
                        </div>
                        <h4 style="text-align: center;">SECTION A : FILL UP BY APPLICANT</h4>

                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="form-group row" align="left">
                                <label class="control-label col-sm-2" for="date_fill">Date:<font color="red">**</font>&nbsp;</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" id="date_fill" name="date_fill" required autocomplete="" value="">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <input type="radio" class="mycheck" name="dic_leave" value="LEAVE REQUEST"> Leave Request

                                &emsp;&emsp;&emsp;<input type="radio" class="mycheck" name="dic_leave" value="TAKE LEAVE"> Take Leave
                            </div>

                            <div class="form-group row" align="left">
                                <label class="control-label col-sm-2">Date of Leave:<font color="red">**</font>&nbsp;</label>
                                <label class="control-label col-sm-1" for="date_lv_from">From:</label>
                                <div class="col-sm-3">
                                    <input class="form-control" id="date_lv_from" name="date_lv_from" required value="<?if(!$date_lv_from){
                                        echo date("d/m/Y");
                                    }else{
                                        echo date($date_lv_from);
                                    }
                                    ?>">
                                </div>
                                <div class="form-group row" align="left">
                                    <label class="control-label col-sm-1" for="date_lv_to">To:</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="date_lv_to" name="date_lv_to" required value="<?if(!$date_lv_to){
                                            echo date("d/m/Y");
                                        }else{
                                            echo date($date_lv_to);
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <label class="control-label col-sm-2">Day of Leave:<font color="red">**</font>&nbsp;</label>
                                <label class="control-label col-sm-1" for="day_lv_from">From:</label>
                                <div class="col-sm-3">
                                    <select  required class="form-control" name="day_lv_from" id="day_lv_from">
                                        <option value="">-- Choose Day --</option>
                                        <option value="SUNDAY">Sunday</option>
                                        <option value="MONDAY">Monday</option>
                                        <option value="TUESDAY">Tuesday</option>
                                        <option value="WEDNESDAY">Wednesday</option>
                                        <option value="THURSDAY">Thursday</option>
                                        <option value="FRIDAY">Friday</option>
                                        <option value="SATURDAY">Saturday</option>


                                    </select>
                                </div>
                                <div class="form-group row" align="left">
                                    <label class="control-label col-sm-1" for="day_lv_to">From:</label>
                                    <div class="col-sm-3">
                                        <select  required class="form-control" name="day_lv_to" id="day_lv_to">
                                            <option value="">-- Choose Day --</option>
                                            <option value="SUNDAY">Sunday</option>
                                            <option value="MONDAY">Monday</option>
                                            <option value="TUESDAY">Tuesday</option>
                                            <option value="WEDNESDAY">Wednesday</option>
                                            <option value="THURSDAY">Thursday</option>
                                            <option value="FRIDAY">Friday</option>
                                            <option value="SATURDAY">Saturday</option>



                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!--<div class="form-group row" align="left">
							<label class="control-label col-sm-2" for="type_of_leave" name="type_of_leave">Type of Leave:<font color="red">**</font>&nbsp;</label>
							<label for="type_of_leave"></label>
							&emsp;<input type="radio" id="r1" name="type_leave" required autocomplete="" value="AL" onclick="myFunction()" /> Annual Leave
							&emsp;<input type="radio" id="r2" name="type_leave" value="MC" onclick="myFunction()" /> Medical Leave
							&emsp;<input type="radio" id="r2" name="type_leave" value="LP" onclick="myFunction()" /> Leave Without Pay
							&emsp;<input type="radio" id="r2" name="type_leave" value="CL" onclick="myFunction()" /> Compassionate Leave
							&emsp;<input type="radio" id="r2" name="type_leave" value="URL" onclick="myFunction()" /> Leave Without Record

							<div style="display: none;" id="text" class="col-sm-4">
								<select  required class="form-control" name="descrip" id="descrip">
								<option id="text">-- Choose Annual Leave --</option>
								<? echo getDropDownAnnual("");?>
								</select>
							</div>
						</div>-->

                            <div class="form-group row" align="left">
                                <label class="control-label col-sm-2" for="reason_leave">Reason of Leave:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="reason_leave" name="reason_leave" value="">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <label class="control-label col-sm-2" for="total_lv_req">Total Leave Request (Day)</label>
                                <div class="col-xs-5">
                                    <input class="form-control"  name="total_lv_req" id="total_lv_req"  required autocomplete="off">
                                </div>
                            </div>



                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Attachment&nbsp;<font color="red"><i>(Hanya fail format pdf/jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                    <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-success" onclick="return Confirm()">Simpan</button>
                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                <!-- <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()"> -->
            </div>

            </form>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>



<!-- /#wrapper -->


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>

    //radio button type leave
    function myFunction() {
        var r1 = document.getElementById("r1");
        var r2 = document.getElementById("r2");
        var text = document.getElementById("text");
        if (r1.checked == true){
            text.style.display = "block";
        } else if (r2.checked == true) {
            text.style.display = "none";
        }
    }

    //checkbox day leave
    function ValidateDaySelection()
    {
        var checkboxes = document.getElementsByName("day_leave");
        var numberOfCheckedItems = 0;
        for(var i = 0; i < checkboxes.length; i++)
        {
            if(checkboxes[i].checked)
                numberOfCheckedItems++;
        }
        if(numberOfCheckedItems > 6)
        {
            alert("You can't select more than six days !");
            return false;
        }
    }

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }



    var date_lv_from=$('input[name="date_lv_from"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_lv_from.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });
    var date_lv_to=$('input[name="date_lv_to"]'); //our date input has the name "date"
    // var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_lv_to.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,

        todayHighlight:true
    });
    /* $("#date_lv_to").change(function () {
             var days = 0;
             var millisecondsPerDay = 1000 * 60 * 60 * 24;
             var date_lv_from = stringToDate(document.getElementById("date_lv_from").value,"dd/MM/yyyy","/");
             var date_lv_to = stringToDate(document.getElementById("date_lv_to").value,"dd/MM/yyyy","/");

             var millisBetween = date_lv_to.getTime() - date_lv_from.getTime();
             days = millisBetween / millisecondsPerDay;
             // days = days+1;// add 1 sebab hari yg sama dikira satu hari
             //var mydate = new Date('2014-04-03');
             //var days= dateDiff(new Date(tarikh_mula), new Date(tarikh_akhir);
             days = days+1;
             document.getElementById("total_lv_req").value=days;
             var baki_cuti = document.getElementById("baki_cuti_pohon_cons").value;
             document.getElementById("baki_cuti_pohon").value=baki_cuti-days;
             // console.log(baki_cuti);
     }); */

    // function showDays(){

    //   //var tarikh_mula = new Date(document.getElementById("tarikh_mula").value);
    //   //var tarikh_akhir = new Date(document.getElementById("tarikh_akhir").value);
    //   var days = 0;
    //   var millisecondsPerDay = 1000 * 60 * 60 * 24;
    //   var tarikh_mula = stringToDate(document.getElementById("tarikh_mula").value,"dd/MM/yyyy","/");
    //   var tarikh_akhir = stringToDate(document.getElementById("tarikh_akhir").value,"dd/MM/yyyy","/");

    //   var millisBetween = tarikh_akhir.getTime() - tarikh_mula.getTime();
    //   days = millisBetween / millisecondsPerDay;
    //   days = days+1;// add 1 sebab hari yg sama dikira satu hari
    //   //var mydate = new Date('2014-04-03');
    //   //var days= dateDiff(new Date(tarikh_mula), new Date(tarikh_akhir);
    //   document.getElementById("jumlah_cuti").value=days;
    //   var baki_cuti = document.getElementById("baki_cuti").value;
    //   document.getElementById("baki_cuti").value=baki_cuti-days;
    //   console.log(baki_cuti);


    // }

    function stringToDate(_date,_format,_delimiter)
    {
        var formatLowerCase=_format.toLowerCase();
        var formatItems=formatLowerCase.split(_delimiter);
        var dateItems=_date.split(_delimiter);
        var monthIndex=formatItems.indexOf("mm");
        var dayIndex=formatItems.indexOf("dd");
        var yearIndex=formatItems.indexOf("yyyy");
        var month=parseInt(dateItems[monthIndex]);
        month-=1;
        var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
        return formatedDate;
    }

    function loadCuti(obj) {
        //alert(obj.value);
        if(obj.checked) {
            var objValue = obj.value;

            // alert('objValue-'+objValue);
            $.ajax({
                url: "../model/cuti_function.php",
                type: "POST",
                data: {action:"getCutiInfo",code:obj.value,staff_record_id:"<? echo $staff_record_id;?>"},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    var dataObject = $.parseJSON(response);
                    // $.alert('test here:'+response.length);
                    if(response.length == 2){


                        $('#nama').val("");
                        $('#notel').val("");

                    }else{
                        $('#baki_cuti_pohon').val(dataObject[0].baki_cuti_pohon);
                        $('#baki_cuti_pohon_cons').val(dataObject[0].baki_cuti_pohon);
                        // $('#notel').val(dataObject[0].notel);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    }



</script>

</body>

</html>