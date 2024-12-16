	<?php

$approved = $_GET['app_status'];
if (!isset($approved) && $approved == '') {
    $approved = '0';
    }
$verified = $_GET['ver_status'];
if (!isset($verified) && $verified == '') {
    $verified = '0';
    }

$approve = $_GET['approved_status'];
if (!isset($approve) && $approve == '') {
    $approve = '0';
    }
$verifieds = $_GET['verified_status'];
if (!isset($verifieds) && $verifieds == '') {
    $verifieds = '0';
    }	
	
$role_id = $_SESSION['SESS_ROLE'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$name = $_SESSION['SESS_NAME'];
$leave_approval = $_GET['leave_approval'];
$no_staff = $_SESSION['SESS_NO_STAFF'];	
?>


	
	<style>
	


/**
 * Notification variables
 * =============================================================================
 */
$notification-spacer-y: 1rem;

$notification-padding-y: 0.5rem;
$notification-padding-x: 0.75rem;

$notification-border-width: 0.0625rem;
$notification-border-radius: .25rem;

$notification-font-size: 1rem;
$notification-line-height: 1.5rem;

// Colors
$notification-primary-color: silver;
$notification-error-color: tomato;
$notification-warning-color: gold;
$notification-info-color: skyblue;
$notification-success-color: limegreen;

// Types
$notification-types: (
  "error": $notification-error-color,
  "warning": $notification-warning-color,
  "info": $notification-info-color,
  "success": $notification-success-color
);

/**
 * Notification mixins
 * =============================================================================
 */
@mixin notification-type($color) {
  color: mix($color, black, 8% * 3);
  background-color: lighten($color, 8% * 2);
  border-color: darken($color, 8%);
}

/**
 * Notification
 * @requires close
 * @requires notification.variables
 * @requires notification.mixins
 * {@link https://codepen.io/belyan/full/odLorq/ Examples}
 * =============================================================================
 */
.notification {
  position: relative;
  padding: $notification-padding-y $notification-padding-x;
  
  border: $notification-border-width solid transparent;
  border-radius: $notification-border-radius;
  
  font-size: $notification-font-size;
  line-height: $notification-line-height;
  
  & + & {
    margin-top: $notification-spacer-y;
  }
  
  @include notification-type($notification-primary-color);
  
  @each $type, $color in $notification-types {
    &-#{$type} {
      @include notification-type($color);
    }
  }
  
  &-heading {
    color: inherit;
    line-height: inherit;
  }
  
  &-closable {
    padding-right: ($close-font-size + $notification-padding-x * 2);
    
    // Adjust close link position
    .close {
      position: absolute;
      top: 0;
      right: 0;
      padding: $notification-padding-y $notification-padding-x;
      color: inherit;
    }
  }
}

// Override styles from github markdown
.notification h4 {
  margin-top: 0;
  margin-bottom: 0.5rem;
}

.notification p {
  margin-bottom: 0;
}

.m2{
	border-width: 0.0625rem;
    border-radius: .25rem;
}

    </style>
	
<!--approve ssa n ssr-->				
			<?
			if($approved == '0' && ($role_id == 'HOD' || $_SESSION['SESS_NO_STAFF'] == '740915115003') ) {
            $ssa= approvessa();
									
			while($row_ssa = $ssa->fetch_assoc()){?>
									
			<?
			if ($row_ssa['jumlah'] > 0) {
			?>				
					
            <div class="notification notification-warning notification-closable" role="alert" style="background-color: #228B22; border-width: 0.0625rem; border-radius: .25rem;padding:1rem">
            <strong>ATTENTION</strong> You have <b><?php echo $row_ssa['jumlah']; ?></b> approvement for <b>SSA</b>.
            <button type="button" class="close" data-close="notification">
            <span>&times;</span>
            </button>
            </div>
					
						
			<?}?>	
			<?}?>
			<?}?>
			
			
			<?
			if($approve == '0' && ($role_id == 'HOD' || $_SESSION['SESS_NO_STAFF'] == '740915115003')) {
            $ssr= approvessr();
									
			while($row_ssr = $ssr->fetch_assoc()){?>
									
			<?
			if ($row_ssr['jumlah'] > 0) {
			?>				
					
            <div class="notification notification-warning notification-closable" role="alert" style="background-color: #228B22; border-width: 0.0625rem; border-radius: .25rem;padding:1rem">
            <strong>ATTENTION</strong> You have <b><?php echo $row_ssr['jumlah']; ?></b> approvement for <b>SSR</b>.
            <button type="button" class="close" data-close="notification">
            <span>&times;</span>
            </button>
            </div>
					
						
			<?}?>	
			<?}?>
			<?}?>
			
	<!--verified ssa n ssr-->

			<?
			if($verified == '0') {
            $ssa= verifiedssa();
									
			while($row_ssa = $ssa->fetch_assoc()){?>
									
			<?
			if ($row_ssa['jumlah'] > 0) {
			?>				
					
            <div class="notification notification-warning notification-closable" role="alert" style="background-color: #FFA500; border-width: 0.0625rem; border-radius: .25rem;padding:1rem">
            <strong>ATTENTION</strong> You have <b><?php echo $row_ssa['jumlah']; ?></b> Verified for <b>SSA</b>.
            <button type="button" class="close" data-close="notification">
            <span>&times;</span>
            </button>
            </div>
					
						
			<?}?>	
			<?}?>
			<?}?>
			

			<?
			if($verifieds == '0') {
            $ssr= verifiedssr();
									
			while($row_ssr = $ssr->fetch_assoc()){?>
									
			<?
			if ($row_ssr['jumlah'] > 0) {
			?>				
					
            <div class="notification notification-warning notification-closable" role="alert" style="background-color: #FFA500; border-width: 0.0625rem; border-radius: .25rem;padding:1rem">
            <strong>ATTENTION</strong> You have <b><?php echo $row_ssr['jumlah']; ?></b> Verified for <b>SSR</b>.
            <button type="button" class="close" data-close="notification">
            <span>&times;</span>
            </button>
            </div>
					
						
			<?}?>	
			<?}?>
			<?}?>	