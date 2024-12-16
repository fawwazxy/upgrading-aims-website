<?php

include ('../controller/auth.php');

require "../model/projek_internal_task_functions.php";
require "../model/lookup.php";

?>
<?

$nokp=$_SESSION['SESS_NOKP'];
updateAllTarikhRTodoOver();
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
    <link rel="stylesheet" href="../../js/jkanban-master/jkanban.min.css" />
    <script src="../../js/jkanban-master/jkanban.min.js"></script>

    <style>

        #myKanban {
            overflow-x: auto;
            padding: 20px 0;
        }
        .success {
            background: #00b961;
        }

        .info {
            background: #2a92bf;
        }

        .warning {
            background: #f4ce46;
        }

        .error {
            background: #fb7d44;
        }
        .kanban-board .kanban-drag  {
            background: #D3D3D3;
            position: relative;
            max-height: 500px;
            overflow-y: auto;
        }
        [data-class="info"] {
            background: #00AADE;
        }
        [data-class="warning"] {
            background: #FFBB4C;
        }
        [data-class="success"] {
            background: #2CDE00;
        }
        .kanban-item{
            text-align:left;
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
                <h1 class="page-header">Tugasan Peribadi</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-body">
                <!-- <a href="senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban">
                          <div class="panel panel-red"> -->
                <!-- /.panel-heading -->
                <!-- <div class="panel-heading">
                            <center><b>Analisa Tugasan Peribadi</b></center>
                          </div>
                          <table width="100%" class="table  table-bordered">

                            <thead>
                              <th width="25%" style="text-align: center;">Untuk Pelaksanaan</th>
                              <th width="25%" style="text-align: center;">Dalam Pelaksanaan</th>
                              <th width="25%" style="text-align: center;">Selesai</th>
                              <th width="25%" style="text-align: center;">Tugasan Tertungak</th>
                            </thead>
                           
                           
                            <tbody>
                              <td align="center"><strong><font size="6" color="blue"><? echo getBilTaskByCategory("TODO",$nokp);?></font></strong></td>
                              <td align="center"><strong><font size="6" color="orange"><? echo getBilTaskByCategory("INPROGRESS",$nokp);?></font></strong></td>
                              <td align="center"><strong><font size="6" color="green"><? echo getBilTaskByCategory("DONE",$nokp);?></font></strong></td>
                               <td align="center"><strong><font size="6" color="red"><? echo getBilTaskOverdue($nokp);?></font></strong></td>
                             
                            </tbody>
                          </table>
                        </div></a> -->
                <div class="panel panel-red">
                    <!-- /.panel-heading -->
                    <div class="panel-heading">
                        <center><b>Analisa Tugasan Peribadi</b></center>
                    </div>
                    <!-- /.panel-heading -->
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" bgcolor="#D6DBDF" width="20%"><center>Untuk Pelaksanaan</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" bgcolor="#D6DBDF" width="20%"><center>Dalam Pelaksanaan</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" bgcolor="#D6DBDF" width="30%" colspan="4"><center>Sudah Selesai</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" bgcolor="#D6DBDF" width="20%"><center>Tugasan Tertunggak</center></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="blue"><? echo getBilTaskByCategory("TODO",$nokp);?></font></strong></td>
                            <td onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><? echo getBilTaskByCategory("INPROGRESS",$nokp);?></font></strong></td>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Hari Ini</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Minggu Ini</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Bulan Ini</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Tahun Ini</center></th>
                            <td onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="red"><? echo getBilTaskOverdue($nokp);?></font></strong></td>
                        </tr>
                        <tr>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurDate($nokp);?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurWeek($nokp);?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurMonth($nokp);?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurYear($nokp);?></font></strong>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-heading" align="right">

                    <a href="projek_task_tambah.php"><button class="btn btn-primary">Tambah Tugasan</button></a>

                </div>

                <div class="col-lg-12">

                    <div id="myKanban" align="center" width="100%"></div>
                </div>



                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Tindakan</h4>
                            </div>
                            <div class="modal-body" id="demo">
                                <center>
                                    <button class="btn btn-primary" id="kemaskini" >kemaskini</button>
                                    <button class="btn btn-info" id="view" >Info</button>
                                    <button class="btn btn-primary" id="catatan" >Catatan Progres</button>
                                    <button class="btn btn-danger" id="delete" >Padam</button>
                                </center>


                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
        var KanbanTest = new jKanban({
            element : '#myKanban',
            gutter  : '10px',
            widthBoard: '325px',
            responsivePercentage: true,
            click : function(el){
                var id_board = $(el.parentElement.parentElement).data("id");
                var jenis_catatan = "";

                if(id_board=="_working" || id_board=="_done"){
                    $("#kemaskini").hide();
                    $("#delete").hide();
                    $("#catatan").show();
                    if(id_board=="_working"){
                        jenis_catatan="inprogress";
                    }else{
                        jenis_catatan="done";
                    }
                }else{
                    $("#kemaskini").show();
                    $("#view").show();
                    $("#delete").show();
                    $("#catatan").hide();
                }

                // alert(el.innerHTML);
                // alert(el.dataset.eid)

                $('#modal').modal('toggle');
                $("#kemaskini").click(function(){
                    location.replace("projek_task_tambah.php?id="+el.dataset.eid);
                });
                $("#view").click(function(){
                    location.replace("projek_task_view.php?id="+el.dataset.eid);
                });
                $("#delete").click(function(){
                    $.ajax({
                        url: "../model/projek_internal_task_functions.php",
                        type: "POST",
                        data: {action:"delTask", id:el.dataset.eid},
                        success: function (response) {

                            $.confirm({
                                title: 'Info',
                                content: response,
                                buttons: {
                                    OK: function () {
                                        location.href = "projek_internal_senarai_task.php";
                                    }
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                            location.href = "projek_internal_senarai_task.php";
                        }


                    });
                });
                $("#catatan").click(function(){
                    location.replace("projek_task_catatan_progres.php?id="+el.dataset.eid+"&jenis_catatan="+jenis_catatan);
                });

                //location.replace("projek_task_tambah.php?id="+el.dataset.eid);
            },
            boards  :[
                {
                    'id' : '_todo',
                    'title'  : 'Tugasan Untuk Pelaksanaan',
                    'class' : 'info',
                    dragTo: ["_working"],
                    'item'  : [
                        <? $data_todo= getTaskByNokp("TODO",$_SESSION['SESS_NOKP']);
                        $curr_count=0;
                        while ($list_todo  = $data_todo -> fetch_assoc()){

                        if($curr_count > 0) echo ",";
                        echo "{";
                        echo "id: '".$list_todo['id_task']."',";
                        echo "title: '<b>Tajuk : ".$list_todo['tajuk']."</b><br><b>Tarikh : </b>".$list_todo['tarikh_start']." - ".$list_todo['tarikh_end']."<br><b>Jangka Masa : </b><font size=\"4\">".$list_todo['jam']." Jam ".$list_todo['minit']." Minit</font><br><b>Ditugaskan Oleh: </b>".$list_todo['oleh']."',";
                        ?>
                        'class' : 'info',
            drop: function(el) {
            var board_id = $(el.parentElement.parentElement).data("id");
            if(board_id=="_working"){
                $.ajax({
                    url: "../model/projek_internal_task_functions.php",
                    type: "POST",
                    data: {action:"updateStatusKtegori",id:el.dataset.eid,id_category:"INPROGRESS"},
                    success: function (response) {
                        //alert(response);
                        location.href = "projek_internal_senarai_task.php";

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        }


        <?
        echo "}";
        $curr_count++;

        }?>

        //data sini

        ]
        },
        {
            'id' : '_working',
            'title'  : 'Dalam Pelaksanaan',
            'class' : 'warning',
            dragTo: ["_todo","_done"],
            'item'  : [

            <? $data_working= getTaskByNokp("INPROGRESS",$_SESSION['SESS_NOKP']);
            $curr_count=0;
            while ($list_working  = $data_working -> fetch_assoc()){

            if($curr_count > 0) echo ",";
            echo "{";
            echo "id: '".$list_working['id_task']."',";
            echo "id: '".$list_working['id_task']."',";
            echo "title: '<b>Tajuk : ".$list_working['tajuk']."</b><br><b>Tarikh : </b>".$list_working['tarikh_start']." - ".$list_working['tarikh_end']."<br><b>Jangka Masa : </b><font size=\"4\">".$list_working['jam']." Jam ".$list_working['minit']." Minit</font><br><b>Ditugaskan Oleh: </b>".$list_working['oleh']."',";
            ?>
            'class' : 'warning',
            drop: function(el) {
            var board_id = $(el.parentElement.parentElement).data("id");
            var category="";
            var updateStatus="";
            if(board_id!="_working"){
                if(board_id=="_done"){
                    category="DONE";
                    updateStatus="updateStatusDone";
                }else{
                    category="TODO";
                    updateStatus="updateStatusKtegori";
                }
                //alert(updateStatus);
                $.ajax({
                    url: "../model/projek_internal_task_functions.php",
                    type: "POST",
                    data: {action:updateStatus,id:el.dataset.eid,id_category:category},
                    success: function (response) {
                        //alert(response);
                        location.href = "projek_internal_senarai_task.php";

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        }


            <?
            echo "}";
            $curr_count++;

            }?>
            //data sini
        ]
        },
        {
            'id' : '_done',
            'dragTo' : ['_working'],
            'title'  : 'Sudah Selesai (Bulan Ini)',
            'class' : 'success',
            dragTo: [""],
            'item'  : [
            <? $data_todo= getTaskByNokp("DONE",$_SESSION['SESS_NOKP']);
            $curr_count=0;
            while ($list_todo  = $data_todo -> fetch_assoc()){

                if($curr_count > 0) echo ",";
                echo "{";
                echo "id: '".$list_todo['id_task']."',";
                echo "id: '".$list_todo['id_task']."',";
                echo "title: '<b>Tajuk : ".$list_todo['tajuk']."</b><br><b>Tarikh : </b>".$list_todo['tarikh_start']." - ".$list_todo['tarikh_end']."<br><b>Jangka Masa : </b><font size=\"4\">".$list_todo['jam']." Jam ".$list_todo['minit']." Minit</font><br><b>Ditugaskan Oleh: </b>".$list_todo['oleh']."',";
                echo "class : 'success',";

                echo "}";
                $curr_count++;

            }?>
            //data sini
        ]
        }
        ]
        });

    </script>

</body>

</html>
