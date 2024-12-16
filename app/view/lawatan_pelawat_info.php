<?php

include ('../controller/auth.php');


require "../model/lawatan_functions.php";
require "../model/lookup.php";

$id_lawatan=$_POST['id_lawatan'];
$pelawat_info = getPelawatInfoById($id_lawatan)->fetch_assoc();
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
                <th width="30%"></th>
                <th width="5%"></th>
                <th></th>
            </tr>
            <tr>
                <td><label>Kod Kad</label></td>
                <td><label>:</label></td>
                <td><?echo '<b>'.$pelawat_info['kod_kad'].'</b>'.'&nbsp;-&nbsp;'.$pelawat_info['nama_kad'];?></td>
            </tr>
            <tr>
                <td><label>Nama</label></td>
                <td><label>:</label></td>
                <td><?echo $pelawat_info['nama'];?></td>
            </tr>
            <tr>
                <td><label>No. Kad Pengenalan</label></td>
                <td><label>:</label></td>
                <td><?echo $pelawat_info['nokp'];?></td>
            </tr>
            <tr>
                <td><label>No. Telefon</label></td>
                <td><label>:</label></td>
                <td><?echo '+6'.$pelawat_info['notel'];?></td>
            </tr>
            <tr>
                <td><label>Nama Syarikat</label></td>
                <td><label>:</label></td>
                <td> <?echo $pelawat_info['nama_company'];?></td>
            </tr>
            <tr>
                <td><label>Jenis Kenderaan</label></td>
                <td><label>:</label></td>
                <td><?echo $pelawat_info['jenis_kenderaan'];?></td>
            </tr>
            <tr>
                <td><label>No. Kenderaan</label></td>
                <td><label>:</label></td>
                <td><?echo $pelawat_info['no_kenderaan'];?></td>
            </tr>
            <tr>
                <td><label>Nama Staf</label></td>
                <td><label>:</label></td>
                <td> <?echo $pelawat_info['name'];?></td>
            </tr>
            <tr>
                <td><label>No. Kad Pengenalan</label></td>
                <td><label>:</label></td>
                <td><?echo $pelawat_info['noic'];?></td>
            </tr>
            <tr>
                <td><label>Masa Masuk</label></td>
                <td><label>:</label></td>
                <td><?echo '<b><font color ="blue">'.$pelawat_info['tarikh_masa_masuk'].'</font></b>';?></td>
            </tr>       
            <tr>
                <td><?if($pelawat_info['status_masuk_keluar'] == '0') {?><label>Masa Keluar</label></td>
                <td><label>:</label></td>
                <td>
                <?if($pelawat_info['tarikh_masa_keluar']!=''){echo '<b><font color ="red">'.$pelawat_info['tarikh_masa_keluar'].'</font></b>';}?></td>
            </tr>
            <tr>
                <td><label>Jum. Masa Lawatan</label></td>
                <td><label>:</label></td>
                <td><?echo '<b><font color ="purple">'.$pelawat_info['jum_masa_lawatan'].'</font></b>';?></td>
            </tr><?}?>              
        </table>
    </div>


<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
