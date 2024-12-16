<?php
require_once('lib/json.inc');
    
$JsonSystem = new Json();

if (isset($_FILES['myFile'])) {
    $filename = $_REQUEST['filename'];
	$latitude = $_REQUEST['latitude'];
	$logitude = $_REQUEST['logitude'];
	$myid = $_REQUEST['myid'];
	$catatan = $_REQUEST['catatan'];
	//format: groupid~companyid~userid
	$xdata = $_REQUEST['xdata'];
	$pieces = explode("~", $xdata);
	
    // Example:
    move_uploaded_file($_FILES['myFile']['tmp_name'], "photos/".$filename);
    
    $tarikh = $JsonSystem->autoDate();
	$output = $JsonSystem->executeOperation2("update assigned set latitude='{$latitude}',longitude='{$logitude}',catatan='{$catatan}',status='1',created_date='{$tarikh}' where id='{$myid}'");
	
	$output2 = $JsonSystem->executeOperation2("insert into picture(name,assigned_id) values('{$filename}','{$myid}')");
	
	$activity = $JsonSystem->getData("update activity set status=1 where id in (select activity_id from assigned where id='{$myid}')");
	
	echo 'Log tugasan berjaya...';
}else{
    echo 'Log tugasan gagal...';
}
?>