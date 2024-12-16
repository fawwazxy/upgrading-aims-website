<?php

include ('../controller/auth.php');

require "../model/aims_others_claim_hod_function.php";
require "../model/lookup.php";

$claim_id = $_GET['claim_id'];
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
$month_claim = $_GET['month_claim'];

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
        <!--<?include '../global/menu_keselamatan.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">CLAIM LIST</h1>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>List of Claim</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_others_claim_hod_list.php?hod_review_status=PENDING">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_others_claim_hod_list.php?hod_review_status=VERIFIED">VERIFIED</a> &nbsp;|&nbsp;
                        <a href="aims_others_claim_hod_list.php?hod_review_status=DISVERIFIED">DISVERIFIED</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">


                        <input type="checkbox" id="select_all"/><font size='4'> Select All</font>

                        <? $data=getCheckboxUpdateOtHod($claim_id,$_SESSION['SESS_NAME'])?>
                        <form name="frmactive" method="post" action="">
                            <table border="0">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="VERIFIED" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="DISVERIFIED" />
                                    </td>
                            </table><br>

                            <input name="id" type="hidden" class="input-short" value="<? echo $claim_id;?>" />
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
                                if($hod_review_status == 'PENDING') {
                                    $pemohon= getTravelVerifiedNew($_SESSION['SESS_NO_STAFF']);
                                }
                                else if($hod_review_status == 'VERIFIED') {
                                    $pemohon= getTravelVerifiedApprove($_SESSION['SESS_NO_STAFF']);
                                }
                                else {
                                    $pemohon= getTravelVerifiedDisapprove($_SESSION['SESS_NO_STAFF']);
                                }
                                $i= 1;
                                while($staffinfo = $pemohon->fetch_assoc()) {

                                    $hod_review_date = new DateTime($staffinfo['hod_review_date']);
                                    $b = hodBatch($staffinfo['hod_review_status'],$staffinfo['claim_id'])->fetch_assoc();
                                    ?>
                                    <tr>
                                        <td align="center">
                                            <?echo $i++; ?><br>
                                            <!--<?echo $b['claim_id']; ?>-->
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $b['claim_id']; ?>"/>

                                        </td>
                                        <td>
                                            NAME:<?echo $staffinfo['name'];?><br>
                                            IC:<?echo $staffinfo['noic'];?><br>
                                            DEPARTMENT:<?echo $staffinfo['department_sub'];?><br>
                                            COMPANY:<?echo $staffinfo['department_id'];?>
                                        </td>
                                        <td style="text-align:center;"><?echo $staffinfo['month_claim'];?></td>
                                        <td style="text-align:center;">
                                            <?'<b>'.$staffinfo['hod_review_status'].'</b>';
                                            if($staffinfo['hod_review_status']==PENDING){
                                                echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                            else if($staffinfo['hod_review_status']==VERIFIED){
                                                echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>";}
                                            else {
                                                echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISVERIFIED</span>";}

                                            ?><br><br>
                                            <?echo $staffinfo['hod_review_by'];?>

                                            <br><br>
                                            <?echo $staffinfo['hod_review_date'];?>
                                        </td>

                                        <td class="text-center">
                                            <a href="aims_othersclaim_batch_hod.php?id=<?echo $staffinfo['id']?>&status=<?echo $staffinfo['hod_review_status']?>&tahun=<?echo $staffinfo['tahun']?>&company_claim=<?echo $staffinfo['company_claim']?>&month_claim=<?echo $staffinfo['month_claim']?>&claim_id=<?echo $staffinfo['claim_id']?>"target="_blank" data-toggle="" data-id=""><button type="button" class="btn btn-primary">CLAIM INFO</button></a>
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



