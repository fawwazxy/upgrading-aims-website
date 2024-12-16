<?php
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/v02_aims_ot_function.php";
use Dompdf\Dompdf;

$id = $_GET['id'];
$orientation = $_GET['orientation'] ?: 'landscape';
$month_claim = v02getMonthClaimStaff($id)->fetch_assoc();

// Set OT Closed date --------------------------------------------------------------------------------------------------
$ot_day_closed = 15;
if ($month_claim['department_sub'] == 'MOORING-GANG'){
    $ot_day_closed = 20;
}else if (array_key_exists($month_claim['staff_id'], v02getContractorList())){
    $ot_day_closed = 31;
}

// Get OT list from month session --------------------------------------------------------------------------------------
$month_details = v02getOtClaimReport($id);
$i=1;
$table_row = $conversion_table = "";

//declare variable to store latest data --------------------------------------------------------------------------------
$latest_created_ot = $latest_verified_at = $latest_verified_by = $latest_approved_at = $latest_approved_by = "";
$hod_verify = "PENDING";
$hr_review = "PENDING";
$ceo_approved = "PENDING";
$hod_score = 0;
$hr_score = 0;
$ceo_score = 0;
$td_color = [
    '1.5' => 'transparent',
    '2.0' => '#FFFF93',
    '3.0' => '#FF9393'
];

// Month Session Wage Calculation table ---------------------------------------------------------------------------------------
$normal_hour = ($month_claim['normal_hour'] != '0.00') ? $month_claim['normal_hour'] : '';
$normal_wage_per_hour = ($month_claim['normal_wageperhour'] != '0.00') ? $month_claim['normal_wageperhour'] : '';
$normal_total_wages = ($month_claim['normal_totalwages'] != '0.00') ? $month_claim['normal_totalwages'] : '';

$weekend_hour = ($month_claim['weekend_hour'] != '0.00') ? $month_claim['weekend_hour'] : '';
$weekend_wage_per_hour = ($month_claim['weekend_wageperhour'] != '0.00') ? $month_claim['weekend_wageperhour'] : '';
$weekend_total_wages = ($month_claim['weekend_totalwages'] != '0.00') ? $month_claim['weekend_totalwages'] : '';

$holiday_hour = ($month_claim['holiday_hour'] != '0.00') ? $month_claim['holiday_hour'] : '';
$holiday_wage_per_hour = ($month_claim['holiday_wageperhour'] != '0.00') ? $month_claim['holiday_wageperhour'] : '';
$holiday_total_wages = ($month_claim['holiday_totalwages'] != '0.00') ? $month_claim['holiday_totalwages'] : '';

$special_hour = ($month_claim['special_hour'] != '0.00') ? $month_claim['special_hour'] : '';
$special_wage_per_hour = ($month_claim['special_wageperhour'] != '0.00') ? $month_claim['special_wageperhour'] : '';
$special_total_wages = ($month_claim['special_totalwages'] != '0.00') ? $month_claim['special_totalwages'] : '';

$total_claim = ($month_claim['total_claim'] != '0.00') ? $month_claim['total_claim'] : '';

$department_id = ($month_claim['department_id'] == 'MOCSB')? "AGESB":$month_claim['department_id'];

// Generate empty row if no data ---------------------------------------------------------------------------------------
if ($month_details->num_rows < 1){
    $table_row = '<tr><td colspan="8" style="text-align: center">- No overtime claim this session -</td></tr>';
}

