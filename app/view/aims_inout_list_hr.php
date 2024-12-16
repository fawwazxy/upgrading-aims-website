<?php

include ('../controller/auth.php');
require "../model/aims_inout_function.php";
require "../model/lookup.php";

?>
<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$tahun = $_GET['tahun'];
$department_id=$_GET['department_id'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$bln=$_GET['mnt'];
$thn=$_GET['yr'];
$flag=$_GET['flg'];
$dateSelection=$_GET['dt'];

if(!isset($bln)){
    $bln=date('m');

}

if(!isset($thn)){
    $thn=date('Y');

}

if(!isset($flag)){
    $flag='tb_1';

}



$approve = $_GET['approve'];
if (!isset($approve) && $approve == '') {
    $approve = 'APPROVE';
}


/*	if(!isset($department_code)){
        $department_code = $_SESSION['SESS_DEPARTMENT'];

    } */



function dateDifference($date_1 , $date_2 , $differenceFormat)
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

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
                <h1 class="page-header"> IN OUT LIST
                    <a href="v02_aims_inout_hr_check.php" class="btn btn-primary">Switch to Version 2</a></h1>
            </div>
        </div>


        <!--<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Pekerja</h1>
            </div>

        </div>-->

        <?

        include ('../global/menu_bulan_inoutlist.php');
        ?>

        <div align="right" style="float:right">
            <a href="print_inout.php"><button type="button" class="btn btn-primary">Print</button></a>
        </div>
        <br><br><br>


        <div class="row">
            <div class="col-lg-12">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        In Out List

                    </div>



                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="25%">Staff Information</th>
                                <th width="10%">Date</th>
                                <th width="25%">Description</th>
                                <th width="11%">Time InOut</th>
                                <th width="11%">Verified</th>
                                <th width="11%">Approve</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;

                            $data_staff = getListInOut($bln,$thn,$department_id,$_SESSION['SESS_DEPARTMENT_SUB']);

                            while($row_data_staff = $data_staff->fetch_assoc()) {


                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i++; ?></td>

                                    <td>
                                        <b>Staff Name : <?php echo $row_data_staff['name']; ?></b><br>
                                        <b>No IC      : <?php echo $row_data_staff['noic']; ?></b><br>
                                        <b>Department : <?php echo $row_data_staff['department_sub']; ?></b>

                                    </td>

                                    <td>
                                        <b><?php echo $row_data_staff['date_mohon']; ?></b><br>

                                    </td>
                                    <td>
                                        <b><?php echo $row_data_staff['description']; ?></b><br>

                                    </td>

                                    <td>

                                        <b>Time Out : <?php echo $row_data_staff['time_out']; ?></b><br>
                                        <b>Time In : <?php echo $row_data_staff['time_in']; ?></b>

                                    </td>

                                    <td>
                                        <?if($row_data_staff['verified'] == 'PENDING' ) {
                                            echo '<b>'.'PENDING'.'</b>';}
                                        else if($row_data_staff['verified'] == 'APPROVE') {
                                            echo '<b>'.'APPROVE'.'</b>';}
                                        else if($row_data_staff['verified'] == 'DISAPPROVE') {
                                            echo '<b>'.'DISAPPROVE'.'</b>';}

                                        ?><br><br>
                                        <? echo $row_data_staff['verified_name'];?>

                                    </td>

                                    <td>
                                        <?if($row_data_staff['approve'] == 'PENDING' ) {
                                            echo '<b>'.'PENDING'.'</b>';}
                                        else if($row_data_staff['approve'] == 'APPROVE') {
                                            echo '<b>'.'APPROVE'.'</b>';}
                                        else if($row_data_staff['approve'] == 'CHECKED') {
                                            echo '<b>'.'APPROVE'.'</b>';}
                                        else if($row_data_staff['approve'] == 'DISAPPROVE') {
                                            echo '<b>'.'DISAPPROVE'.'</b>';}

                                        ?><br><br>
                                        <? echo $row_data_staff['approve_name'];?>

                                    </td>
                                    <td>
                                        <? if($row_data_staff['approve'] == 'APPROVE'){?>
                                            <a href="../controller/deletebuttoninout.php?id=<? echo $row_data_staff['id']; ?>"><button class="btn btn-danger" type="button" onclick="return Confirm('Are you sure to delete?')">Delete</button></a>
                                            <a href="../controller/button_complete_inout_exec.php?inout_id=<? echo $row_data_staff['inout_id'];?>"><button class="btn btn-success" type="button" onclick="return Confirm()">Check</button></a>
                                        <?}else if($row_data_staff['approve'] == 'CHECKED'){
                                            echo '<b><font color="green">'.'COMPLETE'.'</font></b>';}
                                        ?>




                                        <?
                                        if ($row_data_staff['images'] != '') { ?>
                                        <a href="#myModal3" data-toggle="modal" data-id="<? echo $row_data_staff['id'];?>"><button class="btn btn-info" type="button">Show Attachment</button></a><?}?>

                                    </td>
                                </tr>
                            <?php  } ?>

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
<!-- /#wrapper -->

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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#department_id").change(function(){
            var department_id=$(this).val();
            sendType(department_id);
        });

    });
    function sendType(department_id)
    {
        window.location.href="aims_inout_list_hr.php?approve=<? echo $approve; ?>&mnt=<? echo $bln; ?>&yr=<? echo $thn; ?>&flg=<? echo $flag; ?>&department_id="+department_id;

    }
</script>

</body>

</html>