<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";
?>
<?$id_speccccs_details = $_GET['id'];?>

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

    </script>

</head>

<body>
<? $id = $_GET['id'];?>

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
        $flagScreen="tab_6";
        include ('../global/menu_spesifikasi.php'); ?>
        <div class="row">
        </div>

        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tambah
                </button>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" align="left" id="myModalLabel">Tambah Gambar</h4>
                        </div>

                        <div class="modal-body">
                            <form method="post" action="../controller/spesifikasi_exec.php?act=spesifikasi_cth_gambar" enctype="multipart/form-data">


                                <input class="form-control" placeholder=" " id="project_name" name="id_specs_details" required autocomplete="" value = "<?echo $id;?>" type = "hidden">


                                <div class="form-group" align="left">
                                    <label>Nama Gambar</label>
                                    <input class="form-control" placeholder=" " id="project_code" name="name" required autocomplete="" >
                                </div>

                                <div class="form-group" align="left">
                                    <label>Gambar</label>

                                    <input type="file" name="image"
                                           onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" class="form-control">
                                    <img id="blah" alt="your image" width="200px" height="200px" >

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button></a>
                                </div>
                            </form>
                        </div><!--modal-body-->

                    </div>
                    <!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Gambar : <b>
                            <?
                            $i=1;
                            $datas = getTajukGambar($id_speccccs_details);
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
                                <th width="20px">#</th>
                                <th width="50px">Nama Gambar</th>
                                <th width="50px">Gambar</th>
                                <th width="50px">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getContohGambar($id_speccccs_details);
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?></td>
                                    <td><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photos'] ).'" style="width: 200px; height: 100px;"/>';?></td>
                                    <td><button class="btn btn-info" data-toggle="modal" data-target="#myModal<?echo $row_data['id'];?>">Kemaskini</button>
                                        <a href="../controller/spesifikasi_exec.php?act=spesifikasi_cth_gambar_delete&id=<?php echo $row_data['id']; ?>&id_speccccs_details=<?echo $id_speccccs_details?>"><button class="btn btn-danger" type="button" onclick="return confirm('Anda pasti untuk padam data ini?');">Padam</button><br></a></td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal<?echo $row_data['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Maklumat</h4>
                                                </div>

                                                <div class="modal-body">
                                                    <form method="post" action="../controller/spesifikasi_exec.php?act=spesifikasi_cth_gambar_update" enctype="multipart/form-data">

                                                        <input type="hidden" class="form-control" placeholder=" " id="id_speccccs_details" name="id_speccccs_details" value="<? echo $id_speccccs_details; ?>"/>
                                                        <input type="hidden" class="form-control" placeholder=" " id="id_cth_gambar" name="id_cth_gambar" value="<?echo $row_data['id'];?>"/>

                                                        <div class="form-group" align="left">
                                                            <label>NAMA GAMBAR</label>
                                                            <input class="form-control" placeholder=" " id="name" name="name" VALUE = "<?php echo $row_data['name']; ?>" required autocomplete="">
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>GAMBAR </label><br>
                                                            <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photos'] ).'" style="width: 400px; height: 300px;"/>';?>
                                                            <br>
                                                            <input type="file" name="image" id="image" placeholder="" value="10000">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button></a>
                                                        </div>
                                                    </form>
                                                </div><!--modal-body-->

                                            </div>
                                            <!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </tr>
                                <?php $i++; } ?>
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    </script>


</body>

</html>
