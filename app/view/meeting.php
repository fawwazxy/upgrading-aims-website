<?php


include ('../controller/auth.php');

require "../model/meeting_functions.php";




?>
<?

$bln=$_GET['mnt'];
$thn=$_GET['yr'];

?>

<?
$id=getIdStaff($_GET['no_staff']);
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
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
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
                <h1 class="page-header">Jadual Perancangan</h1>
            </div>
        </div>
        <?
        $flagScreen="tab_2";
        include ('../global/menu_meeting.php');
        ?>
        <div class="row">
            <div class="col-lg-12">

                <br>

                <!-- /.POP up modal  ------------------------------------------------------------------------------------------------------------------------------------->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float:right">Tambah Aktiviti Baru</button></h1>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Tambah Aktiviti</h4>
                            </div>
                            <div class="modal-body">
                                <?php include ('add_meeting.php'); ?>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.POP up modal  ---------------------------------------------------------------------------------------------------------------------------------------->
            </div>
        </div>
        <div class="row">

            <div>
                <br>
                <div class="row">
                    <div>
                        <div class="col-lg-12">
                            <div class="panel panel-default">

                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h1 class="page-header">Senarai Aktiviti</h1>
                                                </div>

                                            </div>
                                            <th>#</th>
                                            <th>Tajuk Aktiviti</th>
                                            <th>Butir - Butir  Aktiviti</th>
                                            <th>Tarikh Bermula</th>

                                            <th>Tarikh Berakhir</th>

                                            <th>Individu Terlibat </th>
                                            <th>Jenis Acara </th>
                                            <th>Status</th>
                                            <th>Tindakan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tr>
                                        <?
                                        $i= 1;
                                        $data = getMeetingInfo($_SESSION['SESS_ID']);
                                        while($row_data = $data->fetch_assoc()) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row_data['title']; ?></td>
                                            <td>
                                                <?php if ($row_data['description']==''){
                                                    echo '(no data)';
                                                }
                                                else
                                                ?>
                                                <a class = "seemore" href="event_descriptions.php?id=<? echo $row_data['id']; ?>" id = "test"><? echo $row_data['description']; ?></a></td>
                                            <td><?php echo $row_data['start']; ?></td>
                                            <td><?php echo $row_data['end']; ?></td>
                                            <td><?php
                                                $j = 0;
                                                $result = getStaffNameByID($row_data['id_staff']);
                                                while ($list = $result->fetch_assoc()){
                                                    if ($j>0) echo "<br>";
                                                    echo $list['name']."&nbsp"."( ".$list['phone'].")" ;
                                                    $j++;
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $row_data['event_type']; ?></td>

                                            <td><b><font <?php if ($row_data['status']=='BATAL'){
                                                        echo 'color="red"';
                                                    }
                                                    elseif ($row_data['status']=='DITERUSKAN'){
                                                        echo 'color="green"';
                                                    }
                                                    else {
                                                        echo 'color="blue"';
                                                    }
                                                    ?>>
                                                        <?php echo $row_data['status'];?> </font></b></td>

                                            <td><a href="edit_meeting.php?id=<? echo $row_data['id']; ?>"><button type="button" class="btn btn-info">Kemaskini</button>
                                                    <a href="../controller/delete_meeting_exec.php?id=<? echo $row_data['id']; ?>"><button type="button" class="btn btn-danger">Padam</button>
                                            </td>
                                            <?php $i++; } ?>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.col-lg-12 -->
                            </div>
                        </div>
                    </div>

                    <!-- /.row -->
                    <!-- /.container-fluid -->
                </div>
                <!-- /#page-wrapper -->

            </div>
            <!-- /#wrapper -->
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $('.seemore').collapser({
        mode: 'chars',
        truncate: 20
    });

</script>
</body>

</html>
