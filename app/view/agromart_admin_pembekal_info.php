<?php

include ('../controller/auth.php');


require "../model/agromart_functions.php";
require "../model/lookup.php";

$id = $_POST['id'];
$id_agencies = $_POST['id_agencies'];
$pembekal_info = getPembekalInfoById($id,$id_agencies)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-4">
    </div>
    <div class="col-xs-8">
        <?if($pembekal_info['photo'] != ''){echo '<img width="150" height="150" src="data:image/jpeg;base64,'.base64_encode( $pembekal_info['photo'] ).'"/>';
        }?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama Agensi</label>
    </div>
    <div class="col-xs-8">
       <?echo $pembekal_info['nama_agensi'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama</label>
    </div>
    <div class="col-xs-8">
       <?echo $pembekal_info['nama'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>No. Kad Pengenalan</label>
    </div>
    <div class="col-xs-8">
        <?echo $pembekal_info['nokp'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>No. Telefon</label>
    </div>
    <div class="col-xs-8">
        <?echo $pembekal_info['notel'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Umur</label>
    </div>
    <div class="col-xs-8">
        <?echo $pembekal_info['umur'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Alamat</label>
    </div>
    <div class="col-xs-8">
        <?echo $pembekal_info['alamat'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Daerah</label>
    </div>
    <div class="col-xs-8">
        <!-- <b><?echo $pembekal_info['kod_daerah'];?></b> -  --><?echo $pembekal_info['daerah'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Negeri</label>
    </div>
    <div class="col-xs-8">
        <b><?echo $pembekal_info['code'];?></b> - <?echo $pembekal_info['negeri'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Jantina</label>
    </div>
    <div class="col-xs-8">
        <?echo $pembekal_info['jantina'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Status</label>
    </div>
    <div class="col-xs-8">
        <?if($pembekal_info['status'] == '1') 
        {
            echo '<b><font color="green">'.'AKTIF'.'</font></b>';
        }
        else {
            echo '<b><font color="red">'.'TIDAK AKTIF'.'</font></b>';
        }
        ?>
    </div>
</div>


