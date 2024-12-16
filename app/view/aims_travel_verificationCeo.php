<?php

include ('../controller/auth.php');

require "../model/aims_travel_function.php";
require "../model/lookup.php";

$department_id=$_GET['department_id'];
$id = $_GET['id'];
$name=$_SESSION['SESS_NAME'];
$department_sub=$_SESSION['SESS_DEPARTMENT_SUB'];
$hod_approval = $_GET['hod_approval'];
if (!isset($hod_approval) && $hod_approval == '') {
    $hod_approval = 'PENDING';
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



</style>
<script type="text/javascript">
    <!--
    function un_check(){
        for (var i = 0; i < document.frmactive.elements.length; i++) {
            var e = document.frmactive.elements[i];
            if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                e.checked = document.frmactive.allbox.checked;
            }}}
    //-->
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
</script>

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
                <h1 class="page-header">TRAVEL AUTHORISATION AND APARTMENT/HOTEL APPLICATION</h1>
                <h3>Management Verification</h3>
            </div>
        </div>


        <?
        //	$flagScreen="tab_1";
        //	include ('../global/menu_travelrequest.php');
        ?>

        <div class="form-group" align="right">
        </div>

        <!--	<table border="0">
					<tr><td>
					<label class="control-label">DEPARTMENT :</label>
						</td><td>&nbsp;&nbsp;&nbsp;</td><td>
						<select  required class="form-control" name="department_id" id="department_id">
                          <option value="">-- Choose Department --</option>
                          <? echo getDropDownDepartment($department_id) ;?>
                          </select>
						  </td>
					</tr>
            </table> -->

        <div class="form-group" align="right">
        </div>



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Travel Application List</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_travel_verificationCeo.php?hod_approval=PENDING">New</a> &nbsp;|&nbsp;
                        <a href="aims_travel_verificationCeo.php?hod_approval=APPROVED">Approve</a> &nbsp;|&nbsp;
                        <a href="aims_travel_verificationCeo.php?hod_approval=REJECTED">Disapprove</a> &nbsp;|&nbsp;
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <input type="checkbox" id="select_all" /><font size='4'> Select All</font></li>

                        <? $data=getCheckboxUpdateTravelHod($id,$_SESSION['SESS_NAME'])?>
                        <td><form name="frmactive" method="post" action="">
                                <table border="0">
                                    <tr>
                                        <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="Approve" />
                                            <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="Disapprove" />
                                        </td>
                                </table><br>

                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Company</th>
                                        <th>Applied On</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Mode of Travel</th>
                                        <!--	<th>Job No</th>  -->
                                        <th>Destination</th>
                                        <th>Departure/Return Date</th>
                                        <th>Approval</th>
                                        <th>Verified By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?

                                    if($hod_approval == 'PENDING') {
                                        $travel = getSenaraiPemohonTravelBaharuCeo($department_sub,$name);
                                    }
                                    else if($hod_approval == 'APPROVED') {
                                        $travel = getSenaraiPemohonTravelApproveCeo($department_sub,$name);
                                    }
                                    else {
                                        $travel = getSenaraiPemohonTravelDisapproveCeo($department_sub,$name);
                                    }

                                    $i=1;
                                    while($t = $travel->fetch_assoc()) {

                                        $date= new DateTime($t['created_date']) ;

                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $i++; ?>
                                                <align="center">
                                                <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $t['id']; ?>" >
                                            </td>
                                            <td><?php echo $t['company_id']; ?></td>
                                            <!--	<td><?php echo $t['department_id']; ?></td> -->
                                            <td><?php echo $date->format('Y-m-d'); ?></td>
                                            <td><?php echo $t['name']; ?></td>
                                            <td><?php echo $t['staff_designation']; ?></td>
                                            <td><?php echo $t['travel_mode_id']; ?></td>
                                            <!--	<td><?php echo $t['job_no']; ?></td> -->
                                            <td><?php echo $t['destination']; ?></td>
                                            <td><?php echo $t['departure_date']; ?> until <?php echo $t['return_date']; ?></td>

                                            <td style="text-align:center"><?php  $t['hod_approval'];
                                                if($t['hod_approval'] == 'PENDING'){
                                                    echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";
                                                }
                                                else if($t['hod_approval'] == 'APPROVED') {
                                                    echo "<span style='background-color:green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVED</span>";
                                                }
                                                else{
                                                    echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>REJECTED</span>";
                                                }
                                                ?> </td>
                                            <td><?php echo $t['hod_by']; ?></td>


                                            <!--	<td><?php echo $t['updated_date']; ?></td>  -->
                                            <!--    <td><?php echo $t['updated_by']; ?></td>  -->


                                            <td>
                                                <a href="#myModal" data-toggle="modal" data-id="<? echo $t['id'];?>"><button type="button" class="btn btn-info">Action</button></a>

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
                                url:'aims_travel_requestHod.php',
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


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        $("#department_id").change(function(){
            var selected_department=$(this).val();
            sendType(selected_department);
        });


        function sendType(selected_department)
        {
            window.location.href="aims_travel_requestlist.php?department_id="+selected_department;

        }



    </script>

</body>

</html>