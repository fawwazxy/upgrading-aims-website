<?php

include ('../controller/auth.php');
require "../model/contractor_function.php";
require "../model/lookup.php";

?>
<?

$bln=$_GET['mnt'];
$thn=$_GET['yr'];
$category_id=$_GET['category_id'];

if(!isset($category_id)){
    $category_id = 'VISITOR';

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
        <?

        if ($category_id=='VISITOR') {
            $flagScreen="tab_1";
        }
        elseif ($category_id=='CONTRACTOR') {
            $flagScreen="tab_2";
        }

        include ('../global/menu_contactorlist.php');
        ?>
        <br>



        <div class="row">
            <div class="panel-heading" align="right">
                <a href="contractor_register.php?id=0"><button class="btn btn-primary">Add New</button></a>

            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pekerja
                    </div>



                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />

                        <? if($category_id == 'CONTRACTOR') {?>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Company</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $i= 1;
                                $data_staff = getContractorList($category_id);
                                while($row_data_staff = $data_staff->fetch_assoc()) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <b><a href="" onclick="return popitup('contractor_details.php?no_staff=<? echo $row_data_staff['no_staff'];?>&id=<? echo $row_data_staff['id'];?>')"><?php echo $row_data_staff['name']; ?></a><br>
                                                &nbsp;<?php echo $row_data_staff['noic']; ?></b>
                                        </td>
                                        <td><b><?php echo $row_data_staff['role_id']; ?></b></td>
                                        <td><b><?php echo $row_data_staff['syarikat']; ?></b></td>
                                        <td>
                                            <b><?php echo $row_data_staff['phone']; ?></b><br>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_staff['phone']; ?>')" >WhatsApp</button><br>
                                        </td>
                                        <td>

                                            <a href="contractor_update.php?id=<? echo $row_data_staff['id'];?>"><button class="btn btn-info" type="button" >Update</button></a>

                                            <? if($row_data_staff['role_id'] == "CONTRACTOR"){?>
                                                <a href="penentuan_tarikh_bekerja_staff.php?id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $row_data_staff['no_staff'];?>&shift_kerja=<? echo $row_data_staff['shift_kerja'];?>"><button class="btn btn-primary" type="button" >Tetapan Offday</button></a>
                                                <a href="../view/electronic_time_card.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&noic=<? echo $row_data_staff['noic']; ?>&sys_id=<? echo $sys['sys_id']; ?>" target="_blank"><button class="btn btn-success" type="button" >Electronic Time Card</button></a>
                                            <?}?>
                                            <? if($row_data_staff['role_id'] == 'VISITOR'){?>
                                                <a href="../view/report_kehadiran_bulan.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&noic=<? echo $row_data_staff['noic']; ?>&sys_id=<? echo $sys['sys_id']; ?>" target="_blank"><button class="btn btn-success" type="button" >Laporan Keseluruhan</button></a>
                                            <?}?>
                                            <a href="../controller/contractor_delete_exec.php?id=<? echo $row_data_staff['id']; ?>"><button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>


                                        </td>



                                    </tr>
                                    <?php $i++; } ?>


                                </tbody>

                            </table>
                        <?} else {?>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Company</th>
                                    <th>Phone</th>
                                    <th>Purpose</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $i= 1;
                                $data_staff = getVisitorList($category_id);
                                while($row_data_staffs = $data_staff->fetch_assoc()) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <b><a href="" onclick="return popitup('contractor_details.php?no_staff=<? echo $row_data_staffs['no_staff'];?>&id=<? echo $row_data_staffs['id'];?>')"><?php echo $row_data_staffs['name']; ?></a><br>
                                                &nbsp;<?php echo $row_data_staffs['noic']; ?></b>
                                        </td>
                                        <td><b><?php echo $row_data_staffs['role_id']; ?></b></td>
                                        <td><b><?php echo $row_data_staffs['syarikat']; ?></b></td>
                                        <td>
                                            <b><?php echo $row_data_staffs['phone']; ?></b><br>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_staffs['phone']; ?>')" >WhatsApp</button><br>
                                        </td>


                                        <td><b><?php echo $row_data_staffs['purpose']; ?></b></td>
                                        <td><b><?php echo $row_data_staffs['masa_masuk']; ?><br>
                                                Location: <?php echo $row_data_staffs['remark_masuk']; ?></b></td>
                                        <td><b><?php echo $row_data_staffs['masa_keluar']; ?><br>
                                                Location: <?php echo $row_data_staffs['remark_keluar']; ?></b></td>
                                        <td>

                                            <a href="contractor_update.php?id=<? echo $row_data_staffs['id'];?>"><button class="btn btn-info" type="button" >Update</button></a>

                                            <? if($row_data_staffs['role_id'] == "CONTRACTOR"){?>
                                                <a href="penentuan_tarikh_bekerja_staff.php?id=<? echo $row_data_staffs['id'];?>&no_staff=<? echo $row_data_staffs['no_staff'];?>&shift_kerja=<? echo $row_data_staffs['shift_kerja'];?>"><button class="btn btn-primary" type="button" >Tetapan Offday</button></a>
                                                <a href="../view/electronic_time_card.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&noic=<? echo $row_data_staffs['noic']; ?>&sys_id=<? echo $sys['sys_id']; ?>" target="_blank"><button class="btn btn-success" type="button" >Electronic Time Card</button></a>
                                            <?}?>
                                            <a href="../controller/contractor_delete_exec.php?id=<? echo $row_data_staffs['id']; ?>"><button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                        </td>



                                    </tr>
                                    <?php $i++; } ?>


                                </tbody>

                            </table>
                        <?}?>
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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#cawangan_kod,#jabatan_kod").change(function(){
            var selected_cawangan=$("#cawangan_kod").val();
            var selected_jabatan=$("#jabatan_kod").val();
            sendType(selected_cawangan,selected_jabatan);
        });

    });
    function sendType(cawangan,jabatan)
    {
        if(jabatan==undefined){
            window.location.href="staff_info.php?statact=<? echo $statact;?>&cawangan_kod="+cawangan;
        }else{
            window.location.href="staff_info.php?statact=<? echo $statact;?>&cawangan_kod="+cawangan+"&jabatan_kod="+jabatan;
        }

    }
</script>

</body>

</html>
