<?php

include ('../controller/auth.php');

require "../model/support_function.php";

$no_staff = $_GET['no_staff'];
$no_staff_login = $_GET['SESS_NO_STAFF'];
$faq_id = $_POST['faq_id'];
$data_staff = getStaffByNoStaff($_SESSION['SESS_NO_STAFF'])->fetch_assoc();


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
        function Confirm(){
            return confirm('Aduan ini akan dihantar kepada Tim Sokongan/Developer?');
        }
    </script>
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
                <h1 class="page-header">Aduan</h1>
            </div>
        </div>
        <div class="row">


            <div class="panel-heading" align="right">
                <a href="client_support_staff.php"><button class="btn btn-primary"  type="button" >Tambah Aduan</button></a>
            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Aduan
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <th>#</th>
                            <th>Sistem</th>
                            <th>Huraian</th>
                            <th>Maklum Balas</th>
                            <th>Tindakan</th>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getAduanList($_SESSION['SESS_NOKP'], $data_staff['phone']);
                            while($row_data = $data->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['nama_projek']; ?></td>
                                    <td><?php echo $row_data['aduan']; ?></td>
                                    <td><?php if($row_data['client_feedback']==''){
                                            if($row_data['status_tindakan']=='C'){echo '<font color="red"><b>STATUS ADUAN : '.$row_data['keterangan'].'</b></font>';}else{
                                                echo '<font color="blue"><b>STATUS ADUAN : '.$row_data['keterangan'].'</b></font>';
                                            }
                                        }else{echo $row_data['client_feedback'];}  ?></td>
                                    <td><?if($row_data['status_tindakan']!='C'){?>
                                            <a href="maklum_balas_staff.php?id=<? echo $row_data['id'];?>"><button class="btn btn-info" type="button" >Maklum Balas</button></a>

                                            <a href="../controller/support_exec.php?action=batal_5&id=<? echo $row_data['id'];?>&id_developer=<?echo $row_data['id_support_developer']?>"> <button class="btn btn-danger" onclick="return Cancel()">Batal</button></a>
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
    });
    $('.Contact').click(function(){
        var id=$('.Contact').val();
        $.ajax({url:"ModalPage.php?id="+id,cache:false,success:function(result){
                $(".modal-content").html(result);
            }});
    });
</script>
</body>

</html>
