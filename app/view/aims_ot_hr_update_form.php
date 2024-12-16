<?php

include ('../controller/auth.php');

require "../model/aims_ot_function.php";

?>

<?
$id = $_GET['id'];
$month = $_GET['month'];
$status = $_GET['review_status'];
$tahun = $_GET['tahun'];
$staff = getStaffOT($id)->fetch_assoc();
$total = getTotal_claim($id,$month,$tahun)->fetch_assoc();
$staffss = gethrname($id,$month,$tahun)->fetch_assoc();
$totalclaim = getOtRates($id,$month,$status,$tahun)->fetch_assoc();
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
        .horizontal-scroll {
            overflow: hidden;
            overflow-x: auto;
            clear: both;
            width: 100%;
        }

        .my-table {
            min-width: rem-calc(640);
        }


        #table-hr tr td:last-child {

            white-space: nowrap;
        }
    </style>


    <script language="javascript" type="text/javascript">
        function updateId(curr_updt_id){
            document.getElementById('curr_updt_id').value = curr_updt_id;
        }

        function updatessr_no(updatessr_no){
            document.getElementById('updatessr_no').value = updatessr_no;
        }

        function Confirm(){
            return confirm('Anda pasti untuk hantar permohonan claim?');
        }

    </script>

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
    <br><br>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Overtime Claim
                    <!--<a href="v02_aims_ot_hr_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>



        <div class="form-group row" align="left">
            <div class="col-sm-6">
                <div class="form-group" align="left">
                    <label>Staff Name: </label><br> <? echo $staff['name'];?>
                </div>

                <div class="form-group" align="left">
                    <label>I/C No: </label><br> <? echo $staff['icno'];?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group" align="left">
                    <label>Company: </label><br> <? echo $staff['department_id'];?>
                </div>

                <div class="form-group" align="left">
                    <label>Position: </label><br> <? echo $staff['position'];?>
                </div>
            </div>
        </div>

        <div class="panel-heading" align="right">
            <!--	<button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a> -->
            <a href="" onclick="return popitup('aims_ot_report.php?id=<? echo $totalclaim['staff_record_id'];?>&month=<? echo $totalclaim['month_claim'];?>&tahun=<? echo $totalclaim['tahun'];?>&review_status=<? echo $totalclaim['review_status'];?>')">
                <button type="button" class="btn btn-info">Form View</button></a>

            <button class="btn btn-primary" onclick="goBack()">Back</button></a>

        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        OVERTIME CLAIM LIST <br>
                        <b><font color="red">IF THERE ANY CHANGES IN MONTH CLAIM. PLEASE UPDATE MONTH CLAIM FIRST BEFORE RATES CALCULATION AND REVIEWING</b></font>
                    </div>

                    <input type="hidden" width="30%" name="staff_record_id" id="staff_record_id" value="<? echo $id;?>" >
                    <input type="hidden" class="form-control" name="month_claim" id="month_claim" value="<? echo $month;?>">
                    <input type="hidden" class="form-control" name="status" id="status" value="<? echo $status;?>">
                    <input type="hidden" class="form-control" name="tahun" id="tahun" value="<? echo $tahun;?>">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="horizontal-scroll">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Working Period</th>
                                    <th>Month Claim</th>
                                    <th>Description</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i= 1;
                                $list_education = getStaffForms($id,$month,$status,$tahun);
                                while($row_data_education = $list_education->fetch_assoc()) {

                                    $start_ot= date('h:i a', strtotime($row_data_education['start_ot']));
                                    $end_ot= date('h:i a', strtotime($row_data_education['end_ot']));
                                    ?>

                                    <tr class="odd gradeX">

                                        <td><?php echo $row_data_education['date_ot']; ?></td>
                                        <td><?php echo $row_data_education['day_ot']; ?></td>
                                        <td><?php echo $start_ot; ?></td>
                                        <td><?php echo $end_ot; ?></td>
                                        <td><?php echo $row_data_education['working_hours']; ?></td>
                                        <td><?php echo $row_data_education['month_claim']; ?></td>
                                        <td><?php echo $row_data_education['description_ot']; ?></td>
                                        <td><?php echo $row_data_education['review_remark']; ?></td>

                                        <td>
                                            <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Save</button></a>
                                            <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $row_data_education['id']; ?>')">Update</button></a>
                                            <!--   <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="confirm('Are you sure you want to delete?'); del_claim('<?php echo $row_data_education['id']; ?>');">Delete</button></a> -->
                                            <? if ($row_data_education['document_name'] != '') {?>
                                                <!--	<a href="#myModal2" data-toggle="modal" data-id="<? echo $row_data_education['id'];?>"><button class="btn btn-warning" type="button">Attachment</button></a> -->
                                                <a href="" onclick="return popitup('aims_ot_attachment.php?id=<? echo $row_data_education['id'];?>')"><button class="btn btn-warning" type="button">Attachment</button></a>

                                            <?}?>
                                            <? if ($row_data_education['document_name'] == '') {?>
                                                <a href="#myModal4" data-toggle="modal" data-id="<? echo $row_data_education['id'];?>" data-stf_id="<? echo $id;?>" data-month="<? echo $month; ?>" data-status="<? echo $status;?>" data-tahun="<? echo $tahun;?>"><button class="btn btn-success" type="button">Add Attachment</button></a>
                                            <?}?>
                                            <input type="hidden" id="ot_id" name="ot_id" value="<?php echo $row_data_education['id']; ?>">
                                        </td>
                                    </tr>
                                <?}?>


                                </tbody>

                            </table>
                        </div>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->

            <table width="100%" class="table table-bordered table-hover">
                <tr>

                    <td style="text-align:center;padding-top:1.5%"><b>1.5</b></td>
                    <td><input type="text" name="r1_5" id="r1_5" onkeyup="total_r15(); total_all()" value="<? echo $totalclaim['r1_5'];?>" class="form-control"/></td>
                    <td><input type="text" name="s1_5" id="s1_5" onkeyup="total_r15(); total_all()" value="<? echo $totalclaim['s1_5'];?>" class="form-control"/></td>
                    <td><input readonly type="text" name="t1_5" id="t1_5" class="form-control" value="<? echo $totalclaim['t1_5'];?>"/></td>

                </tr>
                <tr>
                    <td style="text-align:center;padding-top:1.5%"><b>2</b></td>
                    <td><input type="text" name="r2" id="r2" onkeyup="total_r2(); total_all()" value="<? echo $totalclaim['r2'];?>" class="form-control"/></td>
                    <td><input type="text" name="s2" id="s2" onkeyup="total_r2(); total_all()" value="<? echo $totalclaim['s2'];?>" class="form-control"/></td>
                    <td><input readonly type="text" name="t2" id="t2" class="form-control" value="<? echo $totalclaim['t2'];?>"/></td>

                </tr>
                <tr>
                    <td style="text-align:center;padding-top:1.5%"><b>3</b></td>
                    <td><input type="text" name="r3" id="r3" onkeyup="total_r3(); total_all()" value="<? echo $totalclaim['r3'];?>" class="form-control"/></td>
                    <td><input type="text" name="s3" id="s3" onkeyup="total_r3(); total_all()"value="<? echo $totalclaim['s3'];?>" class="form-control"/></td>
                    <td><input readonly type="text" name="t3" id="t3" class="form-control" value="<? echo $totalclaim['t3'];?>"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="r4" id="r4" onkeyup="total_r4(); total_all()" value="<? echo $totalclaim['r4'];?>" class="form-control"/></td>
                    <td><input type="text" name="s4" id="s4" onkeyup="total_r4(); total_all()" value="<? echo $totalclaim['s4'];?>" class="form-control"/></td>
                    <td><input readonly type="text" name="t4" id="t4" class="form-control" value="<? echo $totalclaim['t4'];?>"/></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align:center;padding-top:1.5%">TOTAL (RM)</td>
                    <td style="text-align:center;">
                        <input readonly type="text" value="<? echo $totalclaim['total_monthclaim'];?>" name="total_monthclaim" id="total_monthclaim" class="form-control"/>
                    </td>
                <tr>

                <tr>
                    <td style="background-color:white;width:20%">REVIEWED BY :</td>
                    <td colspan="2" style="text-align:center;background-color:white;width:40%"><?if($staffss['review_by'] != '') {
                            echo $staffss['review_by'];}
                        else {  echo $_SESSION['SESS_NAME']; }?>
                    </td>
                    <td style="text-align:center;background-color:white;"><a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id ="<? echo $id;?>" data-month ="<? echo $month;?>" data-tahun ="<? echo $tahun;?>">REVIEW</a></td>
                </tr>
            </table>

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
            "paging":   false,
            "info":     false

        });
        $('[data-toggle="tooltip"]').tooltip();
        //var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
            var row = '<tr>' +
                '<td><input type="date" class="form-control" name="date_ot" id="date_ot" style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="day_ot" id="day_ot"  style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="start_ot" id="start_ot"  style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="end_ot" id="end_ot"  style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="working_hours" id="working_hours"  style="text-transform:uppercase"></td>' +
                '<td> '+
                '<select class="form-control" name="month_claim" id="month_claim">' +
                '<option value="JANUARY" data="">JANUARY</option>' +
                '<option value="FEBRUARY" data="">FEBRUARY</option>' +
                '<option value="MARCH" data="">MARCH</option>' +
                '<option value="APRIL" data="">APRIL</option>' +
                '<option value="MAY" data="">MAY</option>' +
                '<option value="JUNE" data="">JUNE</option>' +
                '<option value="JULY" data="">JULY</option>' +
                '<option value="AUGUST" data="">AUGUST</option>' +
                '<option value="SEPTEMBER" data="">SEPTEMBER</option>' +
                '<option value="OCTOBER" data="">OCTOBER</option>' +
                '<option value="NOVEMBER" data="">NOVEMBER</option>' +
                '<option value="DECEMBER" data="">DECEMBER</option>' +
                '</select>' +

                '</td>' +
                '<td><input type="number" class="form-control" name="description_ot" id="description_ot" ></td>'+
                '<td><input type="text" class="form-control" name="review_remark" id="review_remark" value="-"></td>'+
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Save</button></a>'+
                '<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-primary">Update</button></a>'+
                '</td>' +
                '</tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input');
            var select = $(this).parents("tr").find('select');


            input.each(function(){
                if(!$(this).val()){
                    $(this).addClass("error");
                    empty = true;
                } else{
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            var dataArray = ["","","","","",""];
            var dataArray2 = ["",];

            if(!empty){
                var i=0;
                var j=0;

                input.each(function(){
                    if(i<=1){
                        $(this).parent("td").html($(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });

                select.each(function(){
                    $(this).parent("td").html($(this).find("option:selected").text());
                    //$(this).parent("td").html($(this).val());
                    //alert($(this).val());
                    dataArray2[j]=$(this).val();
                    j++;
                });

                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }

            var ot_id = document.getElementById("ot_id").value;

            $.ajax({
                url: "../model/aims_ot_function.php",
                type: "POST",
                data: {action:"update_otherclaim",date_ot:dataArray[0],day_ot:dataArray[1],start_ot:dataArray[2],end_ot:dataArray[3],working_hours:dataArray[4],month_claim:dataArray2[0],description_ot:dataArray[5],review_remark:dataArray[6],id:dataArray[7]},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert(response);
                    $.confirm({
                        title: 'Info',
                        content: response,
                        buttons: {
                            OK: function () {
                                var staff_record_id = document.getElementById("staff_record_id").value;
                                var month_claim = document.getElementById("month_claim").value;
                                var status = document.getElementById("status").value;
                                var tahun = document.getElementById("tahun").value;
                                location.href="../view/aims_ot_hr_update_form.php?id="+staff_record_id+"&month="+month_claim+"&review_status="+status+"&tahun="+tahun;
                            }
                        }
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    location.href = "aims_ot_hr_update_form.php";
                }

            });

        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){
            var i=0;;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                var selectedText = $(this).html();
                if (i==0){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="8" value="' + $(this).text() + '" readonly/>');
                }
                else if (i==1){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '" readonly/>');
                }
                else if (i==2){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '" readonly/>');
                }
                else if (i==3){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '" readonly/>');
                }
                else if (i==4){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '"/>');
                }
                else if (i==5){
                    var dropdowns = '<select name="month_claim" id="month_claim" class="form-control" >'+
                        '<option value="'+ $(this).text() +'">'+ $(this).text() +'</option>'+
                        '<option value="JANUARY" >JANUARY</option>' +
                        '<option value="FEBRUARY">FEBRUARY</option>' +
                        '<option value="MARCH" >MARCH</option>' +
                        '<option value="APRIL" >APRIL</option>' +
                        '<option value="MAY" >MAY</option>' +
                        '<option value="JUNE" >JUNE</option>' +
                        '<option value="JULY" >JULY</option>' +
                        '<option value="AUGUST" >AUGUST</option>' +
                        '<option value="SEPTEMBER" >SEPTEMBER</option>' +
                        '<option value="OCTOBER" >OCTOBER</option>' +
                        '<option value="NOVEMBER" >NOVEMBER</option>' +
                        '<option value="DECEMBER" >DECEMBER</option>' +
                        '</select>'
                    $(this).html(dropdowns);
                }
                else{
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" width="10" value="' + $(this).text() + '">');
                }

                i++;
            });

            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");
        });


        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var row_id = $(this).parents("tr").find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });

            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");
        });

    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function del_claim(id){
        $.ajax({
            //url: "../model/aims_ssr_function.php",
            url: "../model/aims_ot_function.php",
            type: "POST",
            data: {action:"del_claim",id:id},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);
                var id = document.getElementById("id").value;
                window.location="aims_ot_hr_update_form.php?id="+id;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

</script>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">HR SECTION</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var staff_record_id = $(e.relatedTarget).data('id');
                        var month = $(e.relatedTarget).data('month');
                        var total = $("#total_monthclaim").val();
                        var tahun = $(e.relatedTarget).data('tahun');
                        var r1_5 = $("#r1_5").val();
                        var s1_5 = $("#s1_5").val();
                        var t1_5 = $("#t1_5").val();
                        var r2 = $("#r2").val();
                        var s2 = $("#s2").val();
                        var t2 = $("#t2").val();
                        var r3 = $("#r3").val();
                        var s3 = $("#s3").val();
                        var t3 = $("#t3").val();
                        var r4 = $("#r4").val();
                        var s4 = $("#s4").val();
                        var t4 = $("#t4").val();
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_ot_hr_update.php',
                            data:{id:staff_record_id,month:month,total:total,tahun:tahun,r1_5:r1_5,s1_5:s1_5,t1_5:t1_5,r2:r2,s2:s2,t2:t2,r3:r3,s3:s3,t3:t3,r4:r4,s4:s4,t4:t4},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <!--Content-->
        <div class="modal-content">

            <!--Body-->
            <div class="modal-body" id="demo2">

                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');

                        $.ajax({
                            type:'POST',
                            url:'aims_ot_attachment.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo2').html(html);
                            }
                        });
                    });
                </script>

            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline- btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!--/.Content-->

    </div>
