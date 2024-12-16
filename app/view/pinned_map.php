<?
    //require "../global/header.php";
	require "../model/kehadiran_functions.php";
	$sys_id = $_GET['sys_id'];
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
		<style>
			#map_wrapper {
				height: 500px;
			}

			#map_canvas {
				width: 100%;
				height: 100%;
			}
		</style>
	</head>
	<body>
		 <?// $pins = getPins($groups_id) -> fetch_assoc(); ?>
		<!--<center><h2>Nama Kumpulan : <? //echo $pins['name']; ?></h2></center>-->
		<div id="map_wrapper">
			<div id="map_canvas" class="mapping"></div>
		</div>
		<script>
			function initialize() {
				var map;
				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					mapTypeId: 'roadmap'
				};
								
				// Display a map on the page
				map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
				map.setTilt(45);
					
				// Multiple Markers
				var markers = [<? echo $marker; ?>];
					
				// Display multiple markers on a map
				var infoWindow = new google.maps.InfoWindow(), marker, i;
				
				// Loop through our array of markers & place each one on the map  
				for( i = 0; i < markers.length; i++ ) {
					//alert(markers.length);
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);
					marker = new google.maps.Marker({
						position: position,
						map: map,
						label: markers[i][3],
						title: markers[i][0]
					});
					
					// Allow each marker to have an info window    
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infoWindow.setContent(infoWindowContent[i][0]);
							infoWindow.open(map, marker);
						}
					})(marker, i));

					// Automatically center the map fitting all markers on the screen
					map.fitBounds(bounds);
				}

				// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
				var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
					this.setZoom(16);
					google.maps.event.removeListener(boundsListener);
				});
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=<? echo $sys['maps_key']; ?>&sensor=false&callback=initialize"></script>
	
	<!--<script>
		setTimeout(function(){location.href = 'pinned_map.php?data=<? echo $groups_id; ?>';} , 7000);
	</script>-->
	</body>
</html>