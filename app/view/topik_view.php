<?php

  include ('../controller/auth.php');

  require "../model/chat_function.php";

?>

<?
 
  $forum_id = $_GET['id'];
//  $reply_id = $_GET['id'];
?>    


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>

 <link href="../../js/summernote/summernote.css" rel="stylesheet">
<script src="../../js/summernote/summernote.js"></script>


<script language="JavaScript" type="text/javascript">
function Confirm(){
    return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
}

function Confirm2(){
    return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
}


</script>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
    /*newwindow=window.open(url,'name','height=842,width=595');*/
    newwindow=window.open(url,'name','height=595,width=842');
    if (window.focus) {newwindow.focus()}
    return false;
}

// -->
</script>

<style>
 table.arkib{
  border: 1x solid black;
  border-radius: 8px;
background:   papayawhip;
 }

div.ex1 {
    
    padding-left: 50px;
}


</style>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <!-- /.navbar-header -->
            <? include ('../global/menu_top.php'); ?>

            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--li>
                            <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                        </li-->

                        <? include ('../global/menu_left.php'); ?>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>


        <div id="page-wrapper">
            <div class="row">
                
                <div class="col-lg-12">

                   
  <?
              
                                    $data = getTopikView($forum_id);
                                    while($row_data = $data->fetch_assoc()) {
                                    
  ?> 

      <div class="row">
            <center>
          <div class="col-lg-12">
            <h1 class="page-header"> <?php echo $row_data['category_name'] ?> : <?php echo $row_data['topik'] ?> </h1>
           <div class="panel-heading" align="right">
            <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
          </div>
        </div>
            </center>     
      </div>
                  
 
              <div class="panel-body">

             <font style="font-size: 15px;"><p align="left"><?php echo date('d  M Y - h:i A', strtotime ($row_data['forum_date']) );?></p></font> 
            <p><b> <?php echo $row_data['name']?></b> </p>
            <p>  <?php echo $row_data['message'] ?></p>
          </br>

 </div>

          </br>
        </br>
        </br>
        </br>

        <h3 align="center">Perbincangan</h3>

        <?
         $flagnote = 0;     
          $data_n = getReplyView($row_data['id']);
          while($row_dataN = $data_n->fetch_assoc()) { 
            $divname = "div".$flagnote;
                                      ?> 

     <table class="arkib">
          <tr>  
            <td width="1%">
            </br>
               </br>
           <p align="left"><?php echo date('d  M Y - h:i A', strtotime ($row_dataN['reply_date']));?>  : 
             <a onclick="showNote('<?echo $divname;?>')" >Komen</a>

            <?
              if($row_dataN['status']== '0'){
                    echo "";?>
                   
            <a href="../controller/update_forum_reply.php?id=<? echo $row_dataN['reply_id']; ?>&name=<? echo $_SESSION['SESS_NO_STAFF']?>&forum_id=<? echo $row_dataN['id']; ?>"> <button class="btn btn-info" type="button" >Best Answer</button></a>
 

              <? } else if ($row_dataN['status'] == '1'){ 
                  echo "JAWAPAN TERBAIK";  ?>
                                     <?   }?>    
            </p>

       </br>
          <font style="font-size: 13px; "><b><?php echo $row_dataN['name']?></b></font>
           <p><?php echo $row_dataN['mesej'] ?></p>
</td>
</tr>
                    <tr>
                    <td>
                    <?
                    $i=0;
                    $data_m = getReplyView2($row_dataN['reply_id'], $row_dataN['id']);
                    while($row_dataM = $data_m->fetch_assoc()) {


                    ?>
                    </br>
                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <div class="ex1">
                    <p align="left"><?php echo date('d  M Y - h:i A', strtotime ($row_dataM['reply_date']));?>   :   
                    <a onclick="showNote('<?echo $divname;?>')" >Komen</a>



                    <?
                    if($row_dataM['status']== '0'){
                    echo "";?>
                    <a href="../controller/update_forum_reply_1_exec.php?id=<? echo $row_dataM['balas_id']; ?>&name=<? echo $_SESSION['SESS_NO_STAFF']?>&forum_id=<? echo $row_dataM['id']; ?>&reply_id=<? echo $row_dataM['reply_id']; ?>"> <button id="show_button" class="btn btn-info" type="button" >Best Answer</button></a>

                    <? } else if ($row_dataM['status'] == '1'){ 
                    echo "JAWAPAN TERBAIK";  ?>
                    <? }?>    
                    </p>

                    <font style="font-size: 13px; "><p><b><?php echo $row_dataM['u_name']?></b></p></font>
                    <p><?php echo $row_dataM['message'] ?></p>
                    </div>
                    <?}?>

                    </td>
                    </tr>
</table> 
</br>
<div style="display: none;" id="<?echo $divname;?>">
<form method="POST" action="../controller/forum_reply_exec1.php?id=<? echo $row_dataN['reply_id'];?>&topik=<? echo $row_dataN['id'];?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>" enctype="multipart/form-data">

 
<div class="form-group" align="left">
<label>Komen</label>
</br>
  <textarea type="text"  name="messagenote" id="komen<?echo $flagnote;?>" cols="45" rows="5"></textarea>

<button class="btn btn-primary">Simpan</button> <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

</div>


<script>
$(document).ready(function() {
  $('#komen<?echo $flagnote?>').summernote();
});
</script>
</form>
</div>
           <? 
         $flagnote++;   
            }?>  



<div>
<form method="POST" action="../controller/forum_reply_exec.php?id=<? echo $forum_id;?>&name=<? echo $_SESSION['SESS_NO_STAFF']?>" enctype="multipart/form-data">

 
<div class="form-group" align="left">
<label>Komen</label>
</br>
  <textarea type="text"  name="message" id="summernote1" cols="45" rows="5"></textarea>

<button class="btn btn-primary">Simpan</button> <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

</div>
            
        </div>
      </form>
    </div>


            
<?}?>


<script>
$(document).ready(function() {
  $('#summernote1').summernote();
});

function showNote(namediv){
  //$( "."+namediv ).show();
  //alert(namediv);
  document.getElementById(namediv).style.display = 'block';
}
</script>



</br>
</br>
</div>
</div>

</br>
</br>
</br>
</br>
</body>
</html>