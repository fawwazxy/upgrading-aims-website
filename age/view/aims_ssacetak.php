<?php

    include ('../controller/auth.php');

    require "../model/aims_ssa_proc_app_function.php";

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);

    $sys = getSys(1)->fetch_assoc();

    $id = $_GET['id'];
    $staffinfo = getCetakInfoById($id)->fetch_assoc();
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
                <h3>SSA LIST</h3>
            <table border='0' cellspacing='0'>
            <tbody>
<tr>
            <td colspan="2" class='text-left' height='35px' width="30%"><b>SSR NO</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['ssa_no'] ;?></td>
            </tr>
            <tr>
            <td colspan="2" class='text-left' height='35px' width="30%"><b>SSR Date:</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['date'];?></td>
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
			

				<table class="one" border="1">
				<tr><br><br>
				<th style="text-align:center;">SSA Raised</th>
				<th style="text-align:center;">aa</th>
				<th style="text-align:center;">bb</th>
				<th style="text-align:center;">cc</th>
				<th style="text-align:center;">dd</th>
				
				
				<tr>
				<td style="padding:30px;" align="center" type="text" size="20" name="ssa_raised" ><? echo $staffinfo['ssa_raised']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="aa"><? echo $staffinfo['aa']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="bb"><? echo $staffinfo['bb'] ;?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="cc"><? echo $staffinfo['cc']; ?></td>
				<td style="padding:30px;" align="center" type="text" size="10" name="dd"><? echo $staffinfo['dd']; ?></td>
				
				</tr>
							
				</table>
			<br><br>

            <div class="clear-fix"></div>
			<table border='0' cellspacing='0'>
			
			
			<tr>
			<th style="text-align:left;" width="30%">VERIFIED BY:</th>				
			<td>
			<br>
			<?'<b>'.$staffinfo['ver_status'].'</b>';
			if($staffinfo['ver_status']==0){
			echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
			else {
			echo"<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
			;}'</b>'?><br><br><? echo $staffinfo['ver_on'] ?>
			<br>
			<br><label class="control-label">Name : </label>
			<?if($staffinfo['ver_name']!=''){ echo $staffinfo['ver_name'];}?>
			<br><label class="control-label">Designation : </label>
			<?if($staffinfo['ver_design']!=''){ echo $staffinfo['ver_design'];}?>
			</td>
			
			
			<th style="text-align:left;" width="30%">APPROVED BY:</th>
			<td>
			<br>
			<?'<b>'.$staffinfo['app_status'].'</b>';
			if($staffinfo['app_status']==0){
			echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
			else {
			echo"<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
			;}'</b>'?><br><br><? echo $staffinfo['app_on'] ?>
			<br>
			<br><label class="control-label">Name : </label>
			<?if($staffinfo['app_name']!=''){ echo $staffinfo['app_name'];}?>
			<br><label class="control-label">Designation : </label>
			<?if($staffinfo['app_design']!=''){ echo $staffinfo['app_design'];}?>
			</td>
			<br>
										
			<tr><th style="text-align:left;" width="30%">APPROVED BY PROCUREMENT:</th>
			<td>
			<br>
			<?'<b>'.$staffinfo['proc_status'].'</b>';
			if($staffinfo['proc_status']==0){
			echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
			else {
			echo"<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
			;}'</b>'?><br><br><? echo $staffinfo['proc_on'] ?>
			<br>
			<br><label class="control-label">Name : </label>
			<?if($staffinfo['proc_name']!=''){ echo $staffinfo['proc_name'];}?>
			<br><label class="control-label">Designation : </label>
			<?if($staffinfo['proc_design']!=''){ echo $staffinfo['proc_design'];}?>
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
