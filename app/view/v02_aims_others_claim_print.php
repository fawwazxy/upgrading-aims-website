<?php
session_start();
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/v02_aims_others_claim_function.php";
use Dompdf\Dompdf;

$id = $_GET['id'];
$orientation = $_GET['orientation'] ?: 'landscape';

// Get Staff Details ---------------------------------------------------------------------------------------------------
$claim = v02getClaimDetailsByID($id)->fetch_assoc();
$rca_no = getRcaByClaimId($id)->fetch_object()->rca_no;
$i=1;
$total_cost=0.00;

// Get Finance info for claim ------------------------------------------------------------------------------------------
$finance_use = v02getFinanceUse($id)->fetch_assoc();

// Cost Centre ---------------------------------------------------------------------------------------------------------
$cost_centre_list = '';
$type_claim = v02getTypeClaimByClaimId($id);
while ($type = $type_claim->fetch_assoc()){
    $desc = getTypeClaimDescription($type['company_cc_id'])->fetch_assoc();
    $cost_centre_list .= '<li class="text-left">
                            <b>'.$desc['cost_centre'].'</b>: '.$desc['description'].' - RM'.$type['total'].'
                            </li>';
}

// Datetime Variable ---------------------------------------------------------------------------------------------------
$datetime_departure = $claim['datetime_departure'] != '0000-00-00 00:00:00' ?
    date('d/m/Y h:i A', strtotime($claim['datetime_departure'])) : '';

$datetime_arrival = $claim['datetime_arrival'] != '0000-00-00 00:00:00' ?
    date('d/m/Y h:i A', strtotime($claim['datetime_arrival'])) : '';

// Declare status for all LOA ------------------------------------------------------------------------------------------
if (empty($claim['verify_by']) && empty($claim['verify_at'])){ //HOD
    $hod_text_color = 'GREY';
    $hod_text_status = 'PENDING';
    $verify_by = "";
    $verify_at = "";
}else{
    $verify_by = v02getStaffName($claim['verify_by']);
    $verify_at = date("d/m/Y", strtotime($claim['verify_at']));
    if ($claim['verify_status'] == '1'){
        $hod_text_color = 'GREEN';
        $hod_text_status = ($claim['verify_by'] == 'AUTO VERIFIED') ? 'NO SUPPORT NEEDED' : 'VERIFIED';
    } else{
        $hod_text_color = 'RED';
        $hod_text_status = 'REJECTED';
    }
}

if (empty($claim['review_by']) && empty($claim['review_at'])){ //HR
    $hr_text_color = 'GREY';
    $hr_text_status = 'PENDING';
    $review_by = "";
    $review_at = "";
}else{
    $review_by = v02getStaffName($claim['review_by']);
    $review_at = date("d/m/Y", strtotime($claim['review_at']));
    if ($claim['review_status'] == '1'){
        $hr_text_color = 'GREEN';
        $hr_text_status = 'REVIEWED';
    }else{
        $hr_text_color = 'RED';
        $hr_text_status = 'DISAPPROVED';
    }
}

if ($claim['finance_status'] == '1'){ //Finance
    $finance_text_color = 'GREEN';
    $finance_text_status = 'CHECKED';
    $checked_by = v02getStaffName($claim['finance_by']);
    $checked_at = date("d/m/Y", strtotime($claim['finance_at']));
}else{
    $finance_text_color = 'GREY';
    $finance_text_status = 'UNCHECKED';
    $checked_by = ($claim['finance_status'] == '0') ? v02getStaffName($claim['finance_by']) : "";
    $checked_at = ($claim['finance_status'] == '0') ? date("d/m/Y", strtotime($claim['finance_at'])) : "";
}

if (empty($claim['approve_by']) && empty($claim['approve_at'])){ //CEO
    $ceo_text_color = 'GREY';
    $ceo_text_status = 'PENDING';
    $approved_by = "";
    $approved_at = "";
}else{
    $approved_by = v02getStaffName($claim['approve_by']);
    $approved_at = date("d/m/Y", strtotime($claim['approve_at']));
    if ($claim['approve_status'] == '1'){
        $ceo_text_color = 'GREEN';
        $ceo_text_status = 'APPROVED';
    }else{
        $ceo_text_color = 'RED';
        $ceo_text_status = 'DISAPPROVED';
    }
}
$department_id = ($claim['department_id'] == 'MOCSB')? "AGESB":$claim['department_id'];

