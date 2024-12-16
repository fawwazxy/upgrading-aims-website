<?php

  include ('../controller/auth.php');

  require "../model/chat_function.php";

?>

<?
 $forum_id = $_GET['nama'];
  $reply_id = $_GET['id'];
?> 
<html>
<head>
      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


 <link href="../../js/summernote/summernote.css" rel="stylesheet">
<script src="../../js/summernote/summernote.js"></script>




</head>

<body>

 <?
              
                                    $data = getTopikView($forum_id);
                                    while($row_data = $data->fetch_assoc()) {
                                    
  ?> 

            <center>
            <h4 class="page-header"> <?php echo $row_data['category_name'] ?> : <?php echo $row_data['topik'] ?> </h4>
          </center>
      <?}?>

 <form method="POST" action="../controller/forum_reply_exec1.php?id=<? echo $reply_id;?>&topik=<? echo $forum_id;?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>" enctype="multipart/form-data">

</br>

 <?
              
                                    $data_n = getReplyView1($reply_id);
                                    while($row_dataN = $data_n->fetch_assoc()) {
                                    
  ?> <!-- 
          <table class="arkib">
          <tr>  
            <td width="50%">
          <font style="font-size: 8px; "><?php echo $row_dataN['name']?></font>
           <p><?php echo $row_dataN['mesej'] ?> </p>
           <font style="font-size: 8px;"><?php echo $row_dataN['reply_date'] ?></font>

         </td>
         </tr>
</table>  -->
</br>

            <?}?>  
 
<div class="form-group" align="left">
<label>Balas</label>
</br>
  <textarea type="text"  name="message" id="summernote" cols="45" rows="5"></textarea>
</div>




<div class="modal-footer">
<button class="btn btn-primary">Simpan</button>
</div>
</form>

<script>
$(document).ready(function() {
  $('#summernote').summernote();
});

</script>
</body>
</html>