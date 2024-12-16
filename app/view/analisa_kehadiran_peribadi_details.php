<?php

require "../model/analisa_kehadiran_functions.php";
require "../model/lookup.php";

$noic = $_POST['noic'];
$status_kehadiran = $_POST['status_kehadiran'];

?>

 					<div class="panel panel-default">
                    <div class="panel-heading">
                       <label class="control-label" for="date">Maklumat Kehadiran Peribadi <?if($status_kehadiran=='AWAL'){echo '<strong><font color="green">'.'AWAL'.'</font></strong>';}else if($status_kehadiran=='TEPAT'){echo '<strong><font color="purple">'.'TEPAT'.'</font></strong>';}else if($status_kehadiran == 'LEWAT'){echo '<strong><font color="red">'.'LEWAT'.'</font></strong>';} else{echo '<strong><font color="blue">'.'KESELURUHAN'.'</font></strong>';}?></label>
                    </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables2-example">
                                <thead>
                                    <tr>
                                        <th width="7%">Bil</th>
                                        <th width="10%">Hari</th>
                                        <th width="20%">Tarikh & Masa</th>
                                        <th width="20%">Platform</th>
                                        <th width="20%">Lokasi</th>
                                        <th width="15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                        if($status_kehadiran == '') {
                                            $details = getAnalisaKehadiranAllDetails($noic);
                                        }
                                        else {
                                            $details = getAnalisaKehadiranDetails($noic,$status_kehadiran);
                                        }
                                        $i=1;
                                        while($kehadiran_details = $details->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $kehadiran_details['hari_masuk'];?></td>
                                        <td>
                                            <label class="control-label">Masuk :</label>&nbsp;
                                            <?echo $kehadiran_details['masa_masuk'];?>
                                            <br><label class="control-label">Keluar :</label>&nbsp;
                                            <?echo $kehadiran_details['masa_keluar'];?>
                                        </td>
                                        <td>
                                            <label class="control-label">Masuk :</label>&nbsp;
                                            <?echo $kehadiran_details['device_masuk'];?>
                                            <br><label class="control-label">Keluar :</label>&nbsp;
                                            <?echo $kehadiran_details['device_keluar'];?>
                                                
                                        </td>
                                        <!-- <td>
                                            <label class="control-label">Masuk :</label>&nbsp;
                                            <br><?echo getLokasiKehadiran($kehadiran_details['lokasi_masuk']);?>
                                            <br><label class="control-label">Keluar :</label>&nbsp;
                                            <br><?echo getLokasiKehadiran($kehadiran_details['lokasi_keluar']);?>
                                                
                                        </td> -->
                                        <td>
                                            <label class="control-label">Masuk :</label>&nbsp;
                                            <?echo $kehadiran_details['remark_masuk'];?>
                                            <br><label class="control-label">Keluar :</label>&nbsp;
                                            <?echo $kehadiran_details['remark_keluar'];?>
                                                
                                        </td>
                                        <td>
                                            <?echo '<b>'.'<font color="blue">'.$kehadiran_details['bil_jam_bekerja'].'</font></b>';?>
                                            <br>
                                            <?
                                                if($kehadiran_details['status_kehadiran'] == 'AWAL') {
                                                    echo '<b>'.'<font color = "green">'.$kehadiran_details['status_kehadiran'].'</font>'.'</b>';
                                                }
                                                else if($kehadiran_details['status_kehadiran'] == 'TEPAT') {
                                                    echo '<b>'.'<font color = "purple">'.$kehadiran_details['status_kehadiran'].'</font>'.'</b>'; 
                                                }
                                                else {
                                                    echo '<b>'.'<font color = "red">'.$kehadiran_details['status_kehadiran'].'</font>'.'</b>';
                                                }
                                            ?>
                                                
                                        </td>
                                    </tr>
                                    <?}?>
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
	<script>
        $(document).ready(function() {
            $('#dataTables2-example').DataTable({
                responsive: true
            });
        });
    </script>


