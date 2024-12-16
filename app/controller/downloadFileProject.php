
<?

require "../model/project_management_function.php";

$id_pesanan_belian=$_GET['id_pesanan_belian'];
$action=$_GET['action'];

$result = getFileRujukan($id_pesanan_belian) -> fetch_object();



if($action=="projek"){
	$file_rujukan = $result -> document_rujukan;
    $filename = $result -> nama_document_rujukan;
	header("Content-Disposition: attachment; filename=$filename");
	ob_clean();
	flush();
	echo $file_rujukan;



} else if($action=="so"){
	$file_rujukan = $result -> document_rujukan;
    $filename = $result -> nama_document_rujukan;
	header("Content-Disposition: attachment; filename=$filename");
	ob_clean();
	flush();
	echo $file_rujukan;



}
?>