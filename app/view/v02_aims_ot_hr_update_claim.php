<?php
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$ot_info = v02getOtById($id)->fetch_assoc();
$contractor_array = v02getContractorList();

//convert total hours to hours & minutes
$hours = floor($ot_info['total_hours']);
$minutes = ($ot_info['total_hours'] - $hours) * 60;
?>
<div id="wrapper">
    <form method="post" action="../controller/v02_aims_ot_hr_update_claim_exec.php" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id; ?>" />
        <input type="hidden" name="staff_id" value="<? echo $ot_info['staff_id'];?>" /><!-- This input is used if HR change month session id-->
        <br>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="month_claim">Month Claim: </label><br>
                <select required class="form-control" name="month_claim" id="month_claim">
                    <optgroup label="Current: ">
                        <option value="" disabled><? echo $ot_info['month_session'] ?></option>
                    </optgroup>
                    <optgroup label="Change to:">
                        <?
                            $month_session_name = (in_array($ot_info['staff_id'], $contractor_array)) ? substr($ot_info['month_session'], 0, -12) : date("Y-m", strtotime($ot_info['month_session']));
                            $suggested_month_claim = date("Y-m", strtotime($month_session_name));
                        if (in_array($ot_info['staff_id'], $contractor_array)){
                            echo v02getDropDownMonthClaimContractor($suggested_month_claim, 0, -2);
                        }else{
                            echo v02getDropDownMonthClaim($suggested_month_claim, 1, -2);
                        }
                        /*
                            allowed_range (3rd parameter) means how many month will be deducted from current suggested month, and showed as option.
                            Example 1: Current Suggested Month = July 2022; allowed_range = -1 (July 2023);
                            Option will show from:
                                May 2023 - September 2023
                            Example 2: Current Suggested Month = January 2023; allowed_range = -2 (July 2023);
                            Option will show from:
                                June 2023 - September 2023
                        */
                        ?>
                    </optgroup>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="date_ot">Date:</label><br>
                <input type="text" required="" class="form-control" placeholder="" id="date_ot" name=""
                       value="<? echo date("d/m/Y", strtotime($ot_info['date'])) ?>" disabled/>
            </div>

            <div class="form-group col-md-4">
                <label for="day_ot">Day:</label><br>
                <input type="text" required class="form-control" placeholder="" id="day_ot" name=""
                       value="<? echo date("l", strtotime($ot_info['date'])) ?>" disabled />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="start_ot">Start:</label><br>
                <input type="time" required class="form-control" placeholder="" id="start_ot" name="start_ot"
                       value="<? echo $ot_info['start_ot'] ?>" disabled/>
                <span id="timeWarning" style="color: red"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="end_ot">End:</label><br>
                <input type="time" required class="form-control" placeholder="" id="end_ot" name="end_ot"
                       value="<? echo $ot_info['end_ot'] ?>" disabled/>
            </div>

            <div class="form-group col-md-4">
                <label for="working_hours">Total hours:</label><br>
                <div class="row">
                    <div class="col-sm-6" style="padding-right: 0">
                        <input autocomplete="off" required type="number" step="0.01" min="0" max="23.99" class="form-control col-sm-6" id="total_hours" name="total_hours" value="<? echo $ot_info['total_hours']?>" />
                    </div>
                    <div class="col-sm-6" style="padding-left: 0">
                        <input type="text" required class="form-control col-sm-6" placeholder="" id="working_hours" name=""
                               value="<? echo sprintf("%02s",$hours).'H '.sprintf("%02s",$minutes).'M'; ?>" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="rate_mode">Rate Mode:</label><br>
                <select required class="form-control" name="rate_mode" id="rate_mode">
                    <? foreach (getRateMode() as $rate => $description) { ?>
                        <option value="<? echo $rate ?>" <? if ($ot_info['rate_mode'] == $rate) echo 'selected'?>>
                            <? echo $rate.' - '.strtoupper($description); ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="verification_remark">Remark:</label><br>
                <input type="text" class="form-control" placeholder="" id="verification_remark" name="verification_remark" value="<? echo $ot_info['verification_remark'] ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="description">Work Description: </label><br>
                <textarea class="form-control" name="description" id="description" rows="5"
                           required><? echo $ot_info['description'] ?></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <div class="text-center">
                <button type="submit" class="btn btn-block btn-primary">Update</button>
            </div>
        </div>
    </form>
    <script>
        $('#total_hours').on('input', function () {
            let total_hours = $('#total_hours').val();
            let hours = Math.floor(total_hours);
            let minutes = Math.floor((total_hours-hours) * 60);

            minutes = minutes.toString().length<2?'0'+minutes:minutes;
            hours = hours.toString().length<2?'0'+hours:hours;

            $('#working_hours').val(hours + 'H ' + minutes + 'M');
        });
    </script>
</div>