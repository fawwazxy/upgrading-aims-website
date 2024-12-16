<?php

include ('../controller/auth.php');


require "../model/ahli_functions.php";
require "../model/lookup.php";

$id = $_POST['id'];
$kelab_persatuan_info = getKelabPersatuanInfoById($id)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-4">
    </div>
    <div class="col-xs-8">
        <?if($kelab_persatuan_info['logo'] != ''){echo '<img width="120" height="120" src="data:image/jpeg;base64,'.base64_encode( $kelab_persatuan_info['logo'] ).'"/>';
        }?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama</label>
    </div>
    <div class="col-xs-8">
       <?echo $kelab_persatuan_info['nama'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Alamat</label>
    </div>
    <div class="col-xs-8">
       <?echo $kelab_persatuan_info['alamat'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama Pengerusi</label>
    </div>
    <div class="col-xs-8">
        <?echo $kelab_persatuan_info['nama_pengerusi'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>No. Telefon</label>
    </div>
    <div class="col-xs-8">
        <?echo $kelab_persatuan_info['tel'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Email</label>
    </div>
    <div class="col-xs-8">
        <?echo $kelab_persatuan_info['email'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama Bank</label>
    </div>
    <div class="col-xs-8">
        <?echo $kelab_persatuan_info['nama_bank'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>No. Akaun Bank</label>
    </div>
    <div class="col-xs-8">
        <?echo $kelab_persatuan_info['no_akaun'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Status</label>
    </div>
    <div class="col-xs-8">
        <?if($kelab_persatuan_info['status'] == '1') 
        {
            echo '<b><font color="green">'.'Aktif'.'</font></b>';
        }
        else {
            echo '<b><font color="red">'.'Tidak Aktif'.'</font></b>';
        }
        ?>
    </div>
</div>


