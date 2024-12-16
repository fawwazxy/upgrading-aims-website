<?php

include ('../controller/auth.php');


require "../model/dashboard_projek_functions.php";
require "../model/lookup.php";

$id_projek = $_POST['id_projek'];
$projek_info = getProjekInfoById($id_projek)->fetch_assoc();

date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$current_month=date("m");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));

?>
<style>
    td {
        padding-bottom: 20px;
        vertical-align: top;
    }
</style>
  <div class="panel-body">
                            <table width="100%">
                                <tr>
                                    <th width="28%"></th>
                                    <th width="5%"></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><label>Kod Projek Utama</label></td>
                                    <td><label>:</label></td>
                                    <td><?if($projek_info['kod_projek_parent']!=''){ echo '<b>'.$projek_info['kod_projek_parent'].'</b>';} else{echo '<b><font color="brown">'.'PROJEK UTAMA'.'</font></b>';}?></td>
                                </tr>
                                <tr>
                                    <td><label>Kod Projek</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo '<b>'.$projek_info['kod_projek'].'</b>';?></td>
                                </tr>
                                <tr>
                                    <td><label>Nama Projek</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo $projek_info['nama_projek'];?></td>
                                </tr>
                                <tr>
                                    <td><label>Jenis Projek</label></td>
                                    <td><label>:</label></td>
                                    <td><?if($projek_info['jenis_projek']=='1') {echo 'Projek Dalaman';}
                                            else if($projek_info['jenis_projek']=='2') {echo 'Projek Luar';}
                                            else {echo 'Tender';}?></td>
                                </tr>
                                <tr>
                                    <td><label>Nama Pelanggan</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo $projek_info['nama_client'];?></td>
                                </tr>
                                <tr>
                                    <td><label>Negeri</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo $projek_info['negeri'];?></td>
                                </tr>
                                <tr>
                                    <td><label>Negara</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo $projek_info['negara'];?></td>
                                </tr>
                                <tr>
                                    <td><label>Tarikh Mula</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo date("d-m-Y",strtotime($projek_info['tarikh_mula']))?></td>
                                </tr>
                                <tr>
                                    <td><label>Tarikh Tamat</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo date("d-m-Y",strtotime($projek_info['tarikh_tamat']))?></td>
                                </tr>
                                <tr>
                                    <td><label>Catatan</label></td>
                                    <td><label>:</label></td>
                                    <td><?echo $projek_info['catatan'];?></td>
                                </tr>
                                
                            </table>
                            </div>


