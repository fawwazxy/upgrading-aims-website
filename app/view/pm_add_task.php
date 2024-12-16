<?php

include ('../controller/auth.php');

require "../model/task_function.php";

?>

<?
$com_id=$_GET['SESS_COM'];
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$id_project = $_GET['id_project'];
$project_code = $_GET['project_code'];



?>

<style>
    div.ex1 {
        height: 500px;
        overflow: scroll;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>




</head>

<body data-spy="scroll" data-target=".scroll">

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


                <h1 class="page-header">Tambah Maklumat</h1>
            </div>
        </div>

        <? $data=getNamaProjek($id)->fetch_assoc()?>
        <h3>Nama Projek: <?echo $data['project_name']?></h3>

        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">











                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="redirect" type="hidden" value="../view/penawaran_jawatan?id=<?echo $list['id'];?>"/>
                        <input name="iklan_id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <div class="ex1"">
                        <table width="100%" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th>Task</th>
                                <th>Task Start</th>
                                <th>Task Finish</th>
                                <th>Duration</th>
                                <th>Progress</th>
                                <th>Status Assign</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>

                                <form method="post" action="../controller/add_task_exec.php?id=<? echo $id; ?>" >

                                    <input type="hidden" class="form-control" name="project_code" id="project_code" value="<?echo $data['project_code']?>">



                                    <td>&nbsp;</td>

                                    <td>

                                        <select required class="form-control"  name="parent_id" value="">
                                            <option value="">-- Pilih --</option>

                                            <? $task= getTaskPrev($id);
                                            while ($pilih  = $task -> fetch_assoc()){ ?>
                                                <option value="<? echo $pilih['task_id'];?>"><? echo $pilih['task'];?> </option>

                                                <?
                                            }
                                            ?>
                                        </select>



                                        <input type="text" class="form-control" name="task_name" id="task_name">

                                    </td>

                                    <td><input type="date" class="form-control" name="task_start" id="task_start"> </td>
                                    <td><input type="date" class="form-control" name="task_finish" id="task_finish"> </td>
                                    <td><input type="number" class="form-control" name="task_duration" id="task_duration"></td>
                                    <td><input type="number" class="form-control" name="progress" id=progress"> </td>
                                    <td>
                                        <input type="checkbox" name="status" value="1"> Assign<br>
                                    </td>
                                    <td>


                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $log = getTask($id);
                            while($list = $log->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <!--  <td> <input type="text" class="form-control" name="task_name" id="task_name" value=" <?php echo $list['task']; ?>"/></td> -->
                                    <td><?php echo $list['task']; ?></td>
                                    <td><?php echo $list['task_start']; ?></td>
                                    <td><?php echo $list['task_finish']; ?></td>
                                    <td><?php echo $list['task_duration']; ?></td>
                                    <td><?php echo $list['progress']; ?></td>
                                    <td>
                                        <font color="red"><strong>
                                                <? if($list['status_assign']== '0'){
                                                echo "<font color=red><strong>Not Assign</strong></font>";?>

                                                <font color="blue"><strong><?
                                                        } else if ($list['status_assign'] == '1'){
                                                            echo  "<font color=blue><strong>Assign</strong></font>";
                                                        }?>
                                    </td>
                                    <td>

                                        <button type="button" class="btn btn-info" data-id="<? echo $list['id_task']; ?>"  data-id-projek="<? echo $id; ?>" data-toggle="modal" data-target="#myModal1" >Kemaskini</button>
                                        <!-- <input type="text" id="id_projek" value="<? echo $id?>">
                    <input type="text" id="id_task" value="<? echo $list['id_task']; ?>"> -->
                                        <!--
                    <a href="../controller/delete_ahli_exec.php?id_peranan=<? echo $row_data['id']; ?>&id_projek=<? echo $id; ?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button> -->
                                    </td>



                                </tr>
                                <?php $i++; } ?>



                            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Kemaskini</h4>
                                        </div>
                                        <div class="modal-body" id="demo">
                                            <script type="text/javascript">

                                                $('#myModal1').on('show.bs.modal', function (e) {
                                                    var rowid = $(e.relatedTarget).data('id');
                                                    var projek = $(e.relatedTarget).data('id-projek');
                                                    // $('#demo').html(rowid);
                                                    $.ajax({
                                                        type:'GET',
                                                        url:'pm_task_edit.php',
                                                        data:{id_task: +rowid , id: +projek},
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




                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /.row -->
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->





<script type="text/javascript">
    $('#task_finish').on('change', function() {
        var date = $('#task_start').val();
        var date1 = $('#task_finish').val();
        var start = new Date(date).getTime();
        var end = new Date(date1).getTime();

        var distance = end - start;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        document.getElementById("task_duration").value = days+1;

    });

</script>
</body>

</html>

