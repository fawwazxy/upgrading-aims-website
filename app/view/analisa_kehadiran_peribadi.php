<?php
include ('../controller/auth.php');
require "../model/analisa_kehadiran_functions.php";
require "../model/lookup.php";

$name = $_SESSION['SESS_NAME'];
$nokp = $_SESSION['SESS_NOKP'];
$no_staff = $_SESSION['SESS_NO_STAFF'];
$staff_details = getStaffDetailsByNokp($nokp)->fetch_assoc();
$sys = getSys(1)->fetch_assoc();
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
                <h1 class="page-header">Personal Attendance Analysis</h1>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Name:</label>&nbsp;<?echo $name;?><br>
                        <label>IC Number:</label>&nbsp;<?echo $nokp;?><br>
                        <label>Staff No:</label>&nbsp;<?echo $no_staff;?><br>
                        <label>Role:</label>&nbsp;<?echo $staff_details['role'];?><br>
                        <label>Company:</label>&nbsp;<?echo '<b>'.$staff_details['code_department'].'</b>'.'&nbsp;-&nbsp'.$staff_details['description'];?><br>
                        <label>Location:</label>&nbsp;<?echo '<b>'.$staff_details['cawangan_kod'].'</b>'.'&nbsp;-&nbsp'.$staff_details['nama'];?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <br><div class="panel panel-red">

                            <div class="panel-heading" align="center">
                                <label class="control-label" for="date">Personal Attendance Analysis</label>
                            </div>
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th bgcolor="#D6DBDF" width="17%"><center>Total Working Days</center></th>
                                    <th bgcolor="#D6DBDF" width="17%"><center>Total of Attendance</center></th>
                                    <th bgcolor="#D6DBDF" width="17%"><center>Early</center></th>
                                    <th bgcolor="#D6DBDF" width="17%"><center>Punctual</center></th>
                                    <th bgcolor="#D6DBDF" width="17%"><center>Late</center></th>
                                    <th bgcolor="#D6DBDF" width="17%"><center>Attendance Percentage</center></th>
                                </tr>
                                </thead>
                                <?
                                $jumlah_hari_bekerja = getAnalisaJumlahHariBekerja($nokp,$staff_details['no_staff']);
                                $jumlah_kehadiran = getAnalisaJumlahKehadiran($nokp);
                                $kehadiran_awal = getAnalisaKehadiranAwal($nokp);
                                $kehadiran_tepat = getAnalisaKehadiranTepat($nokp);
                                $kehadiran_lewat = getAnalisaKehadiranLewat($nokp);

                                if($jumlah_hari_bekerja != 0 ) {
                                    $peratusan_kehadiran = $jumlah_kehadiran/$jumlah_hari_bekerja * 100;
                                }
                                else {
                                    $peratusan_kehadiran = 0.00;
                                }
                                ?>
                                <tbody>
                                <tr>
                                    <td align="center" rowspan="3" bgcolor="#FDFEFE">
                                        <h2><strong><font color="black"><?echo $jumlah_hari_bekerja;?></font></strong></h2>
                                    </td>

                                    <td align="center" rowspan="3" bgcolor="#FDFEFE" onclick="getAnalisaKehadiranAllDetails()">
                                        <h2><strong><font color="blue"><?echo $jumlah_kehadiran;?></font></strong></h2>
                                    </td>

                                    <td align="center" rowspan="3"  bgcolor="#FDFEFE" onclick="getAnalisaKehadiranDetails('AWAL')">
                                        <h2><strong><font color="green"><?echo $kehadiran_awal;?></font></strong></h2>
                                    </td>

                                    <td align="center" rowspan="3"  bgcolor="#FDFEFE" onclick="getAnalisaKehadiranDetails('TEPAT')">
                                        <h2><strong><font color="purple"><?echo $kehadiran_tepat;?></font></strong></h2>
                                    </td>

                                    <td align="center" rowspan="3"  bgcolor="#FDFEFE" onclick="getAnalisaKehadiranDetails('LEWAT')">
                                        <h2><strong><font color="red"><?echo $kehadiran_lewat;?></font></strong></h2>
                                    </td>

                                    <td align="center" rowspan="3" bgcolor="#FDFEFE">
                                        <h2><strong><font color="brown"><?echo round($peratusan_kehadiran,2);?>%</font></strong></h2>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <?if(isset($nokp))
                        {
                            ?>
                            <div id="kehadiran_details_all">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <label class="control-label" for="date">Personal Attendance Information <?if($status_kehadiran=='AWAL'){echo '<strong><font color="green">'.'EARLY'.'</font></strong>';}else if($status_kehadiran=='TEPAT'){echo '<strong><font color="purple">'.'PUNCTUAL'.'</font></strong>';}else if($status_kehadiran == 'LEWAT'){echo '<strong><font color="red">'.'LATE'.'</font></strong>';} else{echo '<strong><font color="blue">'.'OVERALL'.'</font></strong>';}?></label>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                            <tr>
                                                <th width="7%">No</th>
                                                <th width="10%">Day</th>
                                                <th width="15%">Date & Time</th>
                                                <th width="15%">Platform</th>
                                                <th width="15%">Location</th>
                                                <th width="15%">Status</th>
                                                <th width="15%">Reason for Late</th>
                                                <th width="10%">Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            if($status_kehadiran == '') {
                                                $details = getAnalisaKehadiranAllDetails($nokp);
                                            }
                                            else {
                                                $details = getAnalisaKehadiranDetails($nokp,$status_kehadiran);
                                            }
                                            $i=1;
                                            while($kehadiran_details = $details->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?echo $i++;?></td>
                                                    <td><?echo $kehadiran_details['hari_masuk'];?></td>
                                                    <td>
                                                        <label class="control-label">In :</label>&nbsp;
                                                        <?echo $kehadiran_details['masa_masuk'];?>
                                                        <br><label class="control-label">Out :</label>&nbsp;
                                                        <?echo $kehadiran_details['masa_keluar'];?>
                                                    </td>
                                                    <td>
                                                        <label class="control-label">In :</label>&nbsp;
                                                        <?echo $kehadiran_details['device_masuk'];?>
                                                        <br><label class="control-label">Out :</label>&nbsp;
                                                        <?echo $kehadiran_details['device_keluar'];?>

                                                    </td>
                                                    <!-- <td>
                                            <label class="control-label">Masuk :</label>&nbsp;
                                            <br><?echo getLokasiKehadiran($kehadiran_details['lokasi_masuk']);?>
                                            <br><label class="control-label">Keluar :</label>&nbsp;
                                            <br><?echo getLokasiKehadiran($kehadiran_details['lokasi_keluar']);?>
                                                
                                        </td> -->
                                                    <td>
                                                        <label class="control-label">In :</label>&nbsp;
                                                        <?echo $kehadiran_details['remark_masuk'];?>
                                                        <br><label class="control-label">Out :</label>&nbsp;
                                                        <?echo $kehadiran_details['remark_keluar'];?>

                                                    </td>
                                                    <td>
                                                        <?echo '<b>'.'<font color="blue">'.$kehadiran_details['bil_jam_bekerja'].'</font></b>';?>
                                                        <br>
                                                        <?
                                                        if($kehadiran_details['status_kehadiran'] == 'AWAL') {
                                                            echo '<b>'.'<font color = "green">EARLY</font>'.'</b>';
                                                        }
                                                        else if($kehadiran_details['status_kehadiran'] == 'TEPAT') {
                                                            echo '<b>'.'<font color = "purple">PUNCTUAL</font>'.'</b>';
                                                        }
                                                        else {
                                                            echo '<b>'.'<font color = "red">LATE</font>'.'</b>';
                                                        }
                                                        ?>

                                                    </td>
                                                    <td><?echo $kehadiran_details['sebab_kelewatan'];?></td>
                                                    <?php
                                                    if($kehadiran_details['status_kehadiran'] == 'LEWAT') {
                                                        echo "<td><a href='#myModal1' class='btn btn-info btn-small' data-toggle='modal' data-id=".$kehadiran_details['idd'].">Reason for Late</a></td>";
                                                    }
                                                    else {}
                                                    ?>
                                                </tr>
                                            <?}?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <?}?>
                        <div id="kehadiran_details"></div>

                    </div>
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Sebab Kelewatan</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'analisa_kehadiran_lewat_update.php',
                            data:'id='+rowid,
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>


        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });

            function getAnalisaKehadiranDetails(status_kehadiran){
                //alert(status_kehadiran);
                $.ajax({
                    type: "POST",
                    url: "analisa_kehadiran_details.php",
                    data: {nokp:"<?echo $nokp;?>",status_kehadiran:status_kehadiran},
                    success: function (data) {
                        $('#kehadiran_details').html(data);
                        $('#kehadiran_details_all').hide();
                        // you will get response from your php page (what you echo or print)

                    }

                });
            }

            function getAnalisaKehadiranAllDetails(){
                //alert(status_kehadiran);
                $.ajax({
                    type: "POST",
                    url: "analisa_kehadiran_details.php",
                    data: {nokp:"<?echo $nokp;?>"},
                    success: function (data) {
                        $('#kehadiran_details').html(data);
                        $('#kehadiran_details_all').hide();
                        // you will get response from your php page (what you echo or print)

                    }

                });
            }

        </script>

</body>

</html>