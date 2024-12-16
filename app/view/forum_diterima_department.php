<?php

include ('../controller/auth.php');

require "../model/chat_function.php";

?>
<?
$no_staff=$_GET['no_staff'];

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
        <?
        $flagScreen="tab_2";
        include ('../global/menu_forum.php');

        $flagScreen="tab_2";
        include ('../global/menu_jenis_forum.php');

        ?>
        </br>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Topik
                    </div>
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                            <thead>
                            <tr>
                                <th width="20px">#</th>
                                <th>Topik</th>
                                <th>Unit/Jabatan</th>
                                <!-- <th>Status</th> -->
                                <th>Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data = getForumView1($no_staff);
                            while($row_data = $data->fetch_assoc()) {


                                ?>


                                <tr>


                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php echo $row_data['topik']?>
                                        <h6></br> Oleh : <?php echo $row_data['username'];?>
                                            </br>Kategori : <?php echo $row_data['category_name'];?></h6>
                                    </td>
                                    <td>
                                        <? if($row_data['department_id']== ''){
                                            echo "Tiada Department";

                                        } else if ($row_data['department_id'] ==! ''){
                                            echo $row_data['department_id'];

                                        }?>
                                        <!-- <?php echo  $row_data['department_id'] ?> -->

                                    </td>

                                    <!-- <? if($row_data['status']== '0'){
                                        echo "Belum Dijawab";

                                    } else if ($row_data['status'] == '1'){
                                        echo "Sudah Dijawab";
                                    }?>   -->

                                    <td>
                                        <a href="topik_view.php?id=<? echo $row_data['forum_id']; ?>"> <button class="btn btn-info" type="button" >Lihat Topik</button></a>
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
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</div>



<!-- /#wrapper -->


<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>
