<?php 

require "../model/notification.php";

//STEP 1: call function noti here
  //  $leave_support = getnotiLeaveSupport($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
  //  $leave_approve = getnotiLeaveApprove($_SESSION['SESS_NO_STAFF'],$_SESSION['SESS_DEPARTMENT_SUB']);
    $inout_verify = getnotiInoutVerify($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME'])->fetch_assoc();
    $inout_approve = getnotiInoutApprove($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF'])->fetch_assoc();
    $travel_verifyhod = getnotiTravel($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME'])->fetch_assoc();
    $travel_approve = getnotiTravelApproved($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME'])->fetch_assoc();
    $otpermission_approve = getnotiOtPermissionNew($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF'])->fetch_assoc();
    $ot_verifyhod = getnotiOtHod($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NO_STAFF'])->fetch_assoc();
    $ot_reviewhr = getnotiOtHr($_SESSION['SESS_DEPARTMENT_SUB'])->fetch_assoc();
    $ot_approveceo = notiOtCeo($_SESSION['SESS_DEPARTMENT'],$_SESSION['SESS_NO_STAFF'])->fetch_assoc();
    $claim_verify = getnotiClaimVer($_SESSION['SESS_NO_STAFF'],$_SESSION['SESS_DEPARTMENT_SUB'])->fetch_assoc();
    $claim_reviewhr = getnotiClaimReview($_SESSION['SESS_DEPARTMENT_SUB'])->fetch_assoc();
    $claim_approveceo = getnotiClaimApprove($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
  //  $car_requesthod = getnoticarRequestHod($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME'])->fetch_assoc();


?>

    <style>


.faa-ring {
    color: red
}

@-webkit-keyframes ring {
    0% {
        -webkit-transform: rotate(-15deg);
        transform: rotate(-15deg)
    }

    2% {
        -webkit-transform: rotate(15deg);
        transform: rotate(15deg)
    }

    4% {
        -webkit-transform: rotate(-18deg);
        transform: rotate(-18deg)
    }

    6% {
        -webkit-transform: rotate(18deg);
        transform: rotate(18deg)
    }

    8% {
        -webkit-transform: rotate(-22deg);
        transform: rotate(-22deg)
    }

    10% {
        -webkit-transform: rotate(22deg);
        transform: rotate(22deg)
    }

    12% {
        -webkit-transform: rotate(-18deg);
        transform: rotate(-18deg)
    }

    14% {
        -webkit-transform: rotate(18deg);
        transform: rotate(18deg)
    }

    16% {
        -webkit-transform: rotate(-12deg);
        transform: rotate(-12deg)
    }

    18% {
        -webkit-transform: rotate(12deg);
        transform: rotate(12deg)
    }

    20% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg)
    }
}

@keyframes ring {
    0% {
        -webkit-transform: rotate(-15deg);
        -ms-transform: rotate(-15deg);
        transform: rotate(-15deg)
    }

    2% {
        -webkit-transform: rotate(15deg);
        -ms-transform: rotate(15deg);
        transform: rotate(15deg)
    }

    4% {
        -webkit-transform: rotate(-18deg);
        -ms-transform: rotate(-18deg);
        transform: rotate(-18deg)
    }

    6% {
        -webkit-transform: rotate(18deg);
        -ms-transform: rotate(18deg);
        transform: rotate(18deg)
    }

    8% {
        -webkit-transform: rotate(-22deg);
        -ms-transform: rotate(-22deg);
        transform: rotate(-22deg)
    }

    10% {
        -webkit-transform: rotate(22deg);
        -ms-transform: rotate(22deg);
        transform: rotate(22deg)
    }

    12% {
        -webkit-transform: rotate(-18deg);
        -ms-transform: rotate(-18deg);
        transform: rotate(-18deg)
    }

    14% {
        -webkit-transform: rotate(18deg);
        -ms-transform: rotate(18deg);
        transform: rotate(18deg)
    }

    16% {
        -webkit-transform: rotate(-12deg);
        -ms-transform: rotate(-12deg);
        transform: rotate(-12deg)
    }

    18% {
        -webkit-transform: rotate(12deg);
        -ms-transform: rotate(12deg);
        transform: rotate(12deg)
    }

    20% {
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg)
    }
}

.faa-ring.animated,
.faa-ring.animated-hover:hover,
.faa-parent.animated-hover:hover>.faa-ring {
    -webkit-animation: ring 2s ease infinite;
    animation: ring 2s ease infinite;
    transform-origin-x: 50%;
    transform-origin-y: 0px;
transform-origin-z: initial
}

span.red {
  background: RED;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
}


.top-text-block{
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: 400;
  line-height: 1.42857143;
  color: #333;
  white-space: inherit !important;
  border-bottom:1px solid #f4f4f4;
  position:relative;
  &:hover {
        &:before {
        content: '';
        width: 4px;
        background: #f05a1a;
        left: 0;
        top: 0;
        bottom: 0;
        position: absolute;
    }
  }
  &.unread {
    background:#ffc;
    
    // &:hover {
    //   background:#ffd;
    // }
  }
  
  .top-text-light {
    // color:#ccc;
    color: #999;
    font-size: 0.8em;
  }
}   

.top-head-dropdown {
  .dropdown-menu {
  
    overflow:auto;
  }
  
  li:last-child{
    .top-text-block {
      border-bottom:0;
    }
  }
}
.topbar-align-center {
  text-align: center;
}

</style>

    <!-- Single button -->
    <div class="btn-group top-head-dropdown" style="padding:3px;float:right">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?
		
// STEP 2: tambah count dari call function atas dekat sini

		$noticount = $inout_approve['total'] + $inout_verify['total'] + $travel_verifyhod['total'] + $travel_verifyceo['total'] + $travel_approve['total'] 
		+ $otpermission_approve['total'] + $ot_verifyhod['total'] + $ot_approveceo['total'] + $claim_verify['total'] + $claim_approveceo['total'] + $car_requesthod['total'];   //+ belakang ;
		
		
	// if else Bell animation start
		if($noticount > 0){?>
		<div class="ringing-bell"><i class='fa fa-bell faa-ring animated fa-2x'></i><i class="fa fa-caret-down"></i>
		</div>
		<? } else if($noticount == 0){ ?>
		
		<i class='fa fa-bell fa-2x'></i><i class="fa fa-caret-down"></i>
		
		<?} //end ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-right" style="width: 300px;">
	 
	<?
	// dropdown listing start
		$i= 1;
        
	
// STEP 3: tambah listing baru dekat <li></li> baru dekat bawah sekali
           ?>
		  
           
           <?
		   if($inout_verify['total'] > 0){
	?>
        <li>
          <a href="../view/aims_list_verified_approve.php" class="top-text-block">
            <div class="top-text-heading">In Out Verification <span class="red" style="float:right"><? echo $inout_verify['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		   <?
		   if($inout_approve['total'] > 0){
	?>
        <li>
          <a href="../view/aims_list_approveinout.php" class="top-text-block">
            <div class="top-text-heading">In Out Approvement <span class="red" style="float:right"><? echo $inout_approve['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		 <?
		   if($travel_verifyhod['total'] > 0){
	?>
        <li>
          <a href="../view/aims_travel_requestlist.php" class="top-text-block">
            <div class="top-text-heading">Travel Verification <span class="red" style="float:right"><? echo $travel_verifyhod['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		 
		 <?
		   if($travel_verifyceo['total'] > 0){
	?>
        <li>
          <a href="../view/aims_travel_verificationCeo.php" class="top-text-block">
            <div class="top-text-heading">Travel Verification <span class="red" style="float:right"><? echo $travel_verifyceo['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($travel_approve['total'] > 0){
	?>
        <li>
          <a href="../view/aims_travel_listCeo.php" class="top-text-block">
            <div class="top-text-heading">Travel Approvement <span class="red" style="float:right"><? echo $travel_approve['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($otpermission_approve['total'] > 0){
	?>
        <li>
          <a href="../view/aims_otpermission_approve.php" class="top-text-block">
            <div class="top-text-heading">Overtime Permission Approvement <span class="red" style="float:right"><? echo $otpermission_approve['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($ot_verifyhod['total'] > 0){
	?>
        <li>
          <a href="../view/aims_ot_hod_list.php" class="top-text-block">
            <div class="top-text-heading">Overtime Verification <span class="red" style="float:right"><? echo $ot_verifyhod['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($ot_reviewhr['total'] > 0 && $_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){
	?>
        <li>
          <a href="../view/aims_ot_hr_list.php" class="top-text-block">
            <div class="top-text-heading">Overtime Review <span class="red" style="float:right"><? echo $ot_reviewhr['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($ot_approveceo['total'] > 0){
	?>
        <li>
          <a href="../view/aims_ot_ceo_list.php" class="top-text-block">
            <div class="top-text-heading">Overtime Approvement <span class="red" style="float:right"><? echo $ot_approveceo['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($claim_verify['total'] > 0){
	?>
        <li>
          <a href="../view/aims_others_claim_hod_list.php" class="top-text-block">
            <div class="top-text-heading">Claim Verification <span class="red" style="float:right"><? echo $claim_verify['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($claim_reviewhr['total'] > 0 && $_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){
	?>
        <li>
          <a href="../view/aims_others_claim_hr_list.php" class="top-text-block">
            <div class="top-text-heading">Claim Review <span class="red" style="float:right"><? echo $claim_reviewhr['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($claim_approveceo['total'] > 0 && $_SESSION['SESS_ROLE_ID'] == 'FOUNDER'){
	?>
        <li>
          <a href="../view/aims_others_claim_ceo_list.php" class="top-text-block">
            <div class="top-text-heading">Claim Approvement <span class="red" style="float:right"><? echo $claim_approveceo['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   
		    <?
		   if($car_requesthod['total'] > 0){
	?>
        <li>
          <a href="../view/aims_car_hod_list.php" class="top-text-block">
            <div class="top-text-heading">Transport Approvement <span class="red" style="float:right"><? echo $car_requesthod['total'];?></span></div>
          </a> 
        </li>
		   <?}?>
		   


<? //ADD NEW <li> ABOVE THIS	  ?>

		 <?
		   if($noticount == 0){
	?>
        <li>
          <a href="#" class="top-text-block">
            <div class="top-text-heading" style="align:center">No Notification</div>
          </a> 
        </li>
	       <? } ?>
	       
	<? //} End Listing?>
      
	  
	  </ul>
</div>


