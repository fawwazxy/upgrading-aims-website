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

    
    $id_galeri = $_GET['id_galeri'];
    
    $sys = getSys(1)->fetch_assoc();
    $data_galeri = getGaleriAcaraById($id_galeri)->fetch_assoc();
	$nama_folder = $data_galeri['folder_code'];

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
	<? require "../global/header.php"; ?>
	<link href="../../js/ekko-lightbox/ekko-lightbox.css" rel="stylesheet">
    <script src="../../js/ekko-lightbox/ekko-lightbox.min.js"></script>

	
    
	
	


</head>

<body> 
 <div id="wrapper">
		
    <div class="col-lg-12">
        <div class="row">
		<?php
		 $files = glob("../../acara/galeri/".$nama_folder."/*.*");
		 for ($i=0; $i<count($files); $i++)
		  {
			$image = $files[$i];
			$supported_file = array(
					'gif',
					'jpg',
					'jpeg',
					'png'
			 );

			 $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
			 if (in_array($ext, $supported_file)) {?>
				   <a href="<? echo $image;?>" data-toggle="lightbox" data-gallery="example-gallery">
						<img src="<?echo $image;?>" class="img-thumbnail" width="100px" height="50px">
				  </a>
				<?} else {
					echo "Tiada Gambar";
				}
			  }
		   ?>

    </div>
</div>
  
  
</div>
<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
</script>
</body>

</html>
