<?php

    include ('../controller/auth.php');

    require "../model/aims_ssrapproved_function.php";

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);

    $sys = getSys(1)->fetch_assoc();

    $ssr_no = $_GET['ssr_no'];
    $staffinfo = getCetakInfoById($ssr_no)->fetch_assoc();
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
            font-size: 14px;
        }
         
        div.invoice {
        border:0px solid #ccc;
        padding:10px;
        height:60%;
        width:90%;
        }
        
        .pagebreak { 
            page-break-before: always; 
        }
        
        div.company-address {
            border:1px solid #ccc;
            float:left;
            width:200pt;
        }
         
        div.invoice-details {
            border:0px solid #ccc;
            float:right;
            width:200pt;
        }
         
        div.customer-address {
            border:1px solid #ccc;
            float:right;
            margin-bottom:50px;
            margin-top:100px;
            width:200pt;
        }
         
        div.clear-fix {
            clear:both;
            float:none;
        }
         
        table {
            width:100%;
		
        }
	
        table.one {
			border-collapse:collapse;
            width:100%;
		
        } 
        th {
            text-align: left;
        }
         
        td {
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

     colorbox{
        float: left;
        width: 50px;
        height: 20px;
        margin: 5px;
        border: 1px solid rgba(0, 0, 0, .2);
    }

    </style>

    </head>
 
    <body>
    
            <br><br><br>
          
            <div class="invoice">
            <div style="text-align:center">

            <center>
            <div class="clear-fix"></div>

            
            <tr>
                <h3>SSR LIST</h3>
            <table border='0' cellspacing='0'>
            <tbody>
<tr>
            <td colspan="2" class='text-left' height='35px' width="30%"><b>SSR NO</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['ssr_no'] ;?></td>
            </tr>
            <tr>
            <td colspan="2" class='text-left' height='35px' width="30%"><b>SSR Date:</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['ssr_date'];?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Vessel</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['vessel']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Location</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['location']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Department</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['department']; ?></td>
            </tr>
<tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Item</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['item']; ?></td>
            </tr>			

				<table class="one" border="1">
				<tr><br><br>
				<th style="text-align:center;">No</th>
				<th style="text-align:center;">Description</th>
				<th style="text-align:center;">Quantity Approved</th>
				<th style="text-align:center;">unit</th>
				<th style="text-align:center;">Quantity Required</th>
				<th style="text-align:center;">Balance</th>
				<th style="text-align:center;">Total</th>
				<th style="text-align:center;">Remarks</th>
				</tr>
				<?
                                    $staff = getCetakInfoById($ssr_no);
                                    $i=1;
                                    while($staff_info = $staff->fetch_assoc()) {
									
                                ?>
				<tr>
				<td align="center" ><?echo $i++;?></td>
				<td style="padding:30px;" align="center" type="text" size="20" name="description" ><? echo $staff_info['description']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="quantity_approved"><? echo $staff_info['quantity_approved']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="unit"><? echo $staff_info['unit'] ;?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="quantity_required"><? echo $staff_info['quantity_required']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="balance"><? echo $staff_info['balance']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="sparepart_no"><? echo $staff_info['sparepart_no']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="remarks"><? echo $staff_info['remarks']; ?></td>
				</tr>
					<?}?>		
				</table>
			<br><br>

            <div class="clear-fix"></div>
			<table border='0' cellspacing='0'>
			
			
			<tr>
			<th style="text-align:left;" width="30%">VERIFIED BY:</th>				
			<td>
			<?'<b>'.$staffinfo['verified_status'].'</b>';
										if($staffinfo['verified_status']==0){
										    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
										else {
										    echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>"
										;}'</b>'?><br><br><label class="control-label">Name : </label>
										<?if($staffinfo['verified_name']!=''){echo $staffinfo['verified_name'];}?>
										<br><label class="control-label">Designation : </label>
										<?if($staffinfo['verified_designation']!=''){echo $staffinfo['verified_designation'];}?>
										</td>
			
			
			<th style="text-align:left;" width="30%">APPROVED BY:</th>
			<td>
			<?'<b>'.$staffinfo['approved_status'].'</b>';
										if($staffinfo['approved_status']==0){
										    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
										else {
										    echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
										;}'</b>'?><br>
										<br><label class="control-label">Name : </label>
										<?if($staffinfo['approved_name']!=''){echo $staffinfo['approved_name'];}?>
										<br><label class="control-label">Designation : </label>
										<?if($staffinfo['approved_designation']!=''){echo $staffinfo['approved_designation'];}?>
										</td>
										<br>
			<tr><th style="text-align:left;" width="30%">APPROVED BY PROCUREMENT:</th>
			<td>
			<br><br><br><?'<b>'.$staffinfo['app_pro_status'].'</b>';
										if($staffinfo['app_pro_status']==0){
										    echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
										else {
										    echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
										;}'</b>'?><br>
										<br><label class="control-label">Name : </label>
                                        <?if($staffinfo['app_pro_name']!=''){ echo $staffinfo['app_pro_name'];}?>
                                        <br>
									    <?echo $staffinfo['app_pro_date'];?><br>
										</td></tr>
			
			
										
									
			
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"></td>
            <td colspan="2" class='text-left' height='35px'><b></b></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"></td>
            <td colspan="2" class='text-left' height='35px'><b></b></td>
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
