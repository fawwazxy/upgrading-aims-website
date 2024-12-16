<?php

include ('../controller/auth.php');

require "../model/dashboard_projek_functions.php";
require "../model/lookup.php";

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
            newwindow=window.open(url,'name','height=800,width=1280');
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

                    <? include ('../../app/global/menu_left.php'); ?>

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

        <div class="form-group" align="right">
        </div>

        <div class="form-group" align="right">
            <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='dashboard_projek_tambah.php'">Tambah Baharu</button>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Projek</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="45%">Maklumat Projek</th>
                                <th width="35%">Tarikh Projek</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $projek = getMainProjekList();
                            $i=1;
                            while($list_projek = $projek->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td bgcolor="#F4D03F" href="#myModal1" data-toggle="modal" data-id="<? echo $list_projek['id_projek'];?>"><b><?echo $i;?></b></td>
                                    <td bgcolor="#F4D03F" href="#myModal1" data-toggle="modal" data-id="<? echo $list_projek['id_projek'];?>">
                                        <label class="control-label">Kod Projek Utama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                        <?if($list_projek['kod_projek_parent']!=''){ echo '<b>'.$list_projek['kod_projek_parent'].'</b>';} else{echo '<b><font color="brown">'.'PROJEK UTAMA'.'</font></b>';}?>
                                        <br><label class="control-label">Kod Projek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                        <?if($list_projek['kod_projek']!=''){ echo '<b>'.$list_projek['kod_projek'].'</b>';}?>
                                        <br><label class="control-label">Nama Projek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                        <?if($list_projek['nama_projek']!=''){ echo $list_projek['nama_projek'];}?>
                                        <br><label class="control-label">Jenis Projek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                        <?if($list_projek['jenis_projek']=='1') { echo 'Projek Dalaman';}
                                        else if($list_projek['jenis_projek']=='2') {echo 'Projek Luar';}
                                        else {echo 'Tender';}?>
                                        <br><label class="control-label">Nama Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                        <?if($list_projek['nama_client']!=''){ echo $list_projek['nama_client'];}?>
                                    </td>
                                    <td bgcolor="#F4D03F">
                                        <label class="control-label">Tarikh Mula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                        <?if($list_projek['tarikh_mula']!=''){ echo date("d-m-Y",strtotime($list_projek['tarikh_mula']));}?>
                                        <br><label class="control-label">Tarikh Tamat&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                        <?if($list_projek['tarikh_tamat']!=''){ echo date("d-m-Y",strtotime($list_projek['tarikh_tamat']));}?>
                                    </td>
                                    <td bgcolor="#F4D03F">
                                        <a href="dashboard_projek_papar.php?id_projek=<?echo $list_projek['id_projek'] ;?>" ><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                        <a href="dashboard_projek_kemaskini.php?id_projek=<?echo $list_projek['id_projek'] ;?>" ><button type="button" class="btn btn-primary">Kemaskini</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_projek['id_projek'];?>">
                                    </td>
                                </tr>
                                <?
                                $sub_projek = getSubProjekList($list_projek['kod_projek']);
                                $j=1;
                                while($list_subprojek = $sub_projek->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td bgcolor="#BFC9CA" href="#myModal1" data-toggle="modal" data-id="<? echo $list_subprojek['id_projek'];?>"><?echo $i.'.'.($j++);?></td>
                                        <td bgcolor="#BFC9CA" href="#myModal1" data-toggle="modal" data-id="<? echo $list_subprojek['id_projek'];?>">
                                            <label class="control-label">Kod Projek Utama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <?if($list_subprojek['kod_projek_parent']!=''){ echo '<b>'.$list_subprojek['kod_projek_parent'].'</b>';} else{echo '<b><font color="brown">'.'PROJEK UTAMA'.'</font></b>';}?>
                                            <br><label class="control-label">Kod Projek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <?if($list_subprojek['kod_projek']!=''){ echo '<b>'.$list_subprojek['kod_projek'].'</b>';}?>
                                            <br><label class="control-label">Nama Projek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <?if($list_subprojek['nama_projek']!=''){ echo $list_subprojek['nama_projek'];}?>
                                            <br><label class="control-label">Jenis Projek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <?if($list_subprojek['jenis_projek']=='1') { echo 'Projek Dalaman';}
                                            else if($list_subprojek['jenis_projek']=='2') {echo 'Projek Luar';}
                                            else {echo 'Tender';}?>
                                            <br><label class="control-label">Nama Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <?if($list_subprojek['nama_client']!=''){ echo $list_subprojek['nama_client'];}?>
                                        </td>
                                        <td bgcolor="#BFC9CA">
                                            <label class="control-label">Tarikh Mula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <?if($list_subprojek['tarikh_mula']!=''){ echo date("d-m-Y",strtotime($list_subprojek['tarikh_mula']));}?>
                                            <br><label class="control-label">Tarikh Tamat&nbsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <?if($list_subprojek['tarikh_tamat']!=''){ echo date("d-m-Y",strtotime($list_subprojek['tarikh_tamat']));}?>
                                        </td>
                                        <td bgcolor="#BFC9CA">
                                            <a href="dashboard_projek_papar.php?id_projek=<?echo $list_subprojek['id_projek'] ;?>" ><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                            <a href="dashboard_projek_kemaskini.php?id_projek=<?echo $list_subprojek['id_projek'] ;?>" ><button type="button" class="btn btn-primary">Kemaskini</button></a>
                                            <input type="hidden" id="row_id" value="<?echo $list_subprojek['id_projek'];?>">
                                        </td>
                                    </tr>
                                <?}?>
                                <?$i++;?>
                            <?}?>
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">Maklumat Projek</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'dashboard_projek_info.php',
                            data:{id_projek:rowid},
                            success:function(html){
                                $('#demo1').html(html);
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

<script>

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    // Delete row on delete button click
    $(document).on("click", ".delete", function(){
        var row_id = $(this).parents("tr").find('input[type="hidden"]');
        var curr_id="";
        row_id.each(function(){
            curr_id = $(this).val();
        });
        //alert("ghggg");
        $.ajax({
            url: "../model/iroombook_functions.php",
            type: "POST",
            data: {action:"deleteRoom", row_id:row_id.val() },
            success: function (response) {
                $(this).parents("tr").remove();
                $(".add-new").removeAttr("disabled");
                // you will get response from your php page (what you echo or print)                 
                //$.alert(response);
                $.confirm({
                    title: 'Info',
                    content: response,
                    buttons: {
                        OK: function () {
                            location.href = "iroombook_senarai_bilik.php";
                        }
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                location.href = "iroombook_senarai_bilik.php";
            }


        });

    });

    function nyahAktifRoom(id,status_bilik){
        $.ajax({
            url: "../model/iroombook_functions.php",
            type: "POST",
            data: {action:"nyahAktifRoom",id:id,status_bilik:status_bilik},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='iroombook_senarai_bilik.php';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>

</body>

</html>