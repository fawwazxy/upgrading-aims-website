<?php
	require "../model/menuleft_function.php";
?>


    	
<?php

 //$tahun = date('Y');

	$audit_ip  = $_SERVER['REMOTE_ADDR'];
	$audit_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$audit_user = $_SESSION['SESS_NO_STAFF'];
	
	//Call function
	$audit_insert = addAudit($audit_link,$audit_ip,$audit_user);
	
	if ($_SESSION['SESS_ROLE']=='') {
?>
		<a href="login.php"></a>
<?
	} 
?>

<?
    $data_sec = accessMenu($_SESSION['SESS_ROLE']);
    
    $i=0;
    $temp_module_code = "";
    while($accessMenu = $data_sec->fetch_assoc()) {

    	if($temp_module_code != $accessMenu['module_code']){
    		if($i > 0) echo '</ul></li>';
    		$i++;
?>
		   	<li>
			<a href="#" data-toggle="collapse" data-target="#menu<?echo $i;?>" class="collapsed" > <i class="fa fa-th-large"></i> <span class="nav-label"><?echo $accessMenu['module']?></span> <span class="fa fa-chevron-left pull-right"></span> </a>
			<ul class="sub-menu collapse" id="menu<?echo $i;?>">	
		<?
		}
		?>
		<!--display sub -->
	    <li>
	    	<a href="<? echo $accessMenu['link']?>?tahun=<? echo date('Y') ?>"><? echo $accessMenu['menu']?></a>
	    </li>
	    <!--end sub -->
	    <?if($temp_module_code != $accessMenu['module_code']){?>
			
		<?
		$temp_module_code = $accessMenu['module_code'];  
		
		}
		     
	}
	
	?> 

	                      