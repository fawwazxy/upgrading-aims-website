
<?

require "../model/pemohon_functions.php";

$pemohon_id=clean($_GET['pemohon_id']);
$action=clean($_GET['action']);

$result = getResumeCv($pemohon_id) -> fetch_object();



if($action=="resume"){
	$file_resume = $result -> document_resume;
    $filename = $result -> nama_document_resume;
	header("Content-Disposition: attachment; filename=$filename");
	ob_clean();
	flush();
	echo $file_resume;

}else if($action=="transkrip"){
	$file_document = $result -> document;
	$filename = $result -> nama_document;
	header("Content-Disposition: attachment; filename=$filename");
	ob_clean();
	flush();
	echo $file_document;

}else if($action=="cv"){
	$file_cv = $result -> document_cv;
	$filename = $result -> nama_document_cv;
	header("Content-Disposition: attachment; filename=$filename");
	ob_clean();
	flush();
	echo $file_cv;
}


?>