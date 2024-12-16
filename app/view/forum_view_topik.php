<?php

include ('../controller/auth.php');

require "../model/chat_function.php";

?>

<?
$category_id = $_GET['id'];
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
            <?
            $i= 1;
            $data = getCountCategory($category_id);
            while($row_data = $data->fetch_assoc()) {
                ?>
                <h1>Kategori : <?php echo $row_data['category_name'] ?></h1>
            <?}?>

            <div class="panel-heading" align="right">
                <a href="forum1.php?id=<?echo $category_id?>" > <button type="button" class="btn btn-primary">Tambah Baru</button></a>
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Topik Mengikut Kategori
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                            <thead>
                            <tr>
                                <th width="20px">#</th>
                                <th >Topik</th>
                                <th >Department</th>
                                <th >Penerima</th>
                                <th>Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data = getForumCategory($category_id);
                            while($row_data = $data->fetch_assoc()) {
                                ?>


                                <tr>


                                    <td><?php echo $i; ?></td>

                                    <td>
                                        <?php echo $row_data['topik']?> </br><h6> Oleh :  <?php echo $row_data['username'];?></h6>
                                    </td>

                                    <td>
                                        <? if($row_data['department_id']== ''){
                                            echo "Tiada Department";

                                        } else if ($row_data['department_id'] ==! ''){
                                            echo $row_data['department_id'];

                                        }?><!--
                                        <?php echo $row_data['department']?> -->
                                    </td>

                                    <td>
                                        <? if($row_data['user_name']== ''){
                                            echo "Tiada Penerima";
                                        } else if ($row_data['user_name'] ==! ''){
                                            echo $row_data['user_name'];
                                        }?>
                                        <!--   <?php echo $row_data['user_name']?> -->
                                    </td>

                                    <td>
                                        <a href="topik_view.php?id=<? echo $row_data['forum_id']; ?>"> <!-- <input type="button" value="Lihat " id="countButton" /> -->
                                            <!--   <p>The button was pressed <span id="displayCount">0</span> times.</p> -->
                                            <button onclick="clickCounter()" class="btn btn-info" type="button">Lihat Topik</button>
                                            <div id="result"></div>
                                        </a>
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
</script>
<!--     <script>
function clickCounter() {
    if(typeof(Storage) !== "undefined") {
        if (localStorage.clickcount) {
            localStorage.clickcount = Number(localStorage.clickcount)+1;
        } else {
            localStorage.clickcount = 1;
        }
        document.getElementById("result").innerHTML = "You have clicked the button " + localStorage.clickcount + " time(s).";
    } else {
        document.getElementById("result").innerHTML = "Sorry, your browser does not support web storage...";
    }
}
</script> -->
<!-- 
     <script type="text/javascript">
      var count = 0;
      var button = document.getElementById("countButton");
      var display = document.getElementById("displayCount");

      button.onclick = function(){
        count++;
        display.innerHTML = count;
      }
    </script> -->

</body>

</html>
