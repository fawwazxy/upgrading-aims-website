<?php

  include ('../controller/auth.php');

  require "../model/aims_gl_function.php";

  date_default_timezone_set("Asia/Kuala_Lumpur");

  $id = $_GET['id'];
  $arrival_date = $_GET['arrival_date'];
$room_id = $_GET['room_id'];
$bed_id = $_GET['bed_id'];
$rr_info = getRoomReservById($id)->fetch_assoc();

 ?> 

                     
                      <form method="post" action="../controller/aims_gl_room_reserv_add_exec.php" >  
              <input id="booking_id" name="booking_id" type="hidden" value="<? echo $id?>"/>
              <input id="arrival_date" name="arrival_date" type="hidden" value="<? echo $arrival_date?>"/>
  <input id="room_id" name="room_id" type="hidden" value="<? echo $room_id?>"/>
  <input id="bed_id" name="bed_id" type="hidden" value="<? echo $bed_id?>"/>
  <input id="confirm_by" name="confirm_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
  <input id="confirm_company" name="confirm_company" type="hidden" value="<?php echo $_SESSION['SESS_DEPARTMENT'] ?>"/>
                              
                
                             
              <label><font color="red">** Maklumat Wajib Diisi.</font></label>
              <br>
               
               <div class="form-group row" align="left">
      <label class="control-label col-sm-2" for="ref_no">Ref No:</label>
      <div class="col-sm-10">
        <input class="form-control" type="text" id="ref_no" name="ref_no"  value="AGMSB/RR/GL/<?php echo date("y"); ?>-000">
      </div>
    </div>

    <div class="form-group row" align="left">
      <label class="control-label col-sm-2" for="reserv_date">Date:</label>
      <div class="col-sm-10">          
        <input class="form-control" type="date" id="reserv_date" name="reserv_date">
      </div>
    </div>

    <div class="form-group row" align="left">
      <label class="control-label col-sm-2" for="to">To:</label>
      <div class="col-sm-10">          
        <input class="form-control" type="text" id="to" name="to" value="GLOBAL LOUNGE">
      </div>
    </div>

    <div class="form-group row" align="left">
      <label class="control-label col-sm-2" for="fax">Fax:</label>
      <div class="col-sm-10">          
        <input class="form-control" type="text" id="fax" name="fax" value="09-6238848">
      </div>
    </div>

    <div class="form-group row" align="left">
      <label class="control-label col-sm-2" for="attend">Attendent:</label>
      <div class="col-sm-10">          
      <input class="form-control" type="text" id="attend" name="attend" value="<?php echo $_SESSION['SESS_NAME'] ?>">
      </div>
    </div>

    <div class="form-group row" align="left">
      <label class="control-label col-sm-2" for="from">From:</label>
      <div class="col-sm-10">          
        <input class="form-control" type="text" id="client_company_id" name="client_company_id" value="<? echo $rr_info['company_name'];?>">
      </div>
    </div>

    

    <div class="form-group row">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>  
         
          </form>
