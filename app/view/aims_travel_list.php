<?php

include ('../controller/auth.php');

require "../model/aims_travel_function.php";
require "../model/lookup.php";
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
                    <h1 class="page-header">TRAVEL AUTHORISATION AND APARTMENT/HOTEL APPLICATION</h1>
                </div>
            </div>

            <!--		<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr style="background-color:orange">
									<th width="40%">Total Billing Generate</th>
									<th width="30%">Billing Processed</th>
									<th width="25%">In-Process by Finance</th>
								</tr>
							</thead>
							<tbody>
								<tr>
								   <td><font size='6'><?  ?></font></td>
								   <td><font size='6' color="yellow"><b><? ?></b></td>
								   <td><font size='6' color="green"><b><? ?></b></td>
								</tr>
							</tbody>
			</table>
	-->

            <?
            /*$flagScreen="tab_2";
            include ('../global/menu_travel.php');*/
            ?>

            <div class="row">
                <div class="panel-heading" style="float: right">
                    <div align="right">
                        <a href="/pms/view/travel_add.php" class="btn btn-primary">Travel Authorization Form</a>
                    </div>
                </div>
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
                                    <th>HOD/CEO Verification</th>
                                    <th>CEO/CHAIRMAN Approval</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $travel = getTravelListStaff($_SESSION['SESS_NAME']);
                                $i=1;
                                while($t = $travel->fetch_assoc()) {
                                    $date= new DateTime($t['created_date']) ;
                                    $departure_datetime = $t['departure_date'].'+'.date('h', strtotime($t['departure_time'])).'%3A'.date('i', strtotime($t['departure_time']));
                                    $return_datetime = $t['return_date'].'+'.date('h', strtotime($t['return_time'])).'%3A'.date('i', strtotime($t['return_time']));
                                    $datehod = (strtotime($t['hod_date']) > 0) ? $t['hod_date']:'';
                                    $dateceo = (strtotime($t['ceo_date']) > 0) ? $t['ceo_date']:'';
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
                                                echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:black;'>PENDING</span>";
                                            }
                                            else if($t['hod_approval'] == 'APPROVED') {
                                                echo "<span style='background-color:green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVED</span>";
                                            }
                                            else{
                                                echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>REJECTED</span>";
                                            }
                                            ?>
                                            <br>
                                            <?php echo $t['hod_by']."<br>".$datehod ?></td>


                                        <td style="text-align:center"><?php  $t['ceo_approval'];
                                            if($t['ceo_approval'] == 'PENDING'){
                                                echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:black;'>PENDING</span>";
                                            }
                                            else if($t['ceo_approval'] == 'APPROVED') {
                                                echo "<span style='background-color:green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVED</span>";
                                            }
                                            else{
                                                echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>REJECTED</span>";
                                            }
                                            ?>
                                            <br>
                                            <?php echo $t['ceo_by']."<br>".$dateceo ?></td>


                                        <td>
                                            <? if ($t['travel_mode_id'] == 'COMPANY CAR') {?>
                                                <a href="https://corp.aimsglobal.com.my/request/availability?estimated_departure=<? echo $departure_datetime; ?>&estimated_return=<? echo $return_datetime; ?>"
                                                   class="btn btn-warning" target="_blank">Request Vehicle</a>
                                                <a href="#myModal1" data-toggle="modal" data-id="<? echo $t['id'];?>"><button type="button" class="btn btn-info">Vehicle Info</button></a>
                                            <?}?>
                                            <a href="#myModal" data-toggle="modal" data-id="<? echo $t['id'];?>"><button type="button" class="btn btn-info">Travel Info</button></a>
                                            <a href="aims_travel_update.php?id=<? echo $t['id']; ?>"><button class="btn btn-primary" type="button">Edit</button></a>
                                            <a href="../controller/aims_travel_delete_exec.php?id=<? echo $t['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
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

    <div class="modal fade modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Travel Request</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal').on('show.bs.modal', function (e) {
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





    </script>

</body>

</html>