<?php

include ('../controller/auth.php');


require "../model/lead_produk_function.php";

$id=$_GET['id'];

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

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Kemaskini Produk</h1>
                    </div>
                </div>





                <div class="panel-heading" align="right">
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->

            <div class="row">


                <div class="col-lg-12">



                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form id="myform" method="post"  action="../controller/produk_exec.php?act=produk_edit" name="myform"  enctype="multipart/form-data" >

                                        <?

                                        $produk = getProdukInfo($id)->fetch_assoc();

                                        ?>

                                        <input name="id" type="hidden" class="input-short" value="<?  echo $_GET['id'];?>" />

                                        <div class="form-group" align="left">
                                            <label>Kod Produk</label>
                                            <input class="form-control" placeholder=" " id="code" name="code" value="<?echo $produk['code']?>" required autocomplete="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Produk</label>
                                            <input class="form-control" placeholder=" " id="produk" name="produk" value="<?echo $produk['produk']?>" required autocomplete="">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Penerangan</label>
                                            <textarea class="form-control" placeholder=" " id="penerangan" name="penerangan" value="" required autocomplete=""><?echo $produk['penerangan']?></textarea>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Segmen</label>
                                            </br>
                                            <?
                                            $result = getSegmen();
                                            while($listN = mysqli_fetch_assoc($result)){?>
                                                <br>
                                                <input type = "checkbox" name = "segmen[]" value = "<?php echo "\'".$listN["id"]."\'" ?>"
                                                    <? if(strpos($produk['segmen'],$listN['id'])){
                                                        echo "checked";}?>
                                                >&nbsp;<?php echo $listN["code"];?> : <?php echo $listN["name"];?>

                                            <?}?>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-info">Simpan</button>
                                            <a href="../view/produk.php"><input class="btn btn-success" type="button" value="Kembali"></a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
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

