<?php

include ('../controller/auth.php');

require "../model/support_function.php";

$flagScreen = $_GET['flagScreen'];
if($flagScreen == 'tab_1'){
    $page="list_support_belum_disahkan.php";
}else if($flagScreen == 'tab_2'){
    $page="list_support_dalam_penerimaan.php";
}else if($flagScreen == 'tab_3'){
    $page="list_support_dalam_proses.php";
}else if($flagScreen == 'tab_4'){
    $page="list_support_semakan_terakhir.php";
}else if($flagScreen == 'tab_5'){
    $page="list_support_selesai.php";
}else if($flagScreen == 'tab_6'){
    $page="list_support_batal.php";
}else if($flagScreen == 'tab_8'){
    $page="support_list.php";
}


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
                <h1 class="page-header">Tidak Terima Aduan</h1>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="panel-heading" align="right">
                    <a href="<? echo $page;?>"><button type="button" class="btn btn-success">Kembali</button></a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Aduan Tidak Diterima
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <th>Bil.</th>
                            <th>Sistem</th>
                            <th>Huraian</th>
                            <th>Developer</th>
                            <th>Jum. Tolak</th>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getListRejected('');
                            while($row_data = $data->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['kod_projek'].' - '.$row_data['nama_projek']; ?></td>
                                    <td><?php echo $row_data['aduan']; ?></td>
                                    <td>
                                        <?php $developer = getListSupportDeveloper($row_data['id_support']);
                                        $z=1;
                                        while ($list_developer = $developer->fetch_assoc()) {
                                            echo $z.')&nbsp;&nbsp;'.$list_developer['name'].'&nbsp;&nbsp;('.$list_developer['nom'].' kali)<br>';
                                            $z++;}?>

                                    </td>
                                    <td><font color="red" size="10px"><center><b><?php echo $row_data['bil'];?></b></center></font></td>
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
