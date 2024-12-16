<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
$no_staff = $_GET['no_staff'];

$no_staff_login = $_GET['SESS_NO_STAFF'];
$id = $_GET['id'];
$nama_projek = $_GET['nama_projek'];


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

    <style>
        .A{
            width:10px;
        }



    </style>
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
            $flagScreen="tab_8";
            include ('../global/menu_support_hr.php');
            ?>
            <?
            $flagScreen="tab_1";
            include ('../global/menu_support.php');
            ?>


            <!-- <p><b>Sistem</b>:</?php echo $data['projek_nama']; ?></p> -->
            <div class="col-lg-12">

            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">




            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Aduan
                    </div>








                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Rujukan</th>
                                <th>Nama Projek</th>
                                <!-- <th>Aduan</th> -->
                                <th>Nama-Notel</th>
                                <th>Tindakan Oleh</th>
                                <th>Tahap Keutamaan</th>
                                <th>Tarikh Terima</th>
                                <th>Masa Untuk Siap</th>
                                <th>Status Tindakan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getSupport($nama_projek);
                            while($row_data = $data->fetch_assoc()) {



                                ?>



                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_support']; ?></td>
                                    <td><?php echo $row_data['nama']; ?><br><?php //echo $row_data['agensi_rujukan']; ?></td>

                                    <td><?php echo $row_data['nama_client']; ?><br><?php echo $row_data['notel']; ?></td>
                                    <td>
                                        <!--    <form method="post" action="../controller/add_developer_exec2.php?id=<?php echo $row_data['id']; ?>&nama_projek=<?php echo $id_nama_projek; ?>" >

                        <select required class="form-control"  name="developer" id="developer" value=" <? echo $row_data['namadev']; ?>">

                      <option value="">-- Pilih --</option>
                    <? $person= getNamaDeveloper($department_id);
                                        while ($pilih  = $person -> fetch_assoc()){ ?>
                   <option value="<? echo $pilih['no_staff'];?>"  <? echo ($pilih['no_staff']==$row_data['developer']?'selected':'');?>>   <? echo $pilih['name']?></option>

                          <?
                                        }
                                        ?>
                          </select>

                     <br><br>

                  <button type="submit" class="btn btn-primary">Simpan</button></a> 
                </form> -->
                                        <?php echo $row_data['namadev']; ?>
                                    </td>

                                    <td>
                                        <!--  <form method="post" action="../controller/level_exec.php?id=<?php echo $row_data['id']; ?>&nama_projek=<?php echo $nama_projek; ?>" >

                     <select required class="form-control"  name="level_aduan" id="level_aduan"   value=" <? echo $row_data['level_aduan'];?>">

                      <option value="">-- Pilih --</option>
                    <? $level= getLevel();
                                        while ($listdata  = $level -> fetch_assoc()){ ?>
                   <option value="<? echo $listdata['level'];?>"  <? echo ($listdata['level']==$row_data['level_aduan']?'selected':'');?>>   <? echo $listdata['level']?>-<? echo $listdata['keterangan']?></option>

                          <?
                                        }
                                        ?>
                          </select>

                     <br><br>

                  <button type="submit" class="btn btn-primary">Simpan</button></a> 
                </form>
 -->
                                        <?php echo $row_data['level_aduan']; ?>





                                    </td>
                                    <td><?php echo $row_data['created_date']; ?></td>
                                    <td><?php echo $row_data['tarikh_mula']; ?> <br> HINGGA <br> <?php echo $row_data['tarikh_tamat']; ?></td>


                                    <td>
                                        <?php
                                        $status_tindakan = $row_data['status_tindakan'];
                                        if ($status_tindakan == 'BH' ) {
                                            echo "<font color=red><strong>BELUM HANTAR</strong></font>";
                                            ?>

                                            <a href="../controller/support_hantar_exec.php?no_staff=<? echo $row_data['no_staff'];?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>&id=<? echo $row_data['id'];?>nama_projek=<?php echo $row_data['nama_projek']; ?>"> <button class="btn btn-warning" onclick="return Confirm()">Hantar</button></a>
                                            <?
                                        }

                                        else if ($status_tindakan == 'ST' ) {
                                            echo "<font color=blue><strong>SEMAKAN TERAKHIR</strong></font><br>";}
                                        else if ($status_tindakan == 'S' ) {
                                            echo "<font color=blue><strong>SELESAI</strong></font><br>";}
                                        else if ($status_tindakan == 'DP' ) {
                                            echo "<font color=blue><strong>DALAM PENERIMAAN</strong></font><br>";}
                                        else if ($status_tindakan == 'T' ) {
                                            echo "<font color=blue><strong>DALAM PROSES</strong></font><br>";}
                                        ?>
                                    </td>

                                    <td>
                                        <a href="hr_support_update.php?id=<? echo $row_data['id'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>
                                        <br>

                                        <button class="btn btn-info" type="button" data-id="<? echo $row_data['id']; ?>" data-toggle="modal" data-target="#myModal1" >Papar Aduan</button></a><br>



                                        <?php  if ($status_tindakan == 'BH' ) {

                                        } else{
                                            ?>
                                            <a href="papar_progress.php?id=<? echo $row_data['id_support'];?>" target="_blank"><button class="btn btn-info" type="button" >Papar Progress</button></a>

                                        <?}?>
                                    </td>


                                    <!--  modal -->
                                    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel">Aduan</h4>
                                                </div>
                                                <div class="modal-body" id="demo">
                                                    <script type="text/javascript">
                                                        $('#myModal1').on('show.bs.modal', function (e) {
                                                            var rowid = $(e.relatedTarget).data('id');
                                                            // $('#demo').html(rowid);
                                                            $.ajax({
                                                                type:'GET',
                                                                url:'view_aduan.php',
                                                                data:'id='+rowid,
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
                                    <!-- tutup modal -->


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

<script>
    $('.Contact').click(function(){
        var id=$('.Contact').val();
        $.ajax({url:"ModalPage.php?id="+id,cache:false,success:function(result){
                $(".modal-content").html(result);
            }});
    });
</script>

<script type="text/javascript">

    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type : 'post',
                url : 'fetch_record.php', //Here you will fetch records
                data :  'rowid='+ rowid, //Pass $id
                success : function(data){
                    $('.fetched-data').html(data);//Show fetched data from database
                }
            });
        });
    });
</script>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</script>

</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

</body>

</html>
