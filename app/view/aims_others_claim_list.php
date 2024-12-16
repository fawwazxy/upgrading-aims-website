<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_function.php";
require "../model/lookup.php";

?>
<?

$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];
$sys = getSys(1)-> fetch_assoc();

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
                <h1 class="page-header">Claim</h1>
            </div>
        </div>



        <div class="row">
            <div class="panel-heading" align="right">

                <?
                $staff = getStaffForm($no_staff) -> fetch_assoc();
                ?>


                <table width="100%" >
                    <tr>
                        <th width="14%"></th>
                        <th width="2%"></th>
                        <th></th>
                    </tr>
                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                    <tr>
                        <td><label>Name</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['name']?></td>
                    </tr>

                    <tr>
                        <td><label>Ic</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['noic']?></td>
                    </tr>

                    <tr>
                        <td><label>Company</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['department_id']?></td>
                    </tr>

                    <tr>
                        <td><label>Department</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['department_sub']?></td>
                    </tr>

                </table>

            </div>
            <div class="panel-heading" align="right">
                <div align="right">
                    <a href="aims_others_claim_form.php?no_staff=<? echo $no_staff;?>&staff_record_id=<?echo $staff['st_record_id']?>"><button class="btn btn-primary">Add New</button></a>
                </div>

            </div>
        </div>   <!-- /.panel-heading -->
        <div class="row">
            <div class="col-1g-12">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <label>Claim List</label>
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th rowspan="2">Month Claim</th>
                                <th rowspan="2">Date</th>
                                <th colspan="2">Date Time</th>
                                <th rowspan="2">Details Description</th>
                                <th rowspan="2">Milage (KM*RM)</th>
                                <th rowspan="2">Hotel/Lodging Allowance (RM)</th>
                                <th rowspan="2">Daily Allowance (RM)</th>
                                <th rowspan="2">Others Claim</th>
                                <th rowspan="2">HR Remark</th>
                                <th rowspan="2">HOD Status</th>
                                <th rowspan="2">HR Status</th>
                                <th rowspan="2">Finance Status</th>
                                <th rowspan="2">CEO/CHAIRMAN Status</th>
                                <th rowspan="2">Claim Status</th>
                                <th rowspan="2">Payment Status</th>
                                <th rowspan="2">Company Claim</th>
                                <th rowspan="2">Action</th>

                            </tr>
                            <tr>
                                <td>Departure</td>
                                <td style= "border-right: inset;">Arrival</td>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $OthersClaim = OthersClaim($_SESSION['SESS_NO_STAFF']);
                            $i=1;
                            while($list_others_claim = $OthersClaim->fetch_assoc()) {
                            ?>

                            <tr>


                                <td><?php echo $list_others_claim['month_claim']; ?></td>
                                <td><?php echo $list_others_claim['date_purchase']; ?></td>
                                <td><?php echo $list_others_claim['time_departure']; ?></td>
                                <td><?php echo $list_others_claim['time_arrival']; ?></td>
                                <td><?php echo $list_others_claim['description']; ?></td>
                                <td><?php echo $list_others_claim['milage']; ?></td>
                                <td><?php echo $list_others_claim['hotel_allowance']; ?></td>
                                <td><?php echo $list_others_claim['daily_allowance']; ?></td>
                                <td><?php echo $list_others_claim['total_claim']; ?></td>
                                <td><?php echo $list_others_claim['remark']; ?></td>
                                <td style="text-align:center;">
                                    <?'<b>'.$list_others_claim['hod_review_status'].'</b>';
                                    if($list_others_claim['hod_review_status']==PENDING){
                                        echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                    else if($list_others_claim['hod_review_status']==VERIFIED){
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>";}
                                    else {
                                        echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISVERIFIED</span>";}

                                    ?><br><br>
                                    <?echo $list_others_claim['hod_review_by'];?>

                                    <br><br>
                                    <?echo $list_others_claim['hod_review_date'];?>
                                </td>
                                <td style="text-align:center;">
                                    <?'<b>'.$list_others_claim['hr_review_status'].'</b>';
                                    if($list_others_claim['hr_review_status']==PENDING){
                                        echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                    else if($list_others_claim['hr_review_status']==REVIEW){
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REVIEWED</span>";}
                                    else {
                                        echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                    ?><br><br>
                                    <?echo $list_others_claim['hr_review_by'];?>

                                    <br><br>
                                    <?echo $list_others_claim['hr_review_date'];?>
                                </td>


                                <td style="text-align:center;">
                                    <?'<b>'.$list_others_claim['finance_status'].'</b>';
                                    if($list_others_claim['finance_status']==CHECK){
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius:5px;font-weight:bold;color:white;'>CHECKED</span>";}
                                    else {
                                        echo"<span style='background-color:GREY;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>UNCHECKED</span>";}

                                    ?><br><br>
                                    <?echo $list_others_claim['finance_reviewby'];?>

                                    <br><br>
                                    <?echo $list_others_claim['finance_date'];?>
                                </td>

                                <td style="text-align:center;">
                                    <?'<b>'.$list_others_claim['approve_status'].'</b>';
                                    if($list_others_claim['approve_status']==PENDING){
                                        echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                    else if($list_others_claim['approve_status']==APPROVED){
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>";}
                                    else {
                                        echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                    ?><br><br>
                                    <?echo $list_others_claim['approve_by'];?>

                                    <br><br>
                                    <?echo $list_others_claim['approve_date'];?>
                                </td>

                                <td style='text-align:center'>
                                    <?'<b>'.$list_others_claim['payment_status'].'</b>';
                                    if($list_others_claim['payment_status']==OPEN){
                                        echo"<span style='background-color:RED;padding:5px;border-radius:5px;font-weight:bold;color:white;'>OPEN</span>";}
                                    else {
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>CLOSED</span>";}

                                    ?>
                                </td>
                                <td style='text-align:center'>
                                    <?'<b>'.$list_others_claim['finance_payment_status'].'</b>';
                                    if($list_others_claim['finance_payment_status']==OPEN){
                                        echo"<span style='background-color:RED;padding:5px;border-radius:5px;font-weight:bold;color:white;'>OPEN</span>";}
                                    else {
                                        echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>CLOSED</span>";}

                                    ?>
                                    <br><br> <b>Date & Time payment close:</b> <?echo $list_others_claim['date_payment_status'];?>
                                </td>
                                <td><?php echo $list_others_claim['company_claim']; ?></td>

                                <td><a href="../controller/delete_others_claim.php?id=<? echo $list_others_claim['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger">Delete</a>
                                    <? if ($list_others_claim['hr_review_status'] == 'PENDING') {?>
                                        <a href="aims_other_claim_update_form.php?id=<? echo $list_others_claim['id']; ?>" class="btn btn-info">Edit</a>
                                    <?}?>

                                    <?/* if ($list_others_claim['document_name'] != '') {*/?>
                                    <a href="#myModal2" data-toggle="modal" data-id="<? echo $list_others_claim['id'];?>"><button class="btn btn-warning" type="button">Attachment</button></a>
                                    <?/*}*/?><!--</td>-->


                                    <? $i;}?>



                            </tr>
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

</div>
<!-- /#wrapper -->

<div class="modal-body" id="demo3">
    <script type="text/javascript">
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
                type:'POST',
                url:'aims_others_claim_form.php',
                data:{id:rowid},
                success:function(html){
                    $('#demo3').html(html);
                }
            });
        });
    </script>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            order: [[1, "desc"]]
        });
    });



</script>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo2">
            <script type="text/javascript">
                $('#myModal2').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'aims_others_claim_update_attachment.php',
                        data:{id:rowid},
                        success:function(html){
                            $('#demo2').html(html);
                        }
                    });
                });
            </script>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

</body>

</html>