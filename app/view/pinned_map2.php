<?
    //require "../global/header.php";
	require "../model/kehadiran_functions.php";
	$sys = getSys(1)->fetch_assoc();
	date_default_timezone_set("Asia/Kuala_lumpur");
	$marker = "";	
	$groups_id = $_GET['id'];
	if ($groups_id!='') {
		$pins = getPins($groups_id);
		$i=1;
		while ($rows = $pins -> fetch_assoc()) {
			if($rows['lokasi_keluar']=="" || $rows['lokasi_keluar']=="0,0,0,0" ){
			$marker .= "['".date("d-m-Y h:i:s A",strtotime($rows['masa_masuk']))."\\n"."',".$rows['lokasi_masuk'].",'M$i'],";
			}else if($rows['lokasi_masuk']=="0,0,0,0" && isset($rows['lokasi_keluar'])){
				$marker .= "['".date("d-m-Y h:i:s A",strtotime($rows['masa_keluar']))."\\n"."',".$rows['lokasi_keluar'].",'K$i']";

			}else{
			$marker .= "['".date("d-m-Y h:i:s A",strtotime($rows['masa_masuk']))."\\n"."',".$rows['lokasi_masuk'].",'M$i'],";
			$marker .= "['".date("d-m-Y h:i:s A",strtotime($rows['masa_keluar']))."\\n"."',".$rows['lokasi_keluar'].",'K$i']";
			}
			if ($i < $pins -> num_rows) {$marker .= ",";}
			$i++;
		}
	} else {
		$marker .= "['',".$_GET['lokasi'].",'']";
	}
	
	
	
	
	//echo $marker;
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/<? echo $sys['sys_name']; ?>" />
		<title><? echo $sys['sys_name']; ?> :: <? echo $sys['sys_tagline']; ?></title>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnZ0hphV21d48YY4yyL5QEGpcdEaFV5SY&callback=initMap&libraries=&v=weekly" defer></script>
		
		<style>
			/*#map_wrapper {
				height: 500px;
			}

			#map_canvas {
				width: 100%;
				height: 100%;
			}*/
			
			/* Set the size of the div element that contains the map */
            #map {
              height: 400px;
              /* The height is 400 pixels */
              width: 100%;
              /* The width is the width of the web page */
            }
			
			
		</style>
		
		<script>
		    // Initialize and add the map
            function initMap() {
              // The location of Uluru
              const uluru = { lat: -25.344, lng: 131.036 };
              // The map, centered at Uluru
              const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: uluru,
              });
              // The marker, positioned at Uluru
              const marker = new google.maps.Marker({
                position: uluru,
                map: map,
              });
            }
		    
		</script>
		
	</head>
	<body>
		 <?// $pins = getPins($groups_id) -> fetch_assoc(); ?>
		<!--<center><h2>Nama Kumpulan : <? //echo $pins['name']; ?></h2></center>-->
		<!--div id="map_wrapper">
			<div id="map_canvas" class="mapping"></div>
		</div-->
    		<h3>My Google Maps Demo</h3>
            <!--The div element for the map -->
            <div id="map"></div>
		
	
	
	</body>
</html>