</div>


<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel4">HR ATTACHMENT UPDATE</h4>
            </div>
            <div class="modal-body" id="demo4" style="">
                <script type="text/javascript">
                    $('#myModal4').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        var staff_record_id = $(e.relatedTarget).data('stf_id');
                        var month = $(e.relatedTarget).data('month');
                        var status = $(e.relatedTarget).data('status');
                        var tahun = $(e.relatedTarget).data('tahun');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_ot_hr_attachment.php',
                            data:{id:rowid,stf_id:staff_record_id,month:month,status:status,tahun:tahun},
                            success:function(html){
                                $('#demo4').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    //calculation rates
    function total_r15(){

        var r1_5 = document.getElementById('r1_5').value;
        var s1_5 = document.getElementById('s1_5').value;

        var total = (r1_5*s1_5);
        var t15 = total.toFixed(2);
        var t1_5 = document.getElementById('t1_5');
        t1_5.value = t15;
    }


    function total_r2(){

        var r2 = document.getElementById('r2').value;
        var s2 = document.getElementById('s2').value;

        var total = (r2*s2);
        var t_2 = total.toFixed(2);
        var t2 = document.getElementById('t2');
        t2.value = t_2;
    }



    function total_r3(){

        var r3 = document.getElementById('r3').value;
        var s3 = document.getElementById('s3').value;

        var total = (r3*s3);
        var t_3 = total.toFixed(2);
        var t3 = document.getElementById('t3');
        t3.value = t_3;
    }


    function total_r4(){

        var r4 = document.getElementById('r4').value;
        var s4 = document.getElementById('s4').value;

        var total = (r4*s4);
        var t_4 = total.toFixed(2);
        var t4 = document.getElementById('t4');
        t4.value = t_4;
    }


    function total_all(){

        /*var t1_5 = total_r15();
        var t2 = total_r2();
        var t3 = total_r3();
        var t4 = total_r4();

        var total = (t1_5+t2+t3+t4);
        var totalclaim = total.toFixed(2);*/

        var r1_5 = document.getElementById('r1_5').value;
        var s1_5 = document.getElementById('s1_5').value;

        var total1 = (r1_5*s1_5);

        var r2 = document.getElementById('r2').value;
        var s2 = document.getElementById('s2').value;

        var total2 = (r2*s2);

        var r3 = document.getElementById('r3').value;
        var s3 = document.getElementById('s3').value;

        var total3 = (r3*s3);

        var r4 = document.getElementById('r4').value;
        var s4 = document.getElementById('s4').value;

        var total4 = (r4*s4);

        var total = (total1+total2+total3+total4);
        var totalclaim = total.toFixed(2);
        var total_monthclaim = document.getElementById('total_monthclaim');
        total_monthclaim.value = totalclaim;
    }


    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }


    function goBack() {
        window.history.back();
    }
</script>

</body>

</html>