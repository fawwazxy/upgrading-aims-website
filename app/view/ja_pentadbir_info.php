<?php

include ('../controller/auth.php');


require "../model/jejakasnaf_functions.php";
require "../model/lookup.php";

$id = $_POST['id'];
$info_pentadbir = getPentadbirInfoById($id)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama</label>
    </div>
    <div class="col-xs-8">
       <?echo $info_pentadbir['nama'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>No. Telefon</label>
    </div>
    <div class="col-xs-8">
        <?echo $info_pentadbir['notel'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Email</label>
    </div>
    <div class="col-xs-8">
        <?echo $info_pentadbir['emel'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Jawatan</label>
    </div>
    <div class="col-xs-8">
        <?echo $info_pentadbir['jawatan'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Peranan</label>
    </div>
    <div class="col-xs-8">
        <?echo $info_pentadbir['jenis_acc'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Negeri</label>
    </div>
    <div class="col-xs-8">
        <?echo $info_pentadbir['kod_negeri'].' - '.$info_pentadbir['nama_negeri'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Daerah</label>
    </div>
    <div class="col-xs-8">
        <?echo $info_pentadbir['kod_daerah'].' - '.$info_pentadbir['nama_daerah'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Status</label>
    </div>
    <div class="col-xs-8">
        <?if($info_pentadbir['status'] == '1') 
        {
            echo '<b><font color="green">'.'AKTIF'.'</font></b>';
        }
        else {
            echo '<b><font color="red">'.'TIDAK AKTIF'.'</font></b>';
        }
        ?>
    </div>
</div>