$hr_tracking_text = '';
$rca_no_text = '';
$hr_tracking_val = '';
$rca_no_val = '';

if (in_array($_SESSION['SESS_DEPARTMENT_SUB'] , ['FINACC','HR']) || in_array($_SESSION['SESS_ROLE'], ['HOD','SUPERADMIN'])){

    if ($claim['tracking_no'] != ''){
        $hr_tracking_text = 'HR Tracking';
        $hr_tracking_val = ': '.$claim['tracking_no'];
    }

    if ($rca_no != ''){
        $rca_no_text = 'RCA No';
        $rca_no_val = ': '.$rca_no;
    }
}

//Generate full html (to be converted to PDF) --------------------------------------------------------------------------
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CLAIM - '.$claim['month_claim'].'</title>
    <style type="text/css">
        @page { 
            margin: 0.635cm;
        }
        body{
            font-family: "Arial", sans-serif;
            font-size: 12px;
            margin: 0.635cm;
        }
        table.finance td:empty::after{
            content: "\00a0";
        }
        .finance{
            width: 100%;
            border-collapse: collapse;
        }
        table.finance th{
            border: 1px solid black;
            border-collapse: collapse;
            height: 18px;
        }
        table.finance td{
            padding: 0 2% 0 2%;
            border: 1px solid black;
            border-collapse: collapse;
            height: 19px;
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
            padding: 2px 8px;
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
            border-top: none;
            overflow: hidden
        }
        table.staff{
            width: 100%;
        }
        table.staff  th, td{ 
            padding: 0 8px; 
            border-spacing: 0 15px;
        } 
       
        img{
            margin: 0.5rem 0;
            height: 88px;
            width: auto;
        }  
        .badge{
            color:#ffffff;
            padding: 4px 8px;
            border-radius: 8px;
            font-weight:bold;
            display: inline-block;
        }
        .add-space-bottom td{
            padding-bottom: 8px;
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-muted{
            color: #4b4b4b;
        }
        .w-100{
            width: 100%;
        }
        .separator{
            margin: 4px 0;
        }
    </style>
</head>
<body>
<table class="w-100">
    <tr>
        <td style="width: 75%">
            <img id="logo" src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;" alt="logo"/>
        </td>
        <td style="width: 25%">
            <table class="finance" style="border: 2px solid black">
                <tr>
                    <th class="text-left" style="padding-left:2%">Finance Use</th>
                    <th class="text-right" style="padding-right:4%">Total (RM)</th>
                </tr>
                <tr>
                    <td class="text-left">Advance</td>
                    <td class="text-right">'.$finance_use['advance'].'</td>
                </tr>
                <tr>
                    <td class="text-left">Less : Expenditure</td>
                    <td class="text-right">'.$claim['total_claim'].'</td>
                </tr>
                <tr>
                    <td class="text-left">Refund</td>
                    <td class="text-right">'.$finance_use['refund'].'</td>
                </tr>
                <tr>
                    <td class="text-left">Outstanding</td>
                    <td class="text-right">'.$finance_use['outstanding'].'</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<hr style="margin-bottom: 16px">

<table class="staff" id="medicalPrint">
    <thead>
    <tr>
        <th class="text-center" colspan="4">
            <h2 style="margin: -4px 0 8px">CLAIM FORM</h2>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th style="width: 14%">Name</th>
        <td style="width: 41%">: '.$claim['name'].'</td>
        <th style="width: 15%">Company</th>
        <td style="width: 30%">: '.$department_id.'</td>
    </tr>
    <tr>
        <th>IC Number</th>
        <td>: '.$claim['noic'].'</td>
        <th>Department</th>
        <td>: '.$claim['department_sub'].'</td>
    </tr>
    <tr>
        <th>Staff Number</th>
        <td>: '.$claim['no_staff'].'</td>
        <th>Month Claim</th>
        <td>: '.$claim['month_claim'].'</td>
    </tr>
    <tr>
        <th>'.$hr_tracking_text.'</th>
        <td>'.$hr_tracking_val.'</td>
        <th>'.$rca_no_text.'</th>
        <td>'.$rca_no_val.'</td>
    </tr>
    </tbody>
</table>

<table class="claim" style="margin-top: 8px;table-layout:fixed;" role="grid" id="claimPrint">
    <thead>
    <tr>
        <th style="width: 20%">JOB NUMBER</th>
        <th style="width: 15%">DEPARTURE/RETURN</th>
        <th style="width: 20%">DESCRIPTION</th>
        <th style="width: 29%">TYPE OF CLAIM</th>
        <th style="width: 8%" class="text-center">TOTAL</th>
        <th style="width: 8%">REMARK</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td><b>'.$claim['job_no'].'</b><br>
                <small class="text-muted">Applied on:
                '.date('d/m/Y h:i:sA', strtotime($claim['created_at'])).'
                </small>
            </td>
            <td>
                <small class="text-muted">Departure:</small><br>
                '.$datetime_departure.'<br>
                <small class="text-muted">Return:</small><br>
                '.$datetime_arrival.'
                </td>
            <td>'.nl2br($claim['description']).'</td>
            <td>
                 <ul style="list-style: square;margin: 4px -8px">'.$cost_centre_list.'</ul>       
            </td>
            <td class="text-center">RM'.$claim['total_claim'].'</td>
            <td>'.nl2br($claim['remarks']).'</td>
        </tr>
    </tbody>
</table>

<table class="w-100" style="margin: 16px auto 0 auto">
    <tr>
        <th style="text-align:left;width: 20%">APPLIED BY:</th>
        <th style="text-align:left;width: 20%">VERIFIED BY:</th>
        <th style="text-align:left;width: 20%">REVIEWED BY:</th>
        <th style="text-align:left;width: 20%">CHECKED BY:</th>
        <th style="text-align:left;width: 20%">APPROVED BY:</th>
    </tr>
            
    <tr class="add-space-bottom">
        <td><span class="badge" style="background-color: GREEN">APPLIED</span></td>
        <td><span class="badge" style="background-color: '.$hod_text_color.'">'.$hod_text_status.'</span></td>
        <td><span class="badge" style="background-color: '.$hr_text_color.'">'.$hr_text_status.'</span></td>
        <td><span class="badge" style="background-color: '.$finance_text_color.'">'.$finance_text_status.'</span></td>
        <td><span class="badge" style="background-color: '.$ceo_text_color.'">'.$ceo_text_status.'</span></td>
    </tr>

    <tr class="add-space-bottom">
        <td>'.v02getStaffName($claim['staff_id']).'</td>
        <td>'.$verify_by.'</td>
        <td>'.$review_by.'</td>
        <td>'.$checked_by.'</td>
        <td>'.$approved_by.'</td>
    </tr>
    
    <tr>
        <td>'.date("d/m/Y", strtotime($claim['created_at'])).' </td>
        <td>'.$verify_at.' </td>
        <td>'.$review_at.' </td>
        <td>'.$checked_at.' </td>
        <td>'.$approved_at.' </td>
    </tr>
</table>

<div style="text-align:left;margin-top: 50px">
    <h3><b><i>* THIS FORM IS GENERATED BY SYSTEM AND NO SIGNATURE IS REQUIRED</i></b></h3>
</div>
</body>
</html>';

// Generate PDF from HTML ----------------------------------------------------------------------------------------------
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', $orientation);
$dompdf->render();

$x          = 36;
$y          = 18;
$text       = "Page {PAGE_NUM} of {PAGE_COUNT} - CLAIM FORM: ".$claim['name']." (".date('d/m/Y',strtotime($claim['datetime_departure'])).")";
$font       = $dompdf->getFontMetrics()->get_font('Helvetica', 'normal');
$size       = 8;
$color      = array(0,0,0);
$word_space = 0.0;
$char_space = 0.0;
$angle      = 0.0;

$dompdf->getCanvas()->page_text(
    $x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle
);

ob_end_clean();
$dompdf->stream("AIMS-Office_Claimv2_".$claim['noic']."_".$id,array("Attachment"=>0));