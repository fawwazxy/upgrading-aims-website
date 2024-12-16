<?php 
 
    include ('../controller/auth.php'); 
 
    require "../model/aims_others_claim_function.php"; 
 
    date_default_timezone_set("Asia/Kuala_Lumpur"); 
    
    $date_year = date(Y); 
    $date_day = date(d); 
    $time_hour = date(H); 
    $time_min = date(i); 
    $time_sec = date(s); 
 
    $sys = getSys(1)->fetch_assoc(); 
 
    $id = $_GET['id'];
	$claim_id = $_GET['claim_id']; 
	$tahun = $_GET['tahun']; 
	$status = $_GET['hr_review_status'];
    $staff = getStaffss($claim_id,$company)->fetch_assoc();
	$staffs = getOtherclaimreport($claim_id,$status,$tahun)->fetch_assoc();
	$total = getTotal_claim($claim_id,$tahun,$company)->fetch_assoc();
?> 
 
<!DOCTYPE html> 
<html> 
     
    <title>iOffice::Sistem Pengurusan Pejabat Bersepadu</title> 
    <head> 
    <script src="../../js/jquery/jquery.min.js"></script> 
    <script src="../../js/html2canvas/html2canvas.js"></script> 
 
        <style type="text/css"> 
        i{ 
            font-family: "Times New Roman"; 
        } 
        body {       
            font-family: Times New Roman; 
            font-size: 15px; 
        } 
        input{ 
            padding: 5px; 
        } 
        form{ 
            float: right; 
        } 
        /*.invoice { 
        border:0px solid #ccc; 
        padding:10px; 
        height:60%; 
        width:99%; 
        }*/ 
         
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
          
        table { 
            width:100%; 
   
        } 
  
        table.one { 
			width: 100%;
			border-collapse: collapse;
   
        } 
		
		table.one th {
		padding: 8px;
		border:1px solid ;
		}

		table.one td {
		padding: 8px;
		text-align: center;
		border-right: 1px solid;
		border-left: 1px solid;
		border-bottom: none;
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
 
        <div class="tooltip" id="swapper-first" style="display:block;" onclick="SwapDivsWithClick('swapper-first','swapper-other')"> 
    <span class="tooltiptext">Click on Image to change logo</span> 
    <img id="logo" src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;"/> 
    </div> 
 
    <div id="swapper-other" style="display:none;" onclick="SwapDivsWithClick('swapper-first','swapper-other')"> 
        <img id="logo" src="../../resources/images/avsb-logo.PNG" style="width:440px;height:90px;margin-left:15px;"/> 
    </div> 
 
    <div> 
        <table class= "finance" border="2"> 
            <tr> 
                <th width="10%">Finance Use</th> 
                <th width="10%"></th> 
            </tr> 
 
            <tr> 
                <td>Advance</td> 
                <td><?php echo $staffs['advance']; ?></td> 
            </tr> 
            <tr> 
                <td>Less : Expenditure</td> 
                <td><?php echo $total['total_expenses']; ?></td> 
            </tr> 
            <tr> 
                <td>Refund</td> 
                <td><?php echo $staffs['refund']; ?></td> 
            </tr> 
            <tr> 
                <td>Outstanding</td> 
                <td><?php echo $staffs['outstanding']; ?></td> 
            </tr> 
             
        </table> 
    </div> 
 
    <br><br><br><br><br> 
          <div> 
                <center><h3>CLAIM FORM</h3></center> 
            </div> 
            <br> 
            <div class="invoice"> 
 
            <table border='0' cellspacing='0'> 
 
            <tr> 
            <td height='20px' width="9%"><b>Staff Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></td> 
            <td height='20px' width="35%"><?echo $staff['staff_name'] ;?></td> 
 
            <td rowspan="2" height='20px' width="10%"><b>Claim For Month&nbsp;&nbsp;&nbsp;:</b></td> 
            <td rowspan="2" height='20px' width="20%" ><?echo $staff['month_claim'] ;?></td> 
            </tr> 
 
            <tr> 
            <td height='20px' width="9%"><b>IC Number &nbsp;&nbsp;&nbsp;&nbsp;:</b></td> 
            <td height='20px' width="35%"><?echo $staff['noic'];?></td> 
            </tr> 
 
            <tr>  
            <td height='20px' width="9%"><b>Position &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></td> 
            <td height='20px' width="35%"><?echo $staff['role_id']; ?></td> 
 
            <td height='20px' width="10%"><b>Job No &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></td> 
            <td height='20px' width="20%"><?echo $staff['job_no']; ?></td> 
            </tr> 
              
            <tr>  
            <td height='20px' width="9%"><b>Department &nbsp;&nbsp;&nbsp;:</b></td> 
            <td height='20px' width="35%"><?echo $staff['department_name']; ?></td> 
 
            <td height='20px' width="10%"><b>Company&emsp;&emsp;&emsp;&emsp;&nbsp;:</b></td> 
            <td height='20px' width="20%"><?echo $staff['company_claim']; ?></td> 
            </tr> 
        </table> 
    </div> 
    
    <input type="hidden" width="30%" name="staff_record_id" id="staff_record_id" value="<? echo $id;?>" >
						<input type="hidden" class="form-control" name="month_claim" id="month_claim" value="<? echo $month;?>">
						<input type="hidden" class="form-control" name="status" id="status" value="<? echo $status;?>">
						<input type="hidden" class="form-control" name="tahun" id="tahun" value="<? echo $tahun;?>">
    <table class="one" border="1">
				<tr><br><br>
				<th rowspan="2">Date</th>
				<th colspan="2">Date Time</th>
				<th rowspan="2">Details Description</th>
				<th rowspan="2">Milage (KM*RM)</th>
				<th rowspan="2">Hotel/Lodging Allowance (RM)</th>
				<th rowspan="2">Daily Allowance (RM)</th>
				<th rowspan="2">Others Claim</th>
				<th rowspan="2">HR Remark</th>
				</tr>
				<tr>
					<td style= "border-bottom: inset;">Departure</td>
					<td style= "border-bottom: inset;">Arrival</td>
				</tr>
								<?
                                    $staff = getOtherclaimreport($claim_id,$status,$tahun);
                                    $i=1;
                                    while($staff_info = $staff->fetch_assoc()) {
									
                                ?>
								<tr class="odd gradeX">
								      
										<td><?php echo $staff_info['date_purchase']; ?></td>
										<td><?php echo $staff_info['time_departure']; ?></td>
										<td><?php echo $staff_info['time_arrival']; ?></td>
								        <td><?php echo $staff_info['description']; ?></td>
										<td><?php echo $staff_info['milage']; ?></td>
										<td><?php echo $staff_info['hotel_allowance']; ?></td>
										<td><?php echo $staff_info['daily_allowance']; ?></td>
										<td><?php echo $staff_info['total_claim']; ?></td>
										<td><?php echo $staff_info['remark']; ?></td>
										
								</tr>
								 <?}?>	
								<tr>
								<td colspan="4" style= "border-top: inset;"></td>
								<td style= "border-top: inset;">RM <?php echo $total['total_milage']; ?></td>
								<td style= "border-top: inset;">RM <?php echo $total['total_hotel']; ?></td>
								<td style= "border-top: inset;">RM <?php echo $total['total_daily']; ?></td>
								<td style= "border-top: inset;">RM <?php echo $total['total']; ?></td>
								<td style= "border-top: inset;">Total Expenses : RM <?php echo $total['total_expenses']; ?></td>
								</tr>
							
				</table>
   <br> 
 
            <form> 
                <label for="total_claim">TOTAL EXPENSES</label>&emsp;&emsp;<input style="float: right; width: 175px;" type="text" id="total_expenses" name="total_expenses" value="RM<?echo $total['total_expenses']; ?>"readonly/> 
                <br> 
            </form> 
 
            <br><br><br> 
 
            <div class="clear-fix"></div> 
   <table border='0' cellspacing='0'> 
    
    
   <tr> 
   <th style="text-align:left;" width="15%">VERIFIED BY :<br> HOD/CEO</th>     
   <td width="35%"><br><br><br><br> 
   <?'<b>'.$staffs['hod_review_status'].'</b>'; 
   if($staffs['hod_review_status']== 'PENDING'){ 
    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
	else if ($staffs['hod_review_status']== 'VERIFIED') {
		echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>" 
   ;}
   else { 
    echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISVERIFIED</span>" 
   ;}'</b>'?> 
   <br><br> 
   <?echo $staffs ['hod_review_by'];?><br><br> 
   <?echo $staffs['hod_review_date'];?>  
   </td> 
    
    
   <th style="text-align:left;" width="15%">REVIEWED BY :<br> HUMAN RESOURCES</th> 
   <td width="35%"><br><br><br> 
   <?'<b>'.$staffs['hr_review_status'].'</b>'; 
   if($staffs['hr_review_status']== 'PENDING'){ 
    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
	else if ($staffs['hr_review_status']== 'REVIEW'){
		echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>" 
   ;}
	
   else { 
    echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>" 
   ;}'</b>'?>
   <br><br> 
   <?echo $staffs['hr_review_by'];?><br><br> 
   <?echo $staffs['hr_review_date'];?>  
   </td> 
    
   <tr><th style="text-align:left;" width="15%">APPROVED BY :<br> CEO/CHAIRMAN</th> 
   <td width="35%"> 
   <br><br><br> 
   <?'<b>'.$staffs['approve_status'].'</b>'; 
   if($staffs['approve_status']=='PENDING'){ 
    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";} 
   else if($staffs['approve_status']=='APPROVED'){ 
    echo"<span style='background-color:GREEN;padding:5px;border-radius:5px;font-weight:bold;color:white;'>APPROVED</span>";} 
   else { 
    echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>" 
   ;}'</b>'?> 
   <br><br> 
   <?echo $staffs['approve_by'];?><br><br> 
   <?echo $staffs['approve_date'];?>  
   </td> 
   </tr> 
             
            </th> 
        </tr> 
    </table> </table> 
  
    </fieldset> 
</div> 
 </div> 
    <div style="text-align:center;"> 
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/> 
    <br><br> 
</div> 
 </div> 
    <th> 
     
</th> 
 
</tr> 
</table> 
 
             
    </body> 
 
    <script> 
    $(document).ready(function() { 
         //window.onload = function() { window.print(); } 
    }); 
 
 
    </script> 
</html>