// Loop data and generate row content ----------------------------------------------------------------------------------
while($ot_list = $month_details->fetch_assoc()) {
    $i++;
    if (!empty($ot_list['created_at'])) {
        $latest_created_ot = $ot_list['created_at'];
    }
    if (!empty($ot_list['verify_at']) && $ot_list['verify_status'] == 1) {
        $latest_verified_at = $ot_list['verify_at'];
    }
    if (!empty($ot_list['verify_by']) && $ot_list['verify_status'] == 1) {
        $latest_verified_by = $ot_list['verify_by'];
    }
    if (!empty($ot_list['approved_at']) && $ot_list['approved_status'] == 1) {
        $latest_approved_at = $ot_list['approved_at'];
    }
    if (!empty($ot_list['approved_by']) && $ot_list['approved_status'] == 1) {
        $latest_approved_by = $ot_list['approved_by'];
    }

    //convert hours to hours and minutes
    $hours = floor($ot_list['total_hours']);
    $minutes = sprintf("%02d", ($ot_list['total_hours'] - $hours) * 60);

    //set text from approval column
    //HOD
    $hod_verify = "PENDING";
    if (!empty($ot_list['verify_by']) && !empty($ot_list['verify_at'])) {
        if ($ot_list['verify_status'] == 1) {
            $hod_verify = "VERIFIED";
            $hod_score++;
        } else {
            $hod_verify = "REJECTED";
        }
    }
    //HR
    $hr_review = "PENDING";
    if (!empty($ot_list['review_by']) && !empty($ot_list['review_at'])) {
        if ($ot_list['review_status'] == 1) {
            $hr_review = "REVIEWED";
            $hr_score++;
        } else {
            $hr_review = "REJECTED";
        }
    }
    //CEO
    $ceo_approved = "PENDING";
    if (!empty($ot_list['approved_by']) && !empty($ot_list['approved_at'])) {
        if ($ot_list['approved_status'] == 1) {
            $ceo_approved = "APPROVED";
            $ceo_score++;
        } else {
            $ceo_approved = "DISAPPROVE";
        }
    }

    $table_row .= '<tbody>
                    <tr>
                        <td class="text-center" style="background-color: '.$td_color[$ot_list['rate_mode']].'">
                            '.date('d/m/Y', strtotime($ot_list['date'])).'<br>
                            '.strtoupper(date('l', strtotime($ot_list['date']))).
                        '</td>
                        <td class="text-center" style="padding-left: 0; padding-right: 0">
                            '.date('h:ia', strtotime($ot_list['start_ot'])).
                            '<hr class="separator">'.date('h:ia', strtotime($ot_list['end_ot'])).
                        '</td>
                        <td class="text-center">
                            '.$hours.'H '.$minutes.'M'.'<br>('.$ot_list['total_hours'].' hrs)
                        </td>
                        <td>'.nl2br($ot_list['description']).'</td>
                        <td>'.$ot_list['remark'].'</td>
                        <td class="text-center">'.$hod_verify.'</td>
                        <td class="text-center" style="padding-left: 0; padding-right: 0">
                        '.$hr_review.'<hr class="separator">'.$ceo_approved.'</td>
                    </tr>
                    </tbody>';
}

//Footer Variable ------------------------------------------------------------------------------------------------------
$latest_verified_by = empty($latest_verified_by) ? '-' : getStaffName($latest_verified_by);
$latest_approved_by = empty($latest_approved_by) ? '-' : getStaffName($latest_approved_by);
$latest_created_ot = empty($latest_created_ot) ? "-" : date("d/m/Y", strtotime($latest_created_ot));
$latest_verified_at = empty($latest_verified_at) ? "-" : date("d/m/Y", strtotime($latest_verified_at));
$latest_approved_at = empty($latest_approved_at) ? "-" : date("d/m/Y", strtotime($latest_approved_at));

$hod_color = ($hod_score == 0) ? 'GREY' : 'GREEN';
$hr_color = ($hr_score == 0) ? 'GREY' : 'GREEN';
$ceo_color = ($ceo_score == 0) ? 'GREY' : 'GREEN';

// Overtime hours to Replacement Leave Info ----------------------------------------------------------------------------
$half_month = date('Y-m', strtotime($month_claim['month_session'])).'-'.$ot_day_closed;
$total_overused = v02getOtOverused($id, $half_month);
$total_overused = ($total_overused) ?: 0;

if ($total_overused > 0) {
    $conversion_off_day = ($month_claim['conversion_offday']) ?: '0';
    $off_day_total = $conversion_off_day / 8.0;
    $conversion_claim = ($month_claim['conversion_claim']) ?: '0';

    $off_day_description = $off_day_total < 1 ? '' : '<tr>
                    <td colspan="3" style="color: red; font-size: 12px; font-weight: bold">
                        This staff is eligible for additional leave as mentioned above.
                        Refer to Leave v02 for replacement quota details.
                        Contact Human Resource (HR) Department for more details.
                    </td>
                </tr>';

    $conversion_table = '<table style="border: 1px dashed black; width: 60%; font-size: 16px; margin-top: 32px; padding: 6px">
                <tr>
                    <td style="width: 45%;">Total Overused on <b>'.$half_month.'</b></td>
                    <td style="width: 5%">:</td>
                    <td style="width: 50%">'.$total_overused.' hour(s)</td>
                </tr>
                <tr>
                    <td>Convert to claim</td>
                    <td>:</td>
                    <td>'.$conversion_claim.' hour(s)</td>
                </tr>
                <tr>
                    <td>Convert to off-day</td>
                    <td>:</td>
                    <td>'.$conversion_off_day.' hour(s) ~ '.$off_day_total.' day(s)</td>
                </tr>
                '.$off_day_description.'
            </table>';
}

