<?php

include ('../controller/auth.php');

require "../model/aims_ot_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_lumpur");

$no_staff = $_SESSION['SESS_NO_STAFF'];
$company_id = $_SESSION['SESS_DEPARTMENT'];
$department_id = $_GET['department_id'];
$code_department = $_SESSION['SESS_DEPARTMENT_SUB'];
$month=$_GET['month'];
$year=$_GET['year'];
$flag=$_GET['flg'];

if(!isset($month)){
    $month=date('m');
}

if(!isset($year)){
    $year=date('Y');

}

if(!isset($flag)){
    $flag='tb_1';

}



$staff = getStaffInformation($no_staff) -> fetch_assoc();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <? require "../global/header.php"; ?>

</head>

<style type="text/css">



</style>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" >

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
                <h1 class="page-header">
                    OVERTIME PERMISSION LIST
                    <!--<a href="v02_aims_otpermission_hr.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02
                    </a>-->
                </h1>
            </div>
        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>


        <div class="form-group" align="right">
        </div>

        <div id='cssmenu'>
            <ul>
                <li class="<? echo ($flag=='tb_1'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=AGHSB&flg=<? echo tb_1;?>&year=<?echo $year;?>&month=<?echo $month;?>">AGHSB</a>
                </li>

                <li class="<? echo ($flag=='tb_2'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=AGESB&flg=<? echo tb_2;?>&year=<?echo $year;?>&month=<?echo $month;?>">AGESB</a>
                </li>

                <li class="<? echo ($flag=='tb_3'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=AGIRSB&flg=<? echo tb_3;?>&year=<?echo $year;?>&month=<?echo $month;?>">AGIRSB</a>
                </li>

                <li class="<? echo ($flag=='tb_4'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=AGMHESB&flg=<? echo tb_4;?>&year=<?echo $year;?>&month=<?echo $month;?>">AGMHESB</a>
                </li>

                <li class="<? echo ($flag=='tb_5'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=AGMSB&flg=<? echo tb_5;?>&year=<?echo $year;?>&month=<?echo $month;?>">AGMSB</a>
                </li>

                <li class="<? echo ($flag=='tb_6'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=AVSB&flg=<? echo tb_6;?>&year=<?echo $year;?>&month=<?echo $month;?>">AVSB</a>
                </li>

                <li class="<? echo ($flag=='tb_7'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=TKSB&flg=<? echo tb_7;?>&year=<?echo $year;?>&month=<?echo $month;?>">TKSB</a>
                </li>

                <li class="<? echo ($flag=='tb_8'?'active':'') ?>"><a href="aims_otpermission_hr.php?department_id=MASB&flg=<? echo tb_8;?>&year=<?echo $year;?>&month=<?echo $month;?>">MSET-AIMS</a>
                </li>

            </ul>
        </div> <br><br>
        <div class="col-lg-4">


            <select  required class="form-control" name="year" id="year">
                <option value="0">-- Choose Year--</option>
                <? echo getDropDownYearHr($year);?>
            </select>
        </div>
        <div class="col-lg-4">

            <select  required class="form-control" name="month" id="month">
                <option value="0">-- Choose Month--</option>
                <? echo getDropDownMonthHr($month);?>
            </select>
        </div>


        <br><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Overtime Permission List</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Applied On</th>
                                <th>Approvement</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $ot = getOtPermissionHr($_SESSION['SESS_DEPARTMENT_SUB'],$department_id,$year,$month);
                            $i=1;
                            while($otp = $ot->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $otp['staff_name']; ?></td>
                                    <td><?php echo $otp['otp_date']; ?></td>
                                    <td><?php echo $otp['otp_description']; ?></td>
                                    <td><center><?php echo $otp['created_date']; ?></center></td>
                                    <td><?php echo $otp['approved_by']; ?><br><? echo $otp['approved_date']; ?>

                                    </td>
                                    <td><?php echo $otp['otp_remark']; ?></td>
                                    <td>
                                        <!--	<a href="#updateOTP" class="edit" data-toggle="modal" data-id="<? echo $otp['id'];?>"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a> -->
                                        <a href="../controller/aims_otpdelete_exec.php?id=<? echo $otp['id']; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class="material-icons" style="color: red;" data-toggle="tooltip" title="Delete">&#xE872;</i></a>

                                    </td>
                                </tr>
                            <? } ?>


                            </tbody>

                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->



    <!-- Edit Modal HTML -->
    <div class="modal fade" id="updateOTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">EDIT OVERTIME PERMISSION</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#updateOTP').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_otpermission_update.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
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



    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
            $("#year,#month").change(function(){
                var selected_year=$("#year").val();
                var selected_month=$("#month").val();
                sendType(selected_year,selected_month);
            });

        });
        function sendType(year,month){
            if(month==undefined){
                window.location.href="aims_otpermission_hr.php?department_id=<?echo $department_id;?>&flg=<? echo $flag;?>&year="+year;
            }else{
                window.location.href="aims_otpermission_hr.php?department_id=<?echo $department_id;?>&flg=<? echo $flag;?>&year="+year+"&month="+month;
            }


        }
    </script>

</body>

</html>