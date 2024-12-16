<?php

//include ('../controller/auth.php');


require "../model/library_functions.php";


$id=$_POST['id'];
$data_rujukan = getLibraryInfo($id)->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
#more {display: none;}
</style>
</head>
<body>
<table>
	<tr>
		<td><?echo '<img src="../../elibrary/frontpage/'.$data_rujukan['frontpage_cover_file'].'" style="width:150px;height:200px;">';?></td>
		<td valign="top" style="padding-left: 20px">
			<?if($data_rujukan['status_naskah'] != 0){?>
			<!--<a href="library_elibrary_label.php?id=<?echo $data_rujukan['id']?>" target="_blank" style="color:black"><button>Cetak Semua</button></a><br><br>-->

			<a class="view" target="_blank" href="library_elibrary_label.php?id=<?echo $data_rujukan['id'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Semua Label</button></a><br><?}?>
			<font size="4px" face="Times New Roman"><strong>Kategori : </strong><?echo $data_rujukan['jenis']?></font>
			<br>
			<font size="3px" face="Times New Roman"><strong>Tajuk : </strong><?echo $data_rujukan['nama']?></font>
			<br>
			<?if($data_rujukan['topik']!=''){?>
			<font size="3px" face="Times New Roman"><strong>Topik : </strong><?echo $data_rujukan['topik']?></font>
			<br>
			<?}if($data_rujukan['subtopic']!=''){?>
			<font size="3px" face="Times New Roman"><strong>Sub Topik : </strong><?echo $data_rujukan['subtopic']?></font>
			<br>
			<?}if($data_rujukan['isbn']!=''){?>
			<font size="3px" face="Times New Roman"><strong>ISBN : </strong><?echo $data_rujukan['isbn']?></font>
			<br>
			<?}if($data_rujukan['bilangan']!=''){?>
			<font size="3px" face="Times New Roman"><strong>Jilid : </strong><?echo $data_rujukan['bilangan']?></font>
			<br>
			<?}if($data_rujukan['pengarang']!=''){?>
			<font size="3px" face="Times New Roman"><strong>Nama Pengarang : </strong><?echo $data_rujukan['pengarang']?></font>
			<br>
			<?}if($data_rujukan['penerbit']!=''){?>
			<font size="3px" face="Times New Roman"><strong>Nama Penerbit : </strong><?echo $data_rujukan['penerbit']?></font>
			<br>
			<?}?>
			<font size="3px" face="Times New Roman"><strong>Tahun Penerbitan : </strong><?echo $data_rujukan['tahun_terbitan']?></font>
			<br>
			
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<font size="4px" face="Times New Roman"><strong>Keterangan : </strong><span id="dots">...</span><span id="more"><?echo $data_rujukan['keterangan']?></font>
			<br>
		</td>
	</tr>
</table>
<br><button onclick="myFunction()" id="myBtn">Read more</button>

<script>
function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>

</body>
</html>