//Generate full html (to be converted to PDF) --------------------------------------------------------------------------
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/logo_ioffice.jpeg" />
    <title>Overtime Claim - '.$month_claim['noic'].' ('.$month_claim['month_session'].')</title>
    <style>
        @page { 
            margin: 0.635cm;
        }
        body{
            font-family: "Arial", sans-serif;
            font-size: 10px;
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
            height: 15px;
        }
        table.finance td{
            text-align: right;
            padding: 0 2% 0 2%;
            border: 1px solid black;
            border-collapse: collapse;
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
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
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
        <td style="width: 60%">
            <img id="logo" src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;" alt="logo"/>
        </td>
        <td style="width: 40%">
            <table class="finance" style="border: 2px solid black">
                <tr>
                    <th colspan="4" class="text-left" style="padding-left:2%">HR Use</th>
                </tr>
                <tr>
                    <th class="text-center">1.5</th>
                    <td>'.$normal_hour.'</td>
                    <td>'.$normal_wage_per_hour.'</td>
                    <td>'.$normal_total_wages.'</td>
                </tr>
                <tr>
                    <th class="text-center">2.0</th>
                    <td>'.$weekend_hour.'</td>
                    <td>'.$weekend_wage_per_hour.'</td>
                    <td>'.$weekend_total_wages.'</td>
                </tr>
                <tr>
                    <th class="text-center">3.0</th>
                    <td>'.$holiday_hour.'</td>
                    <td>'.$holiday_wage_per_hour.'</td>
                    <td>'.$holiday_total_wages.'</td>
                </tr>
                <tr>
                    <th class="text-center">~</th>
                    <td>'.$special_hour.'</td>
                    <td>'.$special_wage_per_hour.'</td>
                    <td>'.$special_total_wages.'</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Total &nbsp;</th>
                    <td>'.$total_claim.'</td>
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
            <h2 style="margin: -4px 0 8px">OVERTIME FORM</h2></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th style="width: 14%">Name</th>
        <td style="width: 41%">: '.$month_claim['name'].'</td>
        <th style="width: 15%">Company</th>
        <td style="width: 30%">: '.$department_id.'</td>
    </tr>
    <tr>
        <th>IC Number</th>
        <td>: '.$month_claim['noic'].'</td>
        <th>Department</th>
        <td>: '.$month_claim['department_sub'].'</td>
    </tr>
    <tr>
        <th>Staff Number</th>
        <td>: '.$month_claim['no_staff'].'</td>
        <th>Month Claim</th>
        <td>: '.$month_claim['month_session'].'</td>
    </tr>
    </tbody>
</table>

<table class="claim" style="margin-top: 8px;table-layout:fixed;" role="grid" id="medicalPrint">
    <thead>
    <tr>
        <th style="width: 10%" class="text-center">DATE</th>
        <th style="width: 8%" class="text-center">TIME</th>
        <th style="width: 10%" class="text-center">HOURS</th>
        <th style="width: 42%">WORK DESCRIPTION</th>
        <th style="width: 12%">REMARK</th>
        <th style="width: 8%" class="text-center">HOD</th>
        <th style="width: 10%" class="text-center">HR / CEO</th>
    </tr>
    </thead>
    '.$table_row.'
</table>

'.$conversion_table.'

<table class="w-100" style="margin: 16px auto 0 auto">
    <tr>
        <th style="text-align:left; height: 30px; width: 20%">APPLIED BY:</th>
        <th style="text-align:left; height: 30px; width: 20%">VERIFIED BY:</th>
        <th style="text-align:left; height: 30px; width: 20%">APPROVED BY:</th>
    </tr>
            
    <tr class="add-space-bottom">
        <td><span class="badge" style="background-color: GREEN">APPLIED</span></td>
        <td><span class="badge" style="background-color: '.$hod_color.'">'.$hod_verify.'</span></td>
        <td><span class="badge" style="background-color: '.$ceo_color.'">'.$ceo_approved.'</span></td>
    </tr>

    <tr class="add-space-bottom">
        <td><b>NAME : </b>'.getStaffName($month_claim['staff_id']).'</td>
        <td><b>NAME : </b>'.$latest_verified_by.'</td>
        <td><b>NAME : </b>'.$latest_approved_by.'</td>
    </tr>
    
    <tr>
        <td><b>DATE :</b> '. $latest_created_ot .' </td>
        <td><b>DATE :</b> '. $latest_verified_at .' </td>
        <td><b>DATE :</b> '. $latest_approved_at .' </td>
    </tr>
</table>
</body>
</html>';

/*<div style="text-align:left;margin-top: 50px">
    <h3><b><i>** THIS FORM IS GENERATED BY SYSTEM AND NO SIGNATURE IS REQUIRED</i></b></h3>
</div>*/

// Generate PDF from HTML ----------------------------------------------------------------------------------------------
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', $orientation);
$dompdf->render();

$x          = 36;
$y          = 18;
$text       = "Page {PAGE_NUM} of {PAGE_COUNT} - OVERTIME FORM: ".$month_claim['name']." (".$month_claim['month_session'].")";
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
$dompdf->stream("AIMS-Office_OTv2_".$month_claim['noic']."_".$id,array("Attachment"=>0));