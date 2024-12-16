<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";
?>

<?

$id=$_GET['id'];
$urlcontroller='';
$name_fasa='';
if ($id>0){

    //update
    $urlcontroller="../controller/spesifikasi_exec.php?act=spesifikasi_detail_update";
    $data=getNamaSpesifikasiById($id)->fetch_assoc();
    $name_fasa=$data['name'];
}
else{
    //add new
    $urlcontroller="../controller/spesifikasi_exec.php?act=spesifikasi_detail";
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



        <?
        $flagScreen="tab_1";
        include ('../global/menu_spesifikasi.php');
        ?>

        <div class="row">
            <div class="panel-heading" align="right">

                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                </button>
            </div>




            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Spesifikasi                       </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">





                        <table>
                            <form method="post" action="<? echo $urlcontroller; ?>">


                                <input class="form-control"  type="hidden" name="id" value="<? echo $id; ?>" />

                                <div class="form-group" style="width: 400px;">
                                    <label >Nama Spesifikasi</label>
                                    <input class="form-control" rows="5" name="name" id="name" value="<? echo $name_fasa; ?>" />
                                </div>

                                <div class="modal-footer" style="width: 400px;">
                                    <button type="submit" class="btn btn-primary">Simpan</button></a>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                </div>
                            </form>

                        </table>             </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

            </div>
        </div>

        <? include ('../global/footer.php'); ?>
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
