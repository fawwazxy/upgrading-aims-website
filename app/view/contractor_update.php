<?php

include ('../controller/auth.php');
require "../model/lookup.php";
require "../model/contractor_function.php";


$id = $_GET['id'];
$data = getContractorById($id)->fetch_assoc(); 

$no_staff = $_POST["no_staff"];
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_year = date(Y);
$current_date = $date_year;

  //date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$year=$_GET['year'];
?>

<?
							   $filename = $data['doc_name'];
							   $filepath = '../../contractorphoto/'.$data['doc_name'];
							
							?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <title>Contractor and Visitor Registration</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/aims_logo.png" />
  <link href="../../js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<style type="text/css">

  .form-padding{
    padding-right: 10px;
    padding-left: 20px;
  }
  input[type="text"]{ padding: 20px 10px; line-height: 28px; }

  h5{
    line-height:1.4;
    font-size:13px;
    font-family: "Times New Roman", Times, serif;
  }

  h3{
    font-size:20px;
    text-align: center;

  }

  .toast__container {
    display: table-cell;
    vertical-align: middle;
  }

  .toast__cell{
    display:inline-block;
  }

  .add-margin{
    margin-top:20px;
  }

  .toast__svg{
    fill:#fff;
  }

  .toast {
    text-align:left;
    padding: 21px 0;
    background-color:#fff;
    border-radius:4px;
    max-width: 500px;
    top: 0px;
    position:relative;
    box-shadow: 1px 7px 14px -5px rgba(0,0,0,0.2);
  }


  .toast:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    border-top-left-radius:4px;
    border-bottom-left-radius: 4px;

  }

  .toast__icon{
    position:absolute;
    top:50%;
    left:22px;
    transform:translateY(-50%);
    width:14px;
    height:14px;
    padding: 7px;
    border-radius:50%;
    display:inline-block;
  }

  .toast__type {
    color: #3e3e3e;
    font-weight: 700;
    margin-top: 0;
    margin-bottom: 8px;
  }

  .toast__message {
    font-size: 14px;
    margin-top: 0;
    margin-bottom: 0;
    color: #878787;
  }

  .toast__content{
    padding-left:70px;
    padding-right:60px;
  }

  .toast__close {
    position: absolute;
    right: 22px;
    top: 50%;
    width: 14px;
    cursor:pointer;
    height: 14px;
    fill:#878787;
    transform: translateY(-50%);
  }

  .toast--green .toast__icon{
    background-color:#ff4d00;
  }

  .toast--green:before{
    background-color:#ff4d00;
  }

  .toast--blue .toast__icon{
    background-color:#1D72F3;
  }

  .toast--blue:before{
    background-color:#1D72F3;
  }
</style>
<body>
  <div class="container panel">       
   <td width="10%" align="center">
    <h5><br>
      <img src="../../resources/images/aims_logo.png" style="float:left;width:90px;height:95px;">
      &nbsp;&nbsp;<b>AIMS-GLOBAL HOLDINGS SDN BHD </b>
      <br> &nbsp;&nbsp;NO 20 & 21 Blok B,
      <br> &nbsp;&nbsp;Bestari Centre, Jalan Hiliran
      <br> &nbsp;&nbsp;20300 Kuala Terengganu, Malaysia
      <br> &nbsp;&nbsp;Phone: 09-6228848 | Fax: 09-6238848
    </img>
  </h5>
