<?

    // require "../model/project_management_function.php";
require "../model/contractor_functions.php";
require"../controller/auth.php";


date_default_timezone_set("Asia/Kuala_Lumpur");
$sys_id = $_GET['sys_id'];
$sys = getSys($sys_id)->fetch_assoc();
$com = getCompanyDetails($sys_id)->fetch_assoc();
    // $id = $_GET['id'];
    // $no_staff = $_GET['no_staff'];
$bln=$_GET['mnt'];
$thn=$_GET['thn'];
$noic = $_GET['noic'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/favicon.ico" />
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
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;    
        }
        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        @media print {
            tr {
                -webkit-print-color-adjust: exact; 
                }}
                @media print {
                    #printPageButton {
                        display: none;
                    }
                } 

                @media print {
                  #html-content-holder {
                    display: none;
                }
                #btn-Preview-Image {
                    display: none;
                }
            } 
            table { page-break-inside:auto }
            tr { page-break-inside:avoid; page-break-after:auto }

        </style>
    </head>
    <body>
        <button id="printPageButton" onClick="window.print();">Cetak</button>

        <? /* Start Frontpage Cover */ ?>

        <?
        $kehadiran = getStaffName($noic)->fetch_assoc();
        ?>

        <center>
            <br><br><br><br><br><br><br><br><br>
            <?echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"style="width: 200px; height: 220px;"/>';?>
            <br><br><br>
            <h1>LAPORAN KESELURUHAN KEHADIRAN</h1><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <h3>Laporan Kehadiran Bagi</h3>
            <h3><? echo $kehadiran['name']; ?>&nbsp;[<? echo $kehadiran['no_staff']; ?>]</h3>
            <h3>Laporan Bagi Bulan: <? echo $bln; ?> / <?echo $thn; ?></h3><br><br>
            <!-- No. Telefon: <?// echo $kehadiran['phone']; ?><br>&nbsp;&nbsp;&nbsp;Emel: <?// echo $kehadiran['email']; ?></h4> -->
            <br><br><br><br><br><br>
            <?include '../global/footer_report.php'?>
        </center>

        <? /* End Frontpage Cover */ ?>
        <p style="page-break-after:always;"></p>

        <!---------------------------------------------------------------------------------------->

        <? /* Start SECOND PAGE */ ?>

        <center>
            <br><br><br><br><br><br>

            <center><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $kehadiran['photo'] ).'" style="width: 200px; height: 210px;"/>';?>
        </br><h4><strong><? echo $kehadiran['name'];?></strong><br><? echo $kehadiran['no_staff']?></h4>
    </center>
    <br>


    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

        <thead>
            <tr>
                <th>Sasaran</th>
                <th>Jumlah Jam</th>
                <th>Baki Jam</th>
            </tr>
        </thead>
        <tbody>
            
            <?
            $i= 1;
            $data = getLaporanKehadiran($bln,$thn, $kehadiran['noic']);
            while($row_data = $data->fetch_assoc()) {
                

                ?>
                <tr class="odd gradeX">
                 
                    <td width="45%"><?php echo $row_data['sasaran']; ?></td>
                    <td><?php echo $row_data['total']; ?></td>
                    <td><?php echo $row_data['beza']; ?></td>
                    
                </tr>
                <? $i++;  ?>
                
            </tbody>

        </table>
    </center>

    <? /* End SECOND PAGE */ ?>
    <p style="page-break-after:always;"></p>

    <? /* Start THIRD PAGE */ ?>

    <center>
        <br><br><br><br><br><br>

        <h4>Bulan: <? echo $bln; ?> / <?echo $thn; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Jam : <? echo $row_data['total']?></h4>
        <?}?>

        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Butiran Masuk</th>
                    <th>Lokasi Masuk</th>
                    <th>Butiran Keluar</th>
                    <th>Lokasi Keluar</th>
                </tr>
            </thead>
            <tbody>
                
                <?
                $i= 1;
                $dataK = getKeseluruhanLaporanKehadiran($bln,$thn, $kehadiran['noic']);
                while($data_rowK = $dataK->fetch_assoc()) {
                    
                    $coordinate1=$data_rowK['lokasi_masuk'];
                    $marker1= "['',$coordinate1,'']";
                    
                    $coordinate2=$data_rowK['lokasi_keluar'];
                    $marker2= "['',$coordinate2,'']";
                    

                    ?>
                    <tr class="odd gradeX" valign="top">
                        <td><?php echo $i; ?></td>
                        <td>
                            Masa: <?php echo $data_rowK['masa_masuk']; ?><br>
                            Catatan: <?php echo $data_rowK['remark_masuk']; ?>
                        </td>
                        <td nowrap>
                            <div id="map_canvas<?php echo $i; ?>m" class="maps" data-gps="<?php echo $data_rowK['lokasi_masuk']; ?>" style="width:80%;height:250px"></div>
                            
                            Koordinat: <?php echo $data_rowK['lokasi_masuk']; ?><br>
                            Platform Masuk: <?php echo $data_rowK['device_masuk']; ?><br>
                            Log Photo:<br>
                            <? if ($data_rowK['photo_masuk']!="") {?>
                              <? echo '<img src="../../logphoto/'.date('Ymd',strtotime($data_rowK['created_date'])).'/'.$data_rowK['photo_masuk'].'" style="width: 300px; height: 300px;"/>';?>
                          <? } else { echo "Tiada Gambar. Log menerusi mobile app.";}?>
                      </td>
                      <td>
                        Masa: <?php echo $data_rowK['masa_keluar']; ?><br>
                        Catatan: <?php echo $data_rowK['remark_keluar']; ?>
                    </td>
                    <td nowrap>
                        <div id="map_canvas<?php echo $i; ?>k" class="maps" data-gps="<?php echo $data_rowK['lokasi_keluar']; ?>" style="width:80%;height:250px"></div>
                        Koordinat: <?php echo $data_rowK['lokasi_keluar']; ?><br>
                        Platform Keluar: <?php echo $data_rowK['device_keluar']; ?><br>
                        Log Photo:<br>
                        <? if ($data_rowK['photo_keluar']!="") {?>
                          <? echo '<img src="../../logphoto/'.date('Ymd',strtotime($data_rowK['created_date'])).'/'.$data_rowK['photo_keluar'].'" style="width: 300px; height: 300px;"/>';?>
                      <? } else { echo "Tiada Gambar. Log menerusi mobile app.";}?>
                  </td>

                  
              </tr>
              <? $i++; } ?>
              
          </tbody>

      </table>


  </center>
  <script>
