<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_function.php";

?>

<?
$claim_id = $_GET['claim_id'];
$id = $_GET['id'];
$month = $_GET['month'];
$status = $_GET['hr_review_status'];
$tahun = $_GET['tahun'];
$company =$_GET['company_claim'];
$staff = getStaffOT($claim_id)->fetch_assoc();
$total = getTotal_claim($claim_id,$tahun,$company)->fetch_assoc();
$staffss = gethrname($claim_id,$tahun)->fetch_assoc();
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

        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
        }

        .closebtn {
            margin-left: 30px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>

    <script language="javascript" type="text/javascript">
        function updateId(curr_updt_id){
            document.getElementById('curr_updt_id').value = curr_updt_id;
        }

        function updatessr_no(updatessr_no){
            document.getElementById('updatessr_no').value = updatessr_no;
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




    <div id="page-wrapper">

        <br><br><br>
        <div class="col-lg-12">
            <table width="100%">

                <tr>
                    <td width="50%"><label>NAME : </label> <? echo $staff['name'];?></td>
                    <td width="50%"><label>CLAIM FOR THE MONTH ENDED : </label> <? echo $month;?></td>

                </tr>
                <tr>
                    <td width="50%"><label>IC : </label> <? echo $staff['noic'];?></td>
                    <td width="50%"><label>JOB NO. : </label> <? echo $staff['job_no'];?></td>

                </tr>
                <tr>
                    <td width="50%"><label>DEPARTMENT : </label> <? echo $staff['department_sub'];?></td>
                    <td width="50%"><label>COMPANY CLAIM : </label> <? echo $staff['company_claim'];?></td>

                </tr>


            </table>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        HR ACTION
                    </div>

                    <input type="hidden" width="30%" name="staff_record_id" id="staff_record_id" value="<? echo $id;?>" >
                    <input type="hidden" width="30%" name="claim_id" id="claim_id" value="<? echo $claim_id;?>" >
                    <input type="hidden" class="form-control" name="month_claim" id="month_claim" value="<? echo $month;?>">
                    <input type="hidden" class="form-control" name="status" id="status" value="<? echo $status;?>">
                    <input type="hidden" class="form-control" name="tahun" id="tahun" value="<? echo $tahun;?>">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="horizontal-scroll">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
                                <thead>
                                <tr>
                                    <th rowspan="2">Date</th>
                                    <th colspan="2">Date Time</th>
                                    <th rowspan="2">Details Description</th>
                                    <th rowspan="2">Company Claim</th>
                                    <th rowspan="2">Milage (KM*RM)</th>
                                    <th rowspan="2">Hotel/Lodging Allowance (RM)</th>
                                    <th rowspan="2">Daily Allowance (RM)</th>
                                    <th rowspan="2">Others Claim</th>
                                    <th rowspan="2">Month Claim</th>
                                    <th rowspan="2">Job Number</th>
                                    <th rowspan="2">Remark</th>
                                    <th rowspan="2">Action</th>
                                </tr>

                                <tr>
                                    <td>Departure</td>
                                    <td style= "border-right: inset;">Arrival</td>
                                </tr>

                                </thead>
                                <tbody>
                                <?
                                $i= 1;
                                $list_education = getStaffForms($claim_id,$status,$tahun);
                                while($row_data_education = $list_education->fetch_assoc()) {
                                    ?>

                                    <tr class="odd gradeX">

                                        <td><?php echo $row_data_education['date_purchase']; ?></td>
                                        <td><?php echo $row_data_education['time_departure']; ?></td>
                                        <td><?php echo $row_data_education['time_arrival']; ?></td>
                                        <td><?php echo $row_data_education['description']; ?></td>
                                        <td><?php echo $row_data_education['company_claim']; ?>
                                            <input type="hidden" class="form-control" name="company" id="company" value="<? echo $row_data_education['company_claim'];?>"></td>
                                        <td><?php echo $row_data_education['milage']; ?></td>
                                        <td><?php echo $row_data_education['hotel_allowance']; ?></td>
                                        <td><?php echo $row_data_education['daily_allowance']; ?></td>
                                        <td><?php echo $row_data_education['total_claim']; ?></td>
                                        <td><?php echo $row_data_education['month_claim']; ?></td>
                                        <td><?php echo $row_data_education['job_no']; ?></td>
                                        <td><?php echo $row_data_education['remark']; ?></td>

                                        <td>
                                            <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                            <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $row_data_education['id']; ?>')">Update</button></a>
                                            <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="del_claim('<?php echo $row_data_education['id']; ?>')">Delete</button></a>
                                            <? if ($row_data_education['document_name'] != '') {?>
                                                <a href="#myModal2" data-toggle="modal" data-id="<? echo $row_data_education['id'];?>"><button class="btn btn-warning" type="button">Attachment</button></a>
                                            <?}?>
                                            <? if ($row_data_education['document_name'] == '') {?>
                                                <a href="#myModal4" data-toggle="modal" data-id="<? echo $row_data_education['id'];?>" data-stf_id="<? echo $claim_id;?>" data-month="<? echo $month; ?>" data-status="<? echo $status;?>" data-tahun="<? echo $tahun;?>"><button class="btn btn-success" type="button"> Add Attachment</button></a>
                                            <?}?>
                                            <input type="hidden" id="ot_id" name="ot_id" value="<?php echo $row_data_education['id']; ?>">
                                        </td>
                                    </tr>
                                <?}?>
                                <tr>
                                    <td colspan="5"></td>
                                    <td>RM <?php echo $total['total_milage']; ?></td>
                                    <td>RM <?php echo $total['total_hotel']; ?></td>
                                    <td>RM <?php echo $total['total_daily']; ?></td>
                                    <td>RM <?php echo $total['total']; ?></td>
                                    <td colspan="5"></td>
                                </tr>

                                </tbody>

                            </table>
                        </div>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <table width="100%" class="table table-striped table-bordered table-hover">
            <tr>
                <td style="background-color:white;width:20%">REVIEWED BY :</td>
                <td style="text-align:center;background-color:white;width:30%"><?if($staffss['hr_review_by'] != '') {
                        echo $staffss['hr_review_by'];}
                    else {  echo $_SESSION['SESS_NAME']; }?>
                </td>
                <td style="background-color:white;width:25%"> Total : RM <?php echo $total['total_expenses']; ?> <input type="hidden" id="total_expenses" name="total_expenses" value="<?php echo $total['total_expenses']; ?>"></td>
                <td style="text-align:right;background-color:white;width:25%" colspan="2"><a href="#myModal1" class="btn btn-primary" onclick="myFunction()" data-toggle="modal" data-id ="<? echo $claim_id;?>" data-total ="<? echo $total['total_expenses'];?>" data-tahun ="<? echo $tahun;?>">REVIEW</a></td>
            </tr>
        </table>
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
                '<td><input type="date" class="form-control" name="date_purchase" id="date_purchase" style="text-transform:uppercase"></td>' +
                '<td><input type="datetime" class="form-control" name="time_departure" id="time_departure" style="text-transform:uppercase"></td>' +
                '<td><input type="datetime" class="form-control" name="time_arrival" id="time_arrival" style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="description" id="description"  style="text-transform:uppercase"></td>' +
                '<td> '+
                '<select class="form-control" name="company_claim" id="company_claim">' +
                '<option value="" data=""></option>' +
                '<? echo getDropDownCompany($staff["company_claim"]);?>' +
                '</select>' +

                '</td>' +
                '<td><input type="text" class="form-control" name="milage" id="milage"  style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="hotel_allowance" id="hotel_allowance"  style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="daily_allowance" id="daily_allowance"  style="text-transform:uppercase"></td>' +
                '<td><input type="number" class="form-control" name="total_claim" id="total_claim" ></td>'+
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
                '<option value="NOVEMBER" data="">NOVEMBER</option>' +
                '<option value="DECEMBER" data="">DECEMBER</option>' +
                '</select>' +

                '</td>' +
                '<td><input type="text" class="form-control" name="job_no" id="job_no" value="-"></td>'+
                '<td><input type="text" class="form-control" name="remark" id="remark" value="NONE"></td>'+
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>'+
                '<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-primary">Kemaskini</button></a>'+
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
            var dataArray = ["","","","","","","","","","",""];
            var dataArray2 = ["",""];

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
                url: "../model/aims_others_claim_function.php",
                type: "POST",
                data: {action:"update_otherclaim",date_purchase:dataArray[0],time_departure:dataArray[1],time_arrival:dataArray[2],description:dataArray[3],company_claim:dataArray2[0],milage:dataArray[4],hotel_allowance:dataArray[5],daily_allowance:dataArray[6],total_claim:dataArray[7],month_claim:dataArray2[1],job_no:dataArray[8],remark:dataArray[9],id:dataArray[10]},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert(response);
                    $.confirm({
                        title: 'Info',
                        content: response,
                        buttons: {
                            OK: function () {
                                var id = document.getElementById("staff_record_id").value;
                                var claim_id = document.getElementById("claim_id").value;
                                var month_claim = document.getElementById("month_claim").value;
                                var status = document.getElementById("status").value;
                                var tahun = document.getElementById("tahun").value;
                                location.href="../view/aims_others_claim_hr_update_form.php?id="+id+"&hr_review_status="+status+"&tahun="+tahun+"&month="+month_claim+"&claim_id="+claim_id;
                            }
                        }
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    location.href = "aims_others_claim_hr_update_form.php";
                }


            });

        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){
            var i=0;;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                var selectedText = $(this).html();
                if (i==0){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '" readonly/>');
                }
                else if (i==1){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '" readonly/>');
                }
                else if (i==2){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '" readonly/>');
                }
                else if (i==3){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '"/>');
                }


                else if (i==4){
                    var dropdowns = '<select name="company_claim" id="company_claim" class="form-control" >'+
                        '<? echo getDropDownCompany($staff["company_claim"]);?>' +
                        '</select>'

                    /*$(this).text()*/
                    $(this).html(dropdowns);
                }

                else if (i==5){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '">');
                }

                else if (i==6){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '">');
                }
                else if (i==7){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '">');
                }
                else if (i==8){
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '">');
                }
                else if (i==9){
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
                        '<option value="NOVEMBER" >NOVEMBER</option>' +
                        '<option value="DECEMBER" >DECEMBER</option>' +
                        '</select>'
                    $(this).html(dropdowns);
                }
                else{
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="10" value="' + $(this).text() + '">');
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
            url: "../model/aims_others_claim_function.php",
            type: "POST",
            data: {action:"del_claim",id:id},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);
                var sr_id = document.getElementById("staff_record_id").value;
                var month_claim = document.getElementById("month_claim").value;
                var status = document.getElementById("status").value;
                var company = document.getElementById("company").value;
                window.location ="aims_others_claim_hr_update_form.php?id="+ssr_no+"&month="+month_claim+"&hr_review_status="+status+"&tahun="+tahun+"&company_claim="+company;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

</script>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">HR SECTION</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var id = $(e.relatedTarget).data('id');
                        var total = $(e.relatedTarget).data('total');
                        var tahun = $(e.relatedTarget).data('tahun');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_others_claim_hr_update.php',
                            data:{id:id,total:total,tahun:tahun},
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
    <div class="modal-dialog">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'aims_others_claim_update_attachment.php',
                        data:{id:rowid},
                        success:function(html){
                            $('#demo1').html(html);
                        }
                    });
                });
            </script>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel4">HR IMAGES UPDATE</h4>
            </div>
            <div class="modal-body" id="demo4">
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
                            url:'aims_otherclaim_foto.php',
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
    function myFunction() {
        confirm("PLEASE REFRESH TO GET ACTUAL VALUE IF DELETE");
    }
</script>

</body>

</html>