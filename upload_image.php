<?php
    require_once('lib/json.inc');
    
    $JsonSystem = new Json();

    // Get image string posted from Android App
    $base=$_REQUEST['image'];
	// Get file name posted from Android App
	$filename = $_REQUEST['filename'];
	$latitude = $_REQUEST['latitude'];
	$logitude = $_REQUEST['logitude'];
	$catatan = $_REQUEST['catatan'];
	
	//format: groupid~companyid~userid
	$xdata = $_REQUEST['xdata'];
	$pieces = explode("~", $xdata);
	
	// Decode Image
    $binary=base64_decode($base);
    header('Content-Type: bitmap; charset=utf-8');
	//Images will be saved under 'www/imgupload/uplodedimages' folder
    $file = fopen('photos/'.$filename, 'wb');
	// Create File
    fwrite($file, $binary);
    fclose($file);
    
    
	$tarikh = $JsonSystem->autoDate();
	$output = $JsonSystem->executeOperation2("insert into activity(catatan,latitude,longitude,date_submit,groups_id,user_id) values('{$catatan}','{$latitude}','{$logitude}','{$tarikh}','{$pieces[0]}','{$pieces[2]}')");
	
	$output2 = $JsonSystem->executeOperation2("insert into picture(name,activity_id) values('{$filename}','{$output}')");
	
	echo 'Log tugasan berjaya...';
	
    
?>