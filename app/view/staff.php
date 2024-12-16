<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>
<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];





?>

<!--?

   // if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
   // {
     // activeStaff($id,0);

   // }

   // if(isset($_GET['act']) && $_GET['act'] == "active" && !empty($_GET['id']))
   // {
    // activeStaff($id,1);

   // }






   // ?-->



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
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


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
                <h1 class="page-header">Maklumat Pekerja</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">


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
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pekerja</th>
                                <th>Nombor Pekerja</th>
                                <th>Jawatan</th>
                                <th>Peranan</th>
                                <th>Bahagian</th>
                                <th>No Telefon</th>
                                <th>Status</th>

                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_staff = getPekerja($_SESSION['SESS_NO_STAFF']);
                            while($row_data_staff = $data_staff->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php echo $row_data_staff['name']; ?></a> </td>
                                    <td><?php echo $row_data_staff['no_staff']; ?></td>
                                    <td><?php echo $row_data_staff['jawatan_nama']; ?></td>
                                    <td><?php echo $row_data_staff['role']; ?></td>
                                    <td><?php echo $row_data_staff['desc']; ?></td>
                                    <td><?php echo $row_data_staff['phone']; ?></td>


                                    <td>
                                        <font colorred><strong><?php echo $row_data_staff['status'];
                                                if ($status == BEKERJA) {
                                                    echo "<font color=blue><strong>BEKERJA</strong></font>";
                                                }
                                                else {

                                                }
                                                ?></strong>



                                    </td>


                                    <td>



                                        <?
                                        if ($row_data_staff['status'] == 'BEKERJA') { ?>

                                            <a href=".php?id=<? echo $row_data_staff['id'];?>&no_staff=<?php echo $row_data_staff['no_staff']; ?>"><button class="btn btn-warning" type="button" >Maklumat Gaji</button></a>

                                            <?
                                        }else if  ($row_data_staff['status'] == 'SMBG BLJR') {  ?>



                                            <?
                                        }

                                        else if ($row_data_staff['status'] == 'NAIK PGKT'){ ?>

                                            <?
                                        }
                                        else if ($row_data_staff['status'] == 'BERHENTI'){ ?>

                                            <?
                                        }
                                        ?>



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
        <? include ('../global/footer.php'); ?>
        <!-- /.container-fluid -->
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
</script>

</body>

</html>
