<?php

include ('../controller/auth.php');

require "../model/chat_function.php";

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
        <?
        $flagScreen="tab_5";
        include ('../global/menu_forum.php');

        ?>
        </br>
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group" align="center">

                    <form action="../controller/search_exec.php" method="POST">
                        <h3>Carian**</h3>
                        <table>
                            <tr>
                                <td><input class="form-control" type="text" placeholder="cari" id="name" name="name"" ></td>
                                <td><input class="btn btn-info" type="submit" name="submit" value="Cari"></td>
                            </tr>
                        </table>
                        <h6>** masukkan kata kunci carian anda</h6>
                    </form>
                </div>

            </div>
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
</script>
</body>

</html>
