<?php

include ('../controller/auth.php');

require "../model/project_schedule_function.php";

?>

<?
// echo $id_projek = $_GET['id_projek'];
$id = $_GET['id_project'];
$milestone_id = $_GET['milestone_id'];
$user_name = $_SESSION['SESS_NAME'] ;
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


    <style>
        #myform{
            display: none;

        }
    </style>

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


                <h1 class="page-header">Jadual Kerja</h1>
            </div>
        </div>

        <? $data=getProject($id)->fetch_assoc()?>
        <h3>Kod Projek: <?echo $data['project_code']?></h3>
        <h3>Nama Projek: <?echo $data['project_name']?></h3>
        </br>
        <div class="panel-heading" align="right">
            <a href="../view/ps_project_list.php"><input class="btn btn-success" type="button" value="Kembali"></a>
            <button type="button" onclick="return popitup('ps_schedule_view.php?id_project=<? echo $id; ?>')" class="btn btn-info">Papar Gantt</button>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <button class="btn btn-info" id="showForm">Tambah Milestone</button>
            </div>


            </br>
            </br>
            </br>
            </br>

            <div  class="col-lg-8" >
                <form id="myform" method="post"  action="../controller/ps_schedule_exec.php?act=ps_milestone_add&id_projek=<? echo $id?>&user_name=<? echo $user_name?>">
                    <!--             <input class="form-control"  type="hidden" name="id" value="<? echo $id; ?>" />
 -->             <label>Milestone:</label>
                    <input type="text" class="form-control" name="milestone" value="">

                    <input type="hidden" class="form-control" placeholder="" id="project_code" name="user_name" value="<?echo $user_name;?>">

                    <div class="modal-footer">
                        <button class="btn btn-info" >Simpan</button>
                    </div>
                </form>
            </div>


            <?
            $i=1;
            $dataN = getMilestone($data['id']);
            if ($dataN->num_rows>0){
            while($dataM = $dataN->fetch_assoc()) {

                ?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>Milestone:</label><?echo $dataM['milestone']?>
                            <? $dataX=getDateMin($dataM['id'])->fetch_assoc()?>
                            <br>
                            <label>Tarikh Mula:</label><?echo $dataX['SD']?>
                            <br>
                            <label>Tarikh Tamat:</label><?echo $dataX['ED']?>

                            <?
                            $j=1;
                            $dataTask = getTask($dataM['id']);
                            if ($dataTask->num_rows==0){?>
                                <div align="right">
                                    <a href="../controller/ps_schedule_exec.php?act=ps_milestone_delete&milestone_id=<? echo $dataM['id']?>&id=<? echo $id?>">
                                        <button type="button" align="right" class="btn btn-danger" onClick="return confirm('adakah anda pasti mahu memadam data ini?')";\">Padam Milestone</button></a>
                                </div>
                            <?}?>
                        </div>
                        <div class="panel-body">

                            <div class="panel-body">



                                <table id="dataTables-example"  width="100%" class="table table-striped table-bordered table-hover" >
                                    <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Task</th>
                                        <th>Task Start</th>
                                        <th>Task Finish</th>
                                        <th>Duration</th>
                                        <th>Slack</th>
                                        <th>Tindakan</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr>

                                        <form method="post" action="../controller/ps_schedule_exec.php?act=ps_task_add&id_project=<? echo $id?>&milestone_id=<? echo $dataM['id']?>&username=<? echo $user_name?>">
                                            <td>&nbsp;</td>

                                            <td><input type="text" class="form-control" name="task_name" id="task_name"></td>
                                            <td><input type="date" class="form-control" name="task_start" id="task_start<?echo $i;?>"> </td>
                                            <td><input type="date" class="form-control" name="task_finish" id="task_finish<?echo $i;?>"> </td>
                                            <td><input id="task_duration<?echo $i;?>" type="number" class="form-control" name="task_duration" ></td>
                                            <td><input type="number" class="form-control" name="slack" id="slack"></td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </td>
                                        </form>

                                    </tr>

                                    <?

                                    while($list = $dataTask->fetch_assoc()) {

                                        ?>

                                        <tr class="odd gradeX">

                                            <td><?php echo $j; ?></td>
                                            <td><?php echo $list['task']; ?></td>
                                            <td><?php echo $list['start_date']; ?></td>
                                            <td><?php echo $list['end_date']; ?></td>
                                            <td><?php echo $list['duration']; ?></td>
                                            <td><?php echo $list['slack']; ?></td>
                                            <td><a href="../controller/ps_schedule_exec.php?act=ps_task_delete&task_id=<? echo $list['id']?>&id=<? echo $id?>">
                                                    <button type="button" align="right" class="btn btn-danger" onClick="return confirm('adakah anda pasti mahu memadam data ini?')";\">Padam Task</button></a>
                                            </td>
                                        </tr>

                                        <?php $j++; } ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

                <script type="text/javascript">
                    $('#task_finish<?echo $i;?>').on('change', function() {
                        var date<?echo $i;?> = $('#task_start<?echo $i;?>').val();
                        var date1<?echo $i;?> = $('#task_finish<?echo $i;?>').val();
                        var start<?echo $i;?> = new Date(date<?echo $i;?>).getTime();
                        var end<?echo $i;?> = new Date(date1<?echo $i;?>).getTime();

                        var distance<?echo $i;?> = end<?echo $i;?> - start<?echo $i;?>;

                        var days<?echo $i;?> = Math.floor(distance<?echo $i;?> / (1000 * 60 * 60 * 24));
                        document.getElementById("task_duration<?echo $i;?>").value = days<?echo $i;?>+1;

                    });

                </script>
            <? $i++;}?>
                <div class="col-lg-12">
                    <button style="float: right;" type="button" onclick="return popitup('ps_schedule_view.php?id_project=<? echo $id; ?>')" class="btn btn-info">Papar Gantt</button>

                </div>
            <?}?>

            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->

        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->





<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>


<script>
    $(document).ready(function(){
        $('#showForm').click(function(){
            $('#myform').toggle(300);
        });
    });
</script>

</body>

</html>

