<?
    //require "../global/header.php";
	require "../model/kehadiran_functions.php";
	
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_month = date(m);
	$date_year = date(Y);
	$date_day = date(d);
	$time_hour = date(H);
	$time_min = date(i);
	$time_sec = date(s);
	
	$sys = getSys(1)->fetch_assoc();
    $sys_domain=$sys['sys_domain'];
    $shortcode=$sys['short_name'];
    
	
	$marker = "";	
	
		$pins = getPinsLocation();
		$i=1;
		while ($rows = $pins -> fetch_assoc()) {
		    
		    $lokasi = "Koordinat GPS: ".$rows['latitude'].",".$rows['longitude'];
		    
			$marker .= "['".$lokasi."\\n".$rows['name']."',".$rows['latitude'].",".$rows['longitude'].",'$i']";
			if ($i < $pins -> num_rows) {$marker .= ",";}
			$i++;
			
		}
	
	//echo $marker;
?>
<!DOCTYPE html>
<html>
	<head>
		
	<? require "../global/header.php"; ?>
	
		<style>
			#map_wrapper {
				height: 1000px;
			}

			#map_canvas {
				width: 100%;
				height: 100%;
			}
		</style>
	</head>
	<body>
		<? 
		    $pins = getPinsLocation() -> fetch_assoc(); 
		    
		    $com = getCompanyDetails(1)->fetch_assoc();
		    
		?>
		<center><h2>Senarai Plot Lokasi : <? echo $com['name'];?></h2></center>
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
					this.setZoom(12);
					google.maps.event.removeListener(boundsListener);
				});
			}
		</script>
		<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnZ0hphV21d48YY4yyL5QEGpcdEaFV5SY&sensor=false&callback=initialize"></script-->
		<script src="https://maps.googleapis.com/maps/api/js?key=<? echo $sys['maps_key'];?>&sensor=false&callback=initialize"></script>
		
		
	
	
	</body>
</html>