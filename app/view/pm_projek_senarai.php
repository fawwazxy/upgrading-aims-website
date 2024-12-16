<?php

include ('../controller/auth.php');
require "../model/task_function.php";
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
                <h1 class="page-header">Senarai Projek</h1>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tambah Projek
                </button>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" align="left" id="myModalLabel">Tambah Projek</h4>
                        </div>

                        <div class="modal-body">
                            <form method="post" action="../controller/pm_project_add.php" >

                                <input type="hidden" class="form-control" placeholder=" " id="shortcode" name="shortcode" value="<? echo $shortcode; ?>"/>

                                <div class="form-group" align="left">
                                    <label>Nama Projek</label>
                                    <input class="form-control" placeholder=" " id="project_name" name="project_name" required autocomplete="" >
                                </div>

                                <div class="form-group" align="left">
                                    <label>Singkatan Kod Projek</label>
                                    <input class="form-control" placeholder=" " id="project_code" name="project_code" required autocomplete="" >
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Tambah Maklumat</button></a>
                                </div>
                            </form>
                        </div><!--modal-body-->

                    </div>
                    <!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Projek
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                            <thead>
                            <tr>
                                <th width="20px">#</th>
                                <th width="50px">Kod Projek</th>
                                <th widht="50px">Nama Projek</th>
                                <th widht="50px">Status</th>
                                <th widht="50px">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getProject();
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['project_code']; ?></a></td>
                                    <td><?php echo $row_data['project_name']; ?></a></td>
                                    <td>
                                        <font color="red"><strong>
                                                <? if($row_data['status']== '0'){
                                                echo "<font color=red><strong>TIDAK AKTIF</strong></font>";?>

                                                <font color="blue"><strong><?
                                                        } else if ($row_data['status'] == '1'){
                                                            echo  "<font color=blue><strong>AKTIF</strong></font>";
                                                        }?>
                                    </td>
                                    <td>
                                        <? if($row_data['status']== '0'){
                                            echo " ";
                                        } else if ($row_data['status'] == '1'){
                                            echo  " ";
                                            ?>



                                            <a href="pm_add_task.php?id=<? echo $row_data['id']; ?>"> <button class="btn btn-info" type="button" >Tambah Task</button></a>

                                            <button type="button" class="btn btn-info" data-id="<? echo $row_data['id']; ?>" data-toggle="modal" data-target="#myModal1" >Kemaskini</button>

                                            <a href="../controller/update_pm_projek_exec.php?id=<? echo $row_data['id']; ?>">
                                                <button type="button" class="btn btn-danger">Nyahaktif</button></a>

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
        </div>

        <? include ('../global/footer.php'); ?>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Projek</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'pm_projek_kemaskini.php',
                            data:'id='+rowid,
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
