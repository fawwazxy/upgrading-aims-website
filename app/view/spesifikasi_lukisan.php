<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";

$id_specs_details= $_GET['id'];

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
            return confirm('Adakah Anda Pasti untuk simpan data ini?');
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
            <div class="col-sm-12">
                <?
                $flagScreen="tab_2";
                include ('../global/menu_spesifikasi.php');
                ?>
            </div>
        </div>
        <div class="row">
        </div>
        <div class="panel-heading" align="right">
            <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Lukisan : <b>
                            <?
                            $i=1;
                            $datas = getTajukGambar($id_specs_details);
                            while($row_datas = $datas->fetch_assoc()){
                                echo $row_datas['nama_spec'];
                            }
                            $i++;
                            ?>
                        </b>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="35%">Jenis Lukisan</th>
                                <th width="35%">Lukisan</th>
                                <th width="20%">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=spesifikasi_lukisan" >
                                    <input name="id_specs_details" id="id_specs_details" type="hidden" value="<?php echo $id_specs_details;?>" class="form-control" required />
                                    <td>-</td>
                                    <td align="center"><input name="nama" id="nama" type="text" value="" class="form-control" required /></td>
                                    <td><img id="image" alt="your image" width="100" height="100" />
                                        <input type="file" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" name="image" id="image" placeholder="" value="10000"></a>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary" onclick="return Confirm()">Simpan</button>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                    </td>

                                </form>
                            </tr>

                            <?
                            $i= 1;
                            $data = getDrawingList($id_specs_details);
                            while($row_data = $data->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_data['name']; ?></a></td>
                                <td align="center">
                                    <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photos'] ).'" style="width: 210px; height: 240px;"/>';?>

                                <td>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row_data['id']; ?>">Kemaskini</button>
                                    <a href="../controller/spesifikasi_exec.php?act=spesifikasi_lukisan_delete&id=<?php echo $row_data['id']; ?>&id_specs_details=<?php echo $id_specs_details;?>"><button class="btn btn-danger" type="button" onclick="return confirm('Anda pasti untuk padam data ini?');">Padam</button><br></a>

                                </td>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal<?php echo $row_data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Lukisan</h4>
                                            </div>

                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=spesifikasi_lukisan_update" >

                                                    <input type="hidden" class="form-control" id="id_specs_details" name="id_specs_details" value="<?php echo $id_specs_details; ?>"/>
                                                    <input type="hidden" class="form-control" id="id_lukisan" name="id_lukisan" value="<?php echo $row_data['id']; ?>"/>

                                                    <div class="form-group" align="left">
                                                        <label>Jenis Lukisan</label>
                                                        <input class="form-control" id="nama" name="nama" value="<?php echo $row_data['name']; ?>" required autocomplete="" >
                                                    </div>

                                                    <div class="form-group" align="left">
                                                        <label>Gambar Lukisan</label><br>
                                                        <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photos'] ).'" style="width: 210px; height: 240px;"/>';?>
                                                        <input type="file" name="image" id="image" placeholder="" value="10000">
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button></a>
                                                    </div>
                                                </form>
                                            </div><!--modal-body-->
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <?$i++;}?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
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