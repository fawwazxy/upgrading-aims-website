<?php
	include ('../controller/auth.php');
	
	require "../model/niaga_function.php";

?>
<?
    	
		/*$ccsid = $_GET['ccsid'];
		
				$sql = "SELECT * FROM lottanah WHERE ID='$ccsid'";
				$select = mysql_query($sql) or die (mysql_error().$sql);
				$list = mysql_fetch_array($select);
		
				$lat = $list['LAT'];
				$long = $list['LNG'];
				$lot = $list['LOT'];				
				$mukim = $list['MUKIM_'];
				$daerah = $list['DAERAH_'];
				$hectares = $list['HECTARES'];*/
				
	$leadid = $_GET['leadid'];
	
	$sys = getSys(1)->fetch_assoc();
	
	$lead = getLeadDetails($leadid)->fetch_assoc();
	
	$agensi = $lead['lead_name'];
	$alamat = $lead['lead_address'];
	$lokasi = $lead['lokasi'];
	$daerah = $lead['daerah'];
	$negeri = $lead['negeri'];
	
	$marker= "['',$lokasi,'']";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Paparan Google Maps Lokasi Pelanggan</title>
		<? require "../global/header.php"; ?>
		<!-- Favicons -->
	<link rel="shortcut icon" href="favicon.png" >
		<style>
			#map_wrapper {
				height: 800px;
			}

			#map_canvas {
				width: 100%;
				height: 100%;
			}
			table {
				width:100%;
			}
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
			th, td {
				padding: 15px;
				text-align: left;
			}
			table#t01 tr:nth-child(even) {
				background-color: #eee;
			}
			table#t01 tr:nth-child(odd) {
			   background-color: #fff;
			}
			table#t01 th {
				background-color: black;
				color: white;
			}
		</style>
		
	</head>
	<body>
		
		<center>
			<h1>PAPARAN GOOGLE MAPS LOKASI</h1>
			<br>			
		</center>
		<center>			
		<table id="t01">
			
			<tr>				
				<th colspan="4" align="center">MAKLUMAT CARIAN</th>				
			</tr>
			<tr>				
				<td width="20%">Pelanggan</td>
				<td width="30%"><strong><? echo $agensi;?></strong></td>
				<td width="20%">Alamat</td>
				<td width="30%"><strong><? echo $alamat;?></strong></td>				
			</tr>
			<tr>
				<td width="20%">Negeri</td>
				<td width="30%"><strong><? echo $negeri;?></strong></td>				
				<td width="20%">Daerah</td>
				<td width="30%"><strong><? echo $daerah;?></strong></td>
			</tr>	
		</table>
		<br><br>
		</center>
		
		<div id="map_wrapper">
			<!--<div id="map_canvas" class="mapping"></div>-->
			<div id="map_canvas" style="width:100%;height:700px"></div>
		</div>
		<script>
			function initialize() {
				var map;
				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					mapTypeId: google.maps.MapTypeId.HYBRID
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
					this.setZoom(20);
					google.maps.event.removeListener(boundsListener);
				});
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyciSZxMmYCFy4GsJsEh0nKZezKwHvw_I&sensor=false&callback=initialize"></script>
		<center>
		    <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
		    Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
		</center>
	</body>
</html>