// 			function initialize() {
// 				var map;
// 				var bounds = new google.maps.LatLngBounds();
// 				var mapOptions = {
// 					mapTypeId: google.maps.MapTypeId.HYBRID
// 				};

// 				// Display a map on the page
// 				map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
// 				map.setTilt(45);

// 				// Multiple Markers
// 				var markers = [<? echo $marker1; ?>];

// 				// Display multiple markers on a map
// 				var infoWindow = new google.maps.InfoWindow(), marker, i;

// 				// Loop through our array of markers & place each one on the map  
// 				for( i = 0; i < markers.length; i++ ) {
// 					//alert(markers.length);
// 					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
// 					bounds.extend(position);
// 					marker = new google.maps.Marker({
// 						position: position,
// 						map: map,
// 						label: markers[i][3],
// 						title: markers[i][0]
// 					});

// 					// Allow each marker to have an info window    
// 					google.maps.event.addListener(marker, 'click', (function(marker, i) {
// 						return function() {
// 							infoWindow.setContent(infoWindowContent[i][0]);
// 							infoWindow.open(map, marker);
// 						}
// 					})(marker, i));

// 					// Automatically center the map fitting all markers on the screen
// 					map.fitBounds(bounds);
// 				}

// 				// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
// 				var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
// 					this.setZoom(20);
// 					google.maps.event.removeListener(boundsListener);
// 				});
// 			}
</script>
<script>
  var map;
  function initialize() {
        // Get all map canvas with ".maps" and store them to a variable.
        var maps = document.getElementsByClassName("maps");

        var ids, gps, mapId = '';

        // Loop: Explore all elements with ".maps" and create a new Google Map object for them
        for(var i=0; i<maps.length; i++) {

          // Get ID of single div
          mapId = document.getElementById(maps[i].id);

          // Get LatLng stored in data attribute. 
          // !!! Make sure there is no space in data-attribute !!!
          // !!! and the values are separated with comma !!!
          gps = mapId.getAttribute('data-gps');

          // Convert LatLng to an array
          gps = gps.split(",");

          // Create new Google Map object for single canvas 
          map = new google.maps.Map(mapId, {
            zoom: 15,
            // Use our LatLng array bellow
            center: new google.maps.LatLng(parseFloat(gps[0]), parseFloat(gps[1])),
            mapTypeId: 'roadmap',
            mapTypeControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            }
        });

          // Create new Google Marker object for new map
          var marker = new google.maps.Marker({
            // Use our LatLng array bellow
            position: new google.maps.LatLng(parseFloat(gps[0]), parseFloat(gps[1])),
            map: map
        });
      }
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyciSZxMmYCFy4GsJsEh0nKZezKwHvw_I&sensor=false&callback=initialize"></script>