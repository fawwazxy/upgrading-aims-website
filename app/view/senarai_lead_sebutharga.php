<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>
<?

$lead = $_GET['lead'];

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
        $flagScreen="tab_5";
        include ('../global/menu_niaga.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Pelanggan</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Baru</button>

            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pelanggan
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Senarai Pelanggan</h4>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/lead_add_exec.php?act=sh" >
                                        <div class="form-group" align="left">
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />




                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group"  align="left">
                                                <label>Nama Agensi/Syarikat<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="lead_name" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Nama singkatan<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="lead_shrtname" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Alamat Penuh<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " type="text" name="lead_address" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>No Telefon (WhatsApp) <font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="lead_telno" required>
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Email &nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="lead_email"  autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Nama Personel <font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="pic_name" required>
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Jawatan Personel &nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="pic_position" autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Lokasi (longitud,latitud)</label>
                                                <input class="form-control" placeholder="6.4453253253,4.235325323" type="text" name="lokasi">
                                            </div>







                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="reset" class="btn btn-info">Tetapan Semula</button>
                                            </div>

                                    </form>
                                </div><!--modal-body-->
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->

                </div><!-- /.modal -->






                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Agensi/Syarikat</th>
                            <th>No Telefon</th>
                            <th>Nama Personel</th>
                            <th>Jawatan Personel</th>


                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?
                        $i= 1;
                        $data = getLead();
                        while($row_data = $data->fetch_assoc()) {

                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_data['lead_name']; ?></td>
                                <td><?php echo $row_data['lead_telno']; ?></td>
                                <td><?php echo $row_data['pic_name']; ?></td>
                                <td><?php echo $row_data['pic_position']; ?></td>



                                <?php echo "<td><a href='#myModal1' class='btn btn-info btn-small' data-toggle='modal' data-id=".$row_data['id'].">Kemaskini</a><br>"; ?>
                                <a><button class="btn btn-danger" onclick="return popitup('display_map.php?leadid=<? echo $row_data['id'];?>')" >Google Maps</button></a>

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
        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /.row -->
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Pelanggan</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'lead_edit.php',
                            data:'rowid='+rowid,
                            success:function(html){
                                $('#demo').html(html);
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
</script>

</body>

</html>
