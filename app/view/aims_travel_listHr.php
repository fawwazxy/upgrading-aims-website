<?php

include ('../controller/auth.php');

require "../model/aims_travel_function.php";
require "../model/lookup.php";

$department_sub=$_SESSION['SESS_DEPARTMENT_SUB'];
$company_id=$_GET['company_id'];

if(!isset($company_id)){
    $company_id = "0";
}
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
    td.a{
        padding-bottom: 15px;	}
    #menu {
        background: hsla(1,0%,100%,.9);
        position: absolute;
        top: 50;
        right: 0;
        left: 0;
        min-height: 100%;
        padding-top: 10px;
    }
    td,th{
        text-align: center;
    }
    td.red{
        color: red;
    }
    td.green{
        color: green;
    }
    td.blue{
        color: blue;
    }
    td.orange{
        color: orange;
    }
    td.brown{
        color: brown;
    }



    @media print {
        .noprint {
            display:none
        }
    }



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
    <div class="noprint" id="noprint">
        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">TRAVEL AUTHORIZATION (TAF)
                        <a href="/pms/view/travel_tracking.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                            <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02
                        </a>
                    </h1>
                </div>
            </div>



            <div class="col-lg-4">
                <select class="form-control" name="company_id" id="company_id">
                    <option value="0">-- Choose Company --</option>
                    <? echo getDropDownCompany($company_id) ;?>
                </select>
            </div>
            <br><br>

            <div class="form-group" align="right">

            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Travel Application List</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Applied On</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Mode of Travel</th>
                                    <!--	<th>Job No</th>  -->
                                    <th>Destination</th>
                                    <th>Departure/Return Date</th>
                                    <th>HOD Verification</th>
                                    <th>Verified By</th>
                                    <th>CEO/CHAIRMAN Approval</th>
                                    <th>Approved By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                if($company_id=="0"){
                                    $travel = getTravelListHr($_SESSION['SESS_DEPARTMENT_SUB']);
                                }
                                else{
                                    $travel = getTravelListHrCom($company_id);
                                }
                                $i=1;
                                while($t = $travel->fetch_assoc()) {
                                    $date= new DateTime($t['created_date']) ;
                                    $datehod= new DateTime($t['hod_date']) ;
                                    $dateceo= new DateTime($t['ceo_date']) ;
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $t['company_id']; ?></td>
                                        <td><?php echo $t['department_id']; ?></td>
                                        <td><?php echo $date->format('Y-m-d'); ?></td>
                                        <td><?php echo $t['name']; ?></td>
                                        <td><?php echo $t['staff_designation']; ?></td>
                                        <td><?php echo $t['travel_mode_id']; ?></td>
                                        <!--	<td><?php echo $t['job_no']; ?></td> -->
                                        <td><?php echo $t['destination']; ?></td>
                                        <td><?php echo $t['departure_date']; ?> until <?php echo $t['return_date']; ?></td>

                                        <td><?php  $t['hod_approval'];
                                            if($t['hod_approval'] == 'PENDING'){
                                                echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";
                                            }
                                            else if($t['hod_approval'] == 'APPROVED') {
                                                echo "<span style='background-color:green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVED</span>";
                                            }
                                            else{
                                                echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>REJECTED</span>";
                                            }
                                            ?></td>

                                        <td><?php echo $t['hod_by']."<br>(".$datehod->format('Y-m-d').")" ?></td>

                                        <td style="text-align:center"><?php  $t['ceo_approval'];
                                            if($t['ceo_approval'] == 'PENDING'){
                                                echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";
                                            }
                                            else if($t['ceo_approval'] == 'APPROVED') {
                                                echo "<span style='background-color:green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVED</span>";
                                            }
                                            else{
                                                echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>REJECTED</span>";
                                            }
                                            ?> </td>
                                        <td><?php echo $t['ceo_by']."<br>(".$dateceo->format('Y-m-d').")" ?></td>

                                        <!--	<td style="text-align:center"><?php /* $list_billing['status_billing'];
												if($list_billing['status_billing'] == 0){
													echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>NEW</span>";
													}
												else if($list_billing['status_billing'] == 1) {
													echo "<span style='background-color:Orange; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PROCESSED</span>"; 
												}
												else{
													echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>DELETED</span>"; 
												} */
                                        ?> </td> -->
                                        <!--	<td><?php echo $t['updated_date']; ?></td>  -->
                                        <!--    <td><?php echo $t['updated_by']; ?></td>  -->


                                        <td>
                                            <? if ($t['travel_mode_id'] == 'COMPANY CAR') {?>
                                                <a href="#myModal1" data-toggle="modal" data-id="<? echo $t['id'];?>"><button type="button" class="btn btn-warning">Vehicle Info</button></a>
                                                <a href="#myModal2" data-toggle="modal" data-id="<? echo $t['id'];?>"><button type="button" class="btn btn-info">Travel Info</button></a>
                                                >
                                            <?} else {?>
                                                <a href="#myModal2" data-toggle="modal" data-id="<? echo $t['id'];?>"><button type="button" class="btn btn-info">Travel Info</button></a>
                                            <?}?>
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
    </div>

    <div class="modal fade modal-xl" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Travel Request</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_travel_listInfo.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo3').html(html);
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


    <div class="modal fade modal-xl" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel1">Vehicle Request</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_car_requestravel_print.php',
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
        });

        $("#company_id").change(function(){
            var selected_department=$(this).val();
            sendType(selected_department);
        });


        function sendType(selected_department)
        {
            window.location.href="aims_travel_listHr.php?company_id="+selected_department;

        }




    </script>

</body>

</html>