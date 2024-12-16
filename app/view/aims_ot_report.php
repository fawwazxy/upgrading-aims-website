<?php 
 
    include ('../controller/auth.php'); 
 
    require "../model/aims_ot_function.php"; 
 
    date_default_timezone_set("Asia/Kuala_Lumpur"); 
    $date_month = date(m); 
    $date_year = date(Y); 
    $date_day = date(d); 
    $time_hour = date(H); 
    $time_min = date(i); 
    $time_sec = date(s); 
 
    $sys = getSys(1)->fetch_assoc(); 
 
    $id = $_GET['id']; 
	$month = $_GET['month']; 
	$tahun = $_GET['tahun']; 
	$status = $_GET['review_status'];
    $staff = getStaffss($id,$month)->fetch_assoc();
	$staffs = getOtClaimReportSign($id,$month,$status,$tahun)->fetch_assoc();
	$staff_rate = getOtClaimReportRate($id,$month,$status,$tahun)->fetch_assoc();
	
?> 
 
<!DOCTYPE html> 
<html> 
     
    <title>OVERTIME FORM <? echo $staffs['name']?></title> 
    <head> 
    <script src="../../js/jquery/jquery.min.js"></script> 
    <script src="../../js/html2canvas/html2canvas.js"></script> 
 
        <style type="text/css"> 
        i{ 
            font-family: "Arial"; 
        } 
        body {       
            font-family: Arial; 
            font-size: 11px; 
        } 
        input{ 
            padding: 5px; 
        } 
        form{ 
            float: right; 
        } 
        .invoice { 
        float:center; 
        }
         
        /*.pagebreak {  
            page-break-before: always;  
        } 
         
        div.company-address { 
            border:1px solid #ccc; 
            float:left; 
            width:200pt; 
        }*/ 
          
        /*div.invoice-details { 
            border:0px solid #ccc; 
            float:right; 
            width:200pt; 
        }*/ 
          
        /*div.customer-address { 
            border:1px solid #ccc; 
            float:right; 
            margin-bottom:50px; 
            margin-top:100px; 
            width:200pt; 
        }*/ 
          
        /*div.clear-fix { 
            clear:both; 
            float:none; 
        }*/ 
 
        .finance{ 
            width: 20%; 
            float: right; 
            border-collapse: collapse; 
        } 
        
        table.finance td:empty::after{
            content: "\00a0";
        }
          
        table { 
            width:100%; 
   
        } 
		
		table.staff { 
            padding:0px; 
   
        } 
  
        table.one { 
			width: 100%;
			border-collapse: collapse;
			margin-top:0%;
   
        } 
		
		table.one th {
			padding: 8px;
			border:1px solid ;
		}

		table.one td {
			padding: 2px;
			text-align: center;
			border-right: 1px solid;
			border-left: 1px solid;
			border-bottom: 1px solid;
			border-top: none;
		}
		
        th { 
            text-align: left; 
           
        } 
  
        .text-left { 
            text-align:left; 
        } 
          
        .text-center { 
            text-align:center; 
        } 
          
        .text-right { 
            text-align:right; 
        } 
 
        .text-top { 
            text-align:top; 
        }
 
 
    @media print { 
        #printPageButton { 
        display: none; 
    } 
    }  
 
    @media print { 
      #html-content-holder { 
        display: none; 
      } 
      #btn-Preview-Image { 
        display: none; 
      } 
	  #btn-Preview-Image2 { 
        display: none; 
      }
    }  
    table { page-break-inside:auto } 
    tr { page-break-inside:avoid; page-break-after:auto } 
 
    .colorbox{ 
        float: left; 
        width: 50px; 
        height: 20px;
        margin: 5px; 
        border: 1px solid rgba(0, 0, 0, .2); 
    } 
 
    img { 
      float: left; 
    } 
   
    .tooltip .tooltiptext { 
      visibility: hidden; 
      width: 120px; 
      background-color: #428BCA; 
      color: #fff; 
      text-align: center; 
      border-radius: 4px; 
      padding: 5px 0; 
     
    } 
     
    .tooltip:hover .tooltiptext { 
      visibility: visible; 
    } 
	
	#wrapper{
        margin-left:auto;
        margin-right:auto;
        height:auto; 
        width:auto;
    }
	
	#inner1 {
		float:left; 
	}
	
	#innertable {
		float:right; 
	}

	
	#inner2{
	   float:left; 
	   clear: left;
	   width:100%;
	}
	
 
	
    </style> 
 
    <script type="text/javascript"> 
  
        function SwapDivsWithClick(div1,div2) 
        { 
           d1 = document.getElementById(div1); 
           d2 = document.getElementById(div2); 
           if( d2.style.display == "none" ) 
           { 
              d1.style.display = "none"; 
              d2.style.display = "block"; 
           } 
           else 
           { 
              d1.style.display = "block"; 
              d2.style.display = "none"; 
           } 
        } 
 
