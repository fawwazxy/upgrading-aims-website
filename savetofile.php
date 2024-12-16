<?php
require_once('lib/json.inc');
    
$JsonSystem = new Json();

if (isset($_FILES['myFile'])) {
    $filename = $_REQUEST['filename'];
	$latitude = $_REQUEST['latitude'];
	$logitude = $_REQUEST['logitude'];
	$catatan = $_REQUEST['catatan'];
	//format: groupid~companyid~userid
	$xdata = $_REQUEST['xdata'];
	$pieces = explode("~", $xdata);
	
    // Example:
    //move_uploaded_file($_FILES['myFile']['tmp_name'], "uploads/" . $_FILES['myFile']['name']);
    move_uploaded_file($_FILES['myFile']['tmp_name'], "photos/".$filename);
    
    $tarikh = $JsonSystem->autoDate();
	$output = $JsonSystem->executeOperation2("insert into activity(catatan,latitude,longitude,date_submit,groups_id,user_id) values('{$catatan}','{$latitude}','{$logitude}','{$tarikh}','{$pieces[0]}','{$pieces[2]}')");
	
	$output2 = $JsonSystem->executeOperation2("insert into picture(name,activity_id) values('{$filename}','{$output}')");
	
	echo 'Log tugasan berjaya...';
}else{
    echo 'Log tugasan gagal...';
}
?>