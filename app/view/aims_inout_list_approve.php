<?php

include ('../controller/auth.php');

require "../model/aims_inout_function.php";

$id = $_GET['id'];
$passwordinfo = getaims_verified_approvebyId($id)->fetch_assoc();
?>
<?

$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];
$sys = getSys(1)-> fetch_assoc();
$verified_name = $_SESSION['SESS_NAME'];
$approve = $_GET['approve'];
if (!isset($approve) && $approve == '') {
    $approve = 'PENDING';
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
                <h1 class="page-header"> AIMS VERIFIED </h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <?
                $staff = getStaffInformation($no_staff) -> fetch_assoc();
                ?>

                <div class="panel-heading" align="right">

                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>Verified</label>&nbsp;&nbsp;&nbsp;
                            <a href="aims_list_verified_approve.php?approve=PENDING">Baharu</a> &nbsp;|&nbsp;
                            <a href="aims_list_verified_approve.php?approve=APPROVE">Lulus</a> &nbsp;|&nbsp;
                            <a href="aims_list_verified_approve.php?approve=DISAPPROVE">Tidak Lulus</a> &nbsp;|&nbsp;

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>

                                    <th width="5%">No.</th>
                                    <th width="20%">Staff Info</th>
                                    <th width="20%">In Out Info</th>
                                    <th width="13%">Verified</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?
                                if($approve == 'PENDING') {
                                    $password= getaims_approvelistbaharu($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }
                                else if($approve == 'APPROVE') {
                                    $password= getaims_approvelistlulus($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }
                                else {
                                    $password= getaims_approvelisttidaklulus($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }
                                $i= 1;
                                while($row_data = $password->fetch_assoc())  {
                                    ?>

                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?></td>

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
                                            <? echo $row_data['verified_name'];?>
                                        </td>

                                        <td>
                                            <a href="../controller/hantar_buttonverified_exec.php?aims_inout_id=<? echo $row_data['id'];?>&verified_name=<?echo $verified_name;?>"><button class="btn btn-success" type="button" onclick="return Confirm()" >VERIFIED</button></a><br><br>
                                            <a href="../controller/hantar_buttonverified1_exec.php?aims_inout_id=<? echo $row_data['id'];?>&verified_name=<?echo $verified_name;?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" >DISVERIFIED</button></a>

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


    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

</body>

</html>