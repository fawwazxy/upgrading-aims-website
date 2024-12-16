<?php

include ('../controller/auth.php');

require "../model/lawatan_functions.php";
require "../model/lookup.php";
require_once("../../util/qrcode.php");

$sys = getSys(1)->fetch_assoc();
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
                <h1 class="page-header">Senarai Kad Pelawat</h1>
                <div class="form-group" align="right">
                </div>

            </div>

        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/lawatan_exec.php">
                    <input type="hidden" name="action" value="kad_cetakan_pilihan" />

                    <div class="panel panel-default">
                        <div class="panel-heading" align="left">
                            <label class="control-label" for="date">Senarai Kad Pelawat</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="7%"><center>Bil.</center></th>
                                    <th width="20%"><center>Kod</center></th>
                                    <th width="20%"><center>Jenis Kad</center></th>
                                    <th width="20%"><center>Nama Kad</center></th>
                                    <th width="30%"><center>Pilih Semua&nbsp;&nbsp;&nbsp;<input type="checkbox" id="select_all"style="width:30px;height:30px;" class="form-control"/></center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $kad_pelawat = getKadPelawatList($status_cetak);
                                $i=1;
                                while($list_kad_pelawat = $kad_pelawat->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo '<b>'.$list_kad_pelawat['kod_kad'].'</b>';?></td>
                                        <td><?echo $list_kad_pelawat['jenis_kad'];?></td>
                                        <td><?echo $list_kad_pelawat['nama_kad'];?></td>
                                        <td><center><input type="checkbox" name="kad_pelawat_kods[]" style="width:30px;height:30px;" class="form-control checkbox" value="<?echo $list_kad_pelawat['id_kad'];?>"/></center></td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group" align="center">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;&nbsp;Cetak Kad Pilihan</button>
                        </div>

                        <!-- /.panel-body -->
                    </div>
                </form>

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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        //select all checkboxes
        $("#select_all").change(function(){  //"select all" change 
            $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkbox').change(function(){
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_all").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length ){
                $("#select_all").prop('checked', true);
            }
        });
    });
</script>

</body>

</html>