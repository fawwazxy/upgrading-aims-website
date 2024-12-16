<?

include ('../controller/auth.php');


require "../model/library_functions.php";

$action=$_POST['action'];
$kategori=$_POST['kategori'];
$nama=$_POST['nama'];
$topik=$_POST['topik'];
$subtopic=$_POST['subtopic'];
$tahun_terbitan=$_POST['tahun_terbitan'];
$penerbit=$_POST['penerbit'];
$pengarang=$_POST['pengarang'];
$id_kategori=$_POST['id_kategori'];
$search=$_POST['search'];



?>

						
							<?
								if($action=="searchAdvByKategori"){
									$adv_search = getAdvSearchByKategori($id_kategori,$nama,$topik,$subtopic,$tahun_terbitan,$penerbit,$pengarang);
								}else if($action=="searchAdv"){
									$adv_search = getAdvSearch($kategori,$nama,$topik,$subtopic,$tahun_terbitan,$penerbit,$pengarang);
								}else{
									$adv_search = getSearchAll($search);
								}
								$i=1;
								if($adv_search->num_rows>0){
								while($list_search = $adv_search->fetch_assoc()) { 
							?>  
								
									<a href="#myModal2" data-toggle="modal" data-id="<? echo $list_search['id'];?>">
									<font size="3"><? echo $list_search['nama'];?></font></a><br>
									
									<b><font size="1">Kategori : <? echo $list_search['jenis'].'<br>Penerbit : '.$list_search['penerbit'].'<br>Pengarang : '.$list_search['pengarang'].'<br>Tahun Terbitan : '.$list_search['tahun_terbitan'];?></font></b><br><br>
									
									
								
								<?}
								}else{
									echo 'Tiada Rekod Ditemui';;
									
								}?>
						</ol>