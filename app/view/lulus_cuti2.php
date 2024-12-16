<?php

include ('../controller/auth.php');


require "../model/cuti_function.php";

?>
<?php
$id = $_GET['id'];
$staff_holiday_id = $_GET['staff_holiday_id'];
$staff_record_id = $_GET['staff_record_id'];

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


    <title><? echo $list_sys['sys_name'];?>::<? echo $list_sys['sys_tagline'];?></title>




    <script>
        function Confirm(){
            return confirm('Anda pasti untuk teruskan?');
        }
        function goBack()
        {
            window.history.back()
        }
    </script>
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

                <h1 class="page-header">Maklumat Permohonan Cuti</h1>
                <!-- /.col-lg-12 -->
                <!-- /.row -->

                <div class="row">
                    <div class="panel-heading" align="right">
                        <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                    </div>
                    <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label class="control-label" for="date">Maklumat Permohonan Cuti</label>
                            </div>


                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-8">


                                        <?

                                        $id = $_GET['id'];
                                        $row_pemohon= getMaklumatPemohonCuti($staff_holiday_id,$staff_record_id)->fetch_assoc();

                                        ?>

                                        <form method="post" action="../controller/status_cuti_exec1.php">
                                            <div class="form-group" align="left">
                                                <input name="staff_holiday_id" type="hidden" class="input-short" value="<? echo $staff_holiday_id;?>" />
                                                <input name="total_cuti" type="hidden" class="input-short" value="<? echo $row_pemohon['total_cuti'];?>" />
                                                <input name="baki_cuti" id="baki_cuti" type="hidden" class="input-short" value="<? echo $row_pemohon['baki_cuti'];?>" />
                                                <input name="baki_cuti_pohon" type="hidden" class="input-short" value="<? echo $row_pemohon['baki_cuti_pohon'];?>" />
                                                <input name="jumlah_cuti" id="jumlah_cuti" type="hidden" class="input-short" value="<? echo $row_pemohon['total_lv_req'];?>" />
                                                <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $row_pemohon['staff_record_id'];?>" />
                                                <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                                                <input name="jenis_cuti" type="hidden" class="input-short" value="<? echo $row_pemohon['jenis_cuti'];?>" />

                                                <table width="100%">
                                                    <tr>
                                                        <th width="22%"></th>
                                                        <th width="3%"></th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Nama Staf</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo $row_pemohon['name'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>No. Kad Pengenalan</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo $row_pemohon['noic'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>No. Telefon</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo $row_pemohon['telepon'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Jawatan</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo $row_pemohon['role'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Bahagian</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo $row_pemohon['department_name'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Jenis Cuti</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo $row_pemohon['type_leave'];?></td>
                                                    </tr>

                                                    <tr>
                                                        <td><label>Tarikh Mula</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo date('d/m/Y',strtotime($row_pemohon['date_lv_from']));?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Tarikh Akhir</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo date('d/m/Y',strtotime($row_pemohon['date_lv_to']));?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Sebab/Alasan</label></td>
                                                        <td><label>:</label></td>
                                                        <td><? echo $row_pemohon['reason_leave'];?></td>
                                                    </tr>


                                                </table>
                                                <br>
                                                <label>Lampiran</label><br>
                                                <?
                                                if($row_pemohon['document_type'] == 'jpg' || $row_pemohon['document_type'] == 'jpeg' || $row_pemohon['document_type'] == 'png' || $row_pemohon['document_type'] == 'gif') {
                                                    echo '<img width="300" height="250" src="data:image/jpeg;base64,'.base64_encode( $row_pemohon['document'] ).'"/><br>';}
                                                else if($row_pemohon['document_type'] == 'pdf') {
                                                    echo '<object width="300" height="250" data="data:application/pdf;base64,'.base64_encode( $row_pemohon['document'] ).'"/><br>'.'" type="application/pdf"></object>';}
                                                ?>
                                                <br>
                                                <?if($row_pemohon['document'] != '') {?>
                                                <a href="#myModal1" data-toggle="modal" data-id="<? echo $row_pemohon['sh_id'];?>"><button class="btn btn-info" type="button">Papar Lampiran</button></a><?}?>
                                                <br><br>
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th bgcolor="#D6DBDF" width="25%">Jumlah Cuti Keseluruhan</th>
                                                        <th bgcolor="#D6DBDF" width="25%">Baki Cuti Semasa&nbsp;&nbsp;&nbsp;</th>
                                                        <th bgcolor="#D6DBDF" width="25%">Baki Cuti Permohonan</th>
                                                        <th bgcolor="#D6DBDF" width="25%">Jumlah Cuti Dipohon</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td> <? echo $row_pemohon['total_cuti'];?></td>
                                                        <td><? echo $row_pemohon['baki_cuti'];?></td>
                                                        <td><? echo $row_pemohon['baki_cuti_pohon'];?></td>
                                                        <td><? echo $row_pemohon['total_lv_req'];?></td>

                                                    </tr>
                                                </table>


                                                <label>Tindakan</label><br>

                                                <input name="approvement" id="approvement" type="radio"  value="APPROVE" required/> Approve <br>
                                                <input name="approvement" id="approvement" type="radio"  value="DISAPPROVE" > Disapprove

                                                <br><br>

                                                <label>Remark</label><br>
                                                <textarea id="remark" name="remark" rows="4" cols="50"></textarea>

                                                <br><br>

                                                <label>Diluluskan Oleh</label><br>
                                                <? echo $_SESSION['SESS_NAME'] ?>
                                                <br><br>


                                                <div align="right">
                                                    <button type="submit" class="btn btn-success" onclick="return Confirm()" >Hantar</button>
                                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                    <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                                                </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->

                    <!-- /.row -->
                </div>
                <!-- /#page-wrapper -->
            </div>
        </div>
        <!-- /#wrapper -->
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div> -->
        <div class="modal-body" id="demo1">
            <script type="text/javascript">
                $('#myModal1').on('show.bs.modal', function (e) {
                    var rowid = $(e.relatedTarget).data('id');
                    // $('#demo').html(rowid);
                    $.ajax({
                        type:'POST',
                        url:'lampiran_papar.php',
                        data:{id:rowid},
                        success:function(html){
                            $('#demo1').html(html);
                        }
                    });
                });
            </script>
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
