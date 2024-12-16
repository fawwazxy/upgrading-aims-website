<?php
session_start();
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/v02_aims_medical_function.php";

use Dompdf\Dompdf;
$i=1;
$id = $_GET['id'];

$medical = getMedicalById($id)->fetch_assoc();
$year_receipt = date('Y', strtotime($medical['receipt_date']));

$staff_name = $_SESSION['SESS_NAME'];
$medical_quota = getMedicalQuotaByStaffId($medical['staff_id'], $year_receipt)->fetch_assoc();

$html = "";

//HR status -> PENDING / APPROVED / REJECTED
if (empty($medical['hr_verify_by']) && empty($medical['hr_verify_at'])){
    $hr_text_color = 'grey';
    $hr_text_status = 'PENDING';
}else{
    if ($medical['hr_verify_status'] == '1'){
        $hr_text_color = 'green';
        $hr_text_status = 'VERIFIED';
    }else{
        $hr_text_color = 'red';
        $hr_text_status = 'REJECTED';
    }
}

//CFO status -> PENDING / APPROVED / REJECTED
if (empty($medical['cfo_approval_by']) && empty($medical['cfo_approval_at'])){
    $cfo_text_color = 'grey';
    $cfo_text_status = 'PENDING';
}else{
    if ($medical['cfo_approval_status'] == '1'){
        $cfo_text_color = 'green';
        $cfo_text_status = 'VERIFIED';
    }else{
        $cfo_text_color = 'red';
        $cfo_text_status = 'REJECTED';
    }
}

//CEO status -> PENDING / APPROVED / REJECTED
if (empty($medical['ceo_approval_by']) && empty($medical['ceo_approval_at'])){
    $ceo_text_color = 'grey';
    $ceo_text_status = 'PENDING';
}else{
    if ($medical['ceo_approval_status'] == '1'){
        $ceo_text_color = 'green';
        $ceo_text_status = 'VERIFIED';
    }else{
        $ceo_text_color = 'red';
        $ceo_text_status = 'REJECTED';

    }
}

$department_id = ($medical['department_id'] == 'MOCSB')? "AGESB":$medical['department_id'];

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/logo_ioffice.jpeg" />
    <title>Medical Claim</title>
   
    <style>
        body{
            font-family: "Arial", sans-serif;
            font-size: 12px;
        }
       
         table.claim{
            width: 100%;
            border-collapse: collapse;
            margin-top:0;
        }

        table.claim th {
            padding: 8px;
            border:1px solid ;
        }

        table.claim td {
            padding: 2px;
            text-align: center;
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
            border-top: none;
        }
        	table.staff  th, td{ 
            padding:0; 
            border-spacing: 0 15px;
        } 
       
        img{
            margin: 0.5rem 0;
            height: 88px;
            width: auto;
        }
              
        .badge{
            color:WHITE;
            padding:6px 8px;
            border-radius: 5px;
            font-weight:bold;
        }

        @media screen and (max-width: 600px) {
            .column {
             width: 100%;
        }
        }
        
        .add-space-bottom td{
            padding-bottom: 8px;
        }
    </style>
    
</head>
<body>
<div>
<img id="logo" src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;" alt="logo"/>
<hr>
<br><br>

<table class="staff"    id="medicalPrint">

    <tbody>
    <tr>
        <th >Name</th>
        <td>: '.$medical['name'].'</td>
    </tr>
    <tr>
        <th>IC</th>
        <td>: '.$medical['noic'].'</td>
    </tr>
    <tr>
        <th>Company</th>
        <td>: '.$department_id.'</td>
    </tr>
     <tr>
        <th>Department</th>
        <td>: '.$medical['department_sub'].'</td>
    </tr>

    </tbody>
</table>

<br><br>
<table class="claim" style="width: 100%;" role="grid" id="medicalPrint">

 	<tr><br><br>
				<th style="text-align:center;">DATE</th>
				<th style="text-align:center;">DESCRIPTION</th>
				<th style="text-align:center;">TOTAL CLAIM(RM)</th>
			    <th style="text-align:center;">BALANCE AFTER APPROVAL(RM)</th>
				<th style="text-align:center;">REMARKS</th>
    </tr>
            	<tr>
				<td style="text-align:center;padding:30px;">'.$medical['receipt_date'].'</td>
				<td style="text-align:center;padding:30px;"> '.$medical['description'].' </td>
				<td style="text-align:center;padding:30px;"> '.$medical['total_claim'].' </td>
				<td style="text-align:center;padding:30px;"> '.$medical['balance_after_approval'].'</td>
				<td style="text-align:center;padding:30px;">'.$medical['remark'].' </td>
				</tr>
</table>

<table style="width: 100%; margin: 55px auto 0 auto">
            <tr>
                <th style="text-align:left; height: 30px; width: 20%">VERIFIED BY HR :</th>
                <th style="text-align:left; height: 30px; width: 20%">APPROVED BY CFO :</th>
                <th style="text-align:left; height: 30px; width: 20%">APPROVED BY CEO :</th>
            </tr>
            
             <tr class="add-space-bottom">
                  <td><span class="badge" style="color: '.$hr_text_color.'">'.$hr_text_status.'</span><br></td>
                  <td><span class="badge" style="color: '.$cfo_text_color.'">'.$cfo_text_status.'</span><br></td>
                  <td><span class="badge" style="color: '.$ceo_text_color.'">'.$ceo_text_status.'</span><br></td>
             </tr>

   <tr class="add-space-bottom">
                <td><b>NAME : </b>'.getStaffName($medical['hr_verify_by']).'</td>
                <td><b>NAME : </b>'.getStaffName($medical['cfo_approval_by']).'</td>
                <td><b>NAME : </b>'.getStaffName($medical['ceo_approval_by']).'</td>
  </tr>
                <tr>
                <td><b>DATE :</b> '. (empty($medical['hr_verify_at'])? "-" : date("d/m/Y", strtotime($medical['hr_verify_at']))) .' </td>
                <td><b>DATE :</b> '. (empty($medical['cfo_approval_at'])? "-" : date("d/m/Y", strtotime($medical['cfo_approval_at']))) .' </td>
                <td><b>DATE :</b> '. (empty($medical['ceo_approval_at'])? "-" : date("d/m/Y", strtotime($medical['ceo_approval_at']))) .' </td>
    </tr>

</table>

  <div style="text-align:left;margin-top: 50px">
        <h3><b><i>** THIS FORM IS GENERATED BY SYSTEM AND NO SIGNATURE IS REQUIRED</i></b></h3>
  </div>

</div>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
ob_end_clean();
$dompdf->stream("Medical_Claim",array("Attachment"=>0));