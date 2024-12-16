<?php
include "../controller/auth.php";
require "../model/aims_inout_function.php";

$no_staff = $_SESSION['SESS_NO_STAFF'];
$staff_id = $_SESSION['SESS_ID'];
$sys = getSys(1)-> fetch_assoc();
$approval = ($_GET['approve']) ?: 'PENDING';
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
    <script type="text/javascript">
        $(document).ready(function(){
            // all checkbox checked if select all is checked
            $('#select_all').on('click',function(){
                $('input[class="checkbox"]').prop('checked', this.checked);
            });

            // select all checked if all checkbox checked
            $('.checkbox').on('click',function(){
                $('#select_all').prop('checked',$('.checkbox:checked').length === $('.checkbox').length);
            });
        });
    </script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> IN OUT APPROVAL
                    <a href="v02_aims_inout_approval.php" class="btn btn-primary">Switch to Version 2</a></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label style="margin-right: 8px">Approval</label>
                        <a style="margin: 0 8px" href="aims_list_approveinout.php?approve=PENDING">New</a> |
                        <a style="margin: 0 8px" href="aims_list_approveinout.php?approve=APPROVE">Approved</a> |
                        <a style="margin: 0 8px" href="aims_list_approveinout.php?approve=DISAPPROVE">Disapproved</a>
                    </div>


                    <div class="panel-body">
                        <input type="checkbox" id="select_all" /><label for="select_all" style="margin-left: 8px"> Select All</label>

                        <? $data=getCheckboxApprove($_SESSION['SESS_NAME'],$_SESSION['SESS_NO_STAFF'])?>
                        <form name="frmactive" method="post" action="">
                            <table style="border: 0">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="APPROVE" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="DISAPPROVE" />
                                    </td>
                            </table><br>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="20%">Staff Info</th>
                                    <th width="20%">In Out Info</th>
                                    <th width="13%">Verified</th>
                                    <th width="13%">Approve</th>
                                    <th width="13%">Reason</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?
                                $in_out_list = getInOutApprovalList($no_staff, $approval);
                                $i= 1;
                                while($row_data = $in_out_list->fetch_assoc()) {
                                    ?>

                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?>
                                            <align="center">
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $row_data['id']; ?>" >
                                        </td>

                                        <td>
                                            <label class="control-label">Nama :<?php echo $row_data['name']; ?></label><br>
                                            <label class="control-label">Ic :<?php echo $row_data['noic']; ?></label><br>
                                            <label class="control-label">Department :<?php echo $row_data['department_sub']; ?></label><br>
                                            <label class="control-label">Company :<?php echo $row_data['department_id']; ?></label>
                                        </td>


                                        <td>
                                            <label class="control-label">Date :<?php echo $row_data['date_mohon']; ?></label><br>
                                            <label class="control-label">Description :<?php echo $row_data['description']; ?></label><br>
                                            <label class="control-label">Time Out :<?php echo $row_data['time_out']; ?></label><br>
                                            <label class="control-label">Time In :<?php echo $row_data['time_in']; ?></label>
                                        </td>


                                        <td>
                                            <?if($row_data['verified'] == 'PENDING' ) {
                                                echo '<b><font color="blue">'.'PENDING'.'</font></b>';}
                                            else if($row_data['verified'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'APPROVE'.'</font></b>';}
                                            else if($row_data['verified'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'DISAPPROVE'.'</font></b>';}

                                            ?><br><br>
                                            <? echo $row_data['verified_name'];?>
                                        </td>


                                        <td>
                                            <?if($row_data['approve'] == 'PENDING' ) {
                                                echo '<b><font color="blue">'.'PENDING'.'</font></b>';}
                                            else if($row_data['approve'] == 'APPROVE') {
                                                echo '<b><font color="green">'.'APPROVE'.'</font></b>';}
                                            else if($row_data['approve'] == 'CHECKED') {
                                                echo '<b><font color="green">'.'APPROVE'.'</font></b>';}
                                            else if($row_data['approve'] == 'DISAPPROVE') {
                                                echo '<b><font color="red">'.'DISAPPROVE'.'</font></b>';}
                                            ?><br><br>

                                            <? echo $row_data['approve_name'];?>
                                        </td>


                                        <td>
                                            <? echo $row_data['reason'];?>
                                        </td>


                                        <td>
                                            <?
                                            if ($row_data['approve'] == 'PENDING') { ?>
                                                <?php echo "<a href='#myModal1' class='btn btn-primary' data-toggle='modal' data-id=".$row_data['id'].">APPROVE</a>"; ?><br><br>
                                            <?}?>

                                            <?
                                            if ($row_data['approve'] == 'DISAPPROVE') { ?>
                                                <?php echo "<a href='#myModal1' class='btn btn-primary' data-toggle='modal' data-id=".$row_data['id'].">APPROVE</a>"; ?><br><br>

                                            <?}?>

                                            <? if ($row_data['images'] != '') { ?>
                                            <a href="#myModal3" data-toggle="modal" data-id="<? echo $row_data['id'];?>"><button class="btn btn-info" type="button">Show Attachment



                                                    </button></a><?}?>

                                        </td>

                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>

                            </table>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

            </div>
            <!-- /.col-lg-12 -->


            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->
        <? include ('../global/footer.php'); ?>

    </div>

    <!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Kemaskini Pelanggan</h4>
                </div>
                <div class="modal-body" id="demo">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_verified_approve.php',
                                data:'id='+rowid,
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

    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div> -->
            <div class="modal-body" id="demo3">
                <script type="text/javascript">
                    $('#myModal3').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_inout_lampiran.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo3').html(html);
                            }
                        });
                    });
                </script>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

</body>

</html>