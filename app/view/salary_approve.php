<?php

include ('../controller/auth.php');

require "../model/staff_function.php";


?>
<?
$id = $_GET['id'];
$no_staff=$_GET['no_staff'];
//$staff_salary_id = $_GET['staff_salary_id'];

updateNotiPelulusSal('1',$no_staff,'SDGDIPROSES');


// $nama = getLoguser($_GET ($_SESSION['SESS_COM'])) -> fetch_assoc();
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
            return confirm('Adakah anda pasti untuk luluskan permohonan? ');
        }

    </script>
    <script type="text/javascript">
        <!--
        function un_check(){
            for (var i = 0; i < document.frmactive.elements.length; i++) {
                var e = document.frmactive.elements[i];
                if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                    e.checked = document.frmactive.allbox.checked;
                }}}
        //-->
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#select_all').on('click',function(){
                if(this.checked){
                    $('.checkbox').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('.checkbox').each(function(){
                        this.checked = false;
                    });
                }
            });

            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#select_all').prop('checked',true);
                }else{
                    $('#select_all').prop('checked',false);
                }
            });
        });
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
            <div class="col-lg-12">

                <?
                $flagScreen="tab_1";
                include ('../global/menu_kelulusan_gaji.php');

                ?>
                <h1 class="page-header">Permohonan Kelulusan Gaji</h1>
            </div>

            <div class="panel-heading" align="right">


            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">





                    <div class="panel-heading">
                        Senarai Maklumat Gaji Pekerja
                    </div>
                    <!-- /.panel-heading -->


                    <input type="checkbox" id="select_all" /> Pilih Semua</li>


                    <? $data=getCheckboxUpdateGaji($id,$no_staff)?>

                    <td><form name="frmactive" method="post" action="">
                            <table width="400" border="0" cellpadding="3" cellspacing="1">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="Lulus" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="Tidak Lulus" /></td>

                                    <div class="panel-body">

                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Nombor Slip</th>
                                                <th>Jawatan</th>
                                                <th>Bahagian</th>
                                                <th>Status</th>
                                                <th>Dihantar Oleh</th>
                                                <th>Diluluskan Oleh</th>
                                                <th>Tarikh Diluluskan</th>
                                                <th>Catatan</th>
                                                <th>Pilih</th>
                                                <th>Tindakan</th>


                                            </tr>
                                            </thead>



                                            <tbody>



                                            <?

                                            $i= 1;
                                            $salary= getSalaryApp();
                                            while($row_salary = $salary->fetch_assoc()) {
                                                ?>

                                                <tr class="odd gradeX">
                                                    <td><?php echo $i; ?></td>
                                                    <td>


                                                        <?php echo $row_salary['nama_pekerja']; ?></a>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modalAkses<?php echo $i; ?>" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        <h4 class="modal-title">Catatan : </h4>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <p>Nama : <?php echo $row_salary['gaji_pokok'];?></p><br>

                                                                        <p>No slip: <?php echo $row_salary['gaji_kasar '];?></p><br>
                                                                        <p>Jawatan: <?php echo $row_salary['nama_jawatan'];?></p><br>
                                                                        <p>Department : <?php echo $row_salary['desc'];?></p><br>


                                                                        </p><br>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Kembali</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!--td><//?php echo $row_salary['nama_pekerja']; ?></td>
                                                    <td><//? echo date('d/m/Y',strtotime($row_salary['tarikh_mula']));?></td>
                                                    <td><//s? echo date('d/m/Y',strtotime($row_salary['tarikh_akhir']));?></td-->

                                                    <td><?php echo $row_salary['no_slip']; ?></td>

                                                    <td><?php echo $row_salary['nama_jawatan']; ?></td>
                                                    <td><?php echo $row_salary['description']; ?></td>



                                                    <td><font color=red><strong><?php echo $row_salary['salary_status'];?></strong></td>
                                                    <td><?php echo $row_salary['requester']; ?></td>
                                                    <td><?php echo $row_salary['approver']; ?></td>
                                                    <td><?php echo $row_salary['tarikh_diluluskan']; ?></td>
                                                    <td><?php echo $row_salary['catatan']; ?></td>



                                                    <td align="center"><input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $row_salary['id']; ?>" ></td>



                                                    <td>
                                                        <?
                                                        if ($row_salary['jenis_kelulusan'] == 'SDGDIPROSES') { ?>

                                                            <a href="lulus_gaji.php?staff_salary_id=<? echo $row_salary['id'];?>"><button class="btn btn-info" type="button" >Luluskan</button></a>



                                                            <?
                                                        }

                                                        ?>

                                                    </td>


                                                </tr>


                                                <?php $i++; } ?>

                                            </tbody>

                                        </table><center>
                                            <!-- Button trigger modal -->



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
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<script language="JavaScript" type="text/javascript">
    function checkDelete(){
        return confirm('Adakah anda pasti untuk padam Peranan ini?');
    }


</script>

</body>

</html>
