<?php

//include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$search=$_POST['search'];
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/bahan_digital.php"; ?>
	<style>
		#menu {
  background: hsla(1,0%,100%,.9);
  position: absolute;
  top: 50;
  right: 0;
  left: 0;
  min-height: 100%;
  padding-top: 10px;
}

	</style>

</head>

<body style="background-image:url('../../elibrary/bookshelf/wallpaper10.jpg');background-repeat: no-repeat;background-size: 100%;">
    <div class="container">
    <table border="0">
        <br>
        <form>
        <center><input type="text" placeholder="Carian.." name="search" id="search">
        <a href="#myModal3"  data-toggle="modal" data-id=""><button><i class="fa fa-search"></button></i></a>
		<button data-toggle="collapse" href="#menu" role="button" aria-expanded="false" aria-controls="collapseExample">Carian Terperinci <i class="fa fa-caret-square-o-down"></i></button>
		</center>
        </form>
		
		<div id="menu" class="collapse">
		  <div class="container">
		  <form>
			<div class="form-group"> 
				<input class="form-control" id="kategori" name="kategori" type="text" placeholder="Masukkan Kategori..." />
			</div>
			<div class="form-group"> 
				<input class="form-control" id="nama" name="nama" type="text" placeholder="Masukkan Judul..."/>
			</div>
			<div class="form-group"> 
				<input class="form-control" id="topik" name="topik" type="text" placeholder="Masukkan Topik..."/>
			</div>
			<div class="form-group"> 
				<input class="form-control" id="subtopic" name="subtopic" type="text" placeholder="Masukkan Sub Topik..."/>
			</div>
			<div class="form-group"> 
				<input class="form-control" id="tahun_terbitan" name="tahun_terbitan" type="text" placeholder="Masukkan Tahun Terbitan..."/>
			</div>
			<div class="form-group"> 
				<input class="form-control" id="penerbit" name="penerbit" type="text" placeholder="Masukkan Nama Penerbit..."/>
			</div>
			<div class="form-group"> 
				<input class="form-control" id="pengarang" name="pengarang" type="text" placeholder="Masukkan Nama Pengarang..."/>
			</div>
			<div class="modal-footer">
			<a href="#myModal1" class="btn btn-info btn-small" data-toggle="modal" data-id="">Cari <i class="fa fa-search"></i></a>
			<button type="reset" class="btn btn-warning">Tetapan Semula</button>
                
            </div>
			</form>
		  </div>
		</div>
    
    <?
        $kategori = getSearchKategori($search);
        $i=1;
        while($list_kategori = $kategori->fetch_assoc()) { 
            if(($i%3) == 1){
                //if($i > 3) echo "</tr>";
                echo "</tr> <tr>";
            }  
    ?>  
        <td>        
<table border="0">

<tr>   
<th>  
    <table class="front" align="center" border="0" >   
        <tr>
            <td colspan="2" align="center" style="padding-left: 10px;padding-right: 10px">
                <div id="html-content-holder<?echo $i;?>" >
         <button style="width: 300px; height: 150px;background-image:url('../../elibrary/bookshelf/buttons.jpg')" id="btn_pelanggan" onclick="window.location.href='library_bahan_digital.php?id=<?echo $list_kategori['id_jenis']?>'"><font color="brown" face="Cambria" size="6px"><?echo $list_kategori['jenis'];?> (<?echo $list_kategori['kuantiti'];?>)</font></button>
            
            
                </div>
            </td><br>
        </tr>
    </table>
</th>
</tr>
</table>
</td>
<?php $i++; } ?>
</table>
    <div class="footer-section">
            <div class="copy-section">
                <!--<div class="container">-->
                    <br>
                    <br>
                    <center>
                        <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
                        Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
                    </center>
                <!--</div>-->
            </div>
        </div>
        </div>
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel2">Senarai Carian</h4>
        </div>
        <div class="modal-body" id="demo3">
        <script type="text/javascript">
          $('#myModal3').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var search=$("#search").val();
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'library_carian.php',
              data:{action:"searchAll",search:search},
              success:function(html){
				  $("#search").val('');
                $('#demo3').html(html);
              }
            });
          });
        </script>
        </div>                                                                       
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Senarai Carian</h4>
        </div>
        <div class="modal-body" id="demo">
        <script type="text/javascript">
          $('#myModal1').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var kategori=$("#kategori").val();
			var nama=$("#nama").val();
			var topik=$("#topik").val();
			var subtopic=$("#subtopic").val();
			var tahun_terbitan=$("#tahun_terbitan").val();
			var penerbit=$("#penerbit").val();
			var pengarang=$("#pengarang").val();
			
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'library_carian.php',
              data:{action:"searchAdv",kategori:kategori,nama:nama,topik:topik,subtopic:subtopic,tahun_terbitan:tahun_terbitan,penerbit:penerbit,pengarang:pengarang},
              success:function(html){
                $('#demo').html(html);
              }
            });
          });
        </script>
        </div>                                                                       
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel2">Maklumat Terperinci Bahan Digital</h4>
        </div>
        <div class="modal-body" id="demo2">
        <script type="text/javascript">
          $('#myModal2').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'library_digital_details.php',
              data:{id:rowid},
              success:function(html){
                $('#demo2').html(html);
              }
            });
          });
        </script>
        </div>                                                                       
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  
</body>


</html>