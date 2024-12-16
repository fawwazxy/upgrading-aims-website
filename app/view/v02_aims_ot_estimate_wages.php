<?php
require "../model/v02_aims_ot_function.php";

$month_session_id = $_POST['id'];
?>
<head>
    <style>
        .conversion-table tr{
            height: 48px;
        }
        #table-hr tr td:last-child {
            white-space: nowrap;
        }
        .font-weight-bold{
            font-weight: bold;
        }

        .table-info tr{
            height: 24px;
        }

        .table-info th{
            padding-right: 8px;
        }
        .bg-radius-secondary{
            background-color: #e1fce2;
            border-radius: 16px;
        }
    </style>
</head>
<div class="container-fluid bg-radius-secondary">
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-danger">Please fill <b>Total Hours</b> in table before using the rates calculator</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3"><h5>Automatic Rate Calculator</h5></div>
        <div class="col-sm-3">
            <div class="form-group row">
                <div class="col-sm-2"><h4>: </h4></div>
                <div class="col-sm-10">
                    <input type="text" name="basic_pay" id="basic_pay" class="form-control numberAndDecimalOnly" oninput="changeToRed('#basic_pay')" onkeypress="inputDecimal(event)" placeholder="Basic Pay">
                </div>
            </div>
        </div>
        <div class="col-md-1"><h4>&divide;</h4></div>
        <div class="col-md-1"><h4 class="font-weight-bold">26</h4></div>
        <div class="col-md-1"><h4>&divide;</h4></div>
        <div class="col-md-1"><h4 class="font-weight-bold">8</h4></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <h4 class="font-weight-bold">Base Rate ( &times; 1.0)</h4>
        </div>
        <div class="col-sm-3">
            <div class="form-group row">
                <div class="col-sm-2"><h4>: </h4></div>
                <div class="col-sm-10">
                    <h4 class="font-weight-bold" id="base_rate">RM 0.00</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr style="background-color: #404040; color: #FFFFFF">
                    <td class="text-center">Rate</td>
                    <td>Total Hours</td>
                    <td class="text-center"></td>
                    <td>Wage per Hour</td>
                    <td class="text-center"></td>
                    <td>Total Wages</td>
                </tr>
                <tr>
                    <td class="text-center" style="padding-top:1.5%"><b>1.5</b></td>
                    <td>
                        <input type="text" name="normal_hour" id="normal_hour" class="form-control" oninput="changeToRed('#normal_hour')"
                               value="<? echo getTotalHourByRate($month_session_id, 1.5, false); ?>" onkeypress="inputDecimal(event)"/>
                    </td>
                    <td class="text-center"><h5>&times;</h5></td>
                    <td>
                        <input type="text" name="normal_wageperhour" id="normal_wageperhour" class="form-control" onkeypress="inputDecimal(event)"/>
                    </td>
                    <td class="text-center"><h5>&equals;</h5></td>
                    <td>
                        <input readonly type="text" name="normal_totalwages" id="normal_totalwages" class="form-control"/>
                    </td>
                </tr>

                <tr>
                    <td class="text-center" style="padding-top:1.5%"><b>2</b></td>
                    <td>
                        <input type="text" name="weekend_hour" id="weekend_hour" class="form-control"
                               oninput="changeToRed('#weekend_hour')" onkeypress="inputDecimal(event)"
                               value="<? echo getTotalHourByRate($month_session_id, 2.0); ?>"/>
                    </td>
                    <td class="text-center"><h5>&times;</h5></td>
                    <td>
                        <input type="text" name="weekend_wageperhour" id="weekend_wageperhour" class="form-control" onkeypress="inputDecimal(event)"/>
                    </td>
                    <td class="text-center"><h5>&equals;</h5></td>
                    <td>
                        <input readonly type="text" name="weekend_totalwages" id="weekend_totalwages" class="form-control"/>
                    </td>
                </tr>

                <tr>
                    <td class="text-center" style="padding-top:1.5%"><b>3</b></td>
                    <td>
                        <input type="text" name="holiday_hour" id="holiday_hour" class="form-control" onkeypress="inputDecimal(event)"
                               value="<? echo getTotalHourByRate($month_session_id, 3.0); ?>"/>
                    </td>
                    <td class="text-center"><h5>&times;</h5></td>
                    <td>
                        <input type="text" name="holiday_wageperhour" id="holiday_wageperhour" class="form-control" onkeypress="inputDecimal(event)"/>
                    </td>
                    <td class="text-center"><h5>&equals;</h5></td>
                    <td>
                        <input readonly type="text" name="holiday_totalwages" id="holiday_totalwages" class="form-control" onkeypress="inputDecimal(event)"/>
                    </td>
                </tr>

                <tr>
                    <td class="text-center" style="padding-top:1.5%">~</td>
                    <td>
                        <input type="text" name="special_hour" id="special_hour" class="form-control"
                               oninput="changeToRed('#special_hour')" onkeypress="inputDecimal(event)"
                               value="<? echo getTotalHourByRate($month_session_id, 4.0); ?>"/>
                    </td>
                    <td class="text-center"><h5>&times;</h5></td>
                    <td>
                        <input type="text" name="special_wageperhour" id="special_wageperhour" class="form-control" onkeypress="inputDecimal(event)"/>
                    </td>
                    <td class="text-center"><h5>&equals;</h5></td>
                    <td>
                        <input readonly type="text" name="special_totalwages" id="special_totalwages" class="form-control" onkeypress="inputDecimal(event)"/>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                    </td>
                    <th colspan="3" class="text-right" style="padding-top:1.5%;border-right: 0">TOTAL (RM)</th>
                    <td></td>
                    <td style="text-align:center;">
                        <input readonly type="text" value="" name="total_claim" id="total_claim" class="form-control"
                               onkeypress="inputDecimal(event)"/>
                    </td>
                <tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    //Automatic rate calculator
    $('#basic_pay').on('input', function (e) {
        let basic = e.target.value; //basic pay value
        let baseRate = (basic / 26 / 8).toFixed(2); //calculate base rate

        //multiply each rate mode with base rate
        let base1half = (baseRate * 1.5), base2 = (baseRate * 2),
            base3 = (baseRate * 3), base4 = (baseRate * 4);
        //set null if value is 0.00
        base1half = (base1half === 0.00) ? null : twoDecimalPlaces(base1half);
        base2 = (base2 === 0.00) ? null : twoDecimalPlaces(base2);
        base3 = (base3 === 0.00) ? null : twoDecimalPlaces(base3);
        base4 = (base4 === 0.00) ? null : twoDecimalPlaces(base4);

        //pick all rate mode total hour value
        let n_hour = $('#normal_hour').val(), w_hour = $('#weekend_hour').val(),
            p_hour = $('#holiday_hour').val(), s_hour = $('#special_hour').val();

        $('#base_rate').text('RM '+baseRate);
        if (n_hour !== '' && base1half !== 'NaN'){ $('#normal_wageperhour').val(base1half);}
        if (w_hour !== '' && base2 !== 'NaN'){ $('#weekend_wageperhour').val(base2);}
        if (p_hour !== '' && base3 !== 'NaN'){ $('#holiday_wageperhour').val(base3);}
        if (s_hour !== '' && base4 !== 'NaN'){ $('#special_wageperhour').val(base4);}
    });

    //calculation rates 1.5
    $('#normal_hour, #normal_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#normal_hour').val();
        let wagePerHour = $('#normal_wageperhour').val();

        $('#normal_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //calculation rates 2.0
    $('#weekend_hour, #weekend_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#weekend_hour').val();
        let wagePerHour = $('#weekend_wageperhour').val();

        $('#weekend_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //calculation rates 3.0
    $('#holiday_hour, #holiday_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#holiday_hour').val();
        let wagePerHour = $('#holiday_wageperhour').val();

        $('#holiday_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //calculation rates 4.0 (special)
    $('#special_hour, #special_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#special_hour').val();
        let wagePerHour = $('#special_wageperhour').val();

        $('#special_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //Sum Total Wages
    $('#normal_hour, #normal_wageperhour, #normal_totalwages, #weekend_hour, #weekend_wageperhour, #weekend_totalwages, #holiday_hour, #holiday_wageperhour, #holiday_totalwages, #special_hour, #special_wageperhour, #special_totalwages, #basic_pay')
        .on('input', function (e) {
            //Total claim: pick value and sum it
            let normalTw = $('#normal_totalwages').val(),
                weekendTw = $('#weekend_totalwages').val(),
                publicTw = $('#holiday_totalwages').val(),
                specialTw = $('#special_totalwages').val();

            //set 0.00 if any picked value is null
            normalTw = (normalTw !== '') ? parseFloat(normalTw) : 0.00;
            weekendTw = (weekendTw !== '') ? parseFloat(weekendTw) : 0.00;
            publicTw = (publicTw !== '') ? parseFloat(publicTw) : 0.00;
            specialTw = (specialTw !== '') ? parseFloat(specialTw) : 0.00;

            let totalTw = normalTw + weekendTw + publicTw + specialTw;
            totalTw = (totalTw === 0.00) ? null : twoDecimalPlaces(totalTw);
            $('#total_claim').val(totalTw);
        });



    function opTwoInputs(value1, value2, operator = 'multiply'){
        value1 = (value1 === undefined) ? 0 : value1;
        value2 = (value2 === undefined) ? 0 : value2;

        let total;

        if (operator === 'minus'){
            total = (value1 - value2);
            $('#total_overused, #convert_to_off_day').css('color', 'red');
        }else {
            total = (value1 * value2);
        }

        return (total === 0.00) ? null : twoDecimalPlaces(total);
    }

    function twoDecimalPlaces(num){
        let result = Math.round((num + Number.EPSILON) * 100) / 100;
        return result.toFixed(2);
    }

    //input decimal only
    function inputDecimal(evt) {
        let theEvent = evt || window.event;
        let key;
        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            let keys = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(keys);
        }
        let regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault){ theEvent.preventDefault();}
        }
    }
</script>





						