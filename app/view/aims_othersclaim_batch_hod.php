<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_hod_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$claim_id = $_GET['claim_id'];
$status = $_GET['status'];
$month = $_GET['month_claim'];
$tahun = $_GET['tahun'];
$company = $_GET['company_claim'];
?>

<?


$no_staff = $_SESSION['SESS_NO_STAFF'];
$department = $_SESSION['SESS_DEPARTMENT'];
$sys = getSys(1)-> fetch_assoc();
$verified_name = $_SESSION['SESS_NAME'];
$hod_review_status = $_GET['hod_review_status'];
if (!isset($hod_review_status) && $hod_review_status == '') {
    $hod_review_status = 'PENDING';
}
$total = getTotal_claim($claim_id,$tahun,$company)->fetch_assoc();
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

    <script language="JavaScript" type="text/javascript">
        function Kemaskini(){
            return confirm('Anda pasti untuk kemaskini maklumat permohonan claim?');
        }

    </script>
    <script language="JavaScript" type="text/javascript">
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

    <div id="page-wrapper">
        <!--<?include '../global/menu_keselamatan.php'?>-->

        <div class="col-lg-12">
            <h1 class="page-header">Claim Form</h1>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <?
                $staff = ListName($id) -> fetch_assoc();
                ?>


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
                            <td width="50%"><label>COMPANY CLAIM : </label> <? echo $company?></label></td>

                        </tr>


                    </table>
                </div>

            </div>
        </div>
        <br><br>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Others Claim By Month : <? echo $month; ?></label>&nbsp;&nbsp;&nbsp;
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <input name="claim_id" type="hidden" class="input-short" value="<? echo $claim_id;?>" />
                        <input name="tahun" type="hidden" class="input-short" value="<? echo $tahun;?>" />
                        <input name="company" type="hidden" class="input-short" value="<? echo $company;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>

                                <th rowspan="2">Date</th>
                                <th colspan="2">Date Time</th>
                                <th rowspan="2">Details Description</th>
                                <th rowspan="2">Milage (KM*RM)</th>
                                <th rowspan="2">Hotel/Lodging Allowance (RM)</th>
                                <th rowspan="2">Daily Allowance (RM)</th>
                                <th rowspan="2">Others Claim</th>
                                <th rowspan="2">Attachment</th>

                            </tr>
                            <tr>
                                <td>Departure</td>
                                <td style= "border-right: inset;">Arrival</td>
                            </tr>

                            </thead>
                            <tbody>
                            <?

                            $pemohon= Listbatch($status,$claim_id);
                            $i= 1;
                            while($staffinfo = $pemohon->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $staffinfo['date_purchase']; ?></td>
                                    <td><?php echo $staffinfo['time_departure']; ?></td>
                                    <td><?php echo $staffinfo['time_arrival']; ?></td>
                                    <td><?php echo $staffinfo['description']; ?></td>
                                    <td><?php echo $staffinfo['milage']; ?></td>
                                    <td><?php echo $staffinfo['hotel_allowance']; ?></td>
                                    <td><?php echo $staffinfo['daily_allowance']; ?></td>
                                    <td><?php echo $staffinfo['total_claim']; ?></td>
                                    <td>
                                        <?if($staffinfo['document_name'] != '') {?>
                                        <a href="#myModal2" class="btn btn-info" data-toggle="modal" data-id="<? echo$staffinfo ['id'];?>">SHOW ATTACHMENT</a><?}?>
                                    </td>
                                </tr>
                            <?}?>
                            <tr>
                                <td colspan="4"></td>
                                <td>RM <?php echo $total['total_milage']; ?></td>
                                <td>RM <?php echo $total['total_hotel']; ?></td>
                                <td>RM <?php echo $total['total_daily']; ?></td>
                                <td>RM <?php echo $total['total']; ?></td>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;background-color:white;" colspan="3">
                                    <b>VERIFIED BY : <?echo $verified_name;?></b>
                                </td>
                                <td style="text-align:right;background-color:white;" colspan="6">
                                    <b>Total Expenses : </b> RM <?php echo $total['total_expenses']; ?>&emsp;&emsp;&emsp;&emsp;
                                    <a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id ="<? echo $id;?>" data-claim_id ="<? echo $claim_id;?>" data-tahun ="<? echo $tahun;?>" data-status="<? echo $status;?>" data-company="<? echo $company;?>">VERIFY</a>
                                </td>
                            </tr>



                            </tbody>
                        </table>
                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->


</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">HOD/CEO SECTION</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var staff_record_id = $(e.relatedTarget).data('id');
                        var claim_id = $(e.relatedTarget).data('claim_id');
                        var tahun = $(e.relatedTarget).data('tahun');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_others_claim_hod_update.php',
                            data:{id:staff_record_id,claim_id:claim_id,tahun:tahun},
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
                        url:'aims_others_claim_attachment.php',
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

<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    // Delete row on delete button click

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

</script>

</body>

</html>