</td><br>
<div class="form-padding">
  <div class="row">

    <h3><b>Contractor and Visitor Registration</h3></b>
    
    <br><form method="post" action="../controller/contractor_update_exec.php" enctype="multipart/form-data">
      <input id="id" name="id" type="hidden" value="<? echo $id?>"/>
      <div class="form-group" align="left">
       <label>Full Name<font color="red">&nbsp;**</font></label>
       <input name="name" id="name" type="text" class="form-control" onkeyup="convertToUppercase(this)"  value="<? echo $data['name'];?>" required >
     </div>

     <div class="form-group" align="left">
       <label>IC Number (without  -) <font color="red">&nbsp;**</font></label>
       <input name="noic" id="noic" type="text" class="form-control" value="<? echo $data['noic'];?>" required autocomplete="" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="12" >
     </div>

     <div class="form-group" align="left">
       <label>Age<font color="red">&nbsp;**</font></label>
       <input id="umur" name="umur" type="text" class="form-control"value="<? echo $data['umur'];?>" required value="" autocomplete="" maxlength="3" onkeyup="this.value=this.value.replace(/[^\d]/,'')"/>
     </div>

     <div class="form-group" align="left">
       <label for="gender" class="label-title">Gender <font color="red">&nbsp;**</font></label>
       <select name="gender" id="gender" class="form-control" required >
        <option><?php if($data['gender'] == 'LLAKI'){
          echo "MAN";}
          else if($data['gender'] == 'PREMPUAN') {
            echo "WOMAN";}
            else
              echo " ";
            ?></option>
            <option value="LLAKI">MAN</option>
            <option value="PREMPUAN">WOMEN</option>
          </select>
        </div>

        <div class="form-group" align="left">
         <label>Phone Number<font color="red">&nbsp;** (e.g: 0123456789)</font></label>
         <input id="phone" name="phone" type="text" class="form-control" value="<? echo $data['phone'];?>" required>
       </div>

       <div class="form-group" align="left">
        <label>Email</label>
        <input name="email" id="email" type="text" class="form-control" value="<? echo $data['email'];?>">
      </div>

      <div class="form-group" align="left">
        <label>ID Akses Pengguna<font color="red">&nbsp;**</font></label>
        <input type="text" class="form-control"  name="username" value="<? echo $data['username']; ?>">
      </div>

      <div class="form-group" align="left">
        <label>Katalaluan<font color="red">&nbsp;**</font></label>
        <input type="text" class="form-control" name="accs_pwd" value="<? echo $data['accs_pwd']; ?>">
      </div>

      <div class="form-group" align="left">
        <label>Company <font color="red">&nbsp;**</font></label>
        <input name="syarikat" id="syarikat" type="text" class="form-control" onkeyup="convertToUppercase(this)" value="<? echo $data['syarikat'];?>" required>
      </div>

      <div class="form-group" align="left">
        <label for="category_id" class="label-title">Category <font color="red">&nbsp;**</font></label>
        <select name="category_id" id="category_id" class="form-control" value="" required>
          <option><?php echo $data['role_id']?></option>
          <option value="CONTRACTOR">CONTRACTOR</option>
          <option value="VISITOR">VISITOR</option>
        </select>
      </div>

      <div class="form-group" align="left">
        <label>Purpose <font color="red">&nbsp;(Visitor only)</font></label>
        <input name="purpose" id="purpose" type="text" class="form-control" onkeyup="convertToUppercase(this)" value="<? echo $data['purpose'];?>">
      </div>

      <div class="form-group" align="left">
        <label>Jumlah Jam Kerja<font color="red">&nbsp;**</font></label>
        <input type="text" class="form-control" name="jum_jam_kerja" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="08:00:00" value="<? echo $data['jum_jam_kerja']; ?>" required>
      </div>

      <div class="form-group" align="left">
        <label>Jumlah Jam Rehat<font color="red">&nbsp;**</font></label>
        <input type="text" class="form-control" name="jum_jam_break" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="01:00:00" value="<? echo $data['jum_jam_break']; ?>" required>
      </div>

      <div class="form-group" align="left">
       <label>Status Qr-code<font color="red"></font>&nbsp;</label><br>
       <? if ($data['status_qrcode'] == '1') { ?>
        <input type="radio" name="status_qrcode" value="1" checked="checked"> ON &nbsp;&nbsp;&nbsp;
        <input type="radio" name="status_qrcode" value="0"> OFF &nbsp;&nbsp;&nbsp;
      <? } else { ?>
        <input type="radio" name="status_qrcode" value="1"> ON &nbsp;&nbsp;&nbsp;
        <input type="radio" name="status_qrcode" value="0" checked="checked"> OFF &nbsp;&nbsp;&nbsp;
      <? } ?>
    </div>

    <div class="form-group" align="left">
     <label>Status Swafoto<font color="red"></font>&nbsp;</label><br>
     <? if ($data['status_swafoto']  == '1') { ?>
      <input type="radio" name="status_swafoto" value="1" checked="checked"> ON &nbsp;&nbsp;&nbsp;
      <input type="radio" name="status_swafoto" value="0"> OFF &nbsp;&nbsp;&nbsp;
    <? } else { ?>
      <input type="radio" name="status_swafoto" value="1"> ON &nbsp;&nbsp;&nbsp;
      <input type="radio" name="status_swafoto" value="0" checked="checked"> OFF &nbsp;&nbsp;&nbsp;
    <? } ?>
  </div>

  <div class="form-group" align="left">
   <label>Status Tag<font color="red"></font>&nbsp;</label><br>
   <? if ($data['status_tag']  == '1') { ?>
    <input type="radio" name="status_tag" value="1" checked="checked"> ON &nbsp;&nbsp;&nbsp;
    <input type="radio" name="status_tag" value="0"> OFF &nbsp;&nbsp;&nbsp;
  <? } else { ?>
    <input type="radio" name="status_tag" value="1"> ON &nbsp;&nbsp;&nbsp;
    <input type="radio" name="status_tag" value="0" checked="checked"> OFF &nbsp;&nbsp;&nbsp;
  <? } ?>
