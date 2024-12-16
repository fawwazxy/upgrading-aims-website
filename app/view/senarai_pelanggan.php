<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

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
        include ('../global/menu_pelanggan.php');
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
                        Maklumat Pelanggan
                    </div>
                    <!-- Modal1 -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Senarai Pelanggan</h4>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/pelanggan_add_exec.php?act=pelanggan" >
                                        <div class="form-group" align="left">

                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group"  align="left">
                                                <label>Nama<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="lead_name" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Nama Singkatan<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="lead_shrtname" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Alamat<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " type="text" name="lead_address" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>No Pejabat</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="lead_telno"  autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Emel</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="lead_email"  autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Nama PIC<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="pic_name" autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Jawatan PIC</label>
                                                <input class="form-control" placeholder=" "  name="pic_position" required autocomplete="">
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Negeri</label>
                                                <select required class="form-control" name="negeri" value="">
                                                    <option value="">-- Pilih --</option>
                                                    <? $negeri= getNegeri();
                                                    while ($list  = $negeri -> fetch_assoc()){ ?>
                                                        <option value="<? echo $list['id'];?>"><? echo $list['name'];?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Daerah</label>
                                                <input class="form-control" placeholder=" "  name="daerah" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Koordinat GPS (longitud,latitud)</label>
                                                <input class="form-control" placeholder=" "  name="lokasi" required autocomplete="">
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Segmen</label>
                                                <select required class="form-control" name="segmen" value="">
                                                    <option value="">-- Pilih --</option>
                                                    <? $segmen= getSegmen();
                                                    while ($list  = $segmen -> fetch_assoc()){ ?>
                                                        <option value="<? echo $list['id'];?>"><? echo $list['name'];?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Status</label>
                                                <select required class="form-control" name="status" value="">
                                                    <option value="0">-- Pilih --</option>
                                                    <option value=0>LEAD</option>
                                                    <option value=1>PROSPECT</option>
                                                    <option value=2>CLIENT</option>
                                                </select>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Data Dimasukkan Oleh</label>
                                                <select required class="form-control" name="created_by">
                                                    <option value="<? echo $_SESSION['SESS_NO_STAFF']; ?>"><? echo $_SESSION['SESS_NO_STAFF']; ?>:<? echo $_SESSION['SESS_NAME'];?></option>
                                                    <option value="">-- Pilih --</option>
                                                    <? $created= getCreated();
                                                    while ($list  = $created -> fetch_assoc()){ ?>
                                                        <option value="<? echo $list['created_by'];?>"><? echo $list['created_by'];?>:<? echo $list['created_name'];?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
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
                            <th>Keterangan </th>
                            <th>Pegawai Dihubungi</th>
                            <th>Negeri & Daerah</th>
                            <th>Segmen & Status</th>
                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?
                        $i= 1;
                        $data = getLead();
                        while($row_data = $data->fetch_assoc()) {

                            $telno = $row_data['lead_telno'];
                            $status = $row_data['status'];
                            $leadid = $row_data['id'];

                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i; ?></td>
                                <td>
                                    <b><?php echo $row_data['lead_shrtname']; ?></b><br>
                                    <?php echo $row_data['lead_name']; ?>
                                </td>
                                <td>
                                    <b><?php echo $row_data['pic_name']; ?></b><br>
                                    <?php echo $row_data['pic_position']; ?><br>
                                    <?php echo $row_data['lead_telno']; ?><br>
                                    <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $telno; ?>&text=Assalamualaikum w.b.t. Tuan/Puan, [Masukkan mesej di sini]. Sekian, terima kasih dari kami; INDEEPRENEUR.COM.')" >WhatsApp</button>
                                </td>
                                <td>
                                    <b><?php echo $row_data['negeri']; ?></b><br>
                                    <?php echo $row_data['daerah']; ?><br>
                                    Koordinat: <?php echo $row_data['lokasi']; ?><br>
                                    <button class="btn btn-danger" onclick="return popitup('display_map.php?leadid=<?php echo $leadid; ?>')" >Google Maps</button>
                                </td>
                                <td>
                                    <b><?php echo $row_data['segmen']; ?></b><br>
                                    <?php
                                    if ($status == 0) {
                                        echo "<b>LEAD</b>";
                                    }
                                    if ($status == 1) {
                                        echo "<b>PROSPECT</b>";
                                    }
                                    if ($status == 2) {
                                        echo "<b>CLIENT</b>";
                                    }

                                    ?>
                                </td>

                                <?php echo "<td><a href='#myModal1' class='btn btn-info btn-small' data-toggle='modal' data-id=".$row_data['id'].">Kemaskini</a></td>"; ?>

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
                            url:'pelanggan_edit.php',
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
