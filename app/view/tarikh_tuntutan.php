<?php

include ('../controller/auth.php');

require "../model/claim_function.php";

?>

<?
$no_staff=$_GET['no_staff'];
$act = $_GET['act'];
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
        function updateId(curr_edit_id){
            document.getElementById('curr_edit_id').value = curr_edit_id;


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
                <!--<h1 class="page-header">Senarai Pemohon</h1>-->
            </div>

            <?
            $flagScreen="tab_4";
            include ('../global/menu_tuntutan.php');
            ?>
            <h1 class="page-header"> Tarikh Tuntutan</h1>

            <?
            $log=getTarikhTuntutan()->fetch_assoc();


            ?>




            <form method="post" action="../controller/tarikh_tuntutan_exec.php" >


                <div class="form-group" align="left">
                    <label>Tarikh Mula Tuntutan &nbsp;</label>
                    <input class="form-control" type="date" name="tarikh_mula_tuntutan" value="<? echo $log['tarikh_mula_tuntutan']; ?>" required autocomplete="off"
                           required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
                </div>

                <div class="form-group" align="left">
                    <label>Tarikh Akhir Tuntutan<font color="red"></font>&nbsp;</label>
                    <input class="form-control" type="date"  name="tarikh_akhir_tuntutan" value="<? echo $log['tarikh_akhir_tuntutan']; ?>" required autocomplete="off"
                           required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
                </div>

                <div class="modal-footer">



                    <button type="submit" class="btn btn-primary" >Simpan</button>
                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                </div>
            </form>

        </div>




        <!-- /.row -->
        <!-- /.container-fluid -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr>
                    <th>#.</th>
                    <th>Tarikh Mula Tuntutan</th>
                    <th>Tarikh Akhir Tuntutan</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
                </thead>
                <tbody>

                <?
                $i= 1;
                $data = getTarikhTuntutanPrevious();
                while($row_data = $data->fetch_assoc()) {




                ?>
                <tr class="odd gradeX">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row_data['tarikh_mula_tuntutan']; ?></td>
                    <td><?php echo $row_data['tarikh_akhir_tuntutan']; ?></td>
                    <td>


                        <?
                        if($row_data['status_tuntutan'] == 1)
                        {

                            echo'<strong><font color=blue>AKTIF</font></strong>';

                        }
                        else
                        {
                            echo '<strong><font color=red>TIDAK AKTIF</font></strong>';
                        }
                        ?>
                    <td>


                        <a href="../controller/tarikh_tuntutan_aktif_exec.php?id=<? echo $row_data['id']; ?>"><button class="btn btn-success" type="button" onclick="return Confirm()" >AKTIF</button>

                            <!--  <a href="../controller/tarikh_tuntutan_update_exec.php?id=<? echo $row_data['id']; ?>"><button class="btn btn-info" type="button" onclick="return Confirm()" data-toggle="modal" data-target="#myModal1">Kemaskini</button>
                                         -->

                            <!--  <button type="button" class="btn btn-info" data-id="<? echo $row_data['id']; ?>"   data-toggle="modal" data-target="#myModal1" >Kemaskini</button> -->
                    </td>




                    <?php $i++; } ?>
                </tr>






                </tbody>


            </table>

        </div>
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->



</div>
<!-- /#wrapper -->
<? include ('../global/footer.php'); ?>





</body>

</html>