</script> 
 
    </head> 
  
    <body> 
<div id="wrapper1">
 <div id="inner1">
    <div class="tooltip" id="swapper-first" style="display:block;" onclick="SwapDivsWithClick('swapper-first','swapper-other')"> 
    <span class="tooltiptext">Click on Image to change logo</span> 
    <img id="logo" src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;"/> 
    </div> 
 
    <div id="swapper-other" style="display:none;" onclick="SwapDivsWithClick('swapper-first','swapper-other')"> 
        <img id="logo" src="../../resources/images/avsb-logo.PNG" style="width:440px;height:90px;margin-left:15px;"/> 
    </div> 
	
	
	
 </div>
 
 <div id="innertable1"> 
        <table class="finance" border="2"> 
            <tr> 
                <th colspan="4" style="padding-left:2%" >HR Use</th> 
            </tr> 
			<tr>
				<td style="text-align:center;"><b>1.5</b></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['r1_5']; ?></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['s1_5']; ?></td>
				<td style="text-align:right;padding-right:1%" width="25%"><? echo $staff_rate['t1_5']; ?></td>
			</tr>
			<tr>
				<td style="text-align:center;"><b>2</b></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['r2']; ?></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['s2']; ?></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['t2']; ?></td>
			</tr>
			<tr>
				<td style="text-align:center;"><b>3</b></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['r3']; ?></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['s3']; ?></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['t3']; ?></td>
			</tr>
			<tr>
				<td><b></b></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['r4']; ?></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['s4']; ?></td>
				<td style="text-align:right;padding-right:1%"><? echo $staff_rate['t4']; ?></td>
			</tr>
            <tr> 
                <td colspan="3" style="padding-left:2%" ><b>Total</b></td> 
                <td style="text-align:right;padding-right:1%"><? echo $staff_rate['total_monthclaim']; ?></td> 
            </tr> 
         <!--   <tr> 
                <td>Less : Expenditure</td> 
                <td> </td> 
            </tr> 
            <tr> 
                <td>Refund</td> 
                <td> </td> 
            </tr> 
            <tr> 
                <td>Outstanding</td> 
                <td> </td> 
            </tr>  -->
             
        </table> 
    </div>
