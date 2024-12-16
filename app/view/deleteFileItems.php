
<?
$filename = $_GET['filename'];
if(isset($_GET['filename'])){
	$urlfilename='../../resources/items/'.$_GET['filename'];
	unlink($urlfilename);
}

echo "<script>window.close();</script>";
?>	
