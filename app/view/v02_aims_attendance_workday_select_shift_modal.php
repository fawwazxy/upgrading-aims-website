<?php
require "../model/v02_attendance_function.php";
$modal_date = $_POST['date'];
$modal_value = $_POST['value'];
$view_only = $_POST['viewOnly']?: false;

?>
<style>
    .mx-16{
        margin-left: 8px;
        margin-right: 8px;
    }
    .shift-container{
        padding-left: 0;
        list-style: none;
    }
    .shift-radio{
        display: none;
    }
    .shift-radio:checked + .shift-bar{
        border: 2px solid #4a7fff;
        color: #4a7fff;
        background-color: #e0eaff;
    }
    .shift-bar{
        font-size: 16px;
        width: 100%;
        height: 2.5em;
        text-decoration: none;
        margin: 8px 0;
        border: 2px solid #9b9b9b;
        color: #9b9b9b;
        border-radius: 3px;
        text-align: left;
        overflow-y: hidden;
        text-overflow: ellipsis;
        display: block;
        cursor: pointer;
    }
    .shift-bar > label{
        padding: 8px 8px;
        cursor: pointer;
        font-weight: bold;
        display: block;
    }
    .time-pill{
        padding: 4px 6px;
        margin-right: 10px;
        color: #303030;
        border-radius: 6px;
        background-color: rgb(229, 229, 229)
    }
    .shift-radio:checked + .shift-bar .time-pill{
        background-color: #4a7fff;
        color: #FFFFFF;
    }
</style>
<input type="hidden" id="modal_date" value="<? echo $modal_date ?>">
<? if ($view_only){
    $item = getShiftById($modal_value)->fetch_assoc();
    $time = getShiftTime($item['start_time'], $item['work_hour'], $item['break_hour'], false, false);?>

    <div class="row">
        <div class="col-md-12">
            <p style="font-size: 20px">
                Your shift on <b><? echo date('jS F Y', strtotime($modal_date)) ?></b> is:
            </p>
            <ul class="shift-container">
                <input type="radio" class="shift-radio" name="shift_id" id="shift_id<? echo '_'.$modal_value?>"
                       value="<? echo $modal_value ?>" data-display="<? echo $item['code'] ?>" <? echo 'checked' ?>>
                <li class="shift-bar">
                    <label for="shift_id<? echo '_'.$modal_value?>">
                        <span class="time-pill"><? echo $time['start'].' - '.$time['end']; ?></span>
                        <? echo $item['code'] ?><i class="fa fa-star mx-16"></i><? echo $item['description'] ?>
                    </label>
                </li>
            </ul>
        </div>
    </div>
<? }else{
    $shift_list = getShiftList('code'); ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="shift-container">
                <input type="radio" class="shift-radio" name="shift_id" id="shift_id"
                       value="" data-display="" <? if ($modal_value == '') echo 'checked'?>>
                <li class="shift-bar">
                    <label for="shift_id" class="text-center">
                        <span class="time-pill">No shift</span>
                        - <i class="fa fa-star mx-16"></i> No shift
                    </label>
                </li>
                <? foreach ($shift_list as $item){
                    $checked = ($modal_value == $item['id']) ? 'checked' : '';
                    $time = getShiftTime($item['start_time'], $item['work_hour'], $item['break_hour'], false, false);?>
                    <input type="radio" class="shift-radio" name="shift_id" id="shift_id<? echo '_'.$item['id']?>"
                           value="<? echo $item['id'] ?>" data-display="<? echo $item['code'] ?>" <? echo $checked ?>>
                    <li class="shift-bar">
                        <label for="shift_id<? echo '_'.$item['id']?>">
                            <span class="time-pill"><? echo $time['start'].' - '.$time['end']; ?></span>
                            <? echo $item['code'] ?><i class="fa fa-star mx-16"></i><? echo $item['description'] ?>
                        </label>
                    </li>
                <? } ?>
            </ul>
        </div>
    </div>

    <div class="row" style="margin-top: 8px">
        <div class="col-md-12">
            <button id="saveShift" type="button" class="btn btn-block btn-primary btn-rounded btn-md ml-4">Save</button>
            <button class="d-none" id="close-modal" data-dismiss="modal"></button>
        </div>
    </div>
<? } ?>

<script type="text/javascript">
    $('#saveShift').on('click', function (){
        let date = $('#modal_date').val();
        let input = $('input[name="shift_id"]:checked');

        let value = input.val();
        let description = input.data('display');

        let shiftElement = $('#shift_'+date);
        let tagElement = $('#shift_tag_'+date);

        if(value === ''){
            shiftElement.val('');
            tagElement.html('<i class="fa fa-calendar mr-16"></i>-').removeClass('tag-blue').addClass('text-muted')
                .attr('data-value', '');
        }else{
            shiftElement.val(value);
            tagElement.html('<i class="fa fa-calendar mr-16"></i>' + description).removeClass('text-muted').addClass('tag-blue')
                .attr('data-value', value);
        }

        $('#close-modal').trigger('click');
    })
</script>