</wrapper>
 
 <div id="inner2">
      
          <div> 
                <center><h2>OVERTIME FORM</h2></center> 
            </div> 
            <br> 
            <div class="invoice"> 
 
            <table class="staff" style="padding:0px" border='0' cellspacing='0'> 
 
            <tr> 
            <td height='20px' width="3%"><b>NAME </b></td> 
            <td height='20px' width="40%" >: <?echo $staff['staff_name'] ;?></td> 
 
			<td height='20px' width="3"><b>POSITION </b></td> 
            <td height='20px' width="40%">: <?echo $staff['position']; ?></td> 
            </tr> 
 
            <tr> 
            <td height='20px' width="3%"><b>I/C NO. </b></td> 
            <td height='20px' width="40%">: <?echo $staff['noic'];?></td> 
			
			<td rowspan="2" height='20px' width="3%"><b>MONTH </b></td> 
            <td rowspan="2" height='20px' width="40%" >: <?echo $staff['month_claim'] ;?></td>
            </tr>
              
            <tr> 
            <td height='20px' width="3%"><b>COMPANY </b></td> 
            <td height='20px' width="40%">: <?echo $staff['department_id']; ?></td> 
            </tr> 
        </table> 
    </div> 
	
    
    <input type="hidden" width="30%" name="staff_record_id" id="staff_record_id" value="<? echo $id;?>" >
						<input type="hidden" class="form-control" name="month_claim" id="month_claim" value="<? echo $month;?>">
						<input type="hidden" class="form-control" name="status" id="status" value="<? echo $status;?>">
						<input type="hidden" class="form-control" name="tahun" id="tahun" value="<? echo $tahun;?>">
						
	<p padding="0px">Please be informed that the employee is allowed to work overtime outside normal office hours.<p>
    <table class="one" border="1">
				<thead>
				<tr>
				<th style="text-align:center;" width="8%" rowspan= "2">DATE</th>
				<th style="text-align:center;" width="8%" rowspan= "2">DAY</th>
				<th style="text-align:center;" width="11%" colspan="2">TIME</th>
				<th style="text-align:center;" width="6%" rowspan= "2">WORKING PERIOD</th>
				<th style="text-align:center;" width="6%" rowspan= "2">TYPES OF CLAIM</th>
				<th style="text-align:center;" width="40%" rowspan= "2">WORK DESCRIPTION</th>
				<th style="text-align:center;" width="10%" rowspan= "2">REMARK</th>
				<th style="text-align:center;" width="10%" rowspan= "2">STATUS</th>
				 
				</tr>
  
			  <tr style="border:1px solid;">  
				<td style="text-align:center;"><b>START</b></td>
				<td style="text-align:center;"><b>END</b></td> 
			  </tr>
			  <thead>
				<tbody>
				<?
                                    $staff = getOtClaimReport($id,$month,$status,$tahun);
                                    $i=1;
                                    while($staff_info = $staff->fetch_assoc()) {
									$start_ot= date('h:i a', strtotime($staff_info['start_ot']));
									$end_ot= date('h:i a', strtotime($staff_info['end_ot']));
									$date_ot= new DateTime($staff_info['date_ot']); 
									$i++;
                                ?>
								
				<tr>
				<td align="center" type="text" size="10" name="date_ot"><? echo $date_ot->format('d-m-Y'); ?></td>
				<td  align="center" type="text" size="10" name="day_ot"><? echo $staff_info['day_ot']; ?></td>
				<td  align="center" type="text" size="15" name="time"><? echo $start_ot; ?></td>
				<td  align="center" type="text" size="15" name="time"><? echo $end_ot; ?></td>
				<td  align="center" type="text" size="10" name="working_hours"><? echo $staff_info['working_hours']; ?></td>
				<td  align="center" type="text" size="10" name="type_claim"><? echo $staff_info['type_claim']; ?></td>
				<td  align="center" type="text" size="20" name="description_ot" ><? echo $staff_info['description_ot']; ?></td>
				<td  align="center" type="text" size="10" name="review_remark"><? echo $staff_info['review_remark']; ?></td>
				<td  align="center" type="text" size="10" name="review_remark">HR: <? echo $staff_info['review_status']; ?><br>
				CEO: <? if ($staff_info['approved_status']=='PENDING'){ echo "<span style='font-weight:bold;color:RED;'>PENDING</span>";} 
				else {echo $staff_info['approved_status'];} ?></td>
				</tr>
				
					<?}?>
						</tbody>
				</table>
   <br> 
 
             
 
            <br><br><br> 
 
			<table border='0' cellspacing='0' width="100%" style="margin-left:auto; margin-right: auto;">
			<tr>
			<th style="text-align:left;" height="30px">APPLIED BY :</th>
			<th style="text-align:left;" height="30px">VERIFIED BY :</th>
			<th style="text-align:left;" height="30px">APPROVED BY :</th>
			</tr>
			<?
			
			$created_date= new DateTime($staffs['created_date']);
			$verify_date= new DateTime($staffs['verify_date']);
			$approved_date= new DateTime($staffs['approved_date']);
			
			?>
			
			<tr>
			<td>
				<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPLIED</span><br><br>
			
			<b>NAME :</b> <? echo $staffs['staff_name']; ?><br><br><b>DATE :</b> <? echo $created_date->format('d-m-Y'); ?>
			</td>
			<td>
			<?
			if($staffs['verify_status']== 'PENDING'){ 
				echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span><br><br>";}
			else if ($staffs['verify_status']== 'VERIFIED') {
				echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>
				<br><br><b>NAME :</b> ".$staffs['verify_by']."<br><br><b>DATE :</b> ".$verify_date->format('d-m-Y');}
			else { 
				echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>REJECTED</span><br><br>";}
			?> 
			
			
			</td>
			<td>
			<?
			if($staffs['approved_status']== 'PENDING'){ 
				echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span><br><br>";}
			else if ($staffs['approved_status']== 'APPROVED') {
				echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>
				<br><br><b>NAME :</b> ".$staffs['approved_by']."<br><br><b>DATE :</b> ".$approved_date->format('d-m-Y');}
			else { 
				echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span><br><br>";}
			?> 
			
			</td>
			</tr>
			
			
			</table>
  
   
    <div style="text-align:center;"> 
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Print"/>
			&nbsp;&nbsp;&nbsp;
		<input id="btn-Preview-Image2" type="button" value="Close" onclick="self.close()">
    <br><br> 
	</div> 
 </div> 
 
 
             
    </body> 
 
    <script> 
    $(document).ready(function() { 
         //window.onload = function() { window.print(); } 
    }); 
 
 
    </script> 
</html>