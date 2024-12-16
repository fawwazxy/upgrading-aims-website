<?php

include ('../controller/auth.php');


require "../model/lawatan_functions.php";
require "../model/lookup.php";

$id_kad=$_POST['id_kad'];
$kad_info = getKadPelawatInfoById($id_kad)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Kod</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$kad_info['kod_kad'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Jenis Kad</label>
    </div>
    <div class="col-xs-8">
       <?echo $kad_info['jenis_kad'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama Kad</label>
    </div>
    <div class="col-xs-8">
        <?echo $kad_info['nama_kad'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Jumlah Cetakan</label>
    </div>
    <div class="col-xs-8">
        <?echo $kad_info['status_cetak'];?>
    </div>
</div>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
