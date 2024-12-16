<?php
	include ('../controller/auth.php');
	require "../model/support_function.php";  
	$id = $_GET['id'];
	$row=  getSupportView($id)->fetch_assoc();
  $parent = getParentSub($row['support_parent'])->fetch_assoc();
?>
	<form method="post" enctype="multipart/form-data" action="../controller/update_aduan_exec.php?id=<?php echo $row_data['id']; ?>" >
    <input name="id_support" type="hidden" class="input-short" value="<? echo $id; ?>" />
        <p><b>No. Rujukan Tiket : </b></p><?php echo $row['norujukan_support'];?><br><br>
       	<p><b>Nama Projek: </b></p> <? echo $row['nama_projek'];?>  <br><br>
       	<p><b>Nama Penghantar: </b></p> <? echo $row['nama_client'];?>  <br><br>
       	<p><b>Tarikh Tiket: </b></p> <? echo $row['created_date'];?>  <br><br>
       	<p><b>No. Telefon: </b></p> <? echo $row['notel'];?>  <br><br>
        <p><b>Aduan: </b></p><? echo $row['aduan'];?><br><br>
        <?if($row['client_feedback']!=''){
          ?>
        <p><b>Maklum Balas: </b></p><? echo $row['client_feedback'];?><br><br>
        <?}if(!is_null($row['support_parent'])){?>
            <center><h4><b><font color="blue">Maklumat Aduan Asal</font></b></h4></center><br>
            <p><b>No. Rujukan Tiket : </b></p><?php echo $parent['norujukan_support'];?><br><br>
            <p><b>Aduan : </b></p><?php echo $parent['aduan'];?><br><br>
          <?}if(!is_null(getSubSupportList($row['norujukan_support'])->fetch_assoc())){
              $j= 1;?>
              <center><h4><b><font color="blue">Sub Aduan</font></b></h4></center><br>
              <?
              $data_sub = getSubSupportList($row['norujukan_support']);
              echo '<label>Pembahagian Aduan</label>';
              while($list_sub = $data_sub->fetch_assoc()) {?>

                <p><b><?echo $j++;?>. a) No. Rujukan Tiket : </b></p><?php echo $list_sub['norujukan_support'];?><br><br>
                <p><b>&nbsp;b) Aduan : </b></p><?php echo $list_sub['aduan'];?><br><br>
              <?}
          }?>


	</form>
</body>

</html>
