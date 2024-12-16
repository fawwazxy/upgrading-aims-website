<?php

include ('../controller/auth.php');


require "../model/agromart_functions.php";
require "../model/lookup.php";

$id = $_POST['id'];
$agensi_info = getAgensiInfoById($id)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-4">
    </div>
    <div class="col-xs-8">
        <?if($agensi_info['logo'] != ''){echo '<img width="150" height="150" src="data:image/jpeg;base64,'.base64_encode( $agensi_info['logo'] ).'"/>';
        }?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Nama</label>
    </div>
    <div class="col-xs-8">
       <?echo $agensi_info['nama'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>No. Pendaftaran</label>
    </div>
    <div class="col-xs-8">
        <?echo $agensi_info['no_pendaftaran'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>No. Telefon</label>
    </div>
    <div class="col-xs-8">
        <?echo $agensi_info['notel'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Email</label>
    </div>
    <div class="col-xs-8">
        <?echo $agensi_info['email'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Alamat</label>
    </div>
    <div class="col-xs-8">
        <?echo $agensi_info['alamat'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Daerah</label>
    </div>
    <div class="col-xs-8">
        <?echo $agensi_info['daerah'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Negeri</label>
    </div>
    <div class="col-xs-8">
        <b><?echo $agensi_info['code'];?></b> - <?echo $agensi_info['negeri'];?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Status</label>
    </div>
    <div class="col-xs-8">
        <?if($agensi_info['status'] == '1') 
        {
            echo '<b><font color="green">'.'AKTIF'.'</font></b>';
        }
        else {
            echo '<b><font color="red">'.'TIDAK AKTIF'.'</font></b>';
        }
        ?>
    </div>
</div>


