<?php
$modal_date = $_POST['date'];
$modal_value = $_POST['value'];
?>
<input type="hidden" id="modal_date" value="<? echo $modal_date ?>">

<div class="row">
    <div class="col-md-12">
        <label for="temporary_input">Description</label>
        <input type="text" class="form-control" name="temporary_input" id="temporary_input" value="<? echo $modal_value ?>">
    </div>
</div>

<div class="row" style="margin-top: 8px">
    <div class="col-md-12">
        <button id="saveDescription" type="button" class="btn btn-block btn-primary">Save</button>
        <button class="d-none" id="close-modal" data-dismiss="modal"></button>
    </div>
</div>

<script type="text/javascript">
    $('#saveDescription').on('click', function (){
        let date = $('#modal_date').val();
        let value = $('#temporary_input').val();

        let descriptionElement = $('#description_'+date);
        let tagElement = $('#tag_'+date);

        if(value === ''){
            descriptionElement.val('');
            tagElement.text('Add description').attr('data-value', '').removeClass('tag-blue').addClass('text-muted');
        }else{
            descriptionElement.val(value);
            tagElement.text(value).attr('data-value', value).removeClass('text-muted').addClass('tag-blue');
        }

        $('#close-modal').trigger('click');
    })
</script>