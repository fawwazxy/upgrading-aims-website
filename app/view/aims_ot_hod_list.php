<?php

include ('../controller/auth.php');
require "../model/lookup.php";

require "../model/aims_ot_function.php";


?>

<?

$sys = getSys(1)-> fetch_assoc();

$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$company_id = $_SESSION['SESS_DEPARTMENT'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$verify_by = $_SESSION['SESS_NAME'];

$month_claim = $_GET['month_claim'];
$idchkbx = $_GET['idchkbx'];

$verify_status = $_GET['verify_status'];
if (!isset($verify_status) && $verify_status == '') {
    $verify_status = 'PENDING';
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

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Overtime Claim
                    <!--<a href="v02_aims_ot_hod_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>

        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Overtime Claim</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_ot_hod_list.php?verify_status=PENDING">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_ot_hod_list.php?verify_status=VERIFIED">VERIFIED</a> &nbsp;|&nbsp;
                        <a href="aims_ot_hod_list.php?verify_status=REJECTED">REJECTED</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input type="checkbox" id="select_all"/><font size='4'> Select All</font></li>

                        <? $data=getCheckboxUpdateOtHod($idchkbx,$_SESSION['SESS_NAME'])?>
                        <form name="frmactive" method="post" action="">
                            <table border="0">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="VERIFY" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="REJECT" />
                                    </td>
                            </table><br>

                            <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="text-align:center;" width="5%">No.</th>
                                    <th style="text-align:center;" width="20%">Staff Info</th>
                                    <th style="text-align:center;" width="20%">Month Claim</th>
                                    <th style="text-align:center;" width="20%">Status</th>
                                    <th style="text-align:center;" width="10%">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                if($verify_status == 'PENDING') {
                                    $pemohon= getOtForHod($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF']);
                                }
                                else if($verify_status == 'VERIFIED') {
                                    $pemohon= getOtForHodApproved($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF']);
                                }
                                else {
                                    $pemohon= getOtForHodDisapproved($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF']);
                                }
                                $i= 1;
                                while($ot = $pemohon->fetch_assoc()) {

                                $verify_date= new DateTime($ot['verify_date']);
                                $b = hodBatch($ot['department_sub'],$ot['month_claim'],$ot['verify_status'],$ot['id'])->fetch_assoc();
                                ?>
                                <tr>
                                    <td align="center">
                                        <?echo $i++; ?>
                                        <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $b['idchkbx']; ?>"/>

                                    </td>
                                    <td>
                                        <b>Name:</b> <?echo $ot['name'];?><br>
                                        <b>IC No:</b> <?echo $ot['noic'];?><br>
                                        <b>Position:</b> <?echo $ot['position'];?><br>
                                        <b>Department:</b> <?echo $ot['department_sub'];?><br>
                                        <b>Company:</b> <?echo $ot['department_id'];?>
                                    </td>
                                    <td style="text-align:center;"><?echo $ot['month_claim'];?></td>
                                    <td style="text-align:center;">
                                        <?'<b>'.$ot['verify_status'].'</b>';
                                        if($ot['verify_status']==PENDING){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($ot['verify_status']==VERIFIED){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>
											<br><br>".$ot['verify_by']."<br>".$verify_date->format('Y-m-d').""; }
                                        else {
                                            echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REJECTED</span>";}

                                        ?>
                                    </td>
                        </form>
                        <td>
                            <!--	<a href="aims_ot_batch_hod.php?month_claim=<? echo $ot['month_claim']?>&id=<?echo $ot['id']?>&verify_status=<?echo $ot['verify_status']?>"><button class="btn btn-primary">CLAIM LIST</button></a> -->
                            <a href="aims_ot_batch_hod.php?month_claim=<? echo $ot['month_claim']?>&id=<?echo $ot['id']?>&verify_status=<?echo $ot['verify_status']?>" target="_blank" data-toggle="" data-id=""><button type="button" class="btn btn-primary">CLAIM INFO</button></a>
                        </td>
                        </tr>
                    <?}?>

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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    // Delete row on delete button click

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>

</body>

</html>



