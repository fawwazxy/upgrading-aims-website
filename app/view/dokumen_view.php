
<?require "../model/spesifikasi_function.php";
require "../global/header.php";
$id_dokumen=$_GET['id_dokumen'];										
$result = getDownloadDocument($id_dokumen) -> fetch_assoc();
$contenttype = "application/pdf"; // retrive content type from database
$blob = $result['document'];  // retrive blob from database
$urlfilename='../../resources/items/'.$result['nama_file_upload'];
if(file_exists ( $urlfilename )){
	
}else{
//file_put_contents('../../resources/items', $blob);
$handle =fopen('../../resources/items/'.$result['nama_file_upload'], 'x');

//write the blob to the file
fwrite($handle, $result['document']);
}
//echo "<script>window.location.href='../../resources/items/".$result['nama_file_upload']."';</script>";
?>	

<html>
<meta name="mobile-web-app-capable" content="yes">
<head>
<? require "../global/header.php"; ?>
<style>
	button {
  margin-right: 30px;
  margin-top: 7px;
}
</style>
<script>
function handleWindowClose(){
	
	$.confirm({
    title: 'Perhatian!',
    content: 'Adakah anda pasti untuk tutup!',
    buttons: {
        YA: function () {
            window.location.href='../../app/view/deleteFileItems.php?filename=<?echo $result['nama_file_upload']?>';
        },
        TIDAK: function () {
            //$.alert('Canceled!');
        }
    }
});
}
</script>

</head>

<body>
<button onclick="handleWindowClose()" class="btn btn-primary" style="float: right;" >TUTUP</button>
</br>
<iframe src="../../resources/items/<?echo $result['nama_file_upload']?>" style="position:fixed; top:50px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
    Your browser doesn't support iframes
</iframe>
</body>
</html>