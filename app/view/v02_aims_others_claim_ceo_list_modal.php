<?php
require "../model/v02_aims_others_claim_function.php";
$no_staff = $_POST['staff_id'];
$month_claim = $_POST['month_claim'];
$verification = ($_POST['verification'])?: 'PENDING';
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="width: 100%">
        <thead>
        <tr>
            <th style="width: 2%">No.</th>
            <th class="text-center">Date</th>
            <th style="width: 16%">Detail Description</th>
            <th style="width: 16%">Type Claim</th>
            <th class="text-center">Total Claim</th>
            <th class="text-center" style="width: 12%">Attachment</th>
        </tr>
        </thead>
        <tbody>
        <?
        $i=1;
        $total_cost=0.00;
        $claim_list = v02getClaimDetailByStaffCeo($no_staff,$month_claim,$verification);
        while($claim = $claim_list->fetch_assoc()) {
            ?>
            <tr>
                <td>
                    <label><? echo $i++; ?></label>
                </td>
                <td style="width: 20%">
                    <small class="text-muted">Departure:</small><br>
                    <b style="color: #870b00"><? echo date('d/m/Y h:i:sA', strtotime($claim['datetime_departure'])); ?></b><br>
                    <small class="text-muted">Return:</small><br>
                    <b style="color: #008701"><? echo date('d/m/Y h:i:sA', strtotime($claim['datetime_arrival'])); ?></b><br>
                    <small class="text-muted">Applied on:</small><br>
                    <b><? echo date('d/m/Y h:i:sA', strtotime($claim['created_at'])); ?></b>
                </td>
                <td style="width: 25%">
                    <? echo nl2br($claim['description'])?>
                    <? echo (empty($claim['remarks'])) ? '' :
                        '<p class="claim-status" style="font-weight: bold;margin-top: 10px; color: black;background-color: lightgrey">REMARKS : <br>- '.nl2br($claim['remarks']).'</p>'
                    ?>
                </td>
                <td style="width: 30%">
                    <ul style="list-style: square;">
                        <?
                        $type_claim = v02getTypeClaimByClaimId($claim['id']);
                        while ($type = $type_claim->fetch_assoc()){
                            $desc = getTypeClaimDescription($type['company_cc_id'])->fetch_assoc();
                            ?>
                            <li><? echo '<b>'.$desc['cost_centre'].'</b>: '.$desc['description'].' - RM '.$type['total']?></li>
                        <? } ?>
                    </ul>
                </td>
                <td class="text-center" style="width: 12%">
                    <? echo 'RM '.$claim['total_claim']?>
                </td>
                <td class="text-center" style="width: 13%">
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <? if ($claim['document_name'] != '') { ?>
                            <a class="btn btn-warning" title="View Attachment" style="border: 1px solid black"
                               onclick="return popitup('v02_aims_others_claim_view_attachment.php?id=<? echo $claim['id'];?>')">
                                <i class="fa fa-file-picture-o" style="font-size: 24px;"></i>
                            </a>
                        <? } else {
                            echo '<i class="text-muted" style="font-size: 10pt"> No Attachment </i>';
                        } ?>
                    </div>
                </td>
            </tr>
            <? $total_cost+=$claim['total_claim'];
        } ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4"></td>
            <td class="text-center"><b>RM <? echo number_format($total_cost,2); ?></b></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>
<script type="text/javascript">
    function popitup(url) {
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>
