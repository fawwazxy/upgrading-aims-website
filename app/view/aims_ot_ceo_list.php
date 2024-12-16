<?php

include ('../controller/auth.php');
require "../model/lookup.php";

require "../model/aims_ot_function.php";

?>

<?


$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];
$department_code=$_GET['department_code'];
$sys = getSys(1)-> fetch_assoc();
$approved_by = $_SESSION['SESS_NAME'];
$approved_status = $_GET['approved_status'];
$idchkbx = $_GET['idchkbx'];

if (!isset($approved_status) && $approved_status == '') {
    $approved_status = 'PENDING';
}
if(!isset($department_code)){
    $department_code = '0';
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
        function Kemaskini(){
            return confirm('Anda pasti untuk kemaskini maklumat permohonan claim?');
        }

    </script>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk hantar permohonan claim?');
        }

        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=890');
            if (window.focus) {newwindow.focus()}
            return false;
        }

    </script>

    <script type="text/javascript">

        function un_check(){
            for (var i = 0; i < document.frmactive.elements.length; i++) {
                var e = document.frmactive.elements[i];
                if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                    e.checked = document.frmactive.allbox.checked;
                }}}

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
                    <!--<a href="v02_aims_ot_ceo_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">-->
                    <!--    <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 02-->
                    <!--</a>-->
                </h1>
            </div>
        </div>


        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-lg-4">

                <select  required class="form-control" name="department_code" id="department_code">
                    <option value="0">-- Choose Company--</option>
                    <? echo getDropDown("department","code_department","description",$department_code);?>
                </select>

            </div></div>
        <br><br>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>List Overtime Claim</label>&nbsp;&nbsp;&nbsp;
                        <a href="aims_ot_ceo_list.php?department_code=<? echo $department_code;?>&approved_status=PENDING">NEW</a> &nbsp;|&nbsp;
                        <a href="aims_ot_ceo_list.php?department_code=<? echo $department_code;?>&approved_status=APPROVED">APPROVED</a> &nbsp;|&nbsp;
                        <a href="aims_ot_ceo_list.php?department_code=<? echo $department_code;?>&approved_status=DISAPPROVED">DISAPPROVED</a>

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <input type="checkbox" id="select_all"/><font size='4'> Select All</font></li>

                        <? $data=getCheckboxUpdateOtCeo($idchkbx,$_SESSION['SESS_NAME']);?>
                        <form name="frmactive" method="post" action="">
                            <table border="0">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="APPROVE" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="DISAPPROVE" />
                                    </td>
                            </table><br>

                            <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="text-align:center;" width="2%">No.</th>
                                    <th style="text-align:center;" width="20%">Staff Info</th>
                                    <th style="text-align:center;" width="20%">Month Claim</th>
                                    <th style="text-align:center;" width="20%">Company</th>
                                    <th style="text-align:center;" width="20%">CEO/CHAIRMAN Status</th>
                                    <th style="text-align:center;" width="20%">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                if($approved_status == 'PENDING') {
                                    $pemohon= getOtForCeo($department_code,$_SESSION['SESS_NO_STAFF']);
                                }
                                else if($approved_status == 'APPROVED') {
                                    $pemohon= getOtForCeoApproved($department_code,$_SESSION['SESS_NO_STAFF']);
                                }
                                else {
                                    $pemohon= getOtForCeoDisapproved($department_code,$_SESSION['SESS_NO_STAFF']);
                                }

                                $i= 1;
                                while($ot = $pemohon->fetch_assoc()) {

                                $verify_date= new DateTime($ot['verify_date']);
                                $review_date= new DateTime($ot['review_date']);
                                $approved_date= new DateTime($ot['approved_date']);
                                $b = ceoBatch($ot['department_sub'],$ot['month_claim'],$ot['approved_status'],$ot['id'])->fetch_assoc();
                                ?>
                                <tr>
                                    <td align="center"><?echo $i++;?>
                                        <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $b['idchkbx']; ?>">

                                    </td>
                                    <td>
                                        <b>Name:</b> <?echo $ot['name'];?><br>
                                        <b>IC No:</b> <?echo $ot['noic'];?><br>
                                        <b>Position:</b> <?echo $ot['position'];?><br>
                                        <b>Department:</b> <?echo $ot['department_sub'];?>
                                    </td>
                                    <td style="text-align:center;"><?echo $ot['month_claim'];?></td>
                                    <td style='text-align:center'><?echo $ot['department_id'];?></td>


                                    <td style='text-align:center'>
                                        <?'<b>'.$ot['approved_status'].'</b>';
                                        if($ot['approved_status']==PENDING){
                                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                                        else if($ot['approved_status']==APPROVED){
                                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>
											<br><br>".$ot['approved_by']."<br>".$approved_date->format('Y-m-d')."";}
                                        else {
                                            echo"<span style='background-color:red;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>";}

                                        ?>
                                    </td>
                        </form>
                        <td>
                            <a href="" onclick="return popitup('aims_ot_report.php?id=<? echo $ot['id'];?>&month=<? echo $ot['month_claim'];?>&tahun=<? echo $ot['tahun'];?>&review_status=REVIEWED')"><button type="button" class="btn btn-info">CLAIM INFO</button></a>

                            <?if($ot['document_name'] != '') {?>
                                <a href="" onclick="return popitup('aims_ot_all_images.php?id=<? echo $ot['id'];?>&month=<? echo $ot['month_claim'];?>&tahun=<? echo $ot['tahun'];?>&review_status=REVIEWED')"><button type="button" class="btn btn-primary">ATTACHMENT</button></a>
                            <?}?>
                            <a href="#myModal1" class="btn btn-success" data-toggle="modal" data-id ="<? echo $ot['id'];?>" data-month ="<? echo $ot['month_claim'];?>">APPROVE</a>
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">HOD/CHAIRMAN SECTION</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        var month = $(e.relatedTarget).data('month');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_ot_ceo_update.php',
                            data:{id:rowid,month:month},
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
                    var month = $(e.relatedTarget).data('month');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'GET',
                        url:'aims_ot_all_images.php',
                        data:{id:rowid,month:month},
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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#department_code").change(function(){
            var selected_cawangan=$(this).val();
            sendType(selected_cawangan);
        });

    });

    function sendType(type)
    {
        window.location.href="aims_ot_ceo_list.php?department_code="+type+"&approved_status=<? echo $approved_status; ?>";

    }
</script>

</body>

</html>



