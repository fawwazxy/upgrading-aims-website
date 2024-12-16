<?php

  //include ('../controller/auth.php');
  
  require "../model/lookup.php";

 $no_staff = $_POST["no_staff"];
    date_default_timezone_set("Asia/Kuala_Lumpur");
  $date_year = date(Y);
  $current_date = $date_year;

  //date_default_timezone_set("Asia/Kuala_Lumpur");
  $current_year=date("Y");
  $year=$_GET['year'];
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
    
    <br><form method="post" action="../controller/aims_contractor_add_exec.php" enctype="multipart/form-data">
      <div class="form-group" align="left">
       <label>Full Name<font color="red">&nbsp;**</font></label>
       <input name="name" id="name" type="text" class="form-control" onkeyup="convertToUppercase(this)" value="" required >
     </div>
     
     <div class="form-group" align="left">
       <label>IC Number (without  -) <font color="red">&nbsp;**</font></label>
       <input name="no_staff" id="no_staff" type="text" class="form-control" value="" required autocomplete="" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="12" >
     </div>

     <div class="form-group" align="left">
       <label>Age<font color="red">&nbsp;**</font></label>
       <input id="umur" name="umur" type="text" class="form-control"value="" required value="" autocomplete="" maxlength="3" onkeyup="this.value=this.value.replace(/[^\d]/,'')"/>
     </div>

     <div class="form-group" align="left">
       <label for="gender" class="label-title">Gender <font color="red">&nbsp;**</font></label>
       <select name="gender" id="gender" class="form-control" required >
        <option value=" ">--Please Choose--</option>
        <option value="LLAKI">Man</option>
        <option value="PREMPUAN">Woman</option>
      </select>
    </div>
    
    <div class="form-group" align="left">
     <label>Phone Number<font color="red">&nbsp;** (e.g: 0123456789)</font></label>
     <input id="phone" name="phone" type="text" class="form-control" value="" required>
   </div>   
   
   
   <div class="form-group" align="left">
    <label>Email</label>
    <input name="email" id="email" type="text" class="form-control" value="">
  </div>
  
  <div class="form-group" align="left">
    <label>Company <font color="red">&nbsp;**</font></label>
    <input name="syarikat" id="syarikat" type="text" class="form-control" onkeyup="convertToUppercase(this)" value="" required>
  </div>

  <div class="form-group" align="left">
    <label for="category_id" class="label-title">Category <font color="red">&nbsp;**</font></label>
    <select name="category_id" id="category_id" class="form-control" required>
      <option value=" ">--Please Choose--</option>
      <option value="CONTRACTOR">Contractor</option>
      <option value="VISITOR">Visitor</option>
    </select>
  </div>
  
  <div class="form-group" align="left">
    <label>Purpose <font color="red">&nbsp;(Visitor only)</font></label>
    <input name="purpose" id="purpose" type="text" class="form-control" onkeyup="convertToUppercase(this)" value="">
  </div>

  <div class="form-group" align="left">
    <label>Vaccine Certificate&nbsp;<font color="red"><i>(Only jpeg/jpg/png/pdf format files are allowed)</i></font></label>
    <input type="hidden" name="MAX_FILE_SIZE">
    <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">   
  </div>
                
                <div class="toast__container">
                <div class="toast__cell">
                <div class="toast toast--green">
                  <div class="toast__icon">
                    <svg version="1.1" class="toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <g><g><path d="M504.502,75.496c-9.997-9.998-26.205-9.998-36.204,0L161.594,382.203L43.702,264.311c-9.997-9.998-26.205-9.997-36.204,0    c-9.998,9.997-9.998,26.205,0,36.203l135.994,135.992c9.994,9.997,26.214,9.99,36.204,0L504.502,111.7    C514.5,101.703,514.499,85.494,504.502,75.496z"></path>
                	</g></g>
                    </svg>
                  </div>
                  <div class="toast__content">
                    <p class="toast__type">Registration & Apps Login Step (English)</p>
                    <p class="toast__message"><b>1.</b> Fill up the form and submit.
                    <br><b>2.</b> Install apps iOffice.<br>Username: IC Number<br>Password: IC Number<br>Domain: aimsglobal.com.my/aims (Copy this)
                    <br><b>3.</b> Click 'Kehadiran' → 'IMBASAN QR-CODE' → 'MASUK' → Scan location QR-Code.
                    <br><b>4.</b> Congratulations! You successfully record your visit into our system.</p>
                  </div>
                  <div class="toast__close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                  <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                </svg>
                  </div>
                </div>
                </div>
                </div>
                
                <div class="toast toast--blue add-margin">
                  <div class="toast__icon">
                <svg version="1.1" class="toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                <g>
                	<g id="info">
                		<g>
                			<path  d="M10,16c1.105,0,2,0.895,2,2v8c0,1.105-0.895,2-2,2H8v4h16v-4h-1.992c-1.102,0-2-0.895-2-2L20,12H8     v4H10z"></path>
                			<circle  cx="16" cy="4" r="4"></circle>
                		</g>
                	</g>
                </g>
                
                    </svg>
                  </div>
                  <div class="toast__content">
                    <p class="toast__type">Langkah Pendaftaran & Log Masuk Aplikasi (B.Melayu)</p>
                    <p class="toast__message"><b>1.</b> Isi borang diatas dan tekan 'Submit'.
                    <br><b>2.</b> Muat turun aplikasi iOffice.<br>Nama: Nombor IC<br>Kata Laluan: Nombor IC<br>Domain: aimsglobal.com.my/aims (Salin)
                    <br><b>3.</b> Klik 'Kehadiran' → 'IMBASAN QR-CODE' → 'MASUK' → Imbas Kod-QR lokasi.
                    <br><b>4.</b> Tahniah! Anda berjaya merekod lawatan anda ke dalam sistem kami.</p>
                  </div>
                  <div class="toast__close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                  <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                </svg>
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
       
        
         </script>
</body>

</html>
