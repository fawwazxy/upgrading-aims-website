<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";

?>

<?
$id = $_GET['id'];
$ref_no = $_GET['ref_no'];
$client_company_id = $_GET['client_company_id'];
$info = getInfoApp($ref_no)->fetch_assoc();
$app = getAppName($id)->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <? require "../global/header.php"; ?>

    <!-- 	<style>
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
        </style>
    -->

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
        <br><br>

        <div class="panel-heading" align="right">

            <button class="btn btn-primary" onclick="goBack()">Back</button></a>

        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <!-- <input type="text" width="30%" name="booking_id" id="booking_id" value="<? echo $booking_id;?>" > -->
                    <input type="hidden" class="form-control" name="ref_no" id="ref_no" value="<? echo $ref_no;?>">
                    <input type="hidden" class="form-control" name="client_company_id" id="client_company_id" value="<? echo $client_company_id;?>">

                    <div class="form-group row">
                        <label class="control-label col-sm-1">Ref No:</label><? echo $info['ref_no']?>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-1">Client:</label><? echo $info['client_company_id']?>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="horizontal-scroll">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
                                <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAME</th>
                                    <th>IC/PASSPORT NO</th>
                                    <th>CHECK IN</th>
                                    <th>CHECK OUT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i= 1;
                                $list_education = getStaffApp($ref_no,$client_company_id);
                                while($list = $list_education->fetch_assoc()) {
                                    ?>

                                    <tr class="odd gradeX">
                                        <td><? echo $i++;?></td>
                                        <td><?php echo $list['client_name']; ?></td>
                                        <td><?php echo $list['client_ic']; ?></td>
                                        <td><?php echo $list['arrival_date']; ?></td>
                                        <td><?php echo $list['departure_date']; ?></td>
                                    </tr>
                                <?}?>

                                </tbody>

                            </table>
                        </div>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
                    <tr>
                        <th rowspan="3" style="width: 20%">APPLICANT'S BY</th>
                        <td style="text-align: left;"><?if($app['applicant_by'] != '') {
                                echo $app['applicant_by'];}
                            else { echo $_SESSION['SESS_NAME'];}?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><?if($app['applicant_company'] != '') {
                                echo $app['applicant_company'];}
                            else { echo $_SESSION['SESS_DEPARTMENT'];}?>
                        </td>
                        <input type="hidden" width="30%" name="id" id="id" value="<? echo $app['id'];?>">
                    </tr>

                    <tr>
                        <td>
                            <button><a href="../controller/aims_gl_applicant_exec.php?id=<? echo $app['id']; ?>&applicant_by=<?echo $_SESSION['SESS_NAME'];?>&applicant_company=<?echo $_SESSION['SESS_DEPARTMENT']; ?>"><span style="color: green" class="material-icons" onclick="return confirm('Are you sure you want to confirm?');">check</span></button></a>
                        </td>
                    </tr>
                    <?
                    $i= 1;
                    $list_education = getStaffApp($ref_no,$client_company_id);
                    while($list = $list_education->fetch_assoc()) {
                        ?>
                    <?}?>

                </table>

            </div>
            <!-- /.col-lg-12 -->
        </div>
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
            responsive: true

        });

        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=890');
            if (window.focus) {newwindow.focus()}
            return false;
        }


        function goBack() {
            window.history.back();
        }
</script>

</body>

</html>