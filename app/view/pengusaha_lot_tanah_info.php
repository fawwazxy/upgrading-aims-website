<?php

include ('../controller/auth.php');


require "../model/pengusaha_functions.php";
require "../model/lookup.php";
$id=$_POST['id'];
$data_lot_tanah = getPengusahaLotTanahDetailsById($id)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Kod Lot Tanah</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$data_lot_tanah['kod_tanah'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama PPK</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$data_lot_tanah['kod_ppk'].'</b>'.' - '.$data_lot_tanah['nama_ppk'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Alamat PPK</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['alamat'].'<br>'.$data_lot_tanah['alamat2'].',<br>'.$data_lot_tanah['alamat3'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Mukim</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['mukim'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Daerah</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['daerah'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Jajahan</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['jajahan'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Negeri</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['name'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Kawasan Kaji Selidik</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['areawunit'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Keluasan</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['keluasan'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Kawasan Pengusahaan</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['area'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Pengairan dan Saliran</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['pengairan'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Seksyen</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['seksyen'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Lot</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['lot'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Perimeter</label>
    </div>
    <div class="col-xs-8">
        <?echo $data_lot_tanah['perimeter'];?>
    </div>
</div>
<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
