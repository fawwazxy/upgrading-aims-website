<?php
    require "../model/acara_functions.php";

    require_once("../../util/qrcode.php");
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);

    
    $nokp = $_GET['nokp'];
    
    $sys = getSys(1)->fetch_assoc();
    $data_sesi = getPhotoFilenamePeserta($nokp)->fetch_assoc();

?>

 
<!DOCTYPE html>
<html lang="en">

<head>
    <title><? echo $sys['sys_name']; ?>::<? echo $sys['sys_tagline']; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.min.js"></script>
	
	<? require "../global/header.php"; ?>


</head>

<body> 
<div class="container" align="center">
  <h2>Gambar Profil</h2>
  <?if($data_sesi['photo_filename']!=''){?>
                    <img width="80" height="100" src="../../acara/foto_peserta/<?echo $data_sesi['photo_filename']; ?>"/><br>
                <?}else{?>
					 <img width="80" height="100" src="<?echo $sys_domain;?>/acara/foto_peserta/nophoto.jpg"/><br>
				<?}?>
  <p>&nbsp;</p>
  <form action="../controller/upload_gambar_peserta_exec.php" method="post" enctype="multipart/form-data">
	<div class="form-group" align="left">
	  <label>Muat Naik Gambar Profil</label>
		<input class="form-control" type="hidden" class="btn btn-link" name="nokp" value="<? echo $nokp;?>"/>
		<input class="form-control" accept="image/*" type="file" class="btn btn-link" name="photo" required />
		<button type="submit" class="form-control btn btn-primary">Muat Naik Gambar</button>
	</div>
	
  </form>
</div>
</body>

</html>