</div>



<!-- <div class="form-group" align="left">-->
<!--  <label>Vaccine Certificate&nbsp;<font color="red"><i>(Only jpeg/jpg/png/pdf format files are allowed)</i></font></label>-->
<!--  <input type="hidden" name="MAX_FILE_SIZE">-->
<!--  <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">   -->
<!--</div>-->

<div class="form-group" align="left">
								  <label>Vaccine Certificate&nbsp;<font color="red"><i>(Only jpeg/jpg/png/pdf format files are allowed)</i></font></label>
								<? if($data['doc_type'] != ''){?>
								  <?if($data['doc_type'] == 'jpg' || $data['doc_type'] == 'jpeg'|| $data['doc_type'] == 'JPG'|| $data['doc_type'] == 'JPEG' || $data['doc_type'] == 'png' || $data['doc_type'] == 'gif') {?>
                                            <center><img class="img-responsive" width="200" height="100" src="<?echo $filepath;?>" border="0"/></center>   
								  <?   }  else if($data['doc_type'] == 'pdf') {?>
                                               <center><iframe width="200" height="100" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe></center>
									<?}?>
								<br><input type="hidden" name="MAX_FILE_SIZE" value="2000000">
								<br><input type="file" onchange="preview(event)" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
								<img id="output" src="#" alt="pic" style="width: 192px;height: auto"/>
								<?}?>
								</div>
							</div>	

<br>

<div class="form-group" align="center">
  <button type="submit" class="btn btn-success">Submit</button>
  &nbsp;
  <button type="reset" class="btn btn-warning">Reset</button>
</div>
</form>

</div>
</div>
</div>
</div>
<script>

  function convertToUppercase(el) {
    if(!el || !el.value) return;
    el.value = el.value.toUpperCase();
  }

  $("#no_staff").on('input', function () {
    var no_staff = $("#no_staff").val();
    if(no_staff.match(/^(\d{2})(\d{2})(\d{2})(\d{2})(\d{4})$/)) {
      var year = RegExp.$1;
      var lastNum = RegExp.$5;
      console.log(year, lastNum);

      var gender = lastNum%2;

      if(gender === 1){
        $("#gender").val("LLAKI");
      }else{
        $("#gender").val("PREMPUAN");
      }


      var now = new Date().getFullYear().toString();

      var decade = now.substr(0, 2);
      if (now.substr(2,2) > year) {
        year = parseInt(decade.concat(year.toString()), 10);
      }else{
        year = "19"+year;
      }

      var age = now-year;
      console.log(age);
      $("#umur").val(age);
    }else{
      $("#umur").val('');
      $("#gender").val('');
    }
  })

  jQuery(document).ready(function(){
    jQuery('.toast__close').click(function(e){
      e.preventDefault();
      var parent = $(this).parent('.toast');
      parent.fadeOut("slow", function() { $(this).remove(); } );
    });
  });

function preview(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
}

</script>
</body>

</html>
