<?php

include ('../controller/auth.php');

require "../model/aims_inout_function.php";

$id = $_GET['id'];
$passwordinfo = getaims_inoutbyId($id)->fetch_assoc();
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


    <script language="JavaScript" type="text/javascript">

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
        <?
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">PERSONAL INFORMATION
                    <a href="v02_aims_inout_list.php" class="btn btn-primary">Switch to Version 2</a></h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <?
                $staff = getStaffInformation($no_staff) -> fetch_assoc();
                ?>

                <table width="100%">
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
                        <td><?php echo $staff['staff_name']?></td>
                    </tr>

                    <tr>
                        <td><label>Ic</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['noic']?></td>
                    </tr>

                    <tr>
                        <td><label>Position</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['role']?></td>
                    </tr>

                    <tr>
                        <td><label>Company</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['department']?></td>
                    </tr>

                    <tr>
                        <td><label>Department</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['department_sub']?></td>
                    </tr>

                </table>


                <div class="panel-heading" align="right">
                    <div align="right">
                        <?php echo "<a href='#myModal1' class='btn btn-primary' data-toggle='modal' data-staff_record_id=".$staff['staff_record_id'].">In/Out Form</a>"; ?>
                        <!-- <a href="permohonan_cuti_tahunan.php?no_staff=<? echo $no_staff;?>"><button class="btn btn-primary" onclick="Alert()" type="button">Borang Permohonan Cuti</button></a> -->
                    </div>

                </div>



            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>InOut Permission</label>&nbsp;&nbsp;&nbsp;

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>

                                    <th width="5%">No.</th>
                                    <th width="10%">Date Apply</th>
                                    <th width="25%">Description</th>
                                    <th width="11%">Time Out/In</th>
                                    <th width="11%">Verified</th>
                                    <th width="11%">Approve</th>
                                    <th width="11%">Attachment</th>
                                    <th width="11%">Action</th>


                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $i= 1;
                                if($_SESSION['SESS_DEPARTMENT_SUB'] == 'MOORING-GANG'){
                                    $password = getInOutSpecialMessage();
                                }
                                else{
                                    $password = getaims_inoutlisit($_SESSION['SESS_NO_STAFF']);
                                }
                                while($row_data = $password->fetch_assoc()) {

                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?></td>

                                        <td>
                                            <b><?php echo $row_data['date_mohon']; ?></b><br>

                                        </td>
                                        <td>
                                            <b><?php echo $row_data['description']; ?></b><br>

                                        </td>

                                        <td>
                                            <b>Time Out = <?php echo $row_data['time_out']; ?></b><br>
                                            <b>Time In = <?php echo $row_data['time_in']; ?></b>

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
                                            <form method="post" action="../controller/aims_inout_images_exec.php" enctype="multipart/form-data">
                                                <input type="hidden" name="MAX_FILE_SIZE" >
                                                <input type="hidden" name="id" value="<? echo $row_data['id'];?>">
                                                <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" >
                                                <br>
                                                <button type="submit" class="btn btn-primary">Muat Naik</button></a>
                                            </form>
                                        </td>

                                        <td>

                                            <?
                                            if ($row_data['approve'] == 'PENDING') { ?>
                                                <?php echo "<a href='#myModal2' class='btn btn-primary btn-small' data-toggle='modal' data-id=".$row_data['id'].">Update</a>"; ?>
                                                <a href="../controller/delete_aims_inout_exec.php?id=<? echo $row_data['id']; ?>"><button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                            <?}?>

                                            <?
                                            if ($row_data['images'] != '') { ?>
                                            <a href="#myModal3" data-toggle="modal" data-id="<? echo $row_data['id'];?>"><button class="btn btn-info" type="button">Show Attachment</button></a><?}?>

                                            <?
                                            if ($row_data['approve'] == 'DISAPPROVE') { ?>
                                                <?php echo "<a href='#myModal2' class='btn btn-primary btn-small' data-toggle='modal' data-id=".$row_data['id'].">Update</a>"; ?>
                                                <a href="../controller/delete_aims_inout_exec.php?id=<? echo $row_data['id']; ?>"><button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                            <?}?>


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
            </div>


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
                    <h4 class="modal-title" id="myModalLabel">In/Out Form</h4>
                </div>
                <div class="modal-body" id="demo">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_inout.php',
                                data:'rowid='+rowid,
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
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Update</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'update_aims_inout.php',
                                data:'id='+rowid,
                                success:function(html){
                                    $('#demo2').html(html);
                                }
                            });
                        });
                    </script>
                </div> <!--modal-body -->
            </div> <!--modal content -->
        </div> <!--modal-dialog -->
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