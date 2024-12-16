<?php

include ('../controller/auth.php');
require "../model/staff_function.php";
require "../model/lookup.php";

?>
<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$tahun = $_GET['tahun'];
$department_code=$_GET['department_id'];
$statact = $_GET['statact'];
if(!isset($statact)){
    $statact = 'ACTIVE';

}

/*	if(!isset($department_code)){
        $department_code = $_SESSION['SESS_DEPARTMENT'];

    } */

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


    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }

        // -->
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
                <h1 class="page-header"> SENARAI CUTI MEDICAL</h1>
            </div>
        </div>


        <?
        $flagScreen="tab_2";
        include ('../global/menu_listCuti.php');
        ?>

        <br>
        <div class="col-lg-4">

            <select  required class="form-control" name="department_code" id="department_code">
                <option value="">-- Pilih Syarikat--</option>
                <? echo getDropDown("department","code_department","description",$department_code);?>
            </select>

        </div>
        <div align="right" style="float:right">
            <a href="print_mc.php"><button type="button" class="btn btn-primary">Print</button></a>
        </div>
        <br><br><br>
        <!--<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Pekerja</h1>
            </div>

        </div>-->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">

                        <input type="text" name="company_id"  value="<? echo $_SESSION['SESS_COM']; ?>">
                        <input type="text" name="shortcode"  value="<? echo $shortcode;?>">
                        <input type="text" name="department_code"  value="<? echo $department_code;?>">
                        <input id="action" name="action" type="hidden" value="upload"/>





                    </div><!--modal-body-->
                </div>
                <!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Cuti
                    </div>



                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarikh</th>
                                <th>Maklumat Staf</th>
                                <th>Jenis Cuti & Bilangan Cuti</th>
                                <th>Status Kelulusan Sokongan</th>
                                <th>Status Kelulusan HOD/CEO</th>
                                <th>Attachment</th>
                                <th>Status Cuti</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_staff = getListCutiMC($department_code);
                            while($row_data_staff = $data_staff->fetch_assoc()) {


                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <b>TARIKH AWAL : <? echo $row_data_staff['date_lv_from'];?></b><br>
                                        <b>TARIKH AKHIR: <? echo $row_data_staff['date_lv_to'];?></b>
                                    </td>



                                    <td>
                                        <b>NAMA STAFF : <? echo $row_data_staff['name'];?></b><br>
                                        <b>BAHAGIAN : <? echo $row_data_staff['department_sub'];?></b><br>
                                        <b>NO KP	   : <? echo $row_data_staff['noic'];?></b><br>
                                        <b>SEBAB	   : <? echo $row_data_staff['reason_leave'];?>
                                    </td>

                                    <td>
                                        <b>JENIS CUTI : <? if($row_data_staff['type_leave'] == 'AL' ) {
                                                echo '<b>'.'Annual leave'.'</b>';}
                                            else if($row_data_staff['type_leave'] == 'MC') {
                                                echo '<b>'.'Medical leave'.'</b>';}
                                            else if($row_data_staff['type_leave'] == 'LP') {
                                                echo '<b>'.'Leave Without Pay'.'</b>';}
                                            else if($row_data_staff['type_leave'] == 'CL') {
                                                echo '<b>'.'Compassionate Leave'.'</b>';}
                                            else {
                                                echo '<b>'.'Leave Without Record'.'</font></b>'; }?></b><br>
                                        <b>BIL. CUTI  : <? echo $row_data_staff['total_lv_req'];?></b>
                                    </td>

                                    <td><? echo $row_data_staff['support'];?><br><? echo $row_data_staff['support_by'];?></td>
                                    <td><? echo $row_data_staff['approvement'];?><br><? echo $row_data_staff['pelulus'];?></td>
                                    <td>
                                        <?if($row_data_staff['document_name'] != '') {?>
                                        <a href="#myModal2" data-toggle="modal" data-id="<? echo $row_data_staff['id'];?>"><button class="btn btn-info" type="button">Papar Lampiran</button></a><?}?>
                                    </td>
                                    <td>
                                        <b>JENIS CUTI : <? echo $row_data_staff['jenis_cuti'];?></b><br>
                                        <b>JUMLAH KESELURUHAN CUTI: <? echo $row_data_staff['total_cuti'];?></b><br>
                                        <b>BAKI CUTI : <? echo $row_data_staff['baki_cuti'];?></b><br>
                                        <!--	<b>BAKI CUTI PERMOHONAN : <? echo $row_data_staff['baki_cuti_pohon'];?></b> -->
                                    </td>
                                    <td align='center'>

                                        <? if($row_data_staff['hr_checked'] == 'UC'){   ?>
                                            <a href="../controller/checkleavehr_exec.php?staff_holiday_id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>
												&staff_record_id=<? echo $row_data_staff['staff_record_id'];?>"><button class="btn btn-success" type="button" onclick="return Confirm()">CHECK</button></a>
                                        <?} else if($row_data_staff['hr_checked'] == 'CHECKED'){?>
                                            <b><font align='center' color="green">CHECKED</font></b>
                                        <? } ?>
                                        <br><br>
                                        <a href="../controller/deleteleavehr_exec.php?staff_holiday_id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $no_staff;?>&tahun=<?echo $tahun;?>
												&type_leave=<? echo $row_data_staff['type_leave'];?>&staff_record_id=<? echo $row_data_staff['staff_record_id'];?>&total_lv_req=<? echo $row_data_staff['total_lv_req'];?>
												"><button class="btn btn-danger" type="button" onclick="return Confirm()" >CANCEL MC</button></a>
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
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

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
                        url:'lampiran_papar.php',
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
        window.location.href="list_cuti_HR_MC.php?department_id="+type;

    }
</script>

</